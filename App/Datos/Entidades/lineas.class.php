<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';

	class Lineas
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_nroLinea;
		public function getNroLinea(){ return $this->_nroLinea; }
		public function setNroLinea($nroLinea){ $this->_nroLinea =$nroLinea; }
		
		private $_empresa;
		public function getEmpresa(){ return $this->_empresa; }
		public function setEmpresa($empresa){ $this->_empresa =$empresa; }

		private $_nombrePlan;
		public function getNombrePlan(){ return $this->_nombrePlan; }
		public function setNombrePlan($nombrePlan){ $this->_nombrePlan =$nombrePlan; }
		
		private $_fechaAlta;
		public function getFechaAlta(){ return $this->_fechaAlta; }
		public function setFechaAlta($fechaAlta){ $this->_fechaAlta =$fechaAlta; }

		private $_costo;
		public function getCosto(){ return $this->_costo; }
		public function setCosto($costo){ $this->_costo =$costo; }

		private $_consEstimado;
		public function getConsEstimado(){ return $this->_consEstimado; }
		public function setConsEstimado($consEstimado){ $this->_consEstimado =$consEstimado; }

		private $_fechaBaja;
		public function getFechaBaja(){ return $this->_fechaBaja; }
		public function setFechaBaja($fechaBaja){ $this->_fechaBaja =$fechaBaja; }
		
		private $_obs;
		public function getObs(){ return $this->_obs; }
		public function setObs($obs){ $this->_obs =$obs; }
		
		private $_asocEq;
		public function getAsocEq(){ return $this->_asocEq; }
		public function setAsocEq($asocEq){ $this->_asocEq =$asocEq; }
		
		private $_asocUs;
		public function getAsocUs(){ return $this->_asocUs; }
		public function setAsocUs($asocUs){ $this->_asocUs =$asocUs; }


		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setNroLinea('');
			$this->setEmpresa('');
			$this->setNombrePlan('');
			$this->setFechaAlta('');
			$this->setCosto(0);
			$this->setConsEstimado(0);
			$this->setFechaBaja('');
			$this->setObs('');
			$this->setAsocEq(0);
			$this->setAsocUs(0);
			
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				$query="INSERT INTO lineas (
										nroLinea,
		        						empresa,	
		        						nombrePlan,
		        						fechaAlta,
		        						costo,
		        						consEstimado,
		        						obs,
	        			) VALUES (
	        							'".$this->getNroLinea()."',   	
	        							'".$this->getEmpresa()."',     	
	        							'".$this->getNombrePlan()."',
	        							'".$this->getFechaAlta()."',
	        							".$this->getCosto().",
	        							".$this->getConsEstimado().",
	        							'".$this->getObs()."',
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
				if(empty($this->getNroLinea()))
					throw new Exception("Impresora no identificada");

				
				# Query 			
				$query="UPDATE lineas SET
								fechaBaja='".$this->getFechaBaja()."',
								obs='".$this->getObs()."',
								asocEq=".$this->getAsocEq().",
								asocUs=".$this->getAsocUs().",
							WHERE nroLinea=".$this->getNroLinea();

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
				if(empty($this->getNroLinea()))
					throw new Exception("Impresora no identificada");
			
				# Query 			
				$query="UPDATE lineas SET							
								fechaBaja = '".$this->getFechaBaja()."
							WHERE nroLinea='".$this->getNroLinea()."'";

				# Ejecucion 	
				return SQL::delete($conexion,$query);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function select()
		{			
			try {
											
				$query = "SELECT * FROM lineas order by fechaBaja";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Lineas);
						
				return $result;

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
					impresoras.nroLinea, impresoras.nombrePlan, impresoras.empresa, 
					impresoras.fechaAlta, impresoras.costo, impresoras.fechaBaja, impresoras.obs
					FROM impresoras left join impresora_plaza 
					on impresoras.nroLinea = impresora_plaza.nroLinea
					WHERE fechaDev is null or fechaBaja is null
					order by fechaBaja";
				} else {
					$query = "SELECT * FROM impresoras inner join impresora_plaza on impresoras.nroLinea = impresora_plaza.nroLinea WHERE fechaDev is null and plaza='".$plaza."'";
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
					impresoras.nroLinea, impresoras.nombrePlan, impresoras.empresa, 
					impresoras.fechaAlta, impresoras.costo, impresoras.fechaBaja, impresoras.obs
					FROM impresoras left join impresora_plaza 
					on impresoras.nroLinea = impresora_plaza.nroLinea 
					WHERE fechaDev is null or fechaBaja is null
					order by fechaBaja";
				} else {
					$query = "SELECT * FROM impresoras inner join impresora_plaza on impresoras.nroLinea = impresora_plaza.nroLinea WHERE fechaDev is null and gestorId='".$gestorId."'";
				}

				# Ejecucion 					
				$result = SQL::selectObject($query, new Impresoras);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function getEmpresaConSerial($nroLinea)
		{			
			try {
				# Query
				$query="SELECT * FROM lineas WHERE nroLinea='".$nroLinea."'";
	
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

		public function setPropiedadesBySelect($filas)
		{	
			if(empty($filas)){
				$this->cleanClass();
			}
			else{
				$this->setNroLinea($filas['nroLinea']);
				$this->setEmpresa(trim($filas['empresa']));			
				$this->setNombrePlan(trim($filas['nombrePlan']));			
				$this->setFechaAlta($filas['fechaAlta']);			
				$this->setCosto(trim($filas['costo']));			
				$this->setConsEstimado(trim($filas['consEstimado']));			
				$this->setFechaBaja($filas['fechaBaja']);			
				$this->setObs($filas['obs']);
				$this->setAsocEq($filas['asocEq']);
				$this->setAsocUs($filas['asocUs']);
			}
		}

		private function cleanClass()
		{
			$this->setNroLinea('');
			$this->setEmpresa('');
			$this->setNombrePlan('');
			$this->setFechaAlta('');
			$this->setCosto(0);
			$this->setConsEstimado(0);
			$this->setFechaBaja('');
			$this->setObs('');
			$this->setAsocEq(0);
			$this->setAsocUs(0);
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