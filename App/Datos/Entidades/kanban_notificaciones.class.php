<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';

	class KanbanNotificaciones
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }
		
		private $_idKanban;
		public function getIdKanban(){ return $this->_idKanban; }
		public function setIdKanban($idKanban){ $this->_idKanban =$idKanban; }

		private $_idUser;
		public function getIdUser(){ return $this->_idUser; }
		public function setIdUser($idUser){ $this->_idUser =$idUser; }
		
		private $_fechaHora;
		public function getFechaHora(){ return $this->_fechaHora; }
		public function setFechaHora($fechaHora){ $this->_fechaHora =$fechaHora; }

		private $_descripcion;
		public function getDescripcion(){ return $this->_descripcion; }
		public function setDescripcion($descripcion){ $this->_descripcion =$descripcion; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado =$estado; }


		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setIdKanban(0);
			$this->setIdUser(0);
			$this->setFechaHora('');
			$this->setDescripcion('');
			$this->setEstado(true);
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				$query="INSERT INTO kanban_notificaciones (
		        						descripcion,
		        						id_kanban,
		        						fecha_hora,
		        						id_user,
		        						estado
		        						
	        			) VALUES ( 	
	        							'".$this->getDescripcion()."',
	        							".$this->getIdKanban().",
	        							'".$this->getFechaHora()."',
	        							".$this->getIdUser().",
	        							'".$this->getEstado()."'

	        							
	        			)";        
		
				// var_dump($query);
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
					throw new Exception("Solicitud no identificada");

				
				# Query 			
				$query="UPDATE kanban_notificaciones SET
								id=".$this->getId().",
        						descripcion='".$this->getDescripcion()."',
        						id_kanban=".$this->getIdKanban().",
        						id_user=".$this->getIdUser().",
        						fecha_hora='".$this->getFechaHora()."',
        						estado='".$this->getEstado()."'
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
					throw new Exception("Notificación no identificada");
			
				# Query 			
				$query="UPDATE kanban_notificaciones SET							
								estado = 'false'
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
					$query = "SELECT * FROM kanban_notificaciones WHERE estado='true'";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el solicitud");		

					$query="SELECT * FROM kanban_notificaciones WHERE id=".$this->getId();
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new KanbanNotificaciones);
						
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
				$this->setDescripcion($filas['descripcion']);			
				$this->setIdKanban($filas['id_kanban']);
				$this->setIdUser($filas['id_user']);
				$this->setFechaHora($filas['fecha_hora']);
				$this->setEstado($filas['estado']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setDescripcion('');
			$this->setIdKanban(0);
			$this->setIdUser(0);
			$this->setFechaHora('');
			$this->setEstado(true);
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';
			/*
			
			*/
		}

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/

		public function selectNotificacionesByUser($id_user)
		{			
			try {
											
				# Query
				$query="SELECT * FROM kanban_notificaciones WHERE id_user=".$id_user." AND estado = 'true'";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new KanbanNotificaciones);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

	}
?>