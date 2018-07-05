<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 
	
	$hanlder = new HandlerExpediciones();

	$id = (isset($_POST["item_id"])?$_POST["item_id"]:'');
	$nombre = (isset($_POST["nombre_item"])?$_POST["nombre_item"]:'');
	$descripcion = (isset($_POST["descripcion"])?$_POST["descripcion"]:'');
	$grupo = (isset($_POST["grupo"])?$_POST["grupo"]:'');
    $estado = (isset($_POST["estado"])?$_POST["estado"]:'');
    $stock = (isset($_POST["stock"])?$_POST["stock"]:'');
    $ptopedido = (isset($_POST["ptopedido"])?$_POST["ptopedido"]:'');

   	$err = "../../../../index.php?view=exp_item_abm&err=";     		
	$info = "../../../../index.php?view=exp_item_abm&info="; 
	    		

	try {

		$hanlder->guardarItemABM($nombre,$descripcion,$id,$grupo,$estado,$stock,$ptopedido);
		$msj="El Item para expediciones se guardo con éxito.";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>