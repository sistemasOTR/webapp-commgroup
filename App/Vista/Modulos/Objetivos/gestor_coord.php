<?php
	
	$gestCoor = $handlerObj->allGestCoor();
	$arrGestores = $handlerSist->selectAllGestor(null);
	foreach ($gestCoor as $key => $value) {
		$gc[] = intval($value->getIdGestor());
	}



	$url_action_nuevo = PATH_VISTA.'Modulos/Objetivos/accion_nuevo_gc.php';  
	$url_action_edit = PATH_VISTA.'Modulos/Objetivos/accion_editar_gc.php';  
?>

<div class='col-md-12 no-padding'>
	<div class="box box-solid">
		<div class="box-header with-border">
			<h3 class="box-title">Gestores/Coordinadores</h3>
			<a href='#' class='btn btn-success pull-right btn-new' data-toggle='modal' data-target='#modal-nuevo'><i class='fa fa-plus'></i> Nueva</a>
		</div>
		<div class="box-body table-resposive">
			<table class="table table-striped table-condensed" id="tabla-plazas">
				<thead>
					<tr>
            <th>GESTOR</th>
						<th>FECHA</th>
						<th style='text-align: right;'>ACCIONES</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($gestCoor)) {
						foreach ($gestCoor as $key => $value) {
							// $historial = "<a href='".$href3."&plaza=".$value->getPlaza()."' class='btn btn-info '><i class='fa fa-eye'></i></a>";

							// Datos Gestor
							// ============================
							$gestor = $handlerSist->selectGestorById($value->getIdGestor());

							// Botones
							// ============================
							$eliminar = "<a href='#' class='btn btn-danger btnEditar' data-id='".$value->getId()."' data-gestor='".$gestor[0]->GESTOR21_ALIAS."' data-toggle='modal' data-target='#modal-edit'><i class='fa fa-trash'></i></a>";


							echo "<tr>";
                echo "<td>".$gestor[0]->GESTOR21_ALIAS."</td>";
								echo "<td>".$value->getFechaInicio()->format('d-m-Y')."</td>";
								echo "<td style='text-align: right;'>".$eliminar."</td>";
							echo "</tr>";
						}
					} ?>
				</tbody>
			</table>	
		</div>
	</div>
</div>

<!-- Modeles -->
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
                <div class="col-md-12">
                  <label>Plaza</label>
                  <select name="slt_gestor" id="slt_gestor_nuevo" class="form-control slt-editable">
                  	<?php 
                  		if (!empty($arrGestores)) {
                  			foreach ($arrGestores as $key => $value) {
                  				if (!in_array($value->GESTOR11_CODIGO,$gc)) {
                  					echo "<option value='".$value->GESTOR11_CODIGO."'>".$value->GESTOR21_ALIAS."</option>";
                  				}
                  			}
                  		}
                  	 ?>
                  </select>
                </div> 
                <div class="col-md-6">
                  <label>Vigencia</label>
                  <input type="date" name="fechaInicio" id="fechaInicio" class="form-control" value="<?php echo date('Y-m-d') ?>">
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
	    $('.slt_editable').val(0);
	  });
	});

</script>



<div class="modal fade in" id="modal-edit">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?php echo $url_action_edit; ?>" method="post">
        <div class="modal-header bg-red">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Eliminar</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                	<p id="edit-title"></p>
                  <input type="hidden" name="id" id="id_edit" class="form-control editable">
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
	$(document).ready(function(){                
	  $(".btnEditar").on('click',function(){
	  	var id = $(this).attr('data-id'),
	  		gestor = $(this).attr('data-gestor');

	  	$('#id_edit').val(id);
	  	$('#edit-title').html('¿Está seguro que desea eliminar a ' + gestor + ' como gestor/coordinador?');
	  });
	});

</script>