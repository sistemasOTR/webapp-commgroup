<?php 
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlertickets.class.php"; 

	$handler = new HandlerTickets();

	$id = (isset($_POST["id_eliminar"])?$_POST["id_eliminar"]:'');
	$fechafin = (isset($_POST["fechafin"])?$_POST["fechafin"]:'');

	try {
		
		$err = "../../../../index.php?view=tickets_reintegros&err=";     		
		$info = "../../../../index.php?view=tickets_reintegros&info=";     		

		$handler->eliminarReintegro($id,$fechafin);
		
		$msj="Reintegro Eliminado";
		header("Location: ".$info.$msj);																						
		
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}





?>