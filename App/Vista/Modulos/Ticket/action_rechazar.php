<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlertickets.class.php"; 
	
	$err = "../../../../index.php?".$_POST["url_redirect"]."&err=";     		
	$info = "../../../../index.php?".$_POST["url_redirect"]."&info=";   

	$handler = new HandlerTickets();

	$id = (isset($_POST["id"])?$_POST["id"]:'');
	$obsRechazo = (isset($_POST["txtObs"])?$_POST["txtObs"]:'');
	
	try {
		$handler->rechazarTicketsAprob($id,$obsRechazo);

		$msj="Ticket Desaprobado";
		header("Location: ".$info.$msj);
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
?>