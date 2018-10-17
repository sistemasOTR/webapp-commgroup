<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php"; 
	
	$handlerAsis = new HandlerAsistencias();


	$id = (isset($_POST["id_eliminar"])?$_POST["id_eliminar"]:'');

	// var_dump($perfil,$id,$nombre,$accion);
	// exit();
		
	
	$err = "../../../../index.php?view=asistencias_estados&err=";     		
	$info = "../../../../index.php?view=asistencias_estados&info="; 
	    		

	try {

		
	     $handlerAsis->deletEstados($id);
			
		
		$msj="El estado se guardo con éxito.";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>