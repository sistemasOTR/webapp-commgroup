<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerimpresoras.class.php";
	
	$hanlder = new HandlerImpresoras();

	$serialNro = (isset($_POST["serialNro"])?$_POST["serialNro"]:'');
	$estado = (isset($_POST["estado"])?$_POST["estado"]:'');

	$fechaCompra = (isset($_POST["fechaCompra"])?$_POST["fechaCompra"]:'');
	$marca = (isset($_POST["marca"])?$_POST["marca"]:'');
	$modelo = (isset($_POST["modelo"])?$_POST["modelo"]:'');
	$precioCompra = (isset($_POST["precioCompra"])?$_POST["precioCompra"]:'');
	
	$err = "../../../../../index.php?view=impresorasxplaza&err=";     		
	$info = "../../../../../index.php?view=impresorasxplaza&info=";     		

	try {

		$hanlder->guardarImpresora($serialNro,$fechaCompra,$marca,$modelo,$precioCompra,$estado);
		
		switch ($estado) {
			case 'NUEVO':
				$msj="Impresora añadida con éxito.";
				break;
			case 'EDITAR':
				$msj="Impresora actualizada con éxito.";
				break;
			case 'ELIMINAR':
				$msj="Impresora dada de baja con éxito.";
				break;											
		}
		
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>