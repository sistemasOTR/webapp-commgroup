<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';
	include_once PATH_DATOS.'Entidades/tipousuario.class.php';
	include_once PATH_DATOS.'Entidades/multiusuario.class.php';

	class Usuario
	{				
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }

		private $_nombre;
		public function getNombre(){ return $this->_nombre; }
		public function setNombre($nombre){ $this->_nombre=$nombre; }

		private $_apellido;
		public function getApellido(){ return $this->_apellido; }
		public function setApellido($apellido){ $this->_apellido=$apellido; }

		private $_email;
		public function getEmail(){ return $this->_email; }
		public function setEmail($email){ $this->_email=$email; }

		private $_password;
		public function getPassword(){ return $this->_password; }
		public function setPassword($password){ 
			$this->_password = md5($password); 
		}

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }		

		private $_fotoPerfil;
		public function getFotoPerfil(){ return $this->_fotoPerfil; }
		public function setFotoPerfil($fotoPerfil){ $this->_fotoPerfil=$fotoPerfil; }

		private $_usuarioPerfil;
		public function getUsuarioPerfil(){ return $this->_usuarioPerfil; }
		public function setUsuarioPerfil($usuarioPerfil){ $this->_usuarioPerfil=$usuarioPerfil; }

		private $_tipoUsuario;
		public function getTipoUsuario(){ return $this->_tipoUsuario; }
		public function setTipoUsuario($tipoUsuario){ $this->_tipoUsuario=$tipoUsuario; }

		private $_userSistema;
		public function getUserSistema(){ return $this->_userSistema; }
		public function setUserSistema($userSistema){ $this->_userSistema=$userSistema; }

		private $_userPlaza;
		public function getUserPlaza(){ return $this->_userPlaza; }
		public function setUserPlaza($userPlaza){ $this->_userPlaza=$userPlaza; }

		private $_aliasUserSistema;
		public function getAliasUserSistema(){ return $this->_aliasUserSistema; }
		public function setAliasUserSistema($aliasUserSistema){ $this->_aliasUserSistema=$aliasUserSistema; }

		private $_passwordAux;
		public function getPasswordAux(){ return $this->_passwordAux; }
		public function setPasswordAux($passwordAux){ $this->_passwordAux = $passwordAux; }

		private $_cambioRol;
		public function getCambioRol(){ return $this->_cambioRol; }
		public function setCambioRol($cambioRol){ $this->_cambioRol = $cambioRol; }


		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setNombre('');
			$this->setApellido('');
			$this->setEmail('');
			$this->setPassword('');			
			$this->setFotoPerfil('');
			$this->setUsuarioPerfil(new UsuarioPerfil);
			$this->setTipoUsuario(new TipoUsuario);
			$this->setUserSistema(0);
			$this->setUserPlaza(0);
			$this->setAliasUserSistema('');
			$this->setEstado(true);		
			$this->setPasswordAux('');		
			$this->setCambioRol(false);
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {
							
				# Validaciones 			
				if(empty($this->getEmail()))
					throw new Exception("Email vacio");
				
				# Query 			
				$query="INSERT INTO usuario (
		        						nombre,
		        						apellido,
		        						email,
		        						password,
		        						foto_perfil,	        						
		        						id_usuario_perfil,
		        						id_plaza,
		        						estado,
		        						password_aux,
		        						cambio_rol
	        			) VALUES (
	        							'".$this->getNombre()."',
	        							'".$this->getApellido()."',
	        							'".$this->getEmail()."',
	        							'".$this->getPassword()."',
	        							'".$this->getFotoPerfil()."',
	        							".$this->getUsuarioPerfil()->getId().",	        							
	        							".$this->getUserPlaza().",	        							
	        							'".$this->getEstado()."',
	        							'".$this->getPasswordAux()."',
	        							'".$this->getCambioRol()."'
	        			)";        
				
				# Ejecucion 	
				return SQL::insert($conexion,$query);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}
		}

		public function update($conexion)
		{		
			try {

				# Validaciones 			
				if(empty($this->getId()))
					throw new Exception("Usuario no identificado");

				if(empty($this->getEmail()))
					throw new Exception("Email vacio");			

				
				# Query 			
				$query="UPDATE usuario SET
								nombre='".$this->getNombre()."', 
								apellido='".$this->getApellido()."', 
								email='".$this->getEmail()."', 							
								foto_perfil='".$this->getFotoPerfil()."', 
								id_usuario_perfil=".$this->getUsuarioPerfil()->getId().",
								id_plaza=".$this->getUserPlaza().",
								estado='".$this->getEstado()."',
								password='".$this->getPassword()."', 	
								password_aux='".$this->getPasswordAux()."',
								cambio_rol='".$this->getCambioRol()."'
							WHERE id=".$this->getId();

				# Ejecucion
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}					
		}

		public function delete($conexion)
		{
			try {
			
				# Validaciones			
				if(empty($this->getId()))
					throw new Exception("Usuario no identificado");

				# Query 			
				$query="UPDATE usuario SET							
								estado='false'
							WHERE id=".$this->getId();
		
				# Ejecucion 	
				return SQL::delete($conexion,$query);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}					
		}

		public function select()
		{			
			try {
				
				# Query
				if(empty($this->getId())){
					$query = "SELECT * FROM usuario WHERE estado='true'";
				}
				else{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id del usuario");		

					$query="SELECT * FROM usuario WHERE id=".$this->getId();
				}

				# Ejecucion 				
				$result = SQL::selectObject($query, new Usuario);
						
				return $result;
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
						
			}

		}

		// public function selectByTipo($tipo,$localidad)
		// {			
		// 	try {
				
		// 			$query="SELECT usuario.* FROM usuario 
		// 				INNER JOIN usuario_perfil ON
		// 					usuario_perfil.id=usuario.id_usuario_perfil
		// 				WHERE usuario_perfil.id='".$tipo."' AND usuario.estado='true'";
		// 		}

		// 		# Ejecucion 				
		// 		$result = SQL::selectObject($query, new Usuario);
						
		// 		return $result;
				
		// 	} catch (Exception $e) {
		// 		throw new Exception($e->getMessage());
						
		// 	}

		// }

		public function setPropiedadesBySelect($filas)
		{	
			if(empty($filas)){
				$this->cleanClass();
			}
			else{
				$this->setId($filas['id']);
				$this->setNombre(trim($filas['nombre']));
				$this->setApellido(trim($filas['apellido']));
				$this->setEmail(trim($filas['email']));
				$this->setPassword(trim($filas['password']));
				$this->setFotoPerfil(trim($filas['foto_perfil']));				

				$this->setPasswordAux(trim($filas['password_aux']));

				$up = new UsuarioPerfil;
				$up->setId($filas['id_usuario_perfil']);
				$up = $up->select();								
				$this->setUsuarioPerfil($up);

				$tu = new TipoUsuario;
				$tu->setId($filas['id_tipo_usuario']);
				$tu = $tu->select();
				$this->setTipoUsuario($tu);

				$this->setUserPlaza($filas['id_plaza']);
				$this->setUserSistema($filas['id_user_sistema']);
				$this->setAliasUserSistema(trim($filas['alias_user_sistema']));
				$this->setEstado($filas['estado']);

				$this->setCambioRol($filas['cambio_rol']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setNombre('');
			$this->setApellido('');
			$this->setEmail('');
			$this->setPassword('');			
			$this->setFotoPerfil('');
			$this->setUsuarioPerfil(new UsuarioPerfil);
			$this->setTipoUsuario(new TipoUsuario);
			$this->setUserPlaza(0);
			$this->setUserSistema(0);
			$this->setAliasUserSistema('');
			$this->setEstado(true);	
			$this->setPasswordAux('');				
			$this->setCambioRol(false);
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';
		}

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/
		public function updatePassword($conexion)
		{			
			# Validaciones 			
			if(empty($this->getId()))
				throw new Exception("Usuario no identificado");

			if(empty($this->getPassword()))
				throw new Exception("La clave no puede estar vacia");
			
			# Query 			
			$query="UPDATE usuario SET
							password='".$this->getPassword()."',
							password_aux='".$this->getPasswordAux()."'
						WHERE id=".$this->getId();

			# Ejecucion 			
			return SQL::update($conexion,$query);
		}

		public function selectByLogin($email, $password)
		{
			# Validaciones 			
			if(empty($email))
				throw new Exception("Email vacio");

			if(empty($password))
				throw new Exception("Password vacia");
						
			# Query 			
			$query = "SELECT * FROM usuario WHERE email='".$email."' AND password='".md5($password)."' AND estado='true'";
			//$query = "SELECT * FROM usuario WHERE email='".$email."' AND password='".$password."' AND estado='true'";

			# Ejecucion 			
			$result = SQL::selectObject($query, new Usuario);
					
			return $result;			
		}

		public function selectByEmail($email)
		{
			# Validaciones 			
			if(empty($email))
				throw new Exception("Email vacio");
				
			# Query 							
			$query = "SELECT TOP 1 * FROM usuario WHERE email='".$email."' AND estado='true'";

			# Ejecucion 			
			$result = SQL::selectObject($query, new Usuario);

			return $result;			
		}

		public function selectByPerfil($perfil)
		{
			# Validaciones 			
			if(empty($perfil))
				throw new Exception("Perfil vacio");
				
			# Query 							
			$query = "SELECT usuario.* FROM usuario 
						INNER JOIN usuario_perfil ON
							usuario_perfil.id=usuario.id_usuario_perfil
						WHERE usuario_perfil.nombre='".$perfil."' AND usuario.estado='true'";

			//echo $query;
			//exit();

			# Ejecucion 			
			$result = SQL::selectObject($query, new Usuario);

			return $result;			
		}
         
         public function selecTop()
		{		
			try {
				
				$query = "SELECT TOP 1 * FROM usuario WHERE estado='true' ORDER BY id DESC";
				
				# Ejecucion 				
				$result = SQL::selectObject($query, new Usuario);

				return $result;


			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}					
		}
		public function getMultiusuario(){
			$m = new Multiusuario;

			return $m->selectByUsuario($this->getId());
		}

		public function updateUserActivo($conexion)
		{		
			try {

				# Validaciones 			
				if(empty($this->getId()))
					throw new Exception("Usuario no identificado");	
				
				# Query 			
				$query="UPDATE usuario SET
								id_tipo_usuario=".$this->getTipoUsuario()->getId().",
								id_user_sistema=".$this->getUserSistema().",
								alias_user_sistema='".$this->getAliasUserSistema()."'								
							WHERE id=".$this->getId();

				# Ejecucion
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}					
		}

		public function updatePerfilUsuario($id,$perfil)
		{		
			try {

				# Validaciones 			
				if(empty($id))
					throw new Exception("Usuario no identificado");	
				
				# Query 			
				$query="UPDATE usuario SET
								id_usuario_perfil=".$perfil."								
							WHERE id=".$this->getId();

				//echo $query;
				//exit();

				# Ejecucion
				return SQL::update(false,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}					
		}

		public function selectGestores()
		{		
			try {
				
				$query = "SELECT * FROM usuario WHERE estado='true' and id_tipo_usuario = 3 order by apellido";
				
				# Ejecucion 				
				$result = SQL::selectObject($query, new Usuario);

				return $result;


			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}					
		}

		public function selectEmpleados()
		{		
			try {
				
				$query = "SELECT * FROM usuario WHERE estado='true' and id_tipo_usuario <> 1 order by apellido";
				
				# Ejecucion 				
				$result = SQL::selectObject($query, new Usuario);

				return $result;


			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}					
		}

		public function selectByPlaza($id_plaza)
		{		
			try {
				
				$query = "SELECT * FROM usuario WHERE estado = 'true' and id_plaza = ".$id_plaza." order by apellido";
				
				# Ejecucion 				
				$result = SQL::selectObject($query, new Usuario);

				return $result;


			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}					
		}

		public function selectGestoresByPlaza($id_plaza)
		{		
			try {
				if (!empty($id_plaza)) {
					$query = "SELECT * FROM usuario WHERE estado = 'true' AND (id_tipo_usuario = 3 or id_tipo_usuario = 4)and id_plaza = ".$id_plaza." order by apellido";
				}else{
					$query = "SELECT * FROM usuario WHERE estado = 'true' AND (id_tipo_usuario = 3 or id_tipo_usuario = 4) order by apellido";
				}
				
				
				
				# Ejecucion 				
				$result = SQL::selectObject($query, new Usuario);

				return $result;


			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}					
		}		
	}
?>







