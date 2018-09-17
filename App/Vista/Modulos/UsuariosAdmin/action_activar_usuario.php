<?php
	include_once "../../../Config/config.ini.php";
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";		
	include_once PATH_NEGOCIO."Usuarios/handlertipousuarios.class.php";		
	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";		
	include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php";		
    
        
	$id_aprobar= (isset($_GET['id_aprobar'])? $_GET['id_aprobar']:'');	
	$id_legajo= (isset($_GET['id_legajo'])? $_GET['id_legajo']:'');	
	$perfil= (isset($_GET['perfil'])? $_GET['perfil']:'');
	

	$err = "../../../../index.php?view=usuarioABM&id=".$id_aprobar."&err=";     		
	$info = "../../../../index.php?view=usuarioABM&id=".$id_aprobar."info=";     		

	try
	{							
        $handler = new HandlerUsuarios;        
        $handler->activarUsuario($id_aprobar);

     if (intval($perfil) !=6) {
        $handlerLegajos=new HandlerLegajos;
        $handlerLegajos->fechaBajaLegajo($fecha=NULL,$id_legajo);
     }
		$msj="Se Activo el usuario. <b>".$nombre." ".$apellido."</b>";
		header("Location: ".$info.$msj);
	}
	catch(Exception $e)
	{
		header("Location: ".$err.$e->getMessage());
	}
	
?>