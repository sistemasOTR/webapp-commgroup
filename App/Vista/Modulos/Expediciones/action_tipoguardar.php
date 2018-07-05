<?php

      include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 
	
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	
	//$f_fecha = new Fechas;
	$hanlder = new HandlerExpediciones();

	
	$tipo = (isset($_POST["tipo"])?$_POST["tipo"]:'');
	$item = (isset($_POST["item"])?$_POST["item"]:'');
	$observacion = (isset($_POST["observacion"])?$_POST["observacion"]:'');
	$cant = (isset($_POST["cantidad"])?$_POST["cantidad"]:'');
	$estados = 1;
	
	$err = "../../../../index.php?view=exp_solicitud&err=";     		
	$info = "../../../../index.php?view=exp_solicitud&info=";     		

	try {
		$hanlder->guardarItemExpedicion($tipo,$item,$observacion,$cant,$estados);

		$msj="Item Cargado";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}





?>