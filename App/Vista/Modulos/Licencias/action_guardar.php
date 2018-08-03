<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php"; 
	
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	
	$f_fecha = new Fechas;
	$handler = new HandlerLicencias();

	$fecha = $f_fecha->FechaActual();
	$tipoLiencia = (isset($_POST["tipo_licencia"])?$_POST["tipo_licencia"]:'');	
	$tipoUsuario = (isset($_POST["tipo_usuario"])?$_POST["tipo_usuario"]:'');	
	$userSistema = (isset($_POST["userSistema"])?$_POST["userSistema"]:'');	

	$fecha_desde = (isset($_POST["fecha_desde"])?$_POST["fecha_desde"]:'');
	$fecha_hasta = (isset($_POST["fecha_hasta"])?$_POST["fecha_hasta"]:'');

	$observaciones = (isset($_POST["observaciones"])?$_POST["observaciones"]:'');;

	$adjunto1 = (isset($_FILES["adjunto1"])?$_FILES["adjunto1"]:'');
	$adjunto2 = (isset($_FILES["adjunto2"])?$_FILES["adjunto2"]:'');
	
	$err = "../../../../index.php?view=licencias_carga&err=";     		
	$info = "../../../../index.php?view=licencias_carga&info=";     		
  
  if ($userSistema != 'GESTOR') {
 
  	try {
		$handler->guardarLicencias($fecha,$tipoUsuario,$tipoLiencia,$observaciones,$fecha_desde,$fecha_hasta,$adjunto1,$adjunto2,$aprobadoCo=true);

		$msj="Item Cargado";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
  }
  else{
  	
  	try {
		$handler->guardarLicencias($fecha,$tipoUsuario,$tipoLiencia,$observaciones,$fecha_desde,$fecha_hasta,$adjunto1,$adjunto2,$aprobadoCo=false);

		$msj="Item Cargado";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
  }
	
	
?>