<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';

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
		
		private $_IMEI;
		public function getIMEI(){ return $this->_IMEI; }
		public function setIMEI($IMEI){ $this->_IMEI =$IMEI; }

		private $_usId;
		public function getUsId(){ return $this->_usId; }
		public function setUsId($usId){ $this->_usId =$usId; }
		
		private $_fechaEntregaLinea;
		public function getFechaEntregaLinea(){ return $this->_fechaEntregaLinea; }
		public function setFechaEntregaLinea($fechaEntregaLinea){ $this->_fechaEntregaLinea =$fechaEntregaLinea; }
		
		private $_fechaEntregaEquipo;
		public function getFechaEntregaEquipo(){ return $this->_fechaEntregaEquipo; }
		public function setFechaEntregaEquipo($fechaEntregaEquipo){ $this->_fechaEntregaEquipo =$fechaEntregaEquipo; }

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
			$this->setIMEI('');
			$this->setUsId(0);
			$this->setFechaEntregaLinea('');
			$this->setFechaEntregaEquipo('');
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
										IMEI,	
		        						usId,
		        						fechaEntregaLinea,
		        						fechaEntregaEquipo,
		        						obsEntrega
	        			) VALUES (
	        							'".$this->getNroLinea()."',     	
	        							'".$this->getIMEI()."',     	
	        							".$this->getUsId().",
	        							'".$this->getFechaEntregaLinea()."',
	        							'".$this->getFechaEntregaEquipo()."',
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
								IMEI='".$this->getIMEI()."',
								usId=".$this->getUsId().",
								fechaEntregaLinea='".$this->getFechaEntregaLinea()."',
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

		public function devolver($conexion)
		{
			try {

				# Query 			
				$query="UPDATE asoc_lu SET
								fechaDev='".$this->getFechaDev()."',
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
											
				$query = "SELECT * FROM asoc_lu order by fechaEntregaLinea";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new LineaUsuario);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function getLineasEntregadas()
		{			
			try {
											
				$query = "SELECT * FROM asoc_lu where fechaDev is null";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new LineaUsuario);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function getLineaEntregada($entId)
		{			
			try {
											
				$query = "SELECT * FROM asoc_lu where entId=".$entId;
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new LineaUsuario);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function getEntrega($nroLinea)
		{			
			try {
											
				$query = "SELECT * FROM asoc_lu where fechaDev is null AND nroLinea=".$nroLinea;
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new LineaUsuario);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function getHistEntregas($nroLinea)
		{			
			try {
											
				$query = "SELECT * FROM asoc_lu where fechaDev is not null AND nroLinea=".$nroLinea." order by fechaEntregaLinea desc";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new LineaUsuario);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function getHistEntregasXIMEI($IMEI)
		{			
			try {
											
				$query = "SELECT * FROM asoc_lu where fechaDev is not null AND IMEI='".$IMEI."' order by fechaEntregaLinea desc";
				

				# Ejecucion 					
				$result = SQL::selectObject($query, new LineaUsuario);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		
		public function getUsuarioLinea($asocUs)
		{			
			try {
											
				$query = "SELECT * FROM asoc_lu where entId=".$asocUs;
				
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
				$this->setIMEI(trim($filas['IMEI']));			
				$this->setUsId(trim($filas['usId']));			
				$this->setFechaEntregaLinea($filas['fechaEntregaLinea']);			
				$this->setFechaEntregaEquipo($filas['fechaEntregaEquipo']);			
				$this->setFechaDev($filas['fechaDev']);			
				$this->setObsEntrega($filas['obsEntrega']);
				$this->setObsDev($filas['obsDev']);
			}
		}

		private function cleanClass()
		{
			$this->setEntId(0);
			$this->setNroLinea('');
			$this->setIMEI('');
			$this->setUsId(0);
			$this->setFechaEntregaLinea('');
			$this->setFechaEntregaEquipo('');
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