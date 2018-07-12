<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlertickets.class.php"; 
	
	$fdesde=(isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  	$fhasta=(isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());    
  	$fusuario=(isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  	$festados=(isset($_GET["festados"])?$_GET["festados"]:'');
	
	$err = "../../../../index.php?view=tickets_aprobar&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$fusuario."&festados=".$festados."&err=";      		
	$info = "../../../../index.php?view=tickets_aprobar&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$fusuario."&festados=".$festados."&info=";    

	$handler = new HandlerTickets();

	$id = (isset($_GET["id"])?$_GET["id"]:'');

	try {
		$handler->desaprobarTickets($id);

		$msj="Ticket Desaprobado";
		header("Location: ".$info.$msj);
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
?>