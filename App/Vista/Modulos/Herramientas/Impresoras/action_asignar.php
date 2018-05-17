<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerimpresoras.class.php";
	
	$hanlder = new HandlerImpresoras();

	$serialNro = (isset($_POST["serialNro"])?$_POST["serialNro"]:'');
	
	$fechaAsig = (isset($_POST["fechaAsig"])?$_POST["fechaAsig"]:'');
	$plaza = (isset($_POST["slt_plaza"])?$_POST["slt_plaza"]:'');
	$gestorId = (isset($_POST["slt_gestor"])?$_POST["slt_gestor"]:'');
	$obs = (isset($_POST["txtObs"])?$_POST["txtObs"]:'');
	
	$err = "../../../../../index.php?view=impresorasxplaza&err=";     		
	$info = "../../../../../index.php?view=impresorasxplaza&info=";     		

	try {

		$hanlder->asignarImpresora($serialNro,$fechaAsig,$plaza,$gestorId,$obs);
		
		
		$msj="Impresora asignada con éxito.";
				
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>