<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';	

	class ObjetivosGC
	{				
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }

		private $_idGestor;
		public function getIdGestor(){ return $this->_idGestor; }
		public function setIdGestor($idGestor){ $this->_idGestor=$idGestor; }

		private $_fechaInicio;
		public function getFechaInicio(){ return $this->_fechaInicio; }
		public function setFechaInicio($fechaInicio){ $this->_fechaInicio=$fechaInicio; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }	

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setIdGestor(0);
			$this->setFechaInicio('');
			$this->setEstado(true);			
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {
							
				# Validaciones 			
				if($this->getIdGestor()<0)
					throw new Exception("Gestor sistema vacia");
				
				# Query 			
				$query="INSERT INTO objetivos_gc (
		        						id_gestor,
		        						fecha_inicio,
		        						estado
	        			) VALUES (
	        							".$this->getIdGestor().",
	        							'".$this->getFechaInicio()."',
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
					throw new Exception("Objetivo no identificado");

				if($this->getIdGestor()<0)
					throw new Exception("Gestor sistema vacia");

				if(empty($this->getObjetivo()))
					throw new Exception("Objetivo vacio");
				
				# Query 			
				$query="UPDATE objetivos_gc SET
								id_gestor=".$this->getIdGestor().",
								fecha_inicio='".$this->getFechaInicio()."',
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
					throw new Exception("Objetivo no identificado");

				# Query 			
				$query="UPDATE objetivos_gc SET							
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

					$query = "SELECT * FROM objetivos_gc WHERE estado='true'";
				}
				else{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id del gestor");		

					$query="SELECT * FROM objetivos_gc WHERE id=".$this->getId();
				}
         
				# Ejecucion 				
				$result = SQL::selectObject($query, new ObjetivosGC);
						
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
				$this->setIdGestor(trim($filas['id_gestor']));
				$this->setFechaInicio($filas['fecha_inicio']);
				$this->setEstado($filas['estado']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setIdGestor(0);
			$this->setFechaInicio('');
			$this->setEstado(true);
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';
		}

		// Tabla
		// ============================

		// USE [Prueba_AppWeb]
		// GO

		// /****** Object:  Table [dbo].[objetivos_gc]    Script Date: 04/12/2018 13:52:52 ******/
		// SET ANSI_NULLS ON
		// GO

		// SET QUOTED_IDENTIFIER ON
		// GO

		// CREATE TABLE [dbo].[objetivos_gc](
		// 	[id] [int] IDENTITY(1,1) NOT NULL,
		// 	[id_gestor] [int] NOT NULL,
		// 	[fecha_inicio] [date] NOT NULL,
		// 	[estado] [bit] NOT NULL,
		//  CONSTRAINT [PK_objetivos_gc] PRIMARY KEY CLUSTERED 
		// (
		// 	[id] ASC
		// )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
		// ) ON [PRIMARY]

		// GO



		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/

	}
?>