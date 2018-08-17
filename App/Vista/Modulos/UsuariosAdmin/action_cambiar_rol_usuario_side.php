<?php
	include_once "../../../Config/config.ini.php";
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";		
	include_once PATH_NEGOCIO."Usuarios/handlertipousuarios.class.php";	
	include_once PATH_NEGOCIO."Usuarios/handlerperfiles.class.php";			
	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";		
	
	$usuario = (isset($_GET['id'])? $_GET['id']:'');			
	$perfil = (isset($_GET['rol'])? $_GET['rol']:'');		
  
	$err = "../../../../index.php?view=panelcontrol";     		
	$info = "../../../../index.php?view=panelcontrol";     		

	try
	{	
		$handler = new HandlerUsuarios;     
        $handler->updatePerfilUsuario($usuario,$perfil);		

		//$msj="Se actualizo la configuracion del usuario. <b>".$nombre." ".$apellido."</b>";
		header("Location: ".$info);
	}
	catch(Exception $e)
	{
		header("Location: ".$err);
	}
	
?>