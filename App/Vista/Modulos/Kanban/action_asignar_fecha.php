<?php 
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerkanban.class.php"; 
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php"; 
	include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 

	$handlerKB = new HandlerKanban;

	$id=(isset($_POST["id_tarea"])?$_POST["id_tarea"]:'');
	$id_operador=(isset($_POST["id_operador"])?$_POST["id_operador"]:'');
	$fin_est=(isset($_POST["fin_est"])?$_POST['fin_est']:'');

	$err = "../../../../index.php?view=kanban&err=";     		
	$info = "../../../../index.php?view=kanban&info=";

	// var_dump($id);
	// exit();

	try {

		$handlerKB->asignarFechasEst(intval($id),$fin_est,intval($id_operador));

		$msj="Fechas estimadas asignadas con éxito";
		header("Location: ".$info.$msj);
	  			
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}  		


?>