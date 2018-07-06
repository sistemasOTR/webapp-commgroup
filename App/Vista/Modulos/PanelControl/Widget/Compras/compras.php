<?php
  include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";
  include_once PATH_NEGOCIO."Sistema/handlerconsultascontrol.class.php";    
  include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 

  $url_action_cambiar = PATH_VISTA.'Modulos/Expediciones/action_cambiar_estado.php';
  $dFecha = new Fechas;
  $fechaActual= $dFecha->FechaActual();
  $fechaInicial= $dFecha->RestarDiasFechaActual(365);

  $handler = new HandlerExpediciones;
  $arrTipo = $handler->selecionarTipo();
  $arrEstados = $handler->selecionarEstados();
  $consulta = $handler->seleccionarComprasByFiltros(null,null,null,null);
   $user = $usuarioActivoSesion;

  ?>

  <div class="col-md-12 nopadding">
	<div class="box box-solid">
	  <div class="box-header with-border">
	  	<a href='<?php echo "index.php?view=exp_compra&fdesde=".$fechaInicial."&fhasta=".$fechaActual."&festados=1" ?>' class="fa fa-search pull-right" id="btn-nuevo"></a>
	    <i class=" fa fa-shopping-cart"></i>
	    <h3 class="box-title">Tabla Compras. 
	    	<span class='text-green'><b>Recibir</b></span>
	    	
	    </h3>
	  </div>
	  <div class="box-body" style='text-align: center;'>
	  	<table class="table table-striped table-condensed" id="tabla-items" cellspacing="0" width="100%">
	  		<thead>
                  <tr>
                    <th width="150">FECHA PEDIDA</th>
                    <th>ITEM</th>             
                    <th width="100">CANTIDAD</th>                                                
                    <th width="30">RECIBIDO</th>                                                  
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
                           $url_action_recibido = PATH_VISTA.'Modulos/Expediciones/action_comprarecibida.php?idpedido='.$value->getId().'&iditem='.$value->getItemExpediciones().'&usuario='.$user->getId().'&cantidad='.$value->getCantidad().'&stock='.$item->getStock().'&redireccion=control';
       

                          if ($value->getRecibido()==0) {
                          $recibido='<a href="'.$url_action_recibido.'"class="fa fa-play"></a>';
                          echo "
                            <tr>
                              <td>".$value->getFecha()->format('d/m/Y')."</td>
                              <td>".$item->getNombre()."</td>                      
                                <td>".$value->getCantidad()."</td>
                                <td>".$recibido."</td>
                                
                               
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




