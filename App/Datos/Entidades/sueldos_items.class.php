<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';

	include_once PATH_DATOS.'Entidades/usuario.class.php';

	class SueldosItems
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }

		private $_idSueldo;
		public function getIdSueldo(){ return $this->_idSueldo; }
		public function setIdSueldo($idSueldo){ $this->_idSueldo =$idSueldo; }

		private $_unidad;
		public function getUnidad(){ return $this->_unidad; }
		public function setUnidad($unidad){ $this->_unidad =$unidad; }

		private $_concepto;
		public function getConcepto(){ return $this->_concepto; }
		public function setConcepto($concepto){ $this->_concepto =$concepto; }
		
		private $_remunerativo;
		public function getRemunerativo(){ return $this->_remunerativo; }
		public function setRemunerativo($remunerativo){ $this->_remunerativo=$remunerativo; }
		
		private $_descuento;
		public function getDescuento(){ return $this->_descuento; }
		public function setDescuento($descuento){ $this->_descuento=$descuento; }
		
		private $_noRemunerativo;
		public function getNoRemunerativo(){ return $this->_noRemunerativo; }
		public function setNoRemunerativo($noRemunerativo){ $this->_noRemunerativo=$noRemunerativo; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }	

		

				

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setIdSueldo(0);
			$this->setUnidad(0);
			$this->setConcepto('');
			$this->setRemunerativo(0);
			$this->setDescuento(0);
			$this->setNoRemunerativo(0);
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
				$query="INSERT INTO sueldos_items (
							id_sueldo,
							unidad,
							concepto,
							rem,
							descuento,
							no_rem,
							estado 
	        			) VALUES (
	        				".$this->getIdSueldo().", 
							".$this->getUnidad().",
							'".$this->getConcepto()."',
							".$this->getRemunerativo().",
							".$this->getDescuento().",
							".$this->getNoRemunerativo().",
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
					throw new Exception("Item no identificado");

				# Query 			
				$query="UPDATE sueldos_items SET 
							concepto='".$this->getConcepto()."',
							id_sueldo=".$this->getIdSueldo().",
							unidad=".$this->getUnidad().",
							rem=".$this->getRemunerativo().",
							descuento=".$this->getDescuento().",
							no_rem=".$this->getNoRemunerativo().",
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
				$query="UPDATE sueldos_items SET							
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
					$query = "SELECT * FROM sueldos_items WHERE estado='true'";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id de Concepto");	

					$query="SELECT * FROM sueldos_items WHERE id=".$this->getId();
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Sueldos);
						
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
				$this->setIdSueldo($filas['id_sueldo']);
				$this->setUnidad($filas['unidad']);
				$this->setConcepto($filas['concepto']);
				$this->setRemunerativo($filas['rem']);
				$this->setDescuento($filas['descuento']);
				$this->setNoRemunerativo($filas['no_rem']);
				$this->setEstado($filas['estado']);	
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setIdSueldo(0);
			$this->setUnidad(0);
			$this->setConcepto('');
			$this->setRemunerativo(0);
			$this->setDescuento(0);
			$this->setNoRemunerativo(0);
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
					throw new Exception("No se selecciono el Sueldo");	

				$query="SELECT * FROM sueldos_items WHERE id=".$id;
				
				# Ejecucion 					
				$result = SQL::selectArray($query, new Sueldos);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}

		}

		public function selectItemsBySueldo($id_sueldo)
		{			
			try {
											
				# Query
				$query="SELECT * FROM sueldos_items WHERE estado = 'true' AND id_sueldo=".$id_sueldo;
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new SueldosItems);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}
		}
	}
?>