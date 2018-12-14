<?php
	$plaza = (isset($_GET["plaza"])?$_GET["plaza"]:"");

	$objXPlaza = $handlerObj->objetivosXPlaza($plaza);
	// $arrPlazas = $handlerSist->selectAllCoordinador(null);

	// $url_action_nuevo = PATH_VISTA.'Modulos/Objetivos/accion_nuevo_obj.php';  
	// $url_action_edit = PATH_VISTA.'Modulos/Objetivos/accion_editar_obj.php';  

	
?>

<div class='col-md-12 no-padding'>
	<div class="box box-solid">
		<div class="box-header with-border">
			<h3 class="box-title">Historico de OBJETIVOS por plaza</h3>
			<a href='<?php echo $href1; ?>' class='btn btn-danger pull-right'><i class='fa fa-arrow-left'></i> Volver</a>
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
						<!-- <th style='text-align: right;'>ACCIONES</th> -->
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($objXPlaza)) {
						foreach ($objXPlaza as $key => $value) {

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
								// echo "<td style='text-align: right;'>".$modificar." ".$historial."</td>";
							echo "</tr>";
						}
					} ?>
				</tbody>
			</table>	
		</div>
	</div>
</div>