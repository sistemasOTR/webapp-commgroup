<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php"; 
	
	$handlerAsis = new HandlerAsistencias();

	$perfil = (isset($_POST["perfil"])?$_POST["perfil"]:'');
	$id = (isset($_POST["tipo_id"])?$_POST["tipo_id"]:'');
	$nombre = (isset($_POST["nombre"])?$_POST["nombre"]:'');
	$observacion2 = (isset($_POST["observacion2"])?$_POST["observacion2"]:'');
	$accion = (isset($_POST["accion"])?$_POST["accion"]:'');
	$color = (isset($_POST["color"])?$_POST["color"]:'');
	$productividad = (isset($_POST["productividad"])?$_POST["productividad"]:'');
	// var_dump($productividad);
	// exit();
		
	
	$err = "../../../../index.php?view=asistencias_estados&err=";     		
	$info = "../../../../index.php?view=asistencias_estados&info="; 
	    		

	try {

		if ($accion=='nuevo') {
		$handlerAsis->newEstado($nombre,$observacion2,intval($perfil),$color,$productividad);
		}else{
	     $handlerAsis->updateEstados($id,$nombre,$observacion2,intval($perfil),$color,$productividad);
		}		
		
		$msj="El estado se guardo con éxito.";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>