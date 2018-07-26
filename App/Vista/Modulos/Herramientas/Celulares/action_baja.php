<<?php
	include_once "../../../../Config/config.ini.php";		

	include_once PATH_NEGOCIO."Modulos/handlercelulares.class.php";
	
	$hanlder = new HandlerCelulares();

	$id = (isset($_POST["id"])?$_POST["id"]:'');

	try {
		$handler->baja($id);

		
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
?>
	
?>