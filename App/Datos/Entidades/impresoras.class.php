<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';

	class Impresoras
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_serialNro;
		public function getSerialNro(){ return $this->_serialNro; }
		public function setSerialNro($serialNro){ $this->_serialNro =$serialNro; }
		
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
		
		private $_obs;
		public function getObs(){ return $this->_obs; }
		public function setObs($obs){ $this->_obs =$obs; }
		
		private $_tipoBaja;
		public function getTipoBaja(){ return $this->_tipoBaja; }
		public function setTipoBaja($tipoBaja){ $this->_tipoBaja =$tipoBaja; }

		private $_userCarga;
		public function getUserCarga(){ return $this->_userCarga; }
		public function setUserCarga($userCarga){ $this->_userCarga =$userCarga; }

		private $_estado;
		public function getEstado(){ return $this->_estado; }
		public function setEstado($estado){ $this->_estado =$estado; }

		private $_userAprobacion;
		public function getUserAprobacion(){ return $this->_userAprobacion; }
		public function setUserAprobacion($userAprobacion){ $this->_userAprobacion =$userAprobacion; }

		private $_aprobado;
		public function getAprobado(){ return var_export($this->_aprobado,true); }
		public function setAprobado($aprobado){ $this->_aprobado =$aprobado; }
		
		private $_fechaHoraAprobacion;
		public function getFechaHoraAprobacion(){ return $this->_fechaHoraAprobacion; }
		public function setFechaHoraAprobacion($fechaHoraAprobacion){ $this->_fechaHoraAprobacion =$fechaHoraAprobacion; }


		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setSerialNro('');
			$this->setMarca('');
			$this->setModelo('');
			$this->setFechaCompra('');
			$this->setPrecioCompra(0);
			$this->setFechaBaja('');
			$this->setObs('');
			$this->setTipoBaja('');
			$this->setUserCarga(0);
			$this->setEstado(0);
			$this->setUserAprobacion(0);
			$this->setAprobado(false);
			$this->setFechaHoraAprobacion('');
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				$query="INSERT INTO impresoras (
										serialNro,
		        						marca,	
		        						modelo,
		        						fechaCompra,
		        						precioCompra,
		        						userCarga,
		        						estado,
		        						aprobado,
		        						obs
	        			) VALUES (
	        							'".$this->getSerialNro()."',   	
	        							'".$this->getMarca()."',     	
	        							'".$this->getModelo()."',
	        							'".$this->getFechaCompra()."',
	        							".$this->getPrecioCompra().",
	        							".$this->getUserCarga().",
	        							1,
	        							'".$this->getAprobado()."',
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
				$query="UPDATE impresoras SET
								serialNro='".$this->getSerialNro()."',
								marca='".$this->getMarca()."',
								modelo='".$this->getModelo()."',
								fechaCompra='".$this->getFechaCompra()."',
								precioCompra=".$this->getPrecioCompra().",
								fechaBaja='".$this->getFechaBaja()."',
								obs='".$this->getObs()."'
							WHERE serialNro=".$this->getSerialNro();

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
				$query="UPDATE impresoras SET							
								fechaBaja = '".$this->getFecha()."
								tipoBaja = '".$this->getTipoBaja()."
							WHERE serialNro='".$this->getSerialNro()."'";

				# Ejecucion 	
				return SQL::delete($conexion,$query);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function select()
		{			
			try {
											
				$query = "SELECT * FROM impresoras order by fechaBaja";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Impresoras);
						
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
				$this->setSerialNro($filas['serialNro']);
				$this->setMarca(trim($filas['marca']));			
				$this->setModelo(trim($filas['modelo']));			
				$this->setFechaCompra($filas['fechaCompra']);			
				$this->setPrecioCompra(trim($filas['precioCompra']));			
				$this->setFechaBaja($filas['fechaBaja']);			
				$this->setObs($filas['obs']);
				$this->setTipoBaja($filas['tipoBaja']);
				$this->setUserCarga($filas['userCarga']);
				$this->setEstado($filas['estado']);
				$this->setUserAprobacion($filas['userAprobacion']);
				$this->setAprobado($filas['aprobado']);
				$this->setFechaHoraAprobacion($filas['fechaHoraAprobacion']);
			}
		}

		private function cleanClass()
		{
			$this->setSerialNro(0);
			$this->setMarca('');
			$this->setModelo('');
			$this->setFechaCompra('');
			$this->setPrecioCompra(0);
			$this->setFechaBaja('');
			$this->setObs('');
			$this->setTipoBaja('');
			$this->setUserCarga(0);
			$this->setEstado(0);
			$this->setUserAprobacion(0);
			$this->setAprobado(false);
			$this->setFechaHoraAprobacion('');
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';
			/*
			USE [Prueba_AppWeb]
			GO

			SET ANSI_NULLS ON
			GO

			SET QUOTED_IDENTIFIER ON
			GO

			SET ANSI_PADDING ON
			GO

			CREATE TABLE [dbo].[impresoras](
				[serialNro] [varchar](30) NOT NULL,
				[marca] [varchar](50) NOT NULL,
				[modelo] [varchar](30) NOT NULL,
				[fechaCompra] [date] NULL,
				[precioCompra] [decimal](18, 2) NULL,
				[fechaBaja] [date] NULL,
				[obs] [text] NULL,
				[aprobado] [bit] NULL,
				[userCarga] [int] NULL,
				[userAprobacion] [int] NULL,
				[fechaHoraAprobacion] [datetime] NULL,
				[tipoBaja] [varchar](50) NULL,
				[estado] [int] NULL,
			 CONSTRAINT [PK_impresoras] PRIMARY KEY CLUSTERED 
			(
				[serialNro] ASC
			)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
			) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

			GO

			SET ANSI_PADDING OFF
			GO


			*/
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

		public function editarImpresora($conexion)
		{
			try {

				# Validaciones 			
				if(empty($this->getSerialNro()))
					throw new Exception("Impresora no identificada");

				
				# Query 			
				$query="UPDATE impresoras SET
								fechaCompra='".$this->getFechaCompra()."',
								precioCompra=".$this->getPrecioCompra().",
								userAprobacion=".$this->getUserAprobacion().",
								aprobado='".$this->getAprobado()."',
								fechaHoraAprobacion='".$this->getFechaHoraAprobacion()."'
							WHERE serialNro='".$this->getSerialNro()."'";
							

				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		public function selectXPlaza($plaza)
		{			
			try {
											
				# Query
				if($plaza=='' || $plaza == '0'){
					$query = "SELECT 
					impresoras.serialNro, impresoras.modelo, impresoras.marca, 
					impresoras.fechaCompra, impresoras.precioCompra, impresoras.fechaBaja, impresoras.obs,impresoras.estado
					FROM impresoras left join impresora_plaza 
					on impresoras.serialNro = impresora_plaza.serialNro
					WHERE fechaDev is null or fechaBaja is null
					order by fechaBaja, gestorId desc";
				} else {
					$query = "SELECT * FROM impresoras inner join impresora_plaza on impresoras.serialNro = impresora_plaza.serialNro WHERE fechaDev is null and plaza='".$plaza."' order by gestorId desc";
				}

				# Ejecucion 					
				$result = SQL::selectObject($query, new Impresoras);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function selectXGestor($gestorId)
		{			
			try {
											
				# Query
				if($gestorId=='' || $gestorId == '0'){
					$query = "SELECT 
					impresoras.serialNro, impresoras.modelo, impresoras.marca, 
					impresoras.fechaCompra, impresoras.precioCompra, impresoras.fechaBaja, impresoras.obs,impresoras.estado 
					FROM impresoras left join impresora_plaza 
					on impresoras.serialNro = impresora_plaza.serialNro 
					WHERE fechaDev is null or fechaBaja is null
					order by fechaBaja, gestorId desc";
				} else {
					$query = "SELECT * FROM impresoras inner join impresora_plaza on impresoras.serialNro = impresora_plaza.serialNro WHERE fechaDev is null and gestorId='".$gestorId."' order by gestorId desc";
				}

				# Ejecucion 					
				$result = SQL::selectObject($query, new Impresoras);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function getMarcaConSerial($serialNro)
		{			
			try {
				# Query
				$query="SELECT * FROM impresoras WHERE serialNro='".$serialNro."'";
	
				# Ejecucion 					
				$result = SQL::selectObject($query, new Impresoras);
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

		public function bajaImpresora($conexion)
		{
			try {

				# Query 			
				$query="UPDATE impresoras SET
								fechaBaja='".$this->getFechaBaja()."',
								tipoBaja='".$this->getTipoBaja()."',
								obs='".$this->getObs()."'
							WHERE serialNro='".$this->getSerialNro()."'";

				// var_dump($query);
				// exit();
				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		public function cambiarEstado($conexion,$estado)
		{
			try {

				# Validaciones 			
				if(empty($this->getSerialNro()))
					throw new Exception("Impresora no identificada");

				
				# Query 			
				$query="UPDATE impresoras SET
							estado=".$estado."
							WHERE serialNro='".$this->getSerialNro()."'";
				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}
	}
?>