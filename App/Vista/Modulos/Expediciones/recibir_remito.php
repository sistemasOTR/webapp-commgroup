<?php
		
	include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php"; 	
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 

  $id= (isset($_GET["id"])?$_GET["id"]:'');
  $fechasolic= (isset($_GET["fechasolic"])?$_GET["fechasolic"]:'');
  $plaza= (isset($_GET["plaza"])?$_GET["plaza"]:'');
  $ver= (isset($_GET["ver"])?$_GET["ver"]:'');

  // var_dump($id,$fechasolic);
  // exit();
	
	$f= new Fechas;
	$fecha=$f->FechaActual();
	$handler= new handlerexpediciones;	

  $envios=$handler->selectByNroEnvio(intval($id));
  $count=count($envios);
  $url_aprobar=PATH_VISTA.'Modulos/Expediciones/action_cambiarestado_remito.php';


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
                      <?php if(!empty($ver))
                        echo" <th width='150'>FALTANTE</th>";?>                  
                     <?php 
                     if(empty($ver))
                      echo" <th width='150'>RECIBIDO</th>                   
                      <th width='150'>CANTIDAD FALTANTE</th>                   
                    </tr>";?>
                  </thead>
                  <tbody>
                      <?php if(!empty($envios)) 

                      {  
                          echo "<form method='POST' action='".$url_aprobar."'>";
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
                            <td>".$value->getCantidadEnviada()."</td>";
                            if (!empty($ver)) {
                              echo "<td>".$value->getCantidadFaltante()."</td>";
                            }
                            if (empty($ver)) {
                           echo" <td><input type='checkbox' class='enviado' name='enviado_".$value->getIdPedido()."' value='0'></td>
                            <td><input type='number' data-env='".$value->getCantidadEnviada()."' id='".$value->getIdPedido()."' onchange='validarEnvio(".$value->getIdPedido().")' name='cantidadnueva[]' value=''></td>
                            <td><input type='hidden' name='id' value='".$id."'></td>
                            <td><input type='hidden' name='countenvios' value='".$count."'></td>
                            <td><input type='hidden' name='id2[]' value='".$value->getIdPedido()."'></td>
                            
                       
                            
                            </tr>
                                   ";    
                          }
                        }
                      }
                    ?> 
                    

                  </tbody>
                </table>
                
              </div>
            </div>

             <div class="col-md-4">
              <a href="javascript:history.back(-1);" class="btn btn-primary" title="Ir la página anterior">Regresar</a>
             </div>
             <?php 
             if (empty($ver)) 
             echo
             "<div class='col-md-2 pull-right'>
              <input type='submit' name='enviar'class='btn btn-success' value='Enviar'>
             </div>";
             ?>
             </form>
          </div>

        </div>
           
       </section> 
     </div>

     <script type="text/javascript">
      $("document").ready(function(){
       $(".enviado").click(function(){
       if ($(this).is(":checked")) {
         var valor=$(this).val(1);

       } else {
        var valor=$(this).val(0);
       } 

       })    
      });  

   function validarEnvio(id_pedido){
    var id= id_pedido;
      var enviar =document.getElementById(id).value;    
       var cantidad=document.getElementById(id).getAttribute('data-env');

        if(Number(enviar) > Number(cantidad) ){
          alert("cantidad maxima "+Number(cantidad));
        document.getElementById(id).value= Number(cantidad) ;
        }if(Number(enviar)<0){
          alert("numero invalido");    
        document.getElementById(id).value=0;
       } 
     }

     </script>