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
    <!--<div class="col-xs-12 col-md-3 pull-right"><input type="text" id="search" class="form-control" placeholder="Escribe para buscar..." /></div>-->
  </div>

  <div class="box-body table-responsive"> 
    
    <table class="table table-striped table-condensed" id="tabla-plaza" cellspacing="0" width="100%" style="text-align:center;">
      <thead>
        <tr>
          <th class='text-center' width="100" colspan="2">Nro Línea</th>
          
        </tr>
      </thead>

      <tbody>
      <?php    
        if(!empty($arrLLibres)){
          foreach ($arrLLibres as $nroLinea) {
            
            echo "<tr>";
              echo "<td>".$nroLinea->getNroLinea()."</td>";
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

  $('#search').quicksearch('table tbody tr');               
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
                  <div class="col-md-6">
                    <label>Empresa</label>
                    <input type="text" name="txtEmpresa" class="form-control">                    
                  </div>
                  <div class="col-md-6">
                    <label>Plan</label>
                    <input type="text" name="txtPlan" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Costo</label>
                    <input type="number" name="txtCosto" id="txtCosto" class="form-control" >
                  </div>
                  <div class="col-md-6">
                    <label>Consumo</label>
                    <input type="number" name="txtConsumo" id="txtConsumo" class="form-control">
                  </div>
                  <div class="col-md-12">
                    <label>Observaciones</label>
                    <textarea name="txtObs" id="txtObs" class="form-control" rows="5"></textarea>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>

      </div>
    </div>
  </div>