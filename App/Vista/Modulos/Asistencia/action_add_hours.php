<?php
	include_once "../../../Config/config.ini.php";

	include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php";	
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    
    $dFecha= new Fechas;
    $handler=new HandlerAsistencias;
	$hora = (isset($_POST["hora"])?$_POST["hora"]:'');
	$user_id = (isset($_POST["user_id"])?$_POST["user_id"]:'');
	$cord_id = (isset($_POST["cord_id"])?$_POST["cord_id"]:'');
	$modo = (isset($_POST["modo"])?$_POST["modo"]:'');
	$fechaCord= (isset($_POST["fecha"])?$_POST["fecha"]:'');
	$estado = (isset($_POST["estado"])?$_POST["estado"]:'');
	$estados = (isset($_POST["estados"])?$_POST["estados"]:'');
	$observacion = (isset($_POST["observacion"])?$_POST["observacion"]:'');
	// $hora=date('H:i');
    if ($modo=='coordinador') {

    $fecha=$dFecha->FechaHoraActual();
    $estado=$estados;
    $user_id=$cord_id;
    $err = "../../../../index.php?view=asistencias&fdesde=".$fechaCord."&err=";     		
	$info = "../../../../index.php?view=asistencias&fdesde=".$fechaCord."&info=";

    }else{
    $fecha=$dFecha->FechaHoraActual();
    $err = "../../../../index.php?view=panelcontrol&err=";     		
	$info = "../../../../index.php?view=panelcontrol&info=";
    }
    if ($estado=='salida') {
    	$ingreso=false;
    }else{
    	$ingreso=true;
    }

	// var_dump($dFecha->FormatearFechas($fecha,"Y-m-d H:i:s","H:i"));
	// exit();

    // var_dump($fecha);
    // exit();
	     		

	try {
		$handler->newAsistencia($user_id,$observacion,$fecha,$ingreso);

		$msj="Items Enviados";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}

?>