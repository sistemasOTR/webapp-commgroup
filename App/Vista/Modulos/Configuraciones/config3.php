<?php
	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
	include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";  

	$url_action = PATH_VISTA.'Modulos/Configuraciones/action_config3.php';  
 
    $fecha= new Fechas;
	$handler = new HandlerSistema;
	$arrCliente = $handler->selectAllEmpresa();
?>

<div class='col-md-12'>
	<form action="<?php echo $url_action; ?>" method="post">
		<div class="box box-solid">
			<div class="box-header with-border">
				<i class="fa fa-cog"></i>
			  	<h3 class="box-title">Puntajes por clientes</h3>
			  	<?php 
			  		$handlerFecha = new HandlerPuntaje;
					$fechaPuntaje = $handlerFecha->buscarFechaPuntaje();
					echo "<p style='padding-left:25px;'>Fecha de vigencia: <strong>".$fechaPuntaje->format('d-m-Y')."</strong></p>";
			  	 ?>
			  	 <label style="float: left;margin-right: 15px;padding-top: 6px;padding-left: 25px;">Nueva Vigencia</label>
			  	 <input type="date" class="form-control" style="width: 200px; float: left;" name="txtFechaVigencia" id="txtFechaVigencia" value="<?php echo date('Y-m-d'); ?>" data-fecha="<?php echo $fecha->FechaActual() ; ?>" onchange="validarFecha(<?php echo "'".$fechaPuntaje->format('Y-m-d')."'"; ?>)">
			  	<a href="index.php?view=configuraciones" class="btn btn-default pull-right"><i class="ion-chevron-left"></i> Volver</a>            
	            
			</div>
			<div class="box-body">
				<div class="box-body table-responsive">
				  	<table class="table table-striped table-condensed" id='tabla'>
					    <thead>
					    	<tr>
					    		<th style='width: 5%;'>VER</th>
						    	<th style='width: 25%;'>EMPRESA</th>
						      	<th>PUNTAJE 
						      		<i class="fa fa-question-circle" data-toggle="tooltip" title="" data-original-title="Valor por servicio para cálculo en puntajes del gestor"></i>
						      	</th>
						    </tr>
						</thead>
						<tbody>
							<?php
								

						    	if(!empty($arrCliente))
						    	{
						    		foreach ($arrCliente as $key => $value) {	
						    			
						    			$handlerP = new HandlerPuntaje;
						    			$puntaje = $handlerP->buscarPuntaje($value->EMPTT11_CODIGO);
						    			$url_detalle = 'index.php?view=detalle&id='.$value->EMPTT11_CODIGO; 
						    			if ($puntaje==0) {	
						    				$vista="<i class='fa fa-eye text-gray'></i>";
						    			} else{
						    				$vista="<a href='".$url_detalle."'><i class='fa fa-eye'></i>";
						    			}
						    			
						    			

						    			echo "
					    				<tr>
					    				    <td>".$vista."</td>
									    	<td>".$value->EMPTT21_NOMBREFA."</td>
											<td><input type='number' step='0.01' class='form-control' name='id_".$value->EMPTT11_CODIGO."' style='width: 100%;' value='".$puntaje."'></td>
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