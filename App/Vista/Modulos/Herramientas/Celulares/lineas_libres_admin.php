<?php 
  $url_action_nueva_linea = PATH_VISTA.'Modulos/Herramientas/Celulares/action_nueva_linea.php';

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>

<div class="box box-solid">
  <div class="box-header with-border">
    <i class="fa fa-list"></i>
    <h3 class="box-title">Líneas libres</h3>
    <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal-nueva-linea'>
        <i class="fa fa-phone"></i> Nueva
    </a>
    
  </div>

  <div class="box-body table-responsive"> 
    <div class="col-xs-12 col-md-6 pull-right"><input type="text" id="search-linea" class="form-control" placeholder="Escribe para buscar..." /></div>
    <table class="table table-striped table-condensed" id="tabla-lineas" cellspacing="0" width="100%" style="text-align:center;">
      <thead>
        <tr>
          <th class='text-center' width="100">Nro Línea</th>
          <th class='text-center' width="100">Plan</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
      <?php    
        if(!empty($arrLLibres)){
          foreach ($arrLLibres as $nroLinea) {
            
            echo "<tr>";
              echo "<td>".$nroLinea->getNroLinea()."</td>";
              echo "<td>".$nroLinea->getNombrePlan()."</td>";
              echo "<td style='font-size: 20px;' width='30'><a href='".$url_detalle_linea."&fNroLinea=".$nroLinea->getNroLinea()."'><i class='ion-eye text-blue'></i></td>";
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
                    <input type="date" name="txtFechaAlta" class="form-control">
                  </div>          
                  <div class="col-md-6">
                    <label>Número de Línea</label>
                    <input type="text" name="txtNroLinea" class="form-control">
                  </div>
                  <div class="col-md-6" style="display: none;">
                    <label>Empresa</label>
                    <input type="text" name="txtEmpresa" class="form-control" value="Claro">                    
                  </div>
                  <div class="col-md-6">
                    <label>Plan</label>
                    <input type="text" name="txtPlan" class="form-control">
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