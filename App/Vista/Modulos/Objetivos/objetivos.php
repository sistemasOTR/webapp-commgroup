<?php

	$objActuales = $handlerObj->objetivosActuales();
	$arrPlazas = $handlerSist->selectAllCoordinador(null);

	$url_action_nuevo = PATH_VISTA.'Modulos/Objetivos/accion_nuevo_obj.php';  
	$url_action_edit = PATH_VISTA.'Modulos/Objetivos/accion_editar_obj.php';  
?>

<div class='col-md-12 no-padding'>
	<div class="box box-solid">
		<div class="box-header with-border">
			<h3 class="box-title">Plazas</h3>
			<a href='#' class='btn btn-success pull-right btn-new' data-toggle='modal' data-target='#modal-nuevo'><i class='fa fa-plus'></i> Nueva</a>
		</div>
		<div class="box-body table-responsive">
			<table class="table table-striped table-condensed" id="tabla-plazas">
				<thead>
					<tr>
						<th>PLAZA</th>
						<th style="text-align: center;">OBJETIVO</th>
						<th style="text-align: center;">OBJ. GEST/COOR</th>
            <th style="text-align: center;">CANT.COORD</th>
            <th style="text-align: center;">VIGENCIA</th>
						<th style='text-align: right;'>ACCIONES</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($objActuales)) {
						foreach ($objActuales as $key => $value) {

							// Botones
							// ============================
							$modificar = "<a href='#' class='btn btn-warning btnEditar' data-id='".$value->getId()."' data-plaza='".$value->getPlaza()."' data-basico='".$value->getBasico()."' data-basicoGC='".$value->getBasicoGC()."' data-cantcoord='".$value->getCantCoord()."' data-vigencia='".$value->getVigencia()->format('Y-m-d')."' data-toggle='modal' data-target='#modal-edit'><i class='fa fa-edit'></i></a>";
							$historial = "<a href='".$href3."&plaza=".$value->getPlaza()."' class='btn btn-info '><i class='fa fa-eye'></i></a>";
							echo "<tr>";
								echo "<td>".$value->getPlaza()."</td>";
								echo "<td style='text-align:center;'>".$value->getBasico()."</td>";
                echo "<td style='text-align:center;'>".$value->getBasicoGC()."</td>";
								echo "<td style='text-align:center;'>".$value->getCantCoord()."</td>";
								echo "<td style='text-align:center;'>".$value->getVigencia()->format('d-m-Y')."</td>";
								echo "<td style='text-align: right;'>".$modificar." ".$historial."</td>";
							echo "</tr>";
						}
					} ?>
				</tbody>
			</table>	
		</div>
	</div>
</div>

<!-- Modales -->
<!-- ====================================== -->

<div class="modal fade in" id="modal-nuevo">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_nuevo; ?>" method="post">
        <div class="modal-header bg-green">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Nuevo</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                  <label>Plaza</label>
                  <select name="slt_plaza" id="slt_plaza_nuevo" class="form-control slt-editable">
                    <?php 
                      if (!empty($arrPlazas)) {
                        foreach ($arrPlazas as $key => $value) {
                          if ($value->CORDI91_ALIGTE != '') {
                            echo "<option value='".$value->CORDI11_ALIAS."'>".$value->CORDI11_ALIAS."</option>";
                          }
                        }
                      }
                     ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <label>Vigencia</label>
                  <input type="date" name="vigencia" id="vigencia_nuevo" class="form-control" value="<?php echo date('Y-m-d') ?>">
                </div>
                <div class="col-md-4">
                  <label>Obj. Gestor</label>
                  <input type="number" name="basico" id="basico_nuevo" class="form-control editable">
                </div>
                <div class="col-md-4">
                  <label>Obj. Gestor/Coordinador</label>
                  <input type="number" name="basicoGC" id="basicoGC_nuevo" class="form-control editable">
                </div>
                <div class="col-md-4">
                  <label>Cantidad de Coordinadores</label>
                  <input type="number" name="cantCoord" id="cantCoord_nuevo" class="form-control editable">
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
	$(document).ready(function(){                
	  $(".btn-new").on('click',function(){
	    $('.editable').val('');
	    $('.slt_editable').val(0);
	    var dNow = new Date();
		var utcdate= dNow.getFullYear() + "-" +(dNow.getMonth()+ 1) + '-0' + dNow.getDate();
	    $('#vigencia_nuevo').val(utcdate);
	  });
	});

</script>

<div class="modal fade in" id="modal-edit">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_edit; ?>" method="post">
        <div class="modal-header bg-yellow">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="edit-title">Nuevo</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                  <label>Obj. Gestor</label>
                  <input type="number" name="basico" id="basico_edit" class="form-control editable">
                  <input type="hidden" name="id" id="id_edit" class="form-control editable">
                </div>
                <div class="col-md-6">
                  <label>Obj. Gestor/Coord.</label>
                  <input type="number" name="basicoGC" id="basicoGC_edit" class="form-control editable">
                </div>
                <div class="col-md-6">
                  <label>Cantidad de Coordinadores</label>
                  <input type="number" name="cantCoord" id="cantCoord_edit" class="form-control editable">
                </div>
                <div class="col-md-6" style="display: none;">
                  <label>Plaza</label>
                  <input type="hidden" name="slt_plaza" id="slt_plaza_edit" class="form-control slt-editable">
                  	
                </div>
                <div class="col-md-6">
                  <label>Vigencia</label>
                  <input type="date" name="vigencia" id="vigencia_edit" class="form-control" value="<?php echo date('Y-m-d') ?>">
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
	$(document).ready(function(){                
	  $(".btnEditar").on('click',function(){
	  	var id = $(this).attr('data-id'),
	  		plaza = $(this).attr('data-plaza'),
	  		basico = $(this).attr('data-basico'),
	  		basicoGC = $(this).attr('data-basicoGC'),
        vigencia = $(this).attr('data-vigencia'),
	  		cantCoord = $(this).attr('data-cantcoord');

	  	$('#id_edit').val(id);
	  	$('#slt_plaza_edit').val(plaza);
	  	$('#edit-title').html('Editar ' + plaza);
	  	$('#basico_edit').val(basico);
	  	$('#basicoGC_edit').val(basicoGC);
      $('#vigencia_edit').val(vigencia);
	  	$('#cantCoord_edit').val(cantCoord);
	  });
	});

</script>