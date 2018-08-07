<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerlicencias.class.php";   
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";  
	 $dFecha = new Fechas;

	$handler = new HandlerLicencias();

	$id= (isset($_POST["id"])?$_POST["id"]:'');
	$fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:$dFecha->FechaActual());
  	$fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:$dFecha->FechaActual()); 
  	$fusuario=(isset($_POST["fusuario"])?$_POST["fusuario"]:'');
  	$festados=(isset($_POST["festados"])?$_POST["festados"]:'');
  	$cord=(isset($_POST["cord"])?$_POST["cord"]:'');
	$observaciones = (isset($_POST["observaciones"])?$_POST["observaciones"]:'');



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
	$err = "../../../../index.php?view=licencias_control&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$fusuario."&festados=".$festados."&err=";     		
	$info = "../../../../index.php?view=licencias_control&fdesde=".$fdesde."&fhasta=".$fhasta."&fusuario=".$fusuario."&festados=".$festados."&info=";    

	
		$handler->aprobarLicencias($id,$observaciones);

		$msj="Licencia Aprobada";
		header("Location: ".$info.$msj);
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}

}
?>