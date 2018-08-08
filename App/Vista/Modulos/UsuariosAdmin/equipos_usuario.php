<?php

  include_once PATH_NEGOCIO."Modulos/handlercelulares.class.php"; 

  $handlerCel = new HandlerCelulares;
  $arrDatosCel = $handlerCel->getEntregasByUser($id);

  $url_impresion_celu = PATH_VISTA.'Modulos/Herramientas/Celulares/imprimir_comodato.php?';  
  $url_impresion_celu_baja = PATH_VISTA."Modulos/Herramientas/Celulares/imprimir_baja_comodato.php?"; 
?>

  
      <!-- Lineas asignadas -->
<div class="box box-solid">
  <div class="box-body table-responsive">
    <table class="table table-striped table-condensed" id="tabla-entregas" cellspacing="0" width="100%" style="text-align:center;">
      <thead>
        <tr>
          <th class='text-center' width="150">Equipo</th>
          <th class='text-center' width="100">Entrega</th>
          <th class='text-center' width="100">Devolución</th>
          <th class='text-center' width="250">Obs. Entrega</th>
          <th class='text-center' width="250">Obs. Devolución</th>
          <th class='text-center'>Com.Ent</th>
          <th class='text-center'>Com.Dev</th>
        </tr>
      </thead>

      <tbody>
      <?php    
        if(!empty($arrDatosCel)){
          foreach ($arrDatosCel as $nroLinea) {
            $IMEI = $nroLinea->getIMEI();
            //var_dump($equipo);
            //exit();
            if($IMEI != '0'){
              $equipo = $handlerCel->getEquipoLinea($IMEI);
              $telefono = $equipo->getMarca()." ".$equipo->getModelo();
              $seguir = true;
            } else {
              $telefono='Propio';
              $seguir=false;
            }

            $linea = $handlerCel->getDatosByNroLinea($nroLinea->getNroLinea());

            $devolucion = "<a href='#' data-toggle='modal' id='".$nroLinea->getEntId()."' data-target='#modal-devolver' data-nroLinea='".$nroLinea->getNroLinea()."' data-fechaEnt='".$nroLinea->getFechaEntregaLinea()->format('Y-m-d')."' data-IMEI='".$nroLinea->getIMEI()."' onclick='devolverLinea(".$nroLinea->getEntId().")'><i class='ion-arrow-return-left text-maroon'></i></a>";
            $enroque_eq = "<a href='#' data-toggle='modal' id='".$nroLinea->getEntId()."_equipo' data-target='#modal-enroque-equipo' data-tipo='equipo' data-nroLinea='".$nroLinea->getNroLinea()."' data-fechaEnt='".$nroLinea->getFechaEntregaLinea()->format('Y-m-d')."' data-IMEI='".$nroLinea->getIMEI()."' data-user='".$nroLinea->getUsId()."' onclick='enroqueEquipo(".$nroLinea->getEntId().")'><i class='fa fa-refresh text-navy'></i></a>";
            $enroque_linea = "<a href='#' data-toggle='modal' id='".$nroLinea->getEntId()."' data-target='#modal-enroque-equipo' data-tipo='linea' data-nroLinea='".$nroLinea->getNroLinea()."' data-fechaEnt='".$nroLinea->getFechaEntregaEquipo()->format('Y-m-d')."' data-IMEI='".$nroLinea->getIMEI()."' data-user='".$nroLinea->getUsId()."' onclick='enroqueLinea(".$nroLinea->getEntId().")'><i class='fa fa-refresh text-navy'></i></a>";

            
            $usuario = $handlerUs->selectById($nroLinea->getUsId());
            if($nroLinea->getFechaEntregaEquipo()->format('d-m-Y') != '01-01-1900'){
              $entregaEquipo = $nroLinea->getFechaEntregaEquipo()->format('d-m-Y');
            } else {
              $entregaEquipo = '-';
            }
            if (!is_null($nroLinea->getFechaDev())) {
              $fechaDev = $nroLinea->getFechaDev()->format('d-m-Y');
              $como_baja = "<a href='".$url_impresion_celu_baja."fID=".$nroLinea->getEntId()."&fTipo=".$nroLinea->getTipoDev()."' target='_blank'><i class='fa fa-file-text text-red' data-toggle='tooltip' title='Ver Comodato'></i>";
            } else {
              $fechaDev = 'Actualidad';
              $como_baja = "<i class='fa fa-file-text text-gray' data-toggle='tooltip' title='Actualmente'></i>";
            }
            
            $visible ='';
            $visibleDev ='';
            if(strlen(trim(strip_tags($nroLinea->getObsEntrega())))<31)
              $visible= "style='display:none;'";

            if(strlen(trim(strip_tags($nroLinea->getObsDev())))<31)
              $visibleDev= "style='display:none;'";

            if ($seguir) {
              echo "<tr>";              
                echo "<td>".$telefono."<br>IMEI: ".$IMEI."</td>";
                echo "<td>".$entregaEquipo."</td>";
                echo "<td>".$fechaDev."</td>";
                echo "<td style='max-width:150px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis; '><i ".$visible." class='fa fa-sort-down pull-left' data-toggle='tooltip' data-placement='bottom' title='' data-original-title='".trim(strip_tags($nroLinea->getObsEntrega()))."'></i>".trim(strip_tags($nroLinea->getObsEntrega()))."</td>";
                echo "<td style='max-width:150px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis; '><i ".$visibleDev." class='fa fa-sort-down pull-left' data-toggle='tooltip' data-placement='bottom' title='' data-original-title='".trim(strip_tags($nroLinea->getObsDev()))."'></i>".trim(strip_tags($nroLinea->getObsDev()))."</td>";
                echo "<td style='font-size: 20px;' width='30'><a href='".$url_impresion_celu."fID=".$nroLinea->getEntId()."' target='_blank'><i class='fa fa-file-text text-yellow' data-toggle='tooltip' title='Ver Comodato'></i></td>";
                echo "<td style='font-size: 20px;' width='30'>".$como_baja."</td>";
              echo "</tr>";
            }
            
          }
        }

      ?>                        
      </tbody>
    </table> 
  </div>
</div>