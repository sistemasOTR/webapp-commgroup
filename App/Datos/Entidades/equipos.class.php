<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';

	class Equipos
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_IMEI;
		public function getIMEI(){ return $this->_IMEI; }
		public function setIMEI($IMEI){ $this->_IMEI =$IMEI; }
		
		private $_marca;
		public function getMarca(){ return $this->_marca; }
		public function setMarca($marca){ $this->_marca =$marca; }

		private $_modelo;
		public function getModelo(){ return $this->_modelo; }
		public function setModelo($modelo){ $this->_modelo =$modelo; }
		
		private $_fechaCompra;
		public function getFechaCompra(){ return $this->_fechaCompra; }
		public function setFechaCompra($fechaCompra){ $this->_fechaCompra =$fechaCompra; }

		private $_precioCompra;
		public function getPrecioCompra(){ return $this->_precioCompra; }
		public function setPrecioCompra($precioCompra){ $this->_precioCompra =$precioCompra; }

		private $_fechaBaja;
		public function getFechaBaja(){ return $this->_fechaBaja; }
		public function setFechaBaja($fechaBaja){ $this->_fechaBaja =$fechaBaja; }
		
		private $_obsBaja;
		public function getObsBaja(){ return $this->_obsBaja; }
		public function setObsBaja($obsBaja){ $this->_obsBaja =$obsBaja; }

		private $_fechaPerd;
		public function getFechaPerd(){ return $this->_fechaPerd; }
		public function setFechaPerd($fechaPerd){ $this->_fechaPerd =$fechaPerd; }
		
		private $_obsPerd;
		public function getObsPerd(){ return $this->_obsPerd; }
		public function setObsPerd($obsPerd){ $this->_obsPerd =$obsPerd; }

		private $_fechaRobo;
		public function getFechaRobo(){ return $this->_fechaRobo; }
		public function setFechaRobo($fechaRobo){ $this->_fechaRobo =$fechaRobo; }
		
		private $_obsRobo;
		public function getObsRobo(){ return $this->_obsRobo; }
		public function setObsRobo($obsRobo){ $this->_obsRobo =$obsRobo; }


		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setIMEI('');
			$this->setMarca('');
			$this->setModelo('');
			$this->setFechaCompra('');
			$this->setPrecioCompra(0);
			$this->setFechaBaja('');
			$this->setObsBaja('');
			$this->setFechaPerd('');
			$this->setObsPerd('');
			$this->setFechaRobo('');
			$this->setObsRobo('');
			
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				$query="INSERT INTO equipos (
										IMEI,
		        						marca,	
		        						modelo,
		        						fechaCompra,
		        						precioCompra,
		        						ocupado
	        			) VALUES (
	        							'".$this->getIMEI()."',
	        							'".$this->getMarca()."',     	
	        							'".$this->getModelo()."',
	        							'".$this->getFechaCompra()."',
	        							".$this->getPrecioCompra().",
	        							'false'
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
				if(empty($this->getIMEI()))
					throw new Exception("Impresora no identificada");

				
				# Query 			
				$query="UPDATE equipos SET
								IMEI='".$this->getIMEI()."',
								marca='".$this->getMarca()."',
								modelo='".$this->getModelo()."',
								fechaCompra='".$this->getFechaCompra()."',
								precioCompra=".$this->getPrecioCompra().",
								fechaBaja='".$this->getFechaBaja()."',
								obs='".$this->getObsBaja()."'
							WHERE IMEI=".$this->getIMEI();

				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}


		public function entregado($conexion)
		{
			try {

				# Query 			
				$query="UPDATE equipos SET
								ocupado='true'
							WHERE IMEI='".$this->getIMEI()."'";
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
				$query="UPDATE equipos SET
								ocupado='false'
							WHERE IMEI='".$this->getIMEI()."'";
				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		public function rotura($conexion)
		{
			try {
				
				# Validaciones 			
				if(empty($this->getIMEI()))
					throw new Exception("Impresora no identificada");
			
				# Query 			
				$query="UPDATE equipos SET							
						fechaBaja = '".$this->getFechaBaja()."',
						obsBaja='".$this->getObsBaja()."'
						WHERE IMEI=".$this->getIMEI()."'";


				# Ejecucion 	
				return SQL::delete($conexion,$query);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function robo($conexion)
		{
			try {
				# Query 			
				$query="UPDATE equipos SET							
						fechaRobo = '".$this->getFechaRobo()."',
						obsRobo='".$this->getObsRobo()."'
						WHERE IMEI='".$this->getIMEI()."'";

				# Ejecucion 	
				return SQL::delete($conexion,$query);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function perdida($conexion)
		{
			try {
				
				# Query 			
				$query="UPDATE equipos SET							
						fechaPerd = '".$this->getFechaPerd()."',
						obsPerd='".$this->getObsPerd()."'
						WHERE IMEI='".$this->getIMEI()."'";


				# Ejecucion 	
				return SQL::delete($conexion,$query);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function select()
		{			
			try {
											
				$query = "SELECT * FROM equipos order by fechaBaja";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Equipos);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function getEquipoLinea($nroIMEI)
		{			
			try {
											
				$query = "SELECT * FROM equipos where IMEI =".$nroIMEI;
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Equipos);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function getEquiposLibres()
		{			
			try {
											
				$query = "SELECT * FROM equipos where ocupado = 'false' order by fechaBaja , fechaPerd , fechaRobo ";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Equipos);
						
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
				$this->setIMEI(trim($filas['IMEI']));
				$this->setMarca(trim($filas['marca']));			
				$this->setModelo(trim($filas['modelo']));			
				$this->setFechaCompra($filas['fechaCompra']);			
				$this->setPrecioCompra(trim($filas['precioCompra']));
				$this->setFechaBaja($filas['fechaBaja']);			
				$this->setObsBaja($filas['obsBaja']);
				$this->setFechaPerd($filas['fechaPerd']);			
				$this->setObsPerd($filas['obsPerd']);
				$this->setFechaRobo($filas['fechaRobo']);			
				$this->setObsRobo($filas['obsRobo']);
				
			}
		}

		private function cleanClass()
		{
			$this->setIMEI('');
			$this->setMarca('');
			$this->setModelo('');
			$this->setFechaCompra('');
			$this->setPrecioCompra(0);
			$this->setFechaBaja('');
			$this->setObsBaja('');
			$this->setFechaPerd('');
			$this->setObsPerd('');
			$this->setFechaRobo('');
			$this->setObsRobo('');
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