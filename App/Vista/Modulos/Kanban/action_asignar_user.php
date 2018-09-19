<?php 
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerkanban.class.php"; 
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php"; 
	include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 

	$handlerKB = new HandlerKanban;

	$id=(isset($_POST["id_tarea"])?$_POST["id_tarea"]:'');
	$id_operador=(isset($_POST["id_operador"])?$_POST["id_operador"]:'');
	$id_enc=(isset($_POST["slt_usuario"])?$_POST['slt_usuario']:'');

	$err = "../../../../index.php?view=kanban&err=";     		
	$info = "../../../../index.php?view=kanban&info=";

	// var_dump($descripcion);
	// exit();

	try {

		$handlerKB->asignarUsuario($id,$id_enc,$id_operador);

		$msj="Usuario asignado con éxito";
		header("Location: ".$info.$msj);
	  			
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}  		


?>