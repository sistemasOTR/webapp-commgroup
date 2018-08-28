<?php

    include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlersueldos.class.php"; 
	
	$handler = new HandlerSueldos;

    $categoria=(isset($_POST["categoria"])?$_POST["categoria"]:'');
    $id=(isset($_POST["tipo_id"])?$_POST["tipo_id"]:'');
    $accion=(isset($_POST["accion"])?$_POST["accion"]:'');

    // var_dump($categoria);
    // exit(); 
	

	
	$err = "../../../../index.php?view=sueldos_conceptos&err=";     		
	$info = "../../../../index.php?view=sueldos_conceptos&info=";   

	if ($accion=='nuevo') {  		

	try {
		$handler->newConcepto($categoria);

		$msj="Concepto creado con éxito";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}

	}

 else {
	try {

   $handler->updateConcepto($id,$categoria);

		$msj="Concepto editado con éxtio";
		header("Location: ".$info.$msj);

		} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
		}

	}

?>	