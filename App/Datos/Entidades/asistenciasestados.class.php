<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';

	include_once PATH_DATOS.'Entidades/usuario.class.php';

	class AsistenciasEstados
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

		private $_usuarioperfil;
		public function getUsuarioPerfil(){ return $this->_usuarioperfil; }
		public function setUsuarioPerfil($usuarioperfil){ $this->_usuarioperfil=$usuarioperfil; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }	

		private $_color;
		public function getColor(){ return $this->_color; }
		public function setColor($color){ $this->_color=$color; }
        
        private $_productivo;
		public function getProductivo(){return var_export($this->_productivo,true); }
		public function setProductivo($productivo){ $this->_productivo=$productivo; }

		private $_observacion;
		public function getObservacion(){ return $this->_observacion; }
		public function setObservacion($observacion){ $this->_observacion=$observacion; }
				

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setNombre('');		
			$this->setUsuarioPerfil(0);		
			$this->setEstado(true);
			$this->setColor('');
			$this->setProductivo(true);
			$this->setObservacion('');
			
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				# Validaciones 				
				
				# Query 			
				$query="INSERT INTO asistencias_estados (
							nombre,
							estado,
							tipo_perfil,
							color,
							productivo,
							observacion
	        			) VALUES (
							'".$this->getNombre()."',
							'".$this->getEstado()."',
							".$this->getUsuarioPerfil().",
							'".$this->getColor()."',		
							".$this->getProductivo().",		
							'".$this->getObservacion()."'		
	        			)";        
			
	        	// echo $query;
	        	// exit();

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
					throw new Exception("Concepto no identificado");

				# Query 			
				$query="UPDATE asistencias_estados SET
							nombre='".$this->getNombre()."',
							estado='".$this->getEstado()."',
							tipo_perfil=".$this->getUsuarioPerfil().",	
							color='".$this->getColor()."',
							productivo=".$this->getProductivo().",
							observacion='".$this->getObservacion()."'
								
							WHERE id=".$this->getId();

	        	// echo $query;
	        	// exit();

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
					throw new Exception(" concepto no identificado");
			
				# Query 			
				$query="UPDATE asistencias_estados SET							
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
				if(empty($this->getId()))
				{
					$query = "SELECT * FROM asistencias_estados WHERE estado='true'";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id de Concepto");	

					$query="SELECT * FROM asistencias_estados WHERE id=".$this->getId();
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new AsistenciasEstados);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}

		}

		public function setPropiedadesBySelect($filas)
		{	
			if(empty($filas)){
				$this->cleanClass();
			}
			else{
                $this->setId($filas['id']);
				$this->setNombre($filas['nombre']);
				$this->setEstado($filas['estado']);	
				$this->setUsuarioPerfil($filas['tipo_perfil']);	
				$this->setColor($filas['color']);	
				$this->setProductivo($filas['productivo']);	
				$this->setObservacion($filas['observacion']);	
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setNombre('');		
			$this->setUsuarioPerfil(0);		
			$this->setEstado(true);
			$this->setColor('');
			$this->setProductivo(true);
			$this->setObservacion('');
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';
		}

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/
	
		public function selectById($id)
		{			
			try {

				if(empty($id))
					throw new Exception("No se selecciono el Usuario");	

				$query="SELECT * FROM asistencias_estados WHERE id=".$id;
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new AsistenciasEstados);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}

		}

		// public function selectByIdUser($id_user)
		// {			
		// 	try {

		// 		if(empty($id_user))
		// 			throw new Exception("No se selecciono el Usuario");	

		// 		$query="SELECT * FROM asistencias_estao WHERE estado='true' AND id_usuario=".$id_user;
				
		// 		# Ejecucion 					
		// 		$result = SQL::selectObject($query, new Asistencias);
						
		// 		return $result;

		// 	} catch (Exception $e) {
		// 		throw new Exception($e->getMessage());		
		// 	}

		// }

	
		
	}
?>