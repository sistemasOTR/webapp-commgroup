<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';	

	class GestorObjetivo
	{				
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }

		private $_idGestorSistema;
		public function getIdGestorSistema(){ return $this->_idGestorSistema; }
		public function setIdGestorSistema($idGestorSistema){ $this->_idGestorSistema=$idGestorSistema; }

		private $_objetivo;
		public function getObjetivo(){ return $this->_objetivo; }
		public function setObjetivo($objetivo){ $this->_objetivo=$objetivo; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }	

		private $_fechaDesde;
		public function getFechaDesde(){ return $this->_fechaDesde; }
		public function setFechaDesde($fechaDesde){ $this->_fechaDesde=$fechaDesde; }

		private $_fechaHasta;
		public function getFechaHasta(){ return $this->_fechaHasta; }
		public function setFechaHasta($fechaHasta){ $this->_fechaHasta=$fechaHasta; }	

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setIdGestorSistema(0);			
			$this->setObjetivo(0);
			$this->setEstado(true);				
			$this->setFechaDesde('');				
			$this->setFechaHasta('');				
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {
							
				# Validaciones 			
				if($this->getIdGestorSistema()<0)
					throw new Exception("Gestor sistema vacia");

				if(empty($this->getObjetivo()))
					throw new Exception("Objetivo vacio");
				
				# Query 			
				$query="INSERT INTO gestor_objetivo (
		        						id_gestor_sistema,
		        						objetivo,
		        						estado,
		        						fecha_desde
	        			) VALUES (
	        							".$this->getIdGestorSistema().",
	        							".$this->getObjetivo().",
	        							'".$this->getEstado()."',
	        							'".$this->getFechaDesde()."'
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
					throw new Exception("Objetivo no identificado");

				if($this->getIdGestorSistema()<0)
					throw new Exception("Gestor sistema vacia");

				if(empty($this->getObjetivo()))
					throw new Exception("Objetivo vacio");
				
				# Query 			
				$query="UPDATE gestor_objetivo SET
								id_gestor_sistema=".$this->getIdGestorSistema().", 
								objetivo=".$this->getObjetivo().", 
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
					throw new Exception("Objetivo no identificado");

				# Query 			
				$query="UPDATE gestor_objetivo SET							
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

					if($this->getIdGestorSistema()<0)
						throw new Exception("No se selecciono el gestor de referencia");		

					$query = "SELECT * FROM gestor_objetivo WHERE id_gestor_sistema=".$this->getIdGestorSistema()." AND estado='true' AND fecha_hasta is NULL";
				}
				else{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id del gestor");		

					$query="SELECT * FROM gestor_objetivo WHERE id=".$this->getId();
				}

				# Ejecucion 				
				$result = SQL::selectObject($query, new GestorObjetivo);
						
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
				$this->setIdGestorSistema(trim($filas['id_gestor_sistema']));
				$this->setObjetivo(trim($filas['objetivo']));											
				$this->setEstado($filas['estado']);
				$this->setFechaDesde($filas['fecha_desde']);
				$this->setFechaHasta($filas['fecha_hasta']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setIdGestorSistema(0);
			$this->setObjetivo(0);			
			$this->setEstado(true);				
			$this->setFechaDesde('');				
			$this->setFechaHasta('');				
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';
		}

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/	
		public function deBaja($conexion,$fechaCambioVigencia)
		{		
			try {
				# Query 			
				$query="UPDATE gestor_objetivo SET
								fecha_hasta='".$fechaCambioVigencia."'
							WHERE fecha_hasta is NULL";
				

				# Ejecucion
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}					
		}

		public function selectActual()
		{			
			try {
				
				# Query
				$query = "SELECT * FROM gestor_objetivo WHERE estado='true' AND fecha_hasta is NULL";
				
				# Ejecucion 				
				$result = SQL::selectObject($query, new GestorObjetivo);
						
				return $result;
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
						
			}

		}

		public function buscarPuntajeFecha($gestor_id,$fechaOperacion)
		{			
			try {
				
				# Query
				$query = "SELECT * FROM gestor_objetivo WHERE id_gestor_sistema=".$gestor_id." AND estado='true' AND fecha_hasta >'".$fechaOperacion."' AND fecha_desde <'".$fechaOperacion."'";
				
				# Ejecucion 				
				$result = SQL::selectObject($query, new GestorObjetivo);
						
				return $result;
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
						
			}

		}

		public function existeObjetivo()
		{			
			try {							
				if($this->getIdGestorSistema()<0)
					throw new Exception("No se selecciono el gestor de referencia");		

				if(empty($this->getObjetivo()))
					throw new Exception("No se cargo el objetivo");		

				$query = "SELECT * FROM gestor_objetivo WHERE id_gestor_sistema=".$this->getIdGestorSistema()." AND objetivo=".$this->getObjetivo()." AND estado='true'";
				
				//echo $query;
				//exit();

				# Ejecucion 				
				$result = SQL::selectObject($query, new GestorObjetivo);
						
				return $result;
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
						
			}

		}	

		public function limpiarTabla($conexion)
		{			
			try {											
				$query = "DELETE FROM gestor_objetivo";
				
				# Ejecucion 	
				return SQL::delete($conexion,$query);			
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
						
			}

		}	

	}
?>