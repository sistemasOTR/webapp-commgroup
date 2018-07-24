<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 

 $fecha = new Fechas;
 $fdesde=$fecha->RestarDiasFechaActual(90);
 $fhasta=$fecha->FechaActual();

 $handler = new HandlerExpediciones;
 $consulta = $handler->seleccionarUltimosEnvios();
 // var_dump($consulta);
 // exit();

 ?>
  <div class="col-md-12 nopadding">
	<div class="box box-solid">
	  <div class="box-header with-border">
	  	<a href="index.php?view=exp_remito&fdesde=<?php echo $fecha->RestarDiasFechaActual(90);?>&fhasta=<?php echo $fecha->FechaActual(); ?>" class="fa fa-search pull-right" id="btn-nuevo"></a>
	    <i class=" fa fa-file-text-o"></i>
	    <h3 class="box-title">Tabla Remitos 
	    	<span class='text-orange'><b>Detalles</b></span>
	    	
	    </h3>
	  </div>
	  <div class="box-body">
	  	<table class="table table-striped" id='tabla'>
                <thead>
                  <tr>
                    <th width="100">Nº REMITO</th> 
                    <th width="120">FECHA</th>                                                              
                    <th width="">DESTINO</th>                                                              
                    <th width="100">VER</th>                          
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
                          $url_detalle_pedido ='index.php?view=exp_detalle_remito&id='.$value->getId().'&fechasolic='.$value->getFecha()->Format('d/m/Y').'&plaza='.$value->getPlaza();

                           $envios = "<a href='".$url_detalle_pedido."'  
                                        type='button' 
                                         class='fa fa-eye'></a>";

                          echo "
                            <tr>
                              <td width='100'>".$value->getId()."</td>  
                              <td width='120'>".$value->getFecha()->Format('d/m/Y')."</td>     
                              <td>".$value->getPlaza()."</td>     
                               <td width='100'>".$envios."</td>

                          </tr>";
                        } 
                      }
                    ?>

                 </tbody>
              </table>	  
	  </div>
	</div>
</div>