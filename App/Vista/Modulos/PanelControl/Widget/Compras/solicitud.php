<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";     
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 


   $fusuario= $usuarioActivoSesion->getId();
   $fplaza= $usuarioActivoSesion->getAliasUserSistema();
   $dFecha = new Fechas;
  $fechaActual= $dFecha->FechaActual();
  $fechaInicial= $dFecha->RestarDiasFechaActual(365);

  $handler = new HandlerExpediciones;
  $arrTipo = $handler->selecionarTipo();
  $arrEstados = $handler->selecionarEstados();
  $consulta = $handler->seleccionarByFiltros(null,null,null,null,null);


?>

<div class="col-md-12 nopadding ">
	<div class="box box-solid">
	  <div class="box-header with-border">
	  	<a href='<?php echo "index.php?view=exp_control&fdesde=".$fechaInicial."&fhasta=".$fechaActual."&festados=1000" ?>' class="fa fa-search pull-right" id="btn-nuevo"></a>
	    <i class=" fa fa-bookmark"></i>
	    <h3 class="box-title">Tabla Solicitudes 
	    	<span class='text-yellow'><b>Pendientes</b></span>
	    	
	    </h3>
	  </div>
	  <div class="box-body " style='text-align: center;'>
	  	<table class="table table-striped table-condensed " id="tabla-items" cellspacing="0" width="100%">
	  		<thead>
                  <tr>
                    <th style="text-align: center">FECHA</th>
                    <th style="text-align: center">ITEM</th>             
                    <th style="text-align: center">CANT PEDIDA</th> 
                    <th style="text-align: center">ESTADO</th>             
                                   
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

                           $item = $handler->selectById($value->getItemExpediciones());
                          if (count($item)==1) {
                            $item = $item[""];
                          }
                          $estado = $handler->selectEstado($value->getEstadosExpediciones());    


                          if ($estado->getId()==1 ||$estado->getId()==6 ||$estado->getId()==7 ) {
                          	
                          
                          echo "
                            <tr>
                              <td>".$value->getFecha()->format('d/m/Y')."</td>
                            
                              <td>".$item->getNombre()."</td>                      
                                <td>".$value->getCantidad()."</td>
                                                    
                                <td>
                                  <span class='label label-".$estado->getColor()."' style='font-size:12px;'>"
                                    .$estado->getNombre().
                                  "</span>
                                </td>
                               
                               </tr>";
                           }
                        } 
                      }
                    ?>
                  </tbody>
              </table>
          </div>
      </div>
  </div>