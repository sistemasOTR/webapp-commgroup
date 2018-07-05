<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 
	
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	
	$f_fecha = new Fechas;
	$handler = new HandlerExpediciones();

	
    $id=(isset($_POST["id_agregar"])?$_POST["id_agregar"]:'');
    $usuario = (isset($_POST["usuario"])?$_POST["usuario"]:'');
    $cantidad = (isset($_POST["cantidad"])?$_POST["cantidad"]:'');
    $apedir = (isset($_POST["apedir"])?$_POST["apedir"]:'');
	$fecha = $f_fecha->FechaActual();

	
	$err = "../../../../index.php?view=exp_item_abm&err=";     		
	$info = "../../../../index.php?view=exp_item_abm&info=";     		

	try {
		$handler->agregarCompra($id,$usuario,$cantidad,$fecha);

		$msj="Item Agregado";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>