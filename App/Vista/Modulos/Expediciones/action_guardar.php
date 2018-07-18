<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 
	
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	
	$f_fecha = new Fechas;
	$hanlder = new HandlerExpediciones();

	
    $plaza=(isset($_POST["plaza"])?$_POST["plaza"]:'');
	$fecha = $f_fecha->FechaActual();
	$usuario = (isset($_POST["usuario"])?$_POST["usuario"]:'');
	$detalle = (isset($_POST["detalle"])?$_POST["detalle"]:'');
	$observaciones = "";
	$item = (isset($_POST["slt_item"])?$_POST["slt_item"]:'');
	$cant = (isset($_POST["cantidad"])?$_POST["cantidad"]:'');
	$tipo = (isset($_POST["tipoUsuario"])?$_POST["tipoUsuario"]:'');
	$estados = false;
	$entregada=0;

	if (trim($tipo) != 'COORDINADOR') {
		$plaza = $tipo;
	}
	
	$err = "../../../../index.php?view=exp_solicitud&err=";     		
	$info = "../../../../index.php?view=exp_solicitud&info=";     		

	try {
		$hanlder->guardarItemExpedicion($fecha,$usuario,$detalle,$observaciones,$item,$cant,$estados,$entregada,$plaza);

		$msj="Item Cargado";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>