<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlercelulares.class.php";
	
	$hanlder = new HandlerCelulares();

	$nroLinea = (isset($_POST["txtNroLinea"])?$_POST["txtNroLinea"]:'');
	$idUsuario = (isset($_POST["txtIdUsuario"])?$_POST["txtIdUsuario"]:0);
	$mesConsumo = (isset($_POST["txtMesConsumo"])?$_POST["txtMesConsumo"]:'');
	$basico = (isset($_POST["txtBasico"])?$_POST["txtBasico"]:0);
	$real = (isset($_POST["txtReal"])?$_POST["txtReal"]:0);
	$excedente = (isset($_POST["txtExcedente"])?$_POST["txtExcedente"]:0);
	$conceptoExc = (isset($_POST["txtObs"])?$_POST["txtObs"]:'');
	
	$err = "../../../../../index.php?view=detalle_linea&fNroLinea=".$nroLinea."&err=";     		
	$info = "../../../../../index.php?view=detalle_linea&fNroLinea=".$nroLinea."&info=";     		

	try {

		$hanlder->agregarConsumo($nroLinea,$idUsuario,$mesConsumo,$basico,$real,$excedente,$conceptoExc);
		
		$msj= 'Consumo agregado con éxito';
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>