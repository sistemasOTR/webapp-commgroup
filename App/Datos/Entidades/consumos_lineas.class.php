<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';

	class ConsumoLinea
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_consId;
		public function getConsId(){ return $this->_consId; }
		public function setConsId($consId){ $this->_consId =$consId; }
		
		private $_nroLinea;
		public function getNroLinea(){ return $this->_nroLinea; }
		public function setNroLinea($nroLinea){ $this->_nroLinea =$nroLinea; }
		
		private $_idUsuario;
		public function getIdUsuario(){ return $this->_idUsuario; }
		public function setIdUsuario($idUsuario){ $this->_idUsuario =$idUsuario; }
		
		private $_mesConsumo;
		public function getMesConsumo(){ return $this->_mesConsumo; }
		public function setMesConsumo($mesConsumo){ $this->_mesConsumo =$mesConsumo; }
		
		private $_basico;
		public function getBasico(){ return $this->_basico; }
		public function setBasico($basico){ $this->_basico =$basico; }
		
		private $_consReal;
		public function getConsReal(){ return $this->_consReal; }
		public function setConsReal($consReal){ $this->_consReal =$consReal; }
		
		private $_excedente;
		public function getExcedente(){ return $this->_excedente; }
		public function setExcedente($excedente){ $this->_excedente =$excedente; }
		
		private $_conceptoExc;
		public function getConceptoExc(){ return $this->_conceptoExc; }
		public function setConceptoExc($conceptoExc){ $this->_conceptoExc =$conceptoExc; }


		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setConsId(0);
			$this->setNroLinea('');
			$this->setIdUsuario(0);
			$this->setMesConsumo('');
			$this->setBasico(0);
			$this->setConsReal(0);
			$this->setExcedente(0);
			$this->setConceptoExc('');
			
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				$query="INSERT INTO consumos_lineas (
										nroLinea,	
										idUsuario,
		        						mesConsumo,
		        						basico,
		        						consReal,
		        						excedente,
		        						conceptoExc
	        			) VALUES (
	        							'".$this->getNroLinea()."',     	
	        							".$this->getIdUsuario().",
	        							'".$this->getMesConsumo()."',
	        							".$this->getBasico().",
	        							".$this->getConsReal().",
	        							".$this->getExcedente().",
	        							'".$this->getConceptoExc()."'
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
				# Query 			
				$query="UPDATE consumos_lineas SET
								nroLinea='".$this->getNroLinea()."',
								idUsuario=".$this->getIdUsuario().",
								mesConsumo='".$this->getMesConsumo()."',
								conceptoExc='".$this->getConceptoExc()."'
							WHERE consId=".$this->getConsId();

				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		
		public function select()
		{			
			try {
											
				$query = "SELECT * FROM consumos_lineas order by mesConsumo desc";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ConsumoLinea);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		
		public function getConsumos($nroLinea)
		{			
			try {
											
				$query = "SELECT * FROM consumos_lineas where nroLinea='".$nroLinea."' order by mesConsumo desc";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ConsumoLinea);
						
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
				$this->setConsId($filas['consId']);
				$this->setNroLinea(trim($filas['nroLinea']));			
				$this->setIdUsuario(trim($filas['idUsuario']));			
				$this->setMesConsumo($filas['mesConsumo']);			
				$this->setBasico(trim($filas['basico']));			
				$this->setConsReal(trim($filas['consReal']));			
				$this->setExcedente(trim($filas['excedente']));			
				$this->setConceptoExc($filas['conceptoExc']);
			}
		}

		private function cleanClass()
		{
			$this->setConsId(0);
			$this->setNroLinea('');
			$this->setIdUsuario(0);
			$this->setMesConsumo('');
			$this->setBasico(0);
			$this->setConsReal(0);
			$this->setExcedente(0);
			$this->setConceptoExc('');
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';
		}

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/

		public function getNombreRoles(){
			$handler = new UsuarioPerfil;
			$roles = explode("|", $this->getRoles());
			
			$nombre_roles = "";
			foreach ($roles as $key => $value) {
				if(!empty($value)){
					$handler->setId($value);
					$nombre_roles = $nombre_roles.$handler->select()->getNombre().",";				
				}
			}			
			return $nombre_roles;
		}
	}
?>