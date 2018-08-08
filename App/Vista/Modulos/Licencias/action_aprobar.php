<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";   
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";  
	 $dFecha = new Fechas;

	$handler = new HandlerLicencias();

	$id= (isset($_GET["id"])?$_GET["id"]:'');
	$idR= (isset($_POST["idAprobar"])?$_POST["idAprobar"]:'');
	$fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  	$fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual()); 
  	$fusuario=(isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  	$festados=(isset($_GET["festados"])?$_GET["festados"]:'');
  	$cord=(isset($_GET["cord"])?$_GET["cord"]:'');
	$observaciones = (isset($_POST["observaciones"])?$_POST["observaciones"]:'');
	$url_redireccion = (isset($_POST["url_redireccion"])?$_POST["url_redireccion"]:'');


  	if (!empty($cord)) {
  		try {
  		$err = "../../../../index.php?view=licencias_controlcoord&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$fusuario."&festados=".$festados."&err=";     		
	    $info = "../../../../index.php?view=licencias_controlcoord&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$fusuario."&festados=".$festados."&info=";   

		$handler->aprobarLicenciasCoord($id);

		$msj="Licencia Aprobada";
		header("Location: ".$info.$msj);
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	   }	
  	}
    else {
    	try {
	$err = "../../../../index.php?view=licencias_control".$url_redireccion."&err=";     		
	$info = "../../../../index.php?view=licencias_control".$url_redireccion."&info=";    

	
		$handler->aprobarLicencias($idR,$observaciones);

		$msj="Licencia Aprobada";
		header("Location: ".$info.$msj);
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}

}
?>