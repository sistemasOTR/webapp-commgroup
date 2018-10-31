<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handleragenda.class.php"; 
	
	$handlerAgenda = new HandlerAgenda();

	$id = (isset($_POST["tipo_id"])?$_POST["tipo_id"]:'');
	$nombre = (isset($_POST["nombre"])?$_POST["nombre"]:'');
	$accion = (isset($_POST["accion"])?$_POST["accion"]:'');
	$color = (isset($_POST["color"])?$_POST["color"]:'');
	// var_dump($productividad);
	// exit();
		
	
	$err = "../../../../index.php?view=agenda_estados&err=";     		
	$info = "../../../../index.php?view=agenda_estados&info="; 
	    		

	try {

		if ($accion=='nuevo') {
			$handlerAgenda->newEstado($nombre,$color);
		}else{
	    	$handlerAgenda->updateEstados($id,$nombre,$color);
		}		
		
		$msj="El estado se guardo con éxito.";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>