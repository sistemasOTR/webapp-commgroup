<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php"; 
	
	$handler = new HandlerLicencias();

	$id = (isset($_POST["id"])?$_POST["id"]:'');
	$fecha = (isset($_POST["fechaElim"])?$_POST["fechaElim"]:'');
	$observaciones = (isset($_POST["observaciones"])?$_POST["observaciones"]:'');
	$url = (isset($_POST["url_redireccion"])?$_POST["url_redireccion"]:'');
	$fdesde=(isset($_GET["fdesde"])?$_GET["fdesde"]:'no fechaini');
  	$fhasta=(isset($_GET["fhasta"])?$_GET["fhasta"]:'no fechafin');    
  	$fusuario=(isset($_GET["fusuario"])?$_GET["fusuario"]:'no user');
  	$festados=(isset($_GET["festados"])?$_GET["festados"]:'no estado');
  	$cord=(isset($_GET["cord"])?$_GET["cord"]:'');


     if ($cord) {
  		$err = "../../../../index.php?view=licencias_controlcoord&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$fusuario."&festados=".$festados."&err=";     		
	    $info = "../../../../index.php?view=licencias_controlcoord&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$fusuario."&festados=".$festados."&info=";   	
  	}
    else {
	$err = "../../../../index.php?view=licencias_control&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$fusuario."&festados=".$festados."&err=";     		
	$info = "../../../../index.php?view=licencias_control&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$fusuario."&festados=".$festados."&info="; 
	
	   }    

	try {
		$handler->rechazarLicencias($id,$fecha,$observaciones);

		$msj="Licencia Rechazada";
		header("Location: ".$info.$msj);
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
?>