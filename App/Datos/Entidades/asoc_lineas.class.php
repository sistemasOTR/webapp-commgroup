<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';

	class LineaEquipo
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_asocId;
		public function getAsocId(){ return $this->_asocId; }
		public function setAsocId($asocId){ $this->_asocId =$asocId; }
		
		private $_nroLinea;
		public function getNroLinea(){ return $this->_nroLinea; }
		public function setNroLinea($nroLinea){ $this->_nroLinea =$nroLinea; }

		private $_IMEI;
		public function getIMEI(){ return $this->_IMEI; }
		public function setIMEI($IMEI){ $this->_IMEI =$IMEI; }
		
		private $_fechaAsoc;
		public function getFechaAsoc(){ return $this->_fechaAsoc; }
		public function setFechaAsoc($fechaAsoc){ $this->_fechaAsoc =$fechaAsoc; }

		private $_fechaDesv;
		public function getFechaDesv(){ return $this->_fechaDesv; }
		public function setFechaDesv($fechaDesv){ $this->_fechaDesv =$fechaDesv; }
		
		private $_obs;
		public function getObs(){ return $this->_obs; }
		public function setObs($obs){ $this->_obs =$obs; }


		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setAsocId(0);
			$this->setNroLinea('');
			$this->setIMEI(0);
			$this->setFechaAsoc('');
			$this->setFechaDesv('');
			$this->setObs('');
			
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				$query="INSERT INTO asoc_lc (
										nroLinea,	
		        						IMEI,
		        						fechaAsoc,
		        						obs
	        			) VALUES (
	        							'".$this->getNroLinea()."',     	
	        							".$this->getIMEI().",
	        							'".$this->getFechaAsoc()."',
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
				if(empty($this->getAsocId()))
					throw new Exception("Impresora no identificada");

				
				# Query 			
				$query="UPDATE asoc_lc SET
								nroLinea='".$this->getNroLinea()."',
								IMEI=".$this->getIMEI().",
								fechaAsoc='".$this->getFechaAsoc()."',
								fechaDesv='".$this->getFechaDesv()."',
								obs='".$this->getObs()."'
							WHERE asocId=".$this->getAsocId();

				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		
		public function select()
		{			
			try {
											
				$query = "SELECT * FROM asoc_lc order by fechaAsoc";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new LineaEquipo);
						
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
				$this->setAsocId($filas['asocId']);
				$this->setNroLinea(trim($filas['nroLinea']));			
				$this->setIMEI(trim($filas['IMEI']));			
				$this->setFechaAsoc($filas['fechaAsoc']);			
				$this->setFechaDesv($filas['fechaDesv']);			
				$this->setObs($filas['obs']);
			}
		}

		private function cleanClass()
		{
			$this->setAsocId(0);
			$this->setNroLinea('');
			$this->setIMEI(0);
			$this->setFechaAsoc('');
			$this->setFechaDesv('');
			$this->setObs('');
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

	class LineaUsuario
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_entId;
		public function getEntId(){ return $this->_entId; }
		public function setEntId($entId){ $this->_entId =$entId; }
		
		private $_nroLinea;
		public function getNroLinea(){ return $this->_nroLinea; }
		public function setNroLinea($nroLinea){ $this->_nroLinea =$nroLinea; }

		private $_usId;
		public function getUsId(){ return $this->_usId; }
		public function setUsId($usId){ $this->_usId =$usId; }
		
		private $_fechaEntrega;
		public function getFechaEntrega(){ return $this->_fechaEntrega; }
		public function setFechaEntrega($fechaEntrega){ $this->_fechaEntrega =$fechaEntrega; }

		private $_fechaDev;
		public function getFechaDev(){ return $this->_fechaDev; }
		public function setFechaDev($fechaDev){ $this->_fechaDev =$fechaDev; }
		
		private $_obsEntrega;
		public function getObsEntrega(){ return $this->_obsEntrega; }
		public function setObsEntrega($obsEntrega){ $this->_obsEntrega =$obsEntrega; }
		
		private $_obsDev;
		public function getObsDev(){ return $this->_obsDev; }
		public function setObsDev($obsDev){ $this->_obsDev =$obsDev; }


		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setEntId(0);
			$this->setNroLinea('');
			$this->setUsId(0);
			$this->setFechaEntrega('');
			$this->setFechaDev('');
			$this->setObsEntrega('');
			$this->setObsDev('');
			
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				$query="INSERT INTO asoc_lu (
										nroLinea,	
		        						usId,
		        						fechaEntrega,
		        						obsEntrega
	        			) VALUES (
	        							'".$this->getNroLinea()."',     	
	        							".$this->getUsId().",
	        							'".$this->getFechaEntrega()."',
	        							'".$this->getObsEntrega()."'
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
				if(empty($this->getEntId()))
					throw new Exception("Impresora no identificada");

				
				# Query 			
				$query="UPDATE asoc_lu SET
								nroLinea='".$this->getNroLinea()."',
								usId=".$this->getUsId().",
								fechaEntrega='".$this->getFechaEntrega()."',
								fechaDev='".$this->getFechaDev()."',
								obsEntrega='".$this->getObsEntrega()."',
								obsDev='".$this->getObsDev()."'
							WHERE entId=".$this->getEntId();

				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		
		public function select()
		{			
			try {
											
				$query = "SELECT * FROM asoc_lu order by fechaEntrega";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new LineaUsuario);
						
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
				$this->setEntId($filas['entId']);
				$this->setNroLinea(trim($filas['nroLinea']));			
				$this->setUsId(trim($filas['usId']));			
				$this->setFechaEntrega($filas['fechaEntrega']);			
				$this->setFechaDev($filas['fechaDev']);			
				$this->setObsEntrega($filas['obsEntrega']);
				$this->setObsDev($filas['obsDev']);
			}
		}

		private function cleanClass()
		{
			$this->setEntId(0);
			$this->setNroLinea('');
			$this->setUsId(0);
			$this->setFechaEntrega('');
			$this->setFechaDev('');
			$this->setObsEntrega('');
			$this->setObsDev('');
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