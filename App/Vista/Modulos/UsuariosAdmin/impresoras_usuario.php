<?php  
  include_once PATH_NEGOCIO."Modulos/handlerimpresoras.class.php";

  $handlerImp = new HandlerImpresoras;
  $arrDatosImp = $handlerImp->selectByGestor($id);

  
  $url_impresion_imp = PATH_VISTA.'Modulos/Herramientas/Impresoras/imprimir_comodato.php?';
  $url_impresion_imp_baja = PATH_VISTA."Modulos/Herramientas/Impresoras/imprimir_baja_comodato.php?"; 
?>

  
      <!-- Lineas asignadas -->
<div class="box box-solid">
  <div class="box-body table-responsive">
    <table class="table table-striped table-condensed" id="tabla-entregas" cellspacing="0" width="100%" style="text-align:center;">
      <thead>
        <tr>
          <th class='text-center' width="150">Impresora</th>
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
        if(!empty($arrDatosImp)){
          foreach ($arrDatosImp as $key => $value) {
            $impresora = $handlerImp->getDatosConSerial($value->getSerialNro());
            // var_dump($impresora);
            $visible ='';
            $visibleDev ='';
            if(strlen(trim(strip_tags($value->getObs())))<31)
              $visible= "style='display:none;'";

            if(strlen(trim(strip_tags($value->getObsDev())))<31)
              $visibleDev= "style='display:none;'";
            if (!is_null($value->getFechaDev())) {
              $fechaDev = $value->getFechaDev()->format('d-m-Y');
              $como_baja = "<a href='".$url_impresion_imp_baja."fID=".$value->getAsigId()."&fTipo=".$value->getTipoDev()."' target='_blank'><i class='fa fa-file-text text-red' data-toggle='tooltip' title='Ver Comodato'></i>";
            } else {
              $fechaDev = 'Actualidad';
              $como_baja = "<i class='fa fa-file-text text-gray' data-toggle='tooltip' title='Actualmente'></i>";
            }





             echo "<tr>";
              echo "<td>".$impresora['_serialNro']."<br>".$impresora['_marca']."<br>".$impresora['_modelo']."</td>";
              echo "<td>".$value->getFechaAsig()->format('d-m-Y')."</td>";
              echo "<td>".$fechaDev."</td>";
              echo "<td style='max-width:150px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis; '><i ".$visible." class='fa fa-sort-down pull-left' data-toggle='tooltip' data-placement='bottom' title='' data-original-title='".trim(strip_tags($value->getObs()))."'></i>".trim(strip_tags($value->getObs()))."</td>";
              echo "<td style='max-width:150px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis; '><i ".$visibleDev." class='fa fa-sort-down pull-left' data-toggle='tooltip' data-placement='bottom' title='' data-original-title='".trim(strip_tags($value->getObsDev()))."'></i>".trim(strip_tags($value->getObsDev()))."</td>";
              echo "<td style='font-size: 20px;' width='30'><a href='".$url_impresion_imp."fasigId=".$value->getAsigId()."' target='_blank'><i class='fa fa-file-text text-yellow' data-toggle='tooltip' title='Ver Comodato'></i></td>";
              echo "<td style='font-size: 20px;' width='30'>".$como_baja."</td>";
            echo "</tr>";
          }
        }

      ?>                        
      </tbody>
    </table> 
  </div>
</div>