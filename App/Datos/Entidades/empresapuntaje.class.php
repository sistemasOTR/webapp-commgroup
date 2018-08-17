<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';	

	class EmpresaPuntaje
	{				
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }

		private $_idEmpresaSistema;
		public function getIdEmpresaSistema(){ return $this->_idEmpresaSistema; }
		public function setIdEmpresaSistema($idEmpresaSistema){ $this->_idEmpresaSistema=$idEmpresaSistema; }

		private $_puntaje;
		public function getPuntaje(){ return $this->_puntaje; }
		public function setPuntaje($puntaje){ $this->_puntaje=$puntaje; }

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
			$this->setIdEmpresaSistema(0);			
			$this->setPuntaje(0);
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
				if(empty($this->getIdEmpresaSistema()))
					throw new Exception("Empresa sistema vacia");

				if(empty($this->getPuntaje()))
					throw new Exception("Puntaje vacio");
				
				# Query 			
				$query="INSERT INTO empresa_puntaje (
		        						id_empresa_sistema,
		        						puntaje,
		        						estado,
		        						fechaDesde
	        			) VALUES (
	        							".$this->getIdEmpresaSistema().",
	        							".$this->getPuntaje().",
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
					throw new Exception("Puntaje no identificado");

				if(empty($this->getIdEmpresaSistema()))
					throw new Exception("Empresa sistema vacia");

				if(empty($this->getPuntaje()))
					throw new Exception("Puntaje vacio");
				
				# Query 			
				$query="UPDATE empresa_puntaje SET
								id_empresa_sistema=".$this->getIdEmpresaSistema().", 
								puntaje=".$this->getCategoria().", 
								estado='".$this->getEstado()."'
							WHERE id=".$this->getId();

				# Ejecucion
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}					
		}

		public function deBaja($conexion,$fechaCambioVigencia)
		{		
			try {
				# Query 			
				$query="UPDATE empresa_puntaje SET
								fechaHasta='".$fechaCambioVigencia."'
							WHERE fechaHasta is NULL";
				

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
					throw new Exception("Puntaje no identificado");

				# Query 			
				$query="UPDATE empresa_puntaje SET							
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

					if(empty($this->getIdEmpresaSistema()))
						throw new Exception("No se selecciono la empresa de referencia");		

					$query = "SELECT * FROM empresa_puntaje WHERE id_empresa_sistema=".$this->getIdEmpresaSistema()." AND estado='true' AND fechaHasta is NULL";
				}
				else{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id de la categoria");		

					$query="SELECT * FROM empresa_puntaje WHERE id=".$this->getId();
				}

				# Ejecucion 				
				$result = SQL::selectObject($query, new EmpresaPuntaje);
						
				return $result;
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
						
			}

		}

		public function selectById($id)
		{			
			try {

					$query="SELECT * FROM empresa_puntaje WHERE id_empresa_sistema=".$id." ORDER BY fechaDesde DESC";
				

				# Ejecucion 				
				$result = SQL::selectObject($query, new EmpresaPuntaje);

				if (count($result)==1) {
					$result= array('' => $result ); 
					return $result;
				}else{
				  return $result;
				}
			
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
						
			}

		}


		public function selectActual()
		{			
			try {
				
				# Query
				$query = "SELECT * FROM empresa_puntaje WHERE estado='true' AND fechaHasta is NULL";
				
				# Ejecucion 				
				$result = SQL::selectObject($query, new EmpresaPuntaje);
						
				return $result;
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
						
			}

		}

		public function buscarPuntajeFecha($empresa_id,$fechaOperacion)
		{			
			try {
				
				# Query
				$query = "SELECT * FROM empresa_puntaje WHERE id_empresa_sistema=".$empresa_id." AND estado='true' AND fechaHasta >'".$fechaOperacion."' AND fechaDesde <'".$fechaOperacion."'";
				
				# Ejecucion 				
				$result = SQL::selectObject($query, new EmpresaPuntaje);
						
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
				$this->setIdEmpresaSistema(trim($filas['id_empresa_sistema']));
				$this->setPuntaje(trim($filas['puntaje']));											
				$this->setEstado($filas['estado']);
				$this->setFechaDesde($filas['fechaDesde']);
				$this->setFechaHasta($filas['fechaHasta']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setIdEmpresaSistema(0);
			$this->setPuntaje(0);			
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

		public function existePuntaje()
		{			
			try {							
				if(empty($this->getIdEmpresaSistema()))
					throw new Exception("No se selecciono la empresa de referencia");		

				if(empty($this->getPuntaje()))
					throw new Exception("No se cargo el puntaje");		

				$query = "SELECT * FROM empresa_puntaje WHERE id_empresa_sistema=".$this->getIdEmpresaSistema()." AND puntaje=".$this->getPuntaje()." AND estado='true'";
				
				//echo $query;
				//exit();

				# Ejecucion 				
				$result = SQL::selectObject($query, new EmpresaPuntaje);
						
				return $result;
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
						
			}

		}	

		public function limpiarTabla($conexion)
		{			
			try {											
				$query = "DELETE FROM empresa_puntaje";
				
				# Ejecucion 	
				return SQL::delete($conexion,$query);			
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
						
			}

		}	

	}
?>