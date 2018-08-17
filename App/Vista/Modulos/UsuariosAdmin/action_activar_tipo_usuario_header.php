<?php
	include_once "../../../Config/config.ini.php";
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";		
	include_once PATH_NEGOCIO."Usuarios/handlertipousuarios.class.php";	
	include_once PATH_NEGOCIO."Usuarios/handlerperfiles.class.php";			
	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";		
	
	$usuario = (isset($_GET['usuario'])? $_GET['usuario']:'');		
	$tipo_usuario = (isset($_GET['tipo_usuario'])? $_GET['tipo_usuario']:'');		
	$id_usuario_sistema = (isset($_GET['id_usuario_sistema'])? $_GET['id_usuario_sistema']:'');		
	$alias_usuario_sistema = (isset($_GET['alias_usuario_sistema'])? $_GET['alias_usuario_sistema']:'');		
  
	$err = "../../../../index.php?view=panelcontrol";     		
	$info = "../../../../index.php?view=panelcontrol";     		

	try
	{	
		$handlerTipoUsuarios = new HandlerTipoUsuarios;
		$objTipoUsuario=$handlerTipoUsuarios->selectById($tipo_usuario);		
		
		$handler = new HandlerUsuarios;     
        $handler->updateUsuarioSistemaActivo($usuario,$objTipoUsuario,$id_usuario_sistema,$alias_usuario_sistema);		

		//$msj="Se actualizo la configuracion del usuario. <b>".$nombre." ".$apellido."</b>";
		header("Location: ".$info);
	}
	catch(Exception $e)
	{
		header("Location: ".$err);
	}
	
?>