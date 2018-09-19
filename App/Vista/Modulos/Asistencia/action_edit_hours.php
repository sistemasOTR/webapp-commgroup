<?php
	include_once "../../../Config/config.ini.php";

	include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php";	
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    
    $dFecha= new Fechas;
    $handler=new HandlerAsistencias;

	$hora = (isset($_POST["hora_edit"])?$_POST["hora_edit"]:'');

	$edit_id = (isset($_POST["edit_id"])?$_POST["edit_id"]:'');


	$fechaCord= (isset($_POST["fecha_edit"])?$_POST["fecha_edit"]:'');
	
	$observacion = (isset($_POST["observacion"])?$_POST["observacion"]:'');
	// $hora=date('H:i');
   

    $fecha=$fechaCord." ".$hora;
  	 $err = "../../../../index.php?view=asistencias&fdesde=".$fechaCord."&err=";     		
	$info = "../../../../index.php?view=asistencias&fdesde=".$fechaCord."&info=";


    // var_dump($fecha,$edit_id,$observacion);
    // exit();
	     		

	try {
		$handler->updateAsistencia($edit_id,$fecha,$observacion);

		$msj="Items Enviados";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}

?>