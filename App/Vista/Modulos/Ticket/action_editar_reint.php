<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";
	$handler = new HandlerTickets();

	$id = (isset($_POST["id"])?$_POST["id"]:'');
	$reintegro = (isset($_POST["reintegro"])?$_POST["reintegro"]:'');
	// $aledanio = (isset($_POST["aledanio"])?$_POST["aledanio"]:'');
	// $operaciones = (isset($_POST["operaciones"])?$_POST["operaciones"]:'');

	// if($aledanio=="on")
	// 	$aledanio_val = true;
	// else
	// 	$aledanio_val = false;

	try {
		$handler->editarTickets($id,$reintegro);

		
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
?>