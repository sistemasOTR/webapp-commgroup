<?php

    include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php"; 
	
	$handler = new HandlerLegajos;

    $categoria=(isset($_POST["categoria"])?$_POST["categoria"]:'');

    // var_dump($categoria);
    // exit();
	

	
	$err = "../../../../index.php?view=legajos_categorias&err=";     		
	$info = "../../../../index.php?view=legajos_categorias&info=";     		

	try {
		$handler->crearCategoria($categoria);

		$msj="Categoria Cargada";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}



?>	