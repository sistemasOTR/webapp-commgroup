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
	$tipo = (isset($_POST["txtTipoBaja"])?$_POST["txtTipoBaja"]:'');
	
	$err = "../../../../../index.php?view=impresorasxplaza&err=";     		
	$info = "../../../../../index.php?view=impresorasxplaza&info=";     		

	try {

		$hanlder->devolverImpresora($asigId,$fechaDev,$obs,$tipo);
		$msj="Impresora devuelta con éxito.";
		// var_dump($tipo);
		// exit();
		if ($tipo == 'condi') {
			$hanlder->asignarImpresora($serialNro,$fechaAsig,$plaza,$gestorId,$obs);
		} else {
			$hanlder->bajaImpresora($serialNro,$fechaDev,$tipo,$obs);
		}

			header("Location: ".$info.$msj.'&pop=yes&fID='.$asigId.'&fTipo='.$tipo);
		
		

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>