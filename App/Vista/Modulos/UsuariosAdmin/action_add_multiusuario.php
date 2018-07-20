<?php
	include_once "../../../Config/config.ini.php";
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";		
	include_once PATH_NEGOCIO."Usuarios/handlertipousuarios.class.php";		
	include_once PATH_NEGOCIO."Usuarios/handlermultiusuarios.class.php";	
	include_once PATH_NEGOCIO."Usuarios/handlerperfiles.class.php";		
	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";		
	include_once PATH_NEGOCIO."Sistema/handlersupervisor.class.php";
	
	$usuario = (isset($_POST['usuario'])? $_POST['usuario']:'');

	$slt_tipousuario = (isset($_POST['slt_tipousuario'])? $_POST['slt_tipousuario']:'');
	$slt_empresa = (isset($_POST['slt_empresa'])? $_POST['slt_empresa']:'');
	$slt_gerente = (isset($_POST['slt_gerente'])? $_POST['slt_gerente']:'');
	$slt_gestor = (isset($_POST['slt_gestor'])? $_POST['slt_gestor']:'');
	$slt_coordinador = (isset($_POST['slt_coordinador'])? $_POST['slt_coordinador']:'');
	$slt_operador = (isset($_POST['slt_operador'])? $_POST['slt_operador']:'');
	$slt_supervisor = (isset($_POST['slt_supervisor'])? $_POST['slt_supervisor']:'');

	$err = "../../../../index.php?view=usuarioABM_multiuser&id=".$usuario."&err=";     		
	$info = "../../../../index.php?view=usuarioABM_multiuser&id=".$usuario."&info=";     		

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
			$handlerSupervisor = new HandlerSupervisor;

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

				case '6':
					$id_user_sistema = $slt_supervisor;
					$objSupervisor = $handlerSupervisor->selectSupervisorById($slt_supervisor);
					$alias_user_sistema = $objSupervisor["nombre"];
					break;					
			}
		}

		if(empty($alias_user_sistema))
			throw new Exception("No se selecciono el Usuario asociado al sistema.");			

		$handlerUsuarios = new HandlerUsuarios;
		$objUsuario=$handlerUsuarios->selectById($usuario);

        $handler = new HandlerMultiusuarios;        
        $handler->insert($objUsuario,$objTU,$id_user_sistema,$alias_user_sistema);		

		$msj="Se agrego una nueva asociación al usuario. <b>".$email."</b>";
		header("Location: ".$info.$msj);
	}
	catch(Exception $e)
	{
		header("Location: ".$err.$e->getMessage());
	}
	
?>