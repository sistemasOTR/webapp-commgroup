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

  	// var_dump($fdesde,$plazas,$perfil);
  	// exit();
	$hora = (isset($_POST["hora"])?$_POST["hora"]:'');
	$user_id = (isset($_POST["user_id"])?$_POST["user_id"]:'');
	$cord_id = (isset($_POST["cord_id"])?$_POST["cord_id"]:'');
	$modo = (isset($_POST["modo"])?$_POST["modo"]:'');
	$fechaCord= (isset($_POST["fecha"])?$_POST["fecha"]:'');
	$ingreso = (isset($_POST["estados"])?$_POST["estados"]:'');
	$estado = (isset($_POST["ingreso"])?$_POST["ingreso"]:'');
	$observacion = (isset($_POST["observacion"])?$_POST["observacion"]:'');
	// $hora=date('H:i');
	if ($modo=='historial') {

    $fecha=$fechaCord." ".$hora;
    $err = "../../../../index.php?view=asistencias_historial&fdesde=".$fdesde."&fhasta=".$fhasta."&iduser=".$iduser."&err=";     		
	$info = "../../../../index.php?view=asistencias_historial&fdesde=".$fdesde."&fhasta=".$fhasta."&iduser=".$iduser."&info=";
	$user_id=$iduser;
	

    }
	elseif ($modo=='gerenciaBO') {
    $fecha=$fechaCord." ".$hora;
    $user_id=$cord_id;
    $err = "../../../../index.php?view=asistencias_gerenciaBO&fdesde=".$fdesde."&fplaza=".$plazas."&err=";     		
	$info = "../../../../index.php?view=asistencias_gerenciaBO&fdesde=".$fdesde."&fplaza=".$plazas."&info=";

	}
    elseif ($modo=='coordinador') {
    $fecha=$fechaCord." ".$hora;
    $user_id=$cord_id;
    $err = "../../../../index.php?view=asistencias&fdesde=".$fechaCord."&err=";     		
	$info = "../../../../index.php?view=asistencias&fdesde=".$fechaCord."&info=";

    }
    else{
    	
    $fecha=$dFecha->FechaHoraActual();
    $ingreso=$estado;
    $err = "../../../../index.php?view=panelcontrol&err=";     		
	$info = "../../../../index.php?view=panelcontrol&info=";
    }
    
     		
	try {
		$handler->newAsistencia(intval($user_id),$observacion,$fecha,intval($ingreso));

		$msj="Items Enviados";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}

?>