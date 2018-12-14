<?php 
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerobjetivos.class.php"; 

	$handlerObj = new HandlerObjetivos;

	$id=(isset($_POST["id"])?$_POST["id"]:'');


	$err = "../../../../index.php?view=objetivos&vista=2&err=";     		
	$info = "../../../../index.php?view=objetivos&vista=2&info=";

	// var_dump($id);
	// exit();

	try {

		$handlerObj->eliminarGestCoor($id);

		$msj="Se ha eliminado el gestor con más de una función";
		header("Location: ".$info.$msj);
	  			
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}  		


?>