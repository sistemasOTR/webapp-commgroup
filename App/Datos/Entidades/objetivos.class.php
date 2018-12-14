<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';	

	class Objetivos
	{				
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }

		private $_plaza;
		public function getPlaza(){ return $this->_plaza; }
		public function setPlaza($plaza){ $this->_plaza=$plaza; }

		private $_basico;
		public function getBasico(){ return $this->_basico; }
		public function setBasico($basico){ $this->_basico=$basico; }

		private $_basicoGC;
		public function getBasicoGC(){ return $this->_basicoGC; }
		public function setBasicoGC($basicoGC){ $this->_basicoGC=$basicoGC; }

		private $_fechaDesde;
		public function getVigencia(){ return $this->_fechaDesde; }
		public function setVigencia($fechaDesde){ $this->_fechaDesde=$fechaDesde; }

		private $_cantCoord;
		public function getCantCoord(){ return $this->_cantCoord; }
		public function setCantCoord($cantCoord){ $this->_cantCoord=$cantCoord; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setPlaza('');			
			$this->setBasico(0);
			$this->setEstado(true);				
			$this->setVigencia('');				
			$this->setBasicoGC(0);				
			$this->setCantCoord(1);				
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {
							
				# Validaciones 			
				if($this->getPlaza()<0)
					throw new Exception("Gestor sistema vacia");

				if(empty($this->getBasico()))
					throw new Exception("Basico vacio");
				
				# Query 			
				$query="INSERT INTO objetivos (
		        						plaza,
		        						basico,
		        						basico_gc,
		        						estado,
		        						vigencia,
		        						cant_coord
	        			) VALUES (
	        							'".$this->getPlaza()."',
	        							".$this->getBasico().",
	        							".$this->getBasicoGC().",
	        							'".$this->getEstado()."',
	        							'".$this->getVigencia()."',
	        							".$this->getCantCoord()."
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
					throw new Exception("Basico no identificado");

				if($this->getPlaza()<0)
					throw new Exception("Gestor sistema vacia");

				if(empty($this->getBasico()))
					throw new Exception("Basico vacio");
				
				# Query 			
				$query="UPDATE objetivos SET
								plaza='".$this->getPlaza()."', 
								basico=".$this->getBasico().", 
								basico_gc=".$this->getBasicoGC().", 
								cant_coord=".$this->getCantCoord().", 
								estado='".$this->getEstado()."'
							WHERE id=".$this->getId();

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
					throw new Exception("Basico no identificado");

				# Query 			
				$query="UPDATE objetivos SET							
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
				if(empty($this->getId())){

					if($this->getPlaza()<0)
						throw new Exception("No se selecciono el gestor de referencia");		

					$query = "SELECT * FROM objetivos WHERE estado='true' order by plaza";
				}
				else{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id del gestor");		

					$query="SELECT * FROM objetivos WHERE id=".$this->getId();
				}
         
				# Ejecucion 				
				$result = SQL::selectObject($query, new Objetivos);
						
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
				$this->setPlaza(trim($filas['plaza']));
				$this->setBasico(trim($filas['basico']));											
				$this->setEstado($filas['estado']);
				$this->setVigencia($filas['vigencia']);
				$this->setBasicoGC($filas['basico_gc']);
				$this->setCantCoord($filas['cant_coord']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setPlaza('');
			$this->setBasico(0);			
			$this->setEstado(true);				
			$this->setVigencia('');				
			$this->setBasicoGC(0);				
			$this->setCantCoord(1);	
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';
		}

		// Tabla
		// ============================

		// USE [Prueba_AppWeb]
		// GO

		// /****** Object:  Table [dbo].[objetivos]    Script Date: 04/12/2018 14:01:33 ******/
		// SET ANSI_NULLS ON
		// GO

		// SET QUOTED_IDENTIFIER ON
		// GO

		// SET ANSI_PADDING ON
		// GO

		// CREATE TABLE [dbo].[objetivos](
		// 	[id] [int] IDENTITY(1,1) NOT NULL,
		// 	[plaza] [varchar](255) NOT NULL,
		// 	[basico] [bigint] NOT NULL,
		// 	[basico_gc] [bigint] NOT NULL,
		// 	[vigencia] [date] NOT NULL,
		// 	[estado] [bit] NOT NULL,
		//  CONSTRAINT [PK_objetivos] PRIMARY KEY CLUSTERED 
		// (
		// 	[id] ASC
		// )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
		// ) ON [PRIMARY]

		// GO

		// SET ANSI_PADDING OFF
		// GO



		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/

		// Objetivo por plaza
		// ============================



		public function objetivosXPlaza($idPlaza)
		{			
			try {
				
				# Query

				$query="SELECT * FROM objetivos WHERE plaza='".$idPlaza."' ORDER BY vigencia DESC";
				
				# Ejecucion 				
				$result = SQL::selectObject($query, new Objetivos);
						
				return $result;
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
						
			}

		}
	}
?>