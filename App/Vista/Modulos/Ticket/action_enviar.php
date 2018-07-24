<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlertickets.class.php"; 
	
	$err = "../../../../index.php?".$_POST["url_redirect"]."&err=";     		
	$info = "../../../../index.php?".$_POST["url_redirect"]."&info=";    

	$handler = new HandlerTickets();

	$id = (isset($_POST["id"])?$_POST["id"]:'');
	$reintegro = (isset($_POST["reintegro"])?$_POST["reintegro"]:'');
	$aledanio = (isset($_POST["aledanio"])?$_POST["aledanio"]:'');
	$traslado = (isset($_POST["traslado"])?$_POST["traslado"]:'');
	$aledNombre = (isset($_POST["aledNombre"])?$_POST["aledNombre"]:'');
	$operaciones = (isset($_POST["operaciones"])?$_POST["operaciones"]:'');


	if($aledanio=="on")
		$aledanio_val = true;
	else
		$aledanio_val = false;

	if($traslado=="on") {
		$traslado_val = true;
		$reintegro = $reintegro + 66;
	} else {
		$traslado_val = false;
	}
		
	

	try {
		$handler->enviarTickets($id,$reintegro,$aledanio_val,$operaciones,$aledNombre,$traslado_val);

		$msj="Ticket Enviado";
		header("Location: ".$info.$msj);
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
?>