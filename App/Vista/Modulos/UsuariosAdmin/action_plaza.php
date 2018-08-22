<?php
	include_once "../../../Config/config.ini.php";
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";	        
        include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";
	
	$id = (isset($_POST['id'])? $_POST['id']:0);			
	$nombre = (isset($_POST['nombre'])? $_POST['nombre']:'');			
	$fecha = (isset($_POST['fecha'])? $_POST['fecha']:'');			
	$tipo = (isset($_POST['tipo'])? $_POST['tipo']:0);			
	$accion = (isset($_POST['accion'])? $_POST['accion']:'');			
	
  
	$err = "../../../../index.php?view=plazas";     		
	$info = "../../../../index.php?view=plazas";     		

	try
	{	
		$handler = new HandlerPlazaUsuarios;

		if ($accion == 'nueva') {
			$handler->insert($nombre,$tipo,$fecha);
		} else {
			$handler->update($id,$nombre,$tipo);
		}
        		

		//$msj="Se actualizo la configuracion del usuario. <b>".$nombre." ".$apellido."</b>";
		header("Location: ".$info);
	}
	catch(Exception $e)
	{
		header("Location: ".$err);
	}
	
?>