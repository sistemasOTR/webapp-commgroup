<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 
	
	$hanlder = new HandlerExpediciones();

	$id = (isset($_POST["tipo_id"])?$_POST["tipo_id"]:'');
	$nombre = (isset($_POST["grupo"])?$_POST["grupo"]:'');
	$accion = (isset($_POST["accion"])?$_POST["accion"]:'');
		
	
	$err = "../../../../index.php?view=exp_tipo_abm&err=";     		
	$info = "../../../../index.php?view=exp_tipo_abm&info="; 
	    		

	try {

		$hanlder->guardarTipoABM($nombre,$id,$accion);
		
		$msj="El tipo para expediciones se guardo con éxito.";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>