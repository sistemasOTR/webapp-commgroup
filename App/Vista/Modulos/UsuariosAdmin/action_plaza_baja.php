<?php
	include_once "../../../Config/config.ini.php";
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";	        
        include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";
	
	$id = (isset($_POST['id'])? $_POST['id']:0);
	$fecha = (isset($_POST['fecha'])? $_POST['fecha']:'');
	$accion = (isset($_POST['accion'])? $_POST['accion']:'');
  
	$err = "../../../../index.php?view=plazas&err=";     		
	$info = "../../../../index.php?view=plazas&info=";

	try
	{	
		$handler = new HandlerPlazaUsuarios;
		// var_dump($accion);
		// exit();
		if ($accion == 'baja') {
			$handler->delete($id,$fecha);
		} else {
			$handler->reactivar($id,$fecha);
		}	

		$msj="Se actualizo la configuracion del usuario. <b>".$nombre." ".$apellido."</b>";
		
		
		header("Location: ".$info.$msj);
	}
	catch(Exception $e)
	{
		header("Location: ".$err);
	}
	
?>