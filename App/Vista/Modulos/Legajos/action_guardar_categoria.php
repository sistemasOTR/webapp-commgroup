<?php

    include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php"; 
	
	$handler = new HandlerLegajos;

    $categoria=(isset($_POST["categoria"])?$_POST["categoria"]:'');
    $id=(isset($_POST["tipo_id"])?$_POST["tipo_id"]:'');
    $accion=(isset($_POST["accion"])?$_POST["accion"]:'');

    // var_dump($categoria);
    // exit(); 
	

	
	$err = "../../../../index.php?view=legajos_categorias&err=";     		
	$info = "../../../../index.php?view=legajos_categorias&info=";   

	if ($accion=='nuevo') {  		

	try {
		$handler->crearCategoria($categoria);

		$msj="Categoria Cargada";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}

	}

 else {
	try {

   $handler->updateCategoria($id,$categoria);

		$msj="Categoria Editada";
		header("Location: ".$info.$msj);

		} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
		}

	}

?>	