<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';

	include_once PATH_DATOS.'Entidades/usuario.class.php';

	class Sueldos
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }

		private $_idUsuario;
		public function getIdUsuario(){ return $this->_idUsuario; }
		public function setIdUsuario($idUsuario){ $this->_idUsuario =$idUsuario; }

		private $_idPlaza;
		public function getIdPlaza(){ return $this->_idPlaza; }
		public function setIdPlaza($idPlaza){ $this->_idPlaza =$idPlaza; }

		private $_tipo;
		public function getTipo(){ return $this->_tipo; }
		public function setTipo($tipo){ $this->_tipo =$tipo; }

		private $_fecha;
		public function getFecha(){ return $this->_fecha; }
		public function setFecha($fecha){ $this->_fecha =$fecha; }

		private $_periodo;
		public function getPeriodo(){ return $this->_periodo; }
		public function setPeriodo($periodo){ $this->_periodo =$periodo; }
		
		private $_remuneracion;
		public function getRemuneracion(){ return $this->_remuneracion; }
		public function setRemuneracion($remuneracion){ $this->_remuneracion=$remuneracion; }
		
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
			$this->setIdUsuario(0);
			$this->setIdPlaza(0);
			$this->setTipo('');
			$this->setPeriodo('');
			$this->setFecha('');
			$this->setRemuneracion(0);
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
				$query="INSERT INTO sueldos (
							id_usuario,
							id_plaza,
							tipo,
							periodo,
							fecha,
							rem,
							descuento,
							no_rem,
							estado 
	        			) VALUES (
	        				".$this->getIdUsuario().", 
							".$this->getIdPlaza().", 
							'".$this->getTipo()."',
							'".$this->getPeriodo()."', 
							'".$this->getFecha()."',
							".$this->getRemuneracion().",
							".$this->getDescuento().",
							".$this->getNoRemunerativo().",
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
				$query="UPDATE sueldos SET
							fecha='".$this->getFecha()."',
							periodo='".$this->getPeriodo()."',
							id_usuario=".$this->getIdUsuario().",
							id_plaza=".$this->getIdPlaza().",
							rem=".$this->getRemuneracion().",
							descuento=".$this->getDescuento().",
							no_rem=".$this->getNoRemunerativo().",
							tipo='".$this->getTipo()."',
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
				$query="UPDATE sueldos SET							
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
					$query = "SELECT * FROM sueldos WHERE estado='true'";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id de Concepto");	

					$query="SELECT * FROM sueldos WHERE id=".$this->getId();
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
				$this->setIdUsuario($filas['id_usuario']);
				$this->setIdPlaza($filas['id_plaza']);
				$this->setTipo($filas['tipo']);
				$this->setPeriodo($filas['periodo']);
				$this->setFecha($filas['fecha']);
				$this->setRemuneracion($filas['rem']);
				$this->setDescuento($filas['descuento']);
				$this->setNoRemunerativo($filas['no_rem']);
				$this->setEstado($filas['estado']);	
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setIdUsuario(0);
			$this->setIdPlaza(0);
			$this->setTipo('');
			$this->setPeriodo('');
			$this->setFecha('');
			$this->setRemuneracion(0);
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
					throw new Exception("No se selecciono el Usuario");	

				$query="SELECT * FROM sueldos WHERE id=".$id;
				
				# Ejecucion 					
				$result = SQL::selectArray($query, new Sueldos);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}

		}
	
		public function selectSueldos($id_plaza,$id_usuario)
		{			
			try {

				$filtro_plaza = '';
				if(!empty($id_plaza))
					$filtro_plaza = ' id_plaza = '.$id_plaza.' AND ';

				$filtro_usuario = '';
				if(!empty($id_usuario))
					$filtro_usuario = ' id_usuario = '.$id_usuario.' AND ';

				$filtro_estado = "estado = 'true' " ;

				$query="SELECT * FROM sueldos 
						WHERE 
						".$filtro_plaza."
						".$filtro_usuario."
						".$filtro_estado;

				# Ejecucion 					
				$result = SQL::selectArray($query, new Sueldos);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}

		}
	}
?>