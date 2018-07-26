<?php

	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlercelulares.class.php";
	
	$handler = new HandlerCelulares();

	$id = (isset($_GET["id"])?$_GET["id"]:'');

	$err = "../../../../../index.php?view=celulares&active=ll&err=";     		
	$info = "../../../../../index.php?view=celulares&active=ll&info=";     		


	try {
		$handler->suspender($id);
		header("Location: ".$info."Línea ".$id." suspendida");

		
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
?>