<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';

	include_once PATH_DATOS.'Entidades/usuario.class.php';

	class SueldosConceptos
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }		
		
		private $_concepto;
		public function getConcepto(){ return $this->_concepto; }
		public function setConcepto($concepto){ $this->_concepto=$concepto; }		

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }	

		

				

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);			
			$this->setConcepto('');			
			$this->setEstado(true);
			
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				# Validaciones 				
				
				# Query 			
				$query="INSERT INTO sueldos_conceptos (
		        						concepto,		    
		        						estado
		        						
		        						
	        			) VALUES (
	        							'".$this->getConcepto()."',   	   
										'".$this->getEstado()."'  
										  
										
	        			)";        
			
	        	//echo $query;
	        	//exit();

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
				$query="UPDATE sueldos_conceptos SET
								concepto='".$this->getConcepto()."',								
								estado='".$this->getEstado()."'
								
							WHERE id=".$this->getId();

	        	//echo $query;
	        	//exit();

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
				$query="UPDATE sueldos_conceptos SET							
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
					$query = "SELECT * FROM sueldos_conceptos WHERE estado='true'";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id de Concepto");		

					$query="SELECT * FROM sueldos_conceptos WHERE id=".$this->getId();
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new SueldosConceptos);
						
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
				// $u = new Usuario;
				// $u->setId($filas['id_usuario']);			
				// $u = $u->select();
				// $this->setUsuarioId($u);					
                $this->setId($filas['id']);				
				$this->setConcepto($filas['concepto']);				
				$this->setEstado($filas['estado']);	
										
				
			}
		}

		private function cleanClass()
		{
			$this->setId(0);			
			$this->setConcepto('');			
			$this->setEstado(true);
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

				$query="SELECT * FROM sueldos_conceptos WHERE id=".$id;
				
				# Ejecucion 					
				$result = SQL::selectArray($query, new SueldosConceptos);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}
	}
?>