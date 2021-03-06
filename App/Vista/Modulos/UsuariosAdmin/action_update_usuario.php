<?php
	include_once "../../../Config/config.ini.php";
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";		
	include_once PATH_NEGOCIO."Usuarios/handlertipousuarios.class.php";	
	include_once PATH_NEGOCIO."Usuarios/handlerperfiles.class.php";			
	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
	include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php";		

	$id= (isset($_POST['id'])? $_POST['id']:'');	
	$nombre = (isset($_POST['nombre'])? $_POST['nombre']:'');
	$apellido = (isset($_POST['apellido'])? $_POST['apellido']:'');
	$nombrecompleto=strtoupper($apellido.", ".$nombre);
	$dni = (isset($_POST['dni'])? $_POST['dni']:'');
	$cuil = (isset($_POST['cuil'])? $_POST['cuil']:'');
	$nacimiento = (isset($_POST['fecha_nacimiento'])? $_POST['fecha_nacimiento']:'');
	$ingreso = (isset($_POST['fecha_ingreso'])? $_POST['fecha_ingreso']:'');
	$direccion = (isset($_POST['direccion'])? $_POST['direccion']:'');
	$categoria = (isset($_POST['slt_categoria'])? $_POST['slt_categoria']:'');
	$horas = (isset($_POST['horas'])? $_POST['horas']:'');
	$legajo = (isset($_POST['legajo'])? $_POST['legajo']:'');
	
	$email = (isset($_POST['email'])? $_POST['email']:'');
	$password = (isset($_POST['password'])? $_POST['password']:'');	
	//$administrador = (isset($_POST['administrador'])? $_POST['administrador']:'');
	$foto = (isset($_FILES['foto'])? $_FILES['foto']:'');

	$slt_perfil = (isset($_POST['slt_perfil'])? $_POST['slt_perfil']:'');

	$slt_tipousuario = (isset($_POST['slt_tipousuario'])? $_POST['slt_tipousuario']:'');
	$slt_empresa = (isset($_POST['slt_empresa'])? $_POST['slt_empresa']:'');
	$slt_gerente = (isset($_POST['slt_gerente'])? $_POST['slt_gerente']:'');
	$slt_gestor = (isset($_POST['slt_gestor'])? $_POST['slt_gestor']:'');
	$slt_coordinador = (isset($_POST['slt_coordinador'])? $_POST['slt_coordinador']:'');
	$slt_operador = (isset($_POST['slt_operador'])? $_POST['slt_operador']:'');

	$cambio_rol = (isset($_POST['cambio_rol'])? $_POST['cambio_rol']:'');
	$plaza = (isset($_POST['slt_plaza'])? $_POST['slt_plaza']:'');

	if($cambio_rol=="on")
		$cambio_rol = true;
	else
		$cambio_rol = false;

	$err = "../../../../index.php?view=usuarioABM_edit&id=".$id."&err=";     		
	$info = "../../../../index.php?view=usuarioABM&info=";     		

	try
	{			
		if(empty($slt_tipousuario)){
			$objTU=null;
			$id_user_sistema ="";
			$alias_user_sistema ="";
		}
		else
		{
			$handlerTU = new HandlerTipoUsuarios;
			$objTU = $handlerTU->selectById($slt_tipousuario);

			$handlerSistema = new HandlerSistema;


			switch ($slt_tipousuario) {
				case '1':
					$id_user_sistema = $slt_empresa;
					$objEmpresa = $handlerSistema->selectEmpresaById($slt_empresa);
					$alias_user_sistema = $objEmpresa[0]->EMPTT21_ABREV;
					break;
				
				case '2':
					$id_user_sistema = 0;
					$alias_user_sistema = $slt_gerente;
					break;

				case '3':
					$id_user_sistema = $slt_gestor;
					$objGestor = $handlerSistema->selectGestorById($slt_gestor);
					$alias_user_sistema = $objGestor[0]->GESTOR21_ALIAS;
					break;

				case '4':
					$id_user_sistema = 0;
					$alias_user_sistema = $slt_coordinador;
					break;

				case '5':
					$id_user_sistema = 0;
					$alias_user_sistema = $slt_operador;
					break;
			}
		}		
        
		if(empty($slt_perfil))
			throw new Exception("No se selecciono el perfil.");		
		
		$handlerPerfiles = new HandlerPerfiles;
		$perfil=$handlerPerfiles->selectById($slt_perfil);	
		if ($slt_perfil != 6) {	

		$handler = new HandlerUsuarios;     
        $handler->updateUsuariosAdmin($id,$nombre,$apellido,$foto,$objTU,$id_user_sistema,$alias_user_sistema,$perfil,$email,$password,$cambio_rol,$plaza);	

        $handlerlegajos= new HandlerLegajos;
        $idLegajo=$handlerlegajos->seleccionarLegajos($id);
     
     	if (is_null($idLegajo)) {
     		// var_dump(intval($id),$nombrecompleto,$dni,$cuil,$ingreso,$nacimiento,$direccion,$categoria,$horas,intval($legajo));
       // 				 exit();

     		$handlerlegajos->insertLegajo($id,$nombrecompleto,$dni,$cuil,$ingreso,$nacimiento,$direccion,$categoria,$horas,$legajo);
     	} else {

     		$handlerlegajos->updatelegajos(intval($idLegajo->getId()),$id,$nombrecompleto,$dni,$cuil,$ingreso,$nacimiento,$direccion,$categoria,$horas,$legajo);
     	}

     } else{
     	$handler = new HandlerUsuarios;     
        $handler->updateUsuariosAdmin($id,$nombre,$apellido,$foto,$objTU,$id_user_sistema,$alias_user_sistema,$perfil,$email,$password,$cambio_rol,$plaza);	


     }
        


		$msj="Se actualizo la configuracion del usuario. <b>".$nombre." ".$apellido."</b>";
		header("Location: ".$info.$msj);
	}
	catch(Exception $e)
	{
		header("Location: ".$err.$e->getMessage());
	}
	
?>