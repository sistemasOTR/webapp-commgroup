<?php 
  $url_action_nueva_linea = PATH_VISTA.'Modulos/Herramientas/Celulares/action_nueva_linea.php';

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>
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
    <div class="col-xs-12 col-md-6 pull-right"><input type="text" id="search-linea" class="form-control" placeholder="Escribe para buscar..." /></div>
    <table class="table table-striped table-condensed" id="tabla-lineas" cellspacing="0" width="100%" style="text-align:center;">
      <thead>
        <tr>
          <th class='text-center' width="30%">NRO LÍNEA</th>
          <th class='text-center' width="30%">PLAN</th>
          <th class='text-center' width="30%">ESTADO</th>
          <th class='text-center' width="10%">ACCION</th>
        </tr>
      </thead>

      <tbody>
      <?php    
        if(!empty($arrLLibres)){
          foreach ($arrLLibres as $nroLinea) {
            switch ($nroLinea->getEstado()) {
              case '0':
                $estado = 'Disponible';
                break;
              case '1':
                $estado = 'Suspendida';
                break;
              
              default:
                $estado = 'Disponible';
                break;
            }
            echo "<tr>";
              echo "<td>".$nroLinea->getNroLinea()."</td>";
              echo "<td>".$nroLinea->getNombrePlan()."</td>";
              echo "<td>".$estado."</td>";
              echo "<td style='font-size: 18px'><a href='#' class='susp-linea' id='".$nroLinea->getNroLinea()."'><i class = 'fa fa-exclamation-triangle text-yellow'></i></a><a href='#' class='baja-linea' id='".$nroLinea->getNroLinea()."'><i class = 'fa fa-times text-red'></i></a><a href='".$url_detalle_linea."&fNroLinea=".$nroLinea->getNroLinea()."&active=ll'><i class='fa fa-eye text-blue'></i></a></td>";
             echo "</tr>";
          }
        }

      ?>                        
      </tbody>
    </table> 
  </div>             
</div>
<script type="text/javascript">   

  $(function () {

  $('#search-linea').quicksearch('#tabla-lineas tbody tr');               
});
       
</script>

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

  $('.baja-linea').on('click',function() {
    var id = this.id;
    $.ajax({
      type: "POST",
      url: 'App/Vista/Modulos/Herramientas/Celulares/action_baja.php',
      data: {
        id: id,
      },
      success: function(data){
        
      }
    });
  });

  $('.susp-linea').on('click',function() {
    var id = this.id;
    $.ajax({
      type: "POST",
      url: 'App/Vista/Modulos/Herramientas/Celulares/action_susp.php',
      data: {
        id: id
      },
      success: function(data){
        
      }
    });
  });
  </script>