<?php
		
	include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php"; 	
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 

  $id= (isset($_GET["id"])?$_GET["id"]:'');
  $fechasolic= (isset($_GET["fechasolic"])?$_GET["fechasolic"]:'');
  $plaza= (isset($_GET["plaza"])?$_GET["plaza"]:'');

  // var_dump($id,$fechasolic);
  // exit();
	
	$f= new Fechas;
	$fecha=$f->FechaActual();
	$handler= new handlerexpediciones;	

  $envios=$handler->selectByNroEnvio(intval($id));


?>
	<div class="content-wrapper">  
  <section class="content-header">
    <div class="col-md-8 col-md-offset-2 text-left" >
          <h5>REMITO: <b><?php echo $id;?></b></h5>
          <h5>Destino: <b><?php echo $plaza;?></b></h5>
          <h5> Fecha: <b><?php echo $fecha;?></b></h5>
    </div>
        
  </section>  
  <section class="content">

    <?php include_once PATH_VISTA."error.php"; ?>
    <?php include_once PATH_VISTA."info.php"; ?>

	<div class="row">
	  <div class='col-md-7 col-md-offset-2'>
        <div class="box box-solid">

            <!-- <div class="box-header with-border pull-right">
              <i class="fa fa-plane"></i>
              <h3 class="box-title">Tabla Remitos</h3>
            </div>	 -->

    	<div class="box-body  table-responsive">
              <table class="table table-striped table-condensed"  id="tabla" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="150">FECHA SOLICITUD</th>
                      <th width="200">USUARIO</th>
                      <th width="">ITEM-DESCRIPCIÓN</th>     
                      <th width="150">CANTIDAD</th>                 
                      <th width="150">FALTANTE</th>                 
                    </tr>
                  </thead>
                  <tbody>
                      <?php if(!empty($envios)) 
                      {  

                        foreach ($envios as $key => $value) {
                           $idPed = $value->getIdPedido();
                           $items=$handler->selectByIdEnvio($idPed);
                           $handleruser=new handlerUsuarios;
                           $usuario=$handleruser->selectById($items->getUsuarioId());
              
                           $item = $handler->selectById($items->getItemExpediciones());
                           if (count($item)==1) {
                            $item = $item[""];
                           }

                            if ($value->getCantidadFaltante()>0) {
                              $color="class='bg-red'";
                            } else {
                              $color="class=''";
                            }
                          echo "<tr ".$color.">
                            
                            <td>".$fechasolic."</td>
                            <td>".$usuario->getNombre()."".$usuario->getApellido()."</td>
                            <td>".$item->getNombre()."-".$item->getDescripcion()."</td>
                            <td>".$value->getCantidadEnviada()."</td>
                            <td>".$value->getCantidadFaltante()."</td>
                            
                            </tr> ";    
                          
                        }
                      }
                    ?> 

                  </tbody>
                </table>
                
              </div>
            </div>
             <div>
             
              <a href="javascript:history.back(-1);" class="btn btn-primary" title="Ir la página anterior">Regresar</a>
  
             </div>
          </div>

        </div>
           
       </section> 
     </div>