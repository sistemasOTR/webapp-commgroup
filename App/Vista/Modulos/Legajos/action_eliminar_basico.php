 <?php 

 	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php"; 
	
	$handler = new HandlerLegajos;
    
    $id=(isset($_POST["id_eliminar"])?$_POST["id_eliminar"]:'');
		
	$err = "../../../../index.php?view=legajos_basicos&err=";     		
	$info = "../../../../index.php?view=legajos_basicos&info=";     		


	try {
		$handler->eliminarBasicos($id);

		$msj="Basico Eliminado";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}



?>	