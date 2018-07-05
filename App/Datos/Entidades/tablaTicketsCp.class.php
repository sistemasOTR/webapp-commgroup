<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';	

	class Reintegro
	{				
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }

		private $_cp;
		public function getCp(){ return $this->_cp; }
		public function setCp($cp){ $this->_cp=$cp; }

		private $_descripcion;
		public function getDescripcion(){ return $this->_descripcion; }
		public function setDescripcion($descripcion){ $this->_descripcion=$descripcion; }

        private $_reintegro;
		public function getReintegro(){ return $this->_reintegro; }
		public function setReintegro($reintegro){ $this->_reintegro=$reintegro; }
        

		private $_fechaIni;
		public function getFechaIni(){ return $this->_fechaIni; }
		public function setFechaIni($fechaIni){ $this->_fechaIni=$fechaIni; }

		private $_fechaFin;
		public function getFechaFin(){ return $this->_fechaFin; }
		public function setFechaFin($fechaFin){ $this->_fechaFin=$fechaFin; }

		private $_plaza;
		public function getPlaza(){ return $this->_plaza; }
		public function setPlaza($plaza){ $this->_plaza=$plaza; }

		private $_aled;
		public function getAled(){ return var_export($this->_aled,true); }
		public function setAled($aled){ $this->_aled=$aled; }

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setCp(0);			
			$this->setDescripcion('');
			$this->setReintegro(0);
			$this->setFechaIni('');
			$this->setFechaFin('');	
			$this->setPlaza('');			
			$this->setAled(false);			
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {
							
				
				# Query 			
				$query="INSERT INTO operacion_reintegro (
		        					
		        						cp,
		        						descripcion,
		        						reintegro,
		        						fecha_ini,
		        						plaza,
		        						aled
	        			) VALUES (
	        							
	        							".$this->getCp().",
	        							'".$this->getDescripcion()."',
	        							".$this->getReintegro().",
	        							'".$this->getFechaIni()."',
	        							'".$this->getPlaza()."',
	        							'".$this->getAled()."'

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
				$query="UPDATE operacion_reintegro SET
								fecha_fin='".$this->getFechaFin()."',
								aled='".$this->getAled()."'		
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
					throw new Exception("Puntaje no identificado");

				# Query 			
				$query="UPDATE operacion_reintegro SET
							     fecha_fin='".$this->getFechaFin()."'
								
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
				$query = "SELECT * FROM operacion_reintegro WHERE fecha_fin is NULL";
				
				# Ejecucion 				
				$result = SQL::selectObject($query, new Reintegro);
						
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
				$this->setCp($filas['cp']);
				$this->setDescripcion($filas['descripcion']);											
				$this->setReintegro($filas['reintegro']);
				$this->setFechaIni($filas['fecha_ini']);
				$this->setFechaFin($filas['fecha_fin']);
				$this->setPlaza($filas['plaza']);
				$this->setAled($filas['aled']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setCp(0);			
			$this->setDescripcion('');
			$this->setReintegro(0);
			$this->setFechaIni('');
			$this->setFechaFin('');
			$this->setPlaza('');		
			$this->setAled(false);		
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';

			/*
			USE [AppWeb]
			GO

			SET ANSI_NULLS ON
			GO
			SET QUOTED_IDENTIFIER ON
			GO
			SET ANSI_PADDING ON
			GO
			CREATE TABLE [dbo].[operacion_reintegro](
				[id] [int] IDENTITY(1,1) NOT NULL,
				[cp] [int] NOT NULL,
				[descripcion] [varchar](50) NOT NULL,
				[reintegro] [float] NOT NULL,
				[fecha_ini] [date] NOT NULL,
				[fecha_fin] [date] NULL,
				[plaza] [varchar](50) NOT NULL,
				[aled] [bit] NULL,
			 CONSTRAINT [PK_operacion_reintegro] PRIMARY KEY CLUSTERED 
			(
				[id] ASC
			)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
			) ON [PRIMARY]

			GO
			SET ANSI_PADDING OFF
			GO
			*/
		}

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/


		public function selectByDate($fecha)
		{			
			try {
				$query = "SELECT * FROM operacion_reintegro WHERE '".$fecha."' >= fecha_ini order by reintegro";

				# Ejecucion 				
				$result = SQL::selectObject($query, new Reintegro);
						
				return $result;
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
						
			}

		}
	}
?>