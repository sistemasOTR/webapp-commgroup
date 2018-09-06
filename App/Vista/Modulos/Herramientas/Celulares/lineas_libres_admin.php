<?php 
  $url_action_nueva_linea = PATH_VISTA.'Modulos/Herramientas/Celulares/action_nueva_linea.php';
  $url_action_suspender = PATH_VISTA.'Modulos/Herramientas/Celulares/action_susp.php';
  $url_action_activar = PATH_VISTA.'Modulos/Herramientas/Celulares/action_activar.php';
  $url_action_baja = PATH_VISTA.'Modulos/Herramientas/Celulares/action_baja.php';
  $url_action_nueva_linea = PATH_VISTA.'Modulos/Herramientas/Celulares/action_nueva_linea.php';

?>
<style>
  a i {margin: 0 5px;}
</style>
<div class="box box-solid">
  <div class="box-header with-border">
    <i class="fa fa-list"></i>
    <h3 class="box-title">Líneas libres</h3>
    <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal-nueva-linea' onclick="nuevaLinea('<?php echo $fHoy; ?>')">
        <i class="fa fa-phone"></i> Nueva
    </a>
    
  </div>

  <div class="box-body table-responsive col-md-10 col-md-offset-1">
    <table class="table table-striped table-condensed" id="tabla-lineas" cellspacing="0" width="100%" style="text-align:center;">
      <thead>
        <tr>
          <th class='text-center' width="30%">NRO LÍNEA</th>
          <th class='text-center' width="30%">PLAN</th>
          <th class='text-center' width="30%">ESTADO</th>
          <th class='text-center' width="10%">ACCIONES</th>
        </tr>
      </thead>

      <tbody>
      <?php    
        if(!empty($arrLLibres)){
          foreach ($arrLLibres as $nroLinea) {
            switch ($nroLinea->getEstado()) {
              case '0':
                $estado = '<span class="text-green"><b>Disponible</b></span>';
                $icon_1 = "<a href='".$url_action_suspender."?id=".$nroLinea->getNroLinea()."' ><i class = 'fa fa-exclamation-triangle text-yellow ' data-toggle='tooltip' title='Suspender línea'></i></a>";
                $icon_2 = "<a href='".$url_action_baja."?id=".$nroLinea->getNroLinea()."' ><i class = 'fa fa-times text-red ' data-toggle='tooltip' title='Dar de baja línea'></i></a>";
                $icon_3 = "<a href='".$url_detalle_linea."&fNroLinea=".$nroLinea->getNroLinea()."&active=ll'><i class='fa fa-eye text-blue'></i></a></td>";
                break;
              case '1':
                $estado = '<span class="text-yellow"><b>Suspendida</b></span>';
                $icon_1 = "<a href='".$url_action_activar."?id=".$nroLinea->getNroLinea()."' ><i class = 'fa fa-bolt text-green ' data-toggle='tooltip' title='Activar línea'></i></a>";
                $icon_2 = "<a href='".$url_action_baja."?id=".$nroLinea->getNroLinea()."' ><i class = 'fa fa-times text-red ' data-toggle='tooltip' title='Dar de baja línea'></i></a>";
                $icon_3 = "<a href='".$url_detalle_linea."&fNroLinea=".$nroLinea->getNroLinea()."&active=ll'><i class='fa fa-eye text-blue'></i></a></td>";
                break;
              case '2':
                $estado = '<span class="text-red"><b>Baja</b></span>';
                $icon_1 = "";
                $icon_2 = "<a href='".$url_action_baja."?id=".$nroLinea->getNroLinea()."' ><i class = 'fa fa-times text-red ' data-toggle='tooltip' title='Dar de baja línea'></i></a>";
                $icon_3 = "<a href='".$url_detalle_linea."&fNroLinea=".$nroLinea->getNroLinea()."&active=ll'><i class='fa fa-eye text-blue'></i></a></td>";
                break;
              
              default:
                $estado = 'Disponible';
                break;
            }

            echo "<tr>";
              echo "<td>".$nroLinea->getNroLinea()."</td>";
              echo "<td>".$nroLinea->getNombrePlan()."</td>";
              echo "<td>".$estado."</td>";
              echo "<td style='font-size: 18px; text-align: right;'>".$icon_1.$icon_2.$icon_3."</td>";
             echo "</tr>";
          }
        }

      ?>                        
      </tbody>
    </table> 
  </div>             
</div>


<div class="modal fade in" id="modal-nueva-linea">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="<?php echo $url_action_nueva_linea; ?>" method="post">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Nueva de Línea</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-md-6">
                    <label>Fecha</label>
                    <input type="date" name="txtFechaAlta" id="txtFechaAlta" class="form-control">
                  </div>          
                  <div class="col-md-6">
                    <label>Número de Línea</label>
                    <input type="text" name="txtNroLinea" id="txtNroLinea" class="form-control">
                  </div>
                  <div class="col-md-6" style="display: none;">
                    <label>Empresa</label>
                    <input type="text" name="txtEmpresa" class="form-control" value="Claro">                    
                  </div>
                  <div class="col-md-6">
                    <label>Plan</label>
                    <input type="text" name="txtPlan" id="txtPlan" class="form-control">
                  </div>
                  <div class="col-md-6" style="display: none;">
                    <label>Costo</label>
                    <input type="number" name="txtCosto" id="txtCosto" class="form-control" value="0" >
                  </div>
                  <div class="col-md-6" style="display: none;">
                    <label>Consumo</label>
                    <input type="number" name="txtConsumo" id="txtConsumo" class="form-control" value="0">
                  </div>
                  <div class="col-md-12" style="display: none;">
                    <label>Observaciones</label>
                    <textarea name="txtObs" id="txtObs" class="form-control" rows="5"></textarea>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>

      </div>
    </div>
  </div>
  <script>
    function nuevaLinea(fecha) {
      document.getElementById('txtFechaAlta').value = fecha;
      document.getElementById('txtNroLinea').value = '';
      document.getElementById('txtPlan').value = '';
    }
  </script>