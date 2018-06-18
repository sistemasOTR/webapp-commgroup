<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerimpresoras.class.php";
	
	$hanlder = new HandlerImpresoras();

	$serialNro = (isset($_POST["serialNro"])?$_POST["serialNro"]:'');
	$fechaCompra = (isset($_POST["fechaCompra"])?$_POST["fechaCompra"]:'');
	$precioCompra = (isset($_POST["precioCompra"])?$_POST["precioCompra"]:'');
	$userAprobacion = (isset($_POST["userAprobacion"])?$_POST["userAprobacion"]:'');
	$fechaActual = (isset($_POST["fechaActual"])?$_POST["fechaActual"]:'');
	
	$err = "../../../../../index.php?view=impresora_detalle&fserialNro=".$serialNro."&err=";     		
	$info = "../../../../../index.php?view=impresora_detalle&fserialNro=".$serialNro."&info=";     		

	try {

		$hanlder->editarImpresora($serialNro,$fechaCompra,$precioCompra,$userAprobacion,$fechaActual);
		$msj="Impresora actualizada con éxito.";
		
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>