<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 
	

	$hanlder = new HandlerExpediciones();

	$i = (isset($_POST["id"])?$_POST["id"]:'');
	$fdesde = (isset($_POST["fdesde"])?$_POST["fdesde"]:'');
	$fhasta = (isset($_POST["fhasta"])?$_POST["fhasta"]:'');
	$fplaza = (isset($_POST["fplaza"])?$_POST["fplaza"]:'');
	$id=intval($i);

	// var_dump($id);
	// exit();

	
	$err = "../../../../index.php?view=exp_control_coordinador&fdesde=".$fdesde."&fhasta=".$fhasta."&fplaza=".$fplaza."&err="; 
	$info = "../../../../index.php?view=exp_control_coordinador&fdesde=".$fdesde."&fhasta=".$fhasta."&fplaza=".$fplaza."&info=";     		

	try {
		$hanlder->eliminarItemEnvio($id);

		$msj="Item Borrado";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>