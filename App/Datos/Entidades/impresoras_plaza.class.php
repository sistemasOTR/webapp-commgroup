<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';

	class ImpresorasPlaza
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_asigId;
		public function getAsigId(){ return $this->_asigId; }
		public function setAsigId($asigId){ $this->_asigId =$asigId; }
		
		private $_serialNro;
		public function getSerialNro(){ return $this->_serialNro; }
		public function setSerialNro($serialNro){ $this->_serialNro =$serialNro; }
		
		private $_plaza;
		public function getPlaza(){ return $this->_plaza; }
		public function setPlaza($plaza){ $this->_plaza =$plaza; }

		private $_gestorId;
		public function getGestorId(){ return $this->_gestorId; }
		public function setGestorId($gestorId){ $this->_gestorId =$gestorId; }

		private $_fechaAsig;
		public function getFechaAsig(){ return $this->_fechaAsig; }
		public function setFechaAsig($fechaAsig){ $this->_fechaAsig =$fechaAsig; }

		private $_fechaDev;
		public function getFechaDev(){ return $this->_fechaDev; }
		public function setFechaDev($fechaDev){ $this->_fechaDev =$fechaDev; }
		
		private $_obs;
		public function getObs(){ return $this->_obs; }
		public function setObs($obs){ $this->_obs =$obs; }
		
		private $_obsDev;
		public function getObsDev(){ return $this->_obsDev; }
		public function setObsDev($obsDev){ $this->_obsDev =$obsDev; }
		
		private $_tipoDev;
		public function getTipoDev(){ return $this->_tipoDev; }
		public function setTipoDev($tipoDev){ $this->_tipoDev =$tipoDev; }


		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setAsigId(0);
			$this->setSerialNro('');
			$this->setPlaza('');
			$this->setGestorId(0);
			$this->setFechaAsig('');
			$this->setFechaDev('');
			$this->setObs('');
			$this->setObsDev('');
			$this->setTipoDev('');
			
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				$query="INSERT INTO impresora_plaza (
										serialNro,
										gestorId,
		        						plaza,	
		        						fechaAsig,
		        						obs
	        			) VALUES (
	        							'".$this->getSerialNro()."',     	
	        							".$this->getGestorId().",   	
	        							'".$this->getPlaza()."',     	
	        							'".$this->getFechaAsig()."',
	        							'".$this->getObs()."'
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
				if(empty($this->getSerialNro()))
					throw new Exception("Impresora no identificada");

				
				# Query 			
				$query="UPDATE impresora_plaza SET
								asigId=".$this->getAsigId().",
								serialNro='".$this->getSerialNro()."',
								plaza='".$this->getPlaza()."',
								gestorId=".$this->getGestorId().",
								fechaAsig='".$this->getFechaAsig()."',
								fechaDev='".$this->getFechaDev()."',
								tipoDev='".$this->getTipoDev()."',
								obs='".$this->getObs()."'
							WHERE asigId=".$this->getAsigId();

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
				if(empty($this->getSerialNro()))
					throw new Exception("Impresora no identificada");
			
				# Query 			
				$query="UPDATE impresora_plaza SET							
								fechaDev = '".$this->getFecha()."
							WHERE asigId=".$this->getAsigId();

				# Ejecucion 	
				return SQL::delete($conexion,$query);

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
				$this->setAsigId($filas['asigId']);
				$this->setSerialNro(trim($filas['serialNro']));
				$this->setPlaza(trim($filas['plaza']));			
				$this->setGestorId($filas['gestorId']);			
				$this->setFechaAsig($filas['fechaAsig']);			
				$this->setFechaDev($filas['fechaDev']);			
				$this->setObs(trim($filas['obs']));
				$this->setObsDev(trim($filas['obsDev']));
				$this->setTipoDev(trim($filas['tipoDev']));
			}
		}

		private function cleanClass()
		{
			$this->setAsigId(0);
			$this->setSerialNro('');
			$this->setPlaza('');
			$this->setGestorId(0);
			$this->setFechaAsig('');
			$this->setFechaDev('');
			$this->setObs('');
			$this->setObsDev('');
			$this->setTipoDev('');
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

		public function devolver($conexion)
		{
			try {

				# Query 			
				$query="UPDATE impresora_plaza SET
								fechaDev='".$this->getFechaDev()."',
								tipoDev='".$this->getTipoDev()."',
								obsDev='".$this->getObsDev()."'
							WHERE asigId=".$this->getAsigId();


				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		public function selectXPlaza($enplaza)
		{			
			try {
				# Query
				if($enplaza=='' || $enplaza == '0'){
					$query = "SELECT * FROM impresora_plaza WHERE fechaDev is null";
				} else {
					$query = "SELECT * FROM impresora_plaza WHERE fechaDev is null and plaza='".$enplaza."'";
				}

				# Ejecucion 					
				$result = SQL::selectObject($query, new ImpresorasPlaza);
				
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function selectXSerial($serialNro)
		{			
			try {
				# Query
				$query="SELECT * FROM impresora_plaza WHERE serialNro='".$serialNro."' and fechaDev is null";

				# Ejecucion 					
				$result = SQL::selectObject($query, new ImpresorasPlaza);
				if(is_null($result)){
					return $result;
				} else {
					$result= get_object_vars($result);

					return $result;

				}

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function getAsignaciones($serialNro)
		{			
			try {
				
				$query = "SELECT * FROM impresora_plaza WHERE serialNro ='".$serialNro."' order by fechaAsig desc";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ImpresorasPlaza);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function selectById($asigId)
		{			
			try {
				
				$query = "SELECT * FROM impresora_plaza WHERE asigId ='".$asigId."' order by fechaAsig desc";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ImpresorasPlaza);
				if(is_null($result)){
					return $result;
				} else {
					$result= get_object_vars($result);

					return $result;

				}

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function selectByGestor($gestorId)
		{			
			try {
				
				$query = "SELECT * FROM impresora_plaza WHERE gestorId ='".$gestorId."' order by fechaAsig desc";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ImpresorasPlaza);
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}
	}
?>