<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlercelulares.class.php";
	
	$hanlder = new HandlerCelulares();

	
	$fechaCompra = (isset($_POST["txtFechaCompra"])?$_POST["txtFechaCompra"]:'');
	$IMEI = (isset($_POST["txtIMEI"])?$_POST["txtIMEI"]:'');
	$marca = (isset($_POST["txtMarca"])?$_POST["txtMarca"]:'');
	$modelo = (isset($_POST["txtModelo"])?$_POST["txtModelo"]:'');
	$precioCompra = (isset($_POST["txtPrecioCompra"])?$_POST["txtPrecioCompra"]:'');
	
	//var_dump($equipo);
	//exit();
	$err = "../../../../../index.php?view=celulares&err=";     		
	$info = "../../../../../index.php?view=celulares&info=";     		

	try {

		$hanlder->nuevoEquipo($fechaCompra,$IMEI,$marca,$modelo,$precioCompra);
		
		
		$msj="El equipo ".$marca." ".$modelo." se ha dado de alta con éxito";
				
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>