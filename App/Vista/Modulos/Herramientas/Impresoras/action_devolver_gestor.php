<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerimpresoras.class.php";
	
	$hanlder = new HandlerImpresoras();

	$asigId = (isset($_POST["devAsigId"])?$_POST["devAsigId"]:'');

	
	$serialNro = (isset($_POST["devSerialNro"])?$_POST["devSerialNro"]:'');
	$fechaDev = (isset($_POST["fechaDev"])?$_POST["fechaDev"]:'');
	$fechaAsig = (isset($_POST["fechaDev"])?$_POST["fechaDev"]:'');
	$plaza = (isset($_POST["devPlaza"])?$_POST["devPlaza"]:'');
	$gestorId = (isset($_POST["slt_gestor"])?$_POST["slt_gestor"]:0);
	$obs = (isset($_POST["txtDevObs"])?$_POST["txtDevObs"]:'');
	
	$err = "../../../../../index.php?view=impresorasxplaza&err=";     		
	$info = "../../../../../index.php?view=impresorasxplaza&info=";     		

	try {

		$hanlder->devolverImpresora($asigId,$fechaDev,$obs);
		$hanlder->asignarImpresora($serialNro,$fechaAsig,$plaza,$gestorId,$obs);
		
		
		$msj="Impresora devuelta con éxito.";
				
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>