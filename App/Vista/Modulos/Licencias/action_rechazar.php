<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php"; 
	
	$handler = new HandlerLicencias();

	$id = (isset($_POST["id"])?$_POST["id"]:'');
	$fecha = (isset($_POST["fechaElim"])?$_POST["fechaElim"]:'');
	$observaciones = (isset($_POST["observaciones"])?$_POST["observaciones"]:'');
	$url = (isset($_POST["url_redireccion"])?$_POST["url_redireccion"]:'');

	$err = "../../../../index.php?view=licencias_control".$url."&err=";     		
	$info = "../../../../index.php?view=licencias_control".$url."&info=";    

	try {
		$handler->rechazarLicencias($id,$fecha,$observaciones);

		$msj="Licencia Aprobada";
		header("Location: ".$info.$msj);
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
?>