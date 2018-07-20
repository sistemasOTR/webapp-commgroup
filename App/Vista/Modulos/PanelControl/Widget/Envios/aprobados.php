<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 

 $fecha = new Fechas;
 $fdesde=$fecha->RestarDiasFechaActual(90);
 $fhasta=$fecha->FechaActual();

 $handler = new HandlerExpediciones;
 $consulta = $handler->seleccionarByFiltroEnvios($fdesde,$fhasta,9,null);

 ?>
  <div class="col-md-12 nopadding">
	<div class="box box-solid">
	  <div class="box-header with-border">
	  	<a href="index.php?view=exp_control&fdesde=<?php echo $fecha->RestarDiasFechaActual(90);?>&fhasta=<?php echo $fecha->FechaActual(); ?>&festados=9" class="fa fa-search pull-right" id="btn-nuevo"></a>
	    <i class=" fa fa-plane"></i>
	    <h3 class="box-title">Tabla Envios 
	    	<span class='text-blue'><b>Aprobados</b></span>
	    	
	    </h3>
	  </div>
	  <div class="box-body" style='text-align: center;'>
	  	<table class="table table-striped table-condensed" id="tabla-envios" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="text-align: center">FECHA</th>
                      <th style="text-align: center">ITEM-DETALLE</th>
                      <th style="text-align: center">PLAZA</th>
                      <th style="text-align: center">CANTIDAD</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      if(!empty($consulta))
                      {
                          if (count($consulta)==1) {
                            $consulta = $consulta[""];
                          }
                        foreach ($consulta as $key => $value) {
                          // var_dump($consulta);
                          //   exit();
                            $cantEnv=$handler->selecionarSinEnviar($value->getId(),$sinenviar=1);
                            
                             if (count($cantEnv)==1) {
                             $cantEnv = $cantEnv[""];
                             }  
                           $item = $handler->selectById($value->getItemExpediciones());
                           if (count($item)==1) {
                             $item = $item[""];
                           }
                          echo "
                            <tr>
                              <td>".$cantEnv->getFecha()->Format('d/m/Y')."</td> 
                              <td>".$item->getNombre()."-".$item->getDescripcion()."</td>  
                              <td>".$value->getPlaza()."</td>                   
                              <td>".$cantEnv->getCantidadEnviada()."</td>            
                              
                            </tr>";
                        } 
                      }
                    ?>
                  </tbody>
              </table>	  
	  </div>
	</div>
</div>