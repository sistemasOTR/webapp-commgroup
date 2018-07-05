<?php

include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 
	
	$hanlder = new HandlerExpediciones();

	$id = (isset($_POST["id_eliminar"])?$_POST["id_eliminar"]:'');
 	
	$err = "../../../../index.php?view=exp_item_abm&err=";     		
	$info = "../../../../index.php?view=exp_item_abm&info="; 
	    		

	try {

		$hanlder->eliminarItemABM($id);
		
		$msj="El Item para expediciones se Elimino con éxito.";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}



?>