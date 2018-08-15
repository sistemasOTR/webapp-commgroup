<?php
		
  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
  include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php";  	
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";
  include_once PATH_DATOS.'Entidades/empresapuntaje.class.php'; 

  $id= (isset($_GET["id"])?$_GET["id"]:'');


 //  // var_dump($id,$fechasolic);
 //  // exit();
	
	$f= new Fechas;
	$fecha=$f->FechaActual();
 $handlerempresa= new EmpresaPuntaje;
 $Empresa=$handlerempresa->selectById($id);




?>
	<div class="content-wrapper">  
  <section class="content-header">
    <div class="col-md-8 col-md-offset-2 text-left" >
    
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
                      <th width="">NOMBRE EMPRESA</th>
                      <th width="">PUNTAJE</th>
                      <th width="">FECHA DESDE</th>     
                      <th width="">FECHA HASTA</th>                 
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                  // var_dump($arrCliente);

                  if(!empty($Empresa))
                  {
                    foreach ($Empresa as $key => $value) { 
                      if (count($Empresa)==1) {
                              $Empresa = $Empresa[""];
                            }
                       $handler = new HandlerSistema;
                        $arrCliente = $handler->selectEmpresaById($id);

                      echo "
                      <tr>
                         <td>".$arrCliente[0]->EMPTT21_NOMBREFA."</td>
                         <td>".$value->getPuntaje()."</td>
                         <td>".$value->getFechaDesde()->Format('d/m/Y')."</td>
                         <td>".$value->getFechaHasta()->Format('d/m/Y')."</td>
                      </tr>";
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