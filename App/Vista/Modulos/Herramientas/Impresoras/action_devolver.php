<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerimpresoras.class.php";
	
	$hanlder = new HandlerImpresoras();

	$asigId = (isset($_POST["asigId"])?$_POST["asigId"]:'');
	
	$fechaDev = (isset($_POST["fechaDev"])?$_POST["fechaDev"]:'');
	$obs = (isset($_POST["txtObs"])?$_POST["txtObs"]:'');
	
	$err = "../../../../../index.php?view=impresorasxplaza&err=";     		
	$info = "../../../../../index.php?view=impresorasxplaza&info=";     		

	try {

		$hanlder->devolverImpresora($asigId,$fechaDev,$obs);
		
		
		$msj="Impresora devuelta con éxito.";
				
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>