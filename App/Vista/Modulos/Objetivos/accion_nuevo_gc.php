<?php 
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerobjetivos.class.php"; 

	$handlerObj = new HandlerObjetivos;

	$id_gestor=(isset($_POST["slt_gestor"])?$_POST["slt_gestor"]:'');


	$err = "../../../../index.php?view=objetivos&vista=2&err=";     		
	$info = "../../../../index.php?view=objetivos&vista=2&info=";

	// var_dump($id);
	// exit();

	try {

		$handlerObj->nuevoGestCoor($id_gestor);

		$msj="Se ha agregado un nuevo gestor con doble función";
		header("Location: ".$info.$msj);
	  			
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}  		


?>