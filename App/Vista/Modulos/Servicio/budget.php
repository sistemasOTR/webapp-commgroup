<?php 
	$arrServicios = $handlerCons->consultaServiciosLiquidacion($fInicio, $fFin,$fempresa,'9,10');
	// var_dump($arrServicios);
	// exit();
 ?>

 <table class="table table-striped table-condensed" id="tabla-servicios">
 	<thead>
 		<tr>
 			<th>FECHA</th>
 			<th>DNI</th>
 			<th>ESTADO</th>
 		</tr>
 	</thead>
 	<tbody>
 		<?php 
 			if (!empty($arrServicios)) {
 				foreach ($arrServicios as $key => $value) {
 					echo "<tr>";
 						echo "<td>".$value->SERTT11_FECSER->format('d-m-Y')."</td>";
 						echo "<td>".$value->SERTT31_PERNUMDOC."</td>";
 						echo "<td>".$value->ESTADOS_DESCCI."</td>";
 					echo "</tr>";
 				}
 			}
 		 ?>
 	</tbody>
 </table>