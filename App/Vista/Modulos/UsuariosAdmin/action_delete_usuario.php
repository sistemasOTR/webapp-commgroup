<?php
	include_once "../../../Config/config.ini.php";
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";		
	include_once PATH_NEGOCIO."Usuarios/handlertipousuarios.class.php";		
	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";		
	include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php";		
    
    $fecha=(isset($_POST['fecha_baja'])? $_POST['fecha_baja']:'');
    $legajo_id=(isset($_POST['legajo_id'])? $_POST['legajo_id']:'');
    $perfil=(isset($_POST['perfil'])? $_POST['perfil']:'');
   
    
	$id= (isset($_POST['id'])? $_POST['id']:'');		
	$nombre = (isset($_POST['nombre'])? $_POST['nombre']:'');
	$apellido = (isset($_POST['apellido'])? $_POST['apellido']:'');
	$err = "../../../../index.php?view=usuarioABM&id=".$id."&err=";     		
	$info = "../../../../index.php?view=usuarioABM&info=";     		

	try
	{							
        $handler = new HandlerUsuarios;        
        $handler->delete($id);

     if (intval($perfil) !=6) {
   
        $handlerLegajos=new HandlerLegajos;
        $handlerLegajos->fechaBajaLegajo($fecha,$legajo_id);
       }

		$msj="Se elimino el usuario. <b>".$nombre." ".$apellido."</b>";
		header("Location: ".$info.$msj);
	}
	catch(Exception $e)
	{
		header("Location: ".$err.$e->getMessage());
	}
	
?>