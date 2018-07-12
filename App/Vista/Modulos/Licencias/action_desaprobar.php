<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php"; 

	$fdesde=(isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  	$fhasta=(isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual());    
  	$fusuario=(isset($_GET["fusuario"])?$_GET["fusuario"]:'');
  	$festados=(isset($_GET["festados"])?$_GET["festados"]:'');
  	$cord=(isset($_GET["cord"])?$_GET["cord"]:'');


  	if ($cord) {
  		$err = "../../../../index.php?view=licencias_controlcoord&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$fusuario."&festados=".$festados."&err=";     		
	    $info = "../../../../index.php?view=licencias_controlcoord&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$fusuario."&festados=".$festados."&info=";   	
  	}
    else {
	$err = "../../../../index.php?view=licencias_control&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$fusuario."&festados=".$festados."&err=";     		
	$info = "../../../../index.php?view=licencias_control&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$fusuario."&festados=".$festados."&info="; 
	
	   }

	$handler = new HandlerLicencias();

	$id = (isset($_GET["id"])?$_GET["id"]:'');

	try {
		$handler->desaprobarLicencias($id);

		$msj="Licencia Desaprobada";
		header("Location: ".$info.$msj);
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
?>