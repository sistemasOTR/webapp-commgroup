<?php 
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlersueldos.class.php"; 
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php"; 

	$handler = new HandlerSueldos;

	$idsueldo=(isset($_GET["idsueldo"])?$_GET["idsueldo"]:'');

	$err = "../../../../index.php?view=sueldos_remun&err=";
	$info = "../../../../index.php?view=sueldos_remun&info=";

	try {

		$handler->cancelarSueldo($idsueldo);
		$handler->deleteItemsBySueldo($idsueldo);
		
		$msj="Sueldo eliminado con éxito";
		header("Location: ".$err.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}


 ?>