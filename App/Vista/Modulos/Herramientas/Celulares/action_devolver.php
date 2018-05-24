<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlercelulares.class.php";
	
	$hanlder = new HandlerCelulares();

	$entId = (isset($_POST["entId"])?$_POST["entId"]:'');
	$fechaDev = (isset($_POST["fechaDev"])?$_POST["fechaDev"]:'');
	$devNroLinea = (isset($_POST["devNroLinea"])?$_POST["devNroLinea"]:'');
	$devIMEI = (isset($_POST["devIMEI"])?$_POST["devIMEI"]:'');
	$obs = (isset($_POST["txtObsDev"])?$_POST["txtObsDev"]:'');
	
	$err = "../../../../../index.php?view=celulares&err=";     		
	$info = "../../../../../index.php?view=celulares&info=";     		

	try {

		$hanlder->devolverLinea($entId,$fechaDev,$devNroLinea,$devIMEI,$obs);
		
		
		$msj="Línea devuelta con éxito.";
				
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>