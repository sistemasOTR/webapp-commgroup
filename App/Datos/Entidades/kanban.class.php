<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';

	class Kanban
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }
		
		private $_titulo;
		public function getTitulo(){ return $this->_titulo; }
		public function setTitulo($titulo){ $this->_titulo =$titulo; }

		private $_descripcion;
		public function getDescripcion(){ return $this->_descripcion; }
		public function setDescripcion($descripcion){ $this->_descripcion =$descripcion; }
		
		private $_fechaSol;
		public function getFechaSol(){ return $this->_fechaSol; }
		public function setFechaSol($fechaSol){ $this->_fechaSol =$fechaSol; }
		
		private $_idSol;
		public function getIdSol(){ return $this->_idSol; }
		public function setIdSol($idSol){ $this->_idSol =$idSol; }

		private $_idEnc;
		public function getIdEnc(){ return $this->_idEnc; }
		public function setIdEnc($idEnc){ $this->_idEnc =$idEnc; }

		private $_inicioEst;
		public function getInicioEst(){ return $this->_inicioEst; }
		public function setInicioEst($inicioEst){ $this->_inicioEst =$inicioEst; }
		
		private $_finEst;
		public function getFinEst(){ return $this->_finEst; }
		public function setFinEst($finEst){ $this->_finEst =$finEst; }
		
		private $_estadoKb;
		public function getEstadoKb(){ return $this->_estadoKb; }
		public function setEstadoKb($estadoKb){ $this->_estadoKb =$estadoKb; }

		private $_prioridad;
		public function getPrioridad(){ return $this->_prioridad; }
		public function setPrioridad($prioridad){ $this->_prioridad =$prioridad; }

		// private $_sector;
		// public function getSector(){ return $this->_sector; }
		// public function setSector($sector){ $this->_sector =$sector; }
		
		private $_plaza;
		public function getPlaza(){ return $this->_plaza; }
		public function setPlaza($plaza){ $this->_plaza =$plaza; }
		
		private $_inicioReal;
		public function getInicioReal(){ return $this->_inicioReal; }
		public function setInicioReal($inicioReal){ $this->_inicioReal =$inicioReal; }

		private $_finReal;
		public function getFinReal(){ return $this->_finReal; }
		public function setFinReal($finReal){ $this->_finReal =$finReal; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado =$estado; }


		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setTitulo('');
			$this->setDescripcion('');
			$this->setFechaSol('');
			$this->setIdSol(0);
			$this->setIdEnc(0);
			$this->setInicioEst('');
			$this->setFinEst('');
			$this->setEstadoKb(0);
			$this->setPrioridad(0);
			// $this->setSector(0);
			$this->setPlaza(0);
			$this->setInicioReal('');
			$this->setFinReal('');
			$this->setEstado(true);
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				$query="INSERT INTO kanban (
										titulo,	
		        						descripcion,
		        						fecha_sol,
		        						id_sol,
		        						estado_kb,
		        						prioridad,
		        						plaza,
		        						id_enc,
		        						inicio_est,
		        						fin_est,
		        						inicio_real,
		        						fin_real,
		        						estado
		        						
	        			) VALUES (
	        							'".$this->getTitulo()."',     	
	        							'".$this->getDescripcion()."',
	        							'".$this->getFechaSol()."',
	        							".$this->getIdSol().",
	        							0,
	        							".$this->getPrioridad().",
	        							".$this->getPlaza().",
	        							".$this->getIdEnc().",
	        							'".$this->getInicioEst()."',
	        							'".$this->getFinEst()."',
	        							'".$this->getInicioReal()."',
	        							'".$this->getFinReal()."',
	        							'".$this->getEstado()."'

	        							
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
				if(empty($this->getId()))
					throw new Exception("Impresora no identificada");

				
				# Query 			
				$query="UPDATE kanban SET
								id='".$this->getId()."',
								titulo='".$this->getTitulo()."',	
        						descripcion='".$this->getDescripcion()."',
        						fecha_sol='".$this->getFechaSol()."',
        						id_sol=".$this->getIdSol().",
        						id_enc=".$this->getIdEnc().",
        						inicio_est='".$this->getInicioEst()."',
        						fin_est='".$this->getFinEst()."',
        						estado_kb=".$this->getEstadoKb().",
        						prioridad=".$this->getPrioridad().",
        						plaza=".$this->getPlaza().",
        						inicio_real='".$this->getInicioReal()."',
        						fin_real='".$this->getFinReal()."',
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
					throw new Exception("Impresora no identificada");
			
				# Query 			
				$query="UPDATE kanban SET							
								estado = '".$this->getEstado()."
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
				if(empty($this->getId()))
				{
					$query = "SELECT * FROM kanban WHERE estado='true'";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el solicitud");		

					$query="SELECT * FROM kanban WHERE id=".$this->getId();
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Kanban);
						
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
				$this->setTitulo(trim($filas['titulo']));			
				$this->setDescripcion($filas['descripcion']);			
				$this->setFechaSol($filas['fecha_sol']);			
				$this->setIdSol($filas['id_sol']);			
				$this->setIdEnc(trim($filas['id_enc']));			
				$this->setInicioEst($filas['inicio_est']);			
				$this->setFinEst($filas['fin_est']);
				$this->setEstadoKb($filas['estado_kb']);			
				$this->setPrioridad($filas['prioridad']);
				$this->setPlaza($filas['plaza']);
				$this->setInicioReal($filas['inicio_real']);
				$this->setFinReal($filas['fin_real']);
				$this->setEstado($filas['estado']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setTitulo('');
			$this->setDescripcion('');
			$this->setFechaSol('');
			$this->setIdSol(0);
			$this->setIdEnc(0);
			$this->setInicioEst('');
			$this->setFinEst('');
			$this->setEstadoKb(0);
			$this->setPrioridad(0);
			$this->setPlaza(0);
			$this->setInicioReal('');
			$this->setFinReal('');
			$this->setEstado(true);
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

			CREATE TABLE [dbo].[kanban](
				[id] [int] IDENTITY(1,1) NOT NULL,
				[titulo] [varchar](100) NOT NULL,
				[descripcion] [text] NOT NULL,
				[fecha_sol] [date] NOT NULL,
				[id_sol] [int] NOT NULL,
				[id_enc] [int] NULL,
				[inicio_est] [date] NULL,
				[fin_est] [date] NULL,
				[estado_kb] [int] NOT NULL,
				[prioridad] [int] NOT NULL,
				[plaza] [int] NOT NULL,
				[inicio_real] [date] NULL,
				[fin_real] [date] NULL,
				[estado] [bit] NOT NULL,
			 CONSTRAINT [PK_kanban] PRIMARY KEY CLUSTERED 
			(
				[id] ASC
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



		public function selectSolicitudesByEstado($estadoKb)
		{			
			try {
											
				# Query
				$query="SELECT * FROM kanban WHERE estado_kb=".$estadoKb;
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Kanban);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function getLastSolicitud()
		{			
			try {
											
				# Query
				$query="SELECT TOP 1 * FROM kanban WHERE estado ='true' ORDER BY id DESC";
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Kanban);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function getSolById($id)
		{			
			try {
											
				# Query
				$query="SELECT * FROM kanban WHERE estado ='true' AND id = ".$id;
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Kanban);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function updateFechas($conexion,$id,$inicio_est,$fin_est)
		{
			try {

				# Query 			
				$query="UPDATE kanban SET
        						inicio_est='".$inicio_est."',
        						fin_est='".$fin_est."'
							WHERE id=".$id;

							// var_dump($query);
							// exit();
				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		public function updateEncargado($conexion,$id,$id_enc)
		{
			try {

				# Query 			
				$query="UPDATE kanban SET
        						id_enc=".$id_enc."
							WHERE id=".$id;

				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		public function cambiarEstadoKB($conexion,$id,$estado)
		{
			try {

				# Query 			
				$query="UPDATE kanban SET
        						estado_kb=".$estado."
							WHERE id=".$id;

				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}



	}
?>