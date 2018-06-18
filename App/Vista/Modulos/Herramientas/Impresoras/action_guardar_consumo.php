<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerimpresoras.class.php";
	
	$handler = new HandlerImpresoras();

	$serialNro = (isset($_POST["consSerialNro"])?$_POST["consSerialNro"]:'');
	$fechaConsumo = (isset($_POST["consFecha"])?$_POST["consFecha"]:'');
	$plaza = (isset($_POST["consPlaza"])?$_POST["consPlaza"]:'');
	$contador = (isset($_POST["consContador"])?$_POST["consContador"]:'');
	$cambioTonner = (isset($_POST["consTonner"])?$_POST["consTonner"]:'');
	$KitA = (isset($_POST["consKitA"])?$_POST["consKitA"]:'');
	$cambioKitA = (isset($_POST["consCambioKitA"])?$_POST["consCambioKitA"]:'');
	$KitB = (isset($_POST["consKitB"])?$_POST["consKitB"]:'');
	$cambioKitB = (isset($_POST["consCambioKitB"])?$_POST["consCambioKitB"]:'');
	$consSamsung = (isset($_POST["consSamsung"])?$_POST["consSamsung"]:'');
	$cambioConsSamsung = (isset($_POST["consCambioSamsung"])?$_POST["consCambioSamsung"]:'');
	$UI = (isset($_POST["consUI"])?$_POST["consUI"]:'');
	$cambioUI = (isset($_POST["consCambioUI"])?$_POST["consCambioUI"]:'');
	$kitM = (isset($_POST["consKitM"])?$_POST["consKitM"]:'');
	$cambioKitM = (isset($_POST["consCambioKitM"])?$_POST["consCambioKitM"]:'');
	$consObs = (isset($_POST["txtObs"])?$_POST["txtObs"]:'');
	$userId = (isset($_POST["consUserId"])?$_POST["consUserId"]:'');
	
	$err = "../../../../../index.php?view=impresorasxplaza&err=";     		
	$info = "../../../../../index.php?view=impresorasxplaza&info=";     		

	try {
		
		$handler->guardarConsumo($serialNro,$fechaConsumo,$plaza,$contador,$cambioTonner,$KitA,$cambioKitA,$KitB,$cambioKitB,$consSamsung,$cambioConsSamsung,$UI,$cambioUI,$kitM,$cambioKitM,$consObs,$userId);
		$msj="Consumo guardado.";
				
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>