<?php
	include_once "../../../Config/config.ini.php";

	include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php";	
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    
    $dFecha= new Fechas;
    $handler=new HandlerAsistencias;

    $fdesde = (isset($_GET["fdesde"])?$_GET["fdesde"]:'');
    $fhasta = (isset($_GET["fhasta"])?$_GET["fhasta"]:'');
    $iduser = (isset($_GET["iduser"])?$_GET["iduser"]:'');
  	$plazas = (isset($_GET["fplaza"])?$_GET["fplaza"]:0);
  	$perfil = (isset($_GET["perfil"])?$_GET["perfil"]:'');

  	


	$hora = (isset($_POST["hora_edit"])?$_POST["hora_edit"]:'');

	$edit_id = (isset($_POST["edit_id"])?$_POST["edit_id"]:'');

	$ingresos = (isset($_POST["ingresos"])?$_POST["ingresos"]:'');


	$fechaCord= (isset($_POST["fecha_edit"])?$_POST["fecha_edit"]:'');
	
	$observacion = (isset($_POST["observacion"])?$_POST["observacion"]:'');
	// $hora=date('H:i');
	if ($perfil=='historial') {

	// var_dump($fdesde,$fdesde,$iduser,$perfil);
 //  	exit();
    	
    $fecha=$fechaCord." ".$hora;
    $err = "../../../../index.php?view=asistencias_historial&fdesde=".$fdesde."&fhasta=".$fhasta."&iduser=".intval($iduser)."&err=";     		
	$info = "../../../../index.php?view=asistencias_historial&fdesde=".$fdesde."&fhasta=".$fhasta."&iduser=".intval($iduser)."&info=";


    }
    elseif ($perfil=='gerenciaBO') {
    	
    $fecha=$fechaCord." ".$hora;
    $err = "../../../../index.php?view=asistencias_gerenciaBO&fdesde=".$fdesde."&fplaza=".$plazas."&err=";     		
	$info = "../../../../index.php?view=asistencias_gerenciaBO&fdesde=".$fdesde."&fplaza=".$plazas."&info=";

    }else{

    $fecha=$fechaCord." ".$hora;
  	 $err = "../../../../index.php?view=asistencias&fdesde=".$fechaCord."&err=";     		
	$info = "../../../../index.php?view=asistencias&fdesde=".$fechaCord."&info=";

}
    // var_dump($fecha);
    // exit();
	     		

	try {
		$handler->updateAsistencia($edit_id,$fecha,$observacion,intval($ingresos));

		$msj="Items Enviados";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}

?>