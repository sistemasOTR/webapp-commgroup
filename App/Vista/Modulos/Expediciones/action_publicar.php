<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 
	

	$hanlder = new HandlerExpediciones();

	$id_usuario = (isset($_GET["id_usuario"])?$_GET["id_usuario"]:'');

	
	$err = "../../../../index.php?view=exp_solicitud&err=";     		
	$info = "../../../../index.php?view=exp_solicitud&info=";     		

	try {
		$hanlder->publicacionItems($id_usuario);

		$msj="Items Enviados";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>