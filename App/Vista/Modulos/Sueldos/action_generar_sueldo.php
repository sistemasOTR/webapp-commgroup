<?php

    include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlersueldos.class.php"; 
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";  
	
	$handler = new HandlerSueldos;

    $fecha=(isset($_POST["fecha"])?$_POST["fecha"]:'');
    $periodo=(isset($_POST["periodo"])?$_POST["periodo"]:'');
    $usuario=(isset($_POST["slt_usuario"])?$_POST["slt_usuario"]:'');
    $tipo=(isset($_POST["slt_tipo"])?$_POST["slt_tipo"]:'');

    $handlerUs = new HandlerUsuarios;
    $usuarioPlaza = $handlerUs->selectById($usuario)->getUserPlaza();
	
	$err = "../../../../index.php?view=sueldos_nuevo&err=";     		
	$info = "../../../../index.php?view=sueldos_form";    		

	try {
		$handler->newSueldo($fecha,$periodo,$usuario,$tipo,$usuarioPlaza);

		$id_sueldo = $handler->selectLastSueldos();

		$msj="Concepto creado con éxito";
		header("Location: ".$info."&idsueldo=".$id_sueldo['id']);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}

?>	