<?php 
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerkanban.class.php"; 
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php"; 
	include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 

	$handlerKB = new HandlerKanban;

	$titulo=(isset($_POST["titulo"])?$_POST["titulo"]:'');
	$descripcion=(isset($_POST["descripcion"])?htmlentities($_POST['descripcion']):'');
	$id_sol=(isset($_POST["id_sol"])?$_POST["id_sol"]:'');
	$fecha_sol=(isset($_POST["fecha_sol"])?$_POST["fecha_sol"]:'');
	$plaza=(isset($_POST["plaza"])?$_POST["plaza"]:'');
	$prioridad=(isset($_POST["slt_prioridad"])?$_POST["slt_prioridad"]:'');

	$err = "../../../../index.php?view=kanban&err=";     		
	$info = "../../../../index.php?view=kanban&info=";

	// var_dump($descripcion);
	// exit();

	try {

		$handlerKB->nuevaSolicitud($titulo,$descripcion,$fecha_sol,$id_sol,$prioridad,$plaza);

		$msj="Solicitud creada con éxito";
		header("Location: ".$info.$msj);
	  			
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}  		


?>