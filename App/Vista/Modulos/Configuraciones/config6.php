<?php
	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
	include_once PATH_NEGOCIO."Sistema/handlersupervisor.class.php"; 
	include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 

	$url_action = PATH_VISTA.'Modulos/Configuraciones/action_config6.php';  
    $fecha= new Fechas;
	$handler = new HandlerSupervisor;
	$arrSupervisor = $handler->selectAllSupervisor();
?>

<div class='col-md-12'>
	<form action="<?php echo $url_action; ?>" method="post">
		<div class="box">
			<div class="box-header">
				<i class="fa fa-cog"></i>
			  	<h3 class="box-title">Objetivos por Supervisor</h3>	
			  	<div class="form-group">
			  		<?php 
			  		$handlerFecha = new HandlerPuntaje;
					$fechaPuntaje = $handlerFecha->buscarFechaPuntajeSupervisor();
					echo "<p style='padding-left:25px;'>Fecha de vigencia: <strong>".$fechaPuntaje->format('d-m-Y')."</strong></p>";
			  	 ?>
			  	 <label style="float: left;margin-right: 15px;padding-top: 6px;padding-left: 25px;">Nueva Vigencia</label>
			  	 <input type="date" class="form-control" style="width: 200px; float: left;" name="txtFechaVigencia" id="txtFechaVigencia" value="<?php echo date('Y-m-d'); ?>" data-fecha="<?php echo $fecha->FechaActual() ; ?>" onchange="validarFecha(<?php echo "'".$fechaPuntaje->format('Y-m-d')."'"; ?>)">
	            	<button type="submit" class="btn btn-success pull-right">Guardar</button>            
	            </div>  
			</div>
			<div class="box-body">
				<div class="box-body table-responsive">
				  	<table class="table table-striped table-condensed" id='tabla'>
					    <thead>
					    	<tr>
						    	<th style='width: 25%;'>Supervisor</th>
						    	<th>Objetivo Suma Plaza</th>
						      	<th>OBJETIVO
						      		<i class="fa fa-question-circle" data-toggle="tooltip" title="" data-original-title="Objetivo para cálculo en puntajes del gestor"></i>
						      	</th>					      	
						    </tr>
						</thead>
						<tbody>
							<?php

						    	if(!empty($arrSupervisor))
						    	{						    		
						    		foreach ($arrSupervisor as $key => $value) {


						    			$handlerP = new HandlerPuntaje;
						    			$objetivo = $handlerP->buscarObjetivoSupervisor($value['id']);
						    			$objetivoPlazas = $handlerP->obtenerPuntajeSupervisor($value['id']);
						    			$url_detalle = 'index.php?view=detalle&id='.$value['id'].'&admin=supervisor';
						    			if (intval($objetivo)==0) {	
						    				$vista="<i class='fa fa-eye text-gray'></i>";
						    			} else{
						    				$vista="<a href='".$url_detalle."'><i class='fa fa-eye'></i>";
						    			}

						    			echo "
					    				<tr>
					    					<td>".$vista."</td>
									    	<td>".$value['nombre']."</td>
									    	<td>".$objetivoPlazas."</td>
											<td><input type='number' step='0.01' class='form-control' name='id_".$value['id']."' style='width: 100%;' value='".$objetivo."'></td>
									    </tr>";
						    		}
						    	}
						    ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="box-footer">
				<div class="form-group">
	            	<button type="submit" class="btn btn-success pull-right">Guardar</button>            
	            </div>
			</div>
		</div>
	</form>
</div>
<script>

	function validarFecha(anterior_vigencia){
        var anteriorvigencia = anterior_vigencia ;
        var today = document.getElementById("txtFechaVigencia").getAttribute('data-fecha');
        var fechaValue=document.getElementById("txtFechaVigencia").value;
       
        if (fechaValue <= anteriorvigencia) {
        	alert("error fecha ya ingresada");
        	document.getElementById("txtFechaVigencia").value = today;	
        }

	}

 
	
</script>