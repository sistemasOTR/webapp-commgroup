<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';

	class ConsumoImpresora
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_consImpId;
		public function getConsImpId(){ return $this->_consImpId; }
		public function setConsImpId($consImpId){ $this->_consImpId =$consImpId; }
		
		private $_serialNro;
		public function getSerialNro(){ return $this->_serialNro; }
		public function setSerialNro($serialNro){ $this->_serialNro =$serialNro; }
		
		private $_plaza;
		public function getPlaza(){ return $this->_plaza; }
		public function setPlaza($plaza){ $this->_plaza =$plaza; }

		private $_fechaConsumo;
		public function getFechaConsumo(){ return $this->_fechaConsumo; }
		public function setFechaConsumo($fechaConsumo){ $this->_fechaConsumo =$fechaConsumo; }

		private $_contador;
		public function getContador(){ return $this->_contador; }
		public function setContador($contador){ $this->_contador =$contador; }

		private $_userId;
		public function getUserId(){ return $this->_userId; }
		public function setUserId($userId){ $this->_userId =$userId; }

		private $_cambioTonner;
		public function getCambioTonner(){ return var_export($this->_cambioTonner,true); }
		public function setCambioTonner($cambioTonner){ $this->_cambioTonner =$cambioTonner; }

		private $_kitA;
		public function getKitA(){ return $this->_kitA; }
		public function setKitA($kitA){ $this->_kitA =$kitA; }

		private $_cambioKitA;
		public function getCambioKitA(){ return var_export($this->_cambioKitA,true); }
		public function setCambioKitA($cambioKitA){ $this->_cambioKitA =$cambioKitA; }

		private $_kitB;
		public function getKitB(){ return $this->_kitB; }
		public function setKitB($kitB){ $this->_kitB =$kitB; }

		private $_cambioKitB;
		public function getCambioKitB(){ return var_export($this->_cambioKitB,true); }
		public function setCambioKitB($cambioKitB){ $this->_cambioKitB =$cambioKitB; }

		private $_consSamsung;
		public function getConsSamsung(){ return $this->_consSamsung; }
		public function setConsSamsung($consSamsung){ $this->_consSamsung =$consSamsung; }

		private $_cambioConsSamsung;
		public function getCambioConsSamsung(){ return var_export($this->_cambioConsSamsung,true); }
		public function setCambioConsSamsung($cambioConsSamsung){ $this->_cambioConsSamsung =$cambioConsSamsung; }

		private $_UI;
		public function getUI(){ return $this->_UI; }
		public function setUI($UI){ $this->_UI =$UI; }

		private $_cambioUI;
		public function getCambioUI(){ return var_export($this->_cambioUI,true); }
		public function setCambioUI($cambioUI){ $this->_cambioUI =$cambioUI; }

		private $_kitM;
		public function getKitM(){ return $this->_kitM; }
		public function setKitM($kitM){ $this->_kitM =$kitM; }

		private $_cambioKitM;
		public function getCambioKitM(){ return var_export($this->_cambioKitM,true); }
		public function setCambioKitM($cambioKitM){ $this->_cambioKitM =$cambioKitM; }

		private $_consObs;
		public function getConsObs(){ return $this->_consObs; }
		public function setConsObs($consObs){ $this->_consObs =$consObs; }


		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setConsImpId(0);
			$this->setSerialNro('');
			$this->setPlaza('');
			$this->setContador(0);
			$this->setUserId(0);
			$this->setFechaConsumo('');
			$this->setCambioTonner(false);
			$this->setKitA('');
			$this->setCambioKitA(false);
			$this->setKitB('');
			$this->setCambioKitB(false);
			$this->setConsSamsung('');
			$this->setCambioConsSamsung(false);
			$this->setUI('');
			$this->setCambioUI(false);
			$this->setKitM('');
			$this->setCambioKitM(false);
			$this->setConsObs('');
			
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				$query="INSERT INTO consumos_impresoras (
										serialNro,
										contador,
										userId,
		        						plaza,	
		        						fechaConsumo,
		        						cambioTonner,
		        						kitA,
		        						cambioKitA,
		        						kitB,
		        						cambioKitB,
		        						consSamsung,
		        						cambioConsSamsung,
		        						UI,
		        						cambioUI,
		        						kitM,
		        						cambioKitM,
		        						ConsObs
	        			) VALUES (
	        							'".$this->getSerialNro()."',     	
	        							".$this->getContador().",   	
	        							".$this->getUserId().",   	
	        							'".$this->getPlaza()."',     	
	        							'".$this->getFechaConsumo()."',
	        							'".$this->getCambioTonner()."',
	        							'".$this->getKitA()."',
	        							'".$this->getCambioKitA()."',
	        							'".$this->getKitB()."',
	        							'".$this->getCambioKitB()."',
	        							'".$this->getConsSamsung()."',
	        							'".$this->getCambioConsSamsung()."',
	        							'".$this->getUI()."',
	        							'".$this->getCambioUI()."',
	        							'".$this->getKitM()."',
	        							'".$this->getCambioKitM()."',
	        							'".$this->getConsObs()."'
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
				$query="UPDATE consumos_impresoras SET
								serialNro='".$this->getSerialNro()."',
								contador=".$this->getContador().",
								userId=".$this->getUserId().",
        						plaza='".$this->getPlaza()."',	
        						fechaConsumo='".$this->getFechaConsumo()."',
        						cambioTonner='".$this->getCambioTonner()."',
        						kitA='".$this->getKitA()."',
        						cambioKitA='".$this->getCambioKitA()."',
        						kitB='".$this->getKitB()."',
        						cambioKitB='".$this->getCambioKitB()."',
        						consSamsung='".$this->getConsSamsung()."',
        						cambioConsSamsung='".$this->getCambioConsSamsung()."',
        						UI='".$this->getUI()."',
        						cambioUI='".$this->getCambioUI()."',
        						kitM='".$this->getKitM()."',
        						cambioKitM='".$this->getCambioKitM()."',
        						ConsObs='".$this->getConsObs()."'
							WHERE consImpId=".$this->getConsImpId();

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
				$query="UPDATE consumos_impresoras SET							
								fechaDev = '".$this->getFecha()."
							WHERE asigId=".$this->getAsigId();

				# Ejecucion 	
				return SQL::delete($conexion,$query);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function getConsumos($serialNro)
		{			
			try {
				
				$query = "SELECT * FROM consumos_impresoras WHERE serialNro ='".$serialNro."' order by fechaConsumo desc";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ConsumoImpresora);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function selectById($consImpId)
		{			
			try {
				
				$query = "SELECT * FROM consumos_impresoras WHERE consImpId ='".$consImpId."' order by fechaConsumo desc";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ConsumoImpresora);
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
				$this->setConsImpId($filas['consImpId']);
				$this->setSerialNro($filas['serialNro']);
				$this->setPlaza($filas['plaza']);
				$this->setContador($filas['contador']);
				$this->setUserId($filas['userId']);
				$this->setFechaConsumo($filas['fechaConsumo']);
				$this->setCambioTonner($filas['cambioTonner']);
				$this->setKitA($filas['kitA']);
				$this->setCambioKitA($filas['cambioKitA']);
				$this->setKitB($filas['kitB']);
				$this->setCambioKitB($filas['cambioKitB']);
				$this->setConsSamsung($filas['consSamsung']);
				$this->setCambioConsSamsung($filas['cambioConsSamsung']);
				$this->setUI($filas['UI']);
				$this->setCambioUI($filas['cambioUI']);
				$this->setKitM($filas['kitM']);
				$this->setCambioKitM($filas['cambioKitM']);
				$this->setConsObs($filas['consObs']);
			}
		}

		private function cleanClass()
		{
			$this->setConsImpId(0);
			$this->setSerialNro('');
			$this->setPlaza('');
			$this->setContador(0);
			$this->setUserId(0);
			$this->setFechaConsumo('');
			$this->setCambioTonner(false);
			$this->setKitA('');
			$this->setCambioKitA(false);
			$this->setKitB('');
			$this->setCambioKitB(false);
			$this->setConsSamsung('');
			$this->setCambioConsSamsung(false);
			$this->setUI('');
			$this->setCambioUI(false);
			$this->setKitM('');
			$this->setCambioKitM(false);
			$this->setConsObs('');
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