<?php 
   $url_action_nuevo_equipo = PATH_VISTA.'Modulos/Herramientas/Celulares/action_nuevo_equipo.php';

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.2.1/jquery.quicksearch.js"></script>

<div class="box box-solid">
  <div class="box-header with-border">
    <i class="fa fa-list"></i>
    <h3 class="box-title">Equipos libres</h3>
    <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal-nuevo-equipo'>
        <i class="fa fa-mobile"></i> Nuevo
    </a>
    <div class="col-xs-12 col-md-6 pull-right"><input type="text" id="search-equipos" class="form-control" placeholder="Escribe para buscar..." /></div>
  </div>

  <div class="box-body table-responsive"> 
    
    <table class="table table-striped table-condensed" id="tabla-equipos" cellspacing="0" width="100%" style="text-align:center;">
      <thead>
        <tr>
          <th class='text-center' width="100">IMEI</th>
          <th class='text-center' width="100">MODELO</th>
          <th class='text-center' width="100">ESTADO</th>
        </tr>
      </thead>

      <tbody>
      <?php    
        if(!empty($arrELibres)){
          foreach ($arrELibres as $equipo) {
            if(!is_null($equipo->getFechaBaja())){
              $class_estado = 'text-red';
              $estado = 'Averiado';
            } elseif(!is_null($equipo->getFechaRobo())) {
              $class_estado = 'text-red';
              $estado = 'Robado';
            } elseif (!is_null($equipo->getFechaPerd())) {
              $class_estado = 'text-red';
              $estado = 'Perdido';
            } else {
              $class_estado = 'text-green';
              $estado = 'OK';
            }
            echo "<tr>";
              echo "<td>".$equipo->getIMEI()."</td>";
              echo "<td>".$equipo->getMarca()." ".$equipo->getModelo()."</td>";
              echo "<td class='".$class_estado."'>".$estado."</td>";
              echo "<td style='font-size: 20px;' width='30'><a href='".$url_detalle_equipo."&fIMEI=".$equipo->getIMEI()."'><i class='ion-eye text-blue'></i></a></td>";
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

  $('#search-equipos').quicksearch('#tabla-equipos tbody tr');               
});
       
</script>
<div class="modal fade in" id="modal-nuevo-equipo">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="<?php echo $url_action_nuevo_equipo; ?>" method="post">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">Nuevo Equipo</h4>
          </div>
          <div class="modal-body">
              <div class="row">
              	<div class="col-xs-12 no-padding">
                  <div class="col-md-6">
                    <label>Fecha de Compra</label>
                    <input type="date" name="txtFechaCompra" class="form-control">
                  </div>
              	</div>
                  <div class="col-md-6">
                    <label>Número de IMEI</label>
                    <input type="text" name="txtIMEI" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Marca</label>
                    <input type="text" name="txtMarca" class="form-control">                    
                  </div>
                  <div class="col-md-6">
                    <label>Modelo</label>
                    <input type="text" name="txtModelo" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Precio de Compra</label>
                    <input type="number" name="txtPrecioCompra" id="txtCosto" class="form-control" >
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