<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';

	class PlazaUsuario
	{				
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }

		private $_nombre;
		public function getNombre(){ return $this->_nombre; }
		public function setNombre($nombre){ $this->_nombre=$nombre; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }	

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setNombre('');
			$this->setEstado(true);
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {
				
				# Query 			
				$query="INSERT INTO plazas_otr (
		        						nombre,
		        						estado
	        			) VALUES (
	        							'".$this->getNombre()."',       							
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
					throw new Exception("Plaza no identificada");
				
				# Query 			
				$query="UPDATE plazas_otr SET
								nombre='".$this->getNombre()."',
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
					throw new Exception("Plaza no identificada");

				# Query 			
				$query="UPDATE plazas_otr SET							
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
					$query = "SELECT * FROM plazas_otr WHERE estado='true' order by nombre";
				}
				else{
					if(empty($this->getId()))
						throw new Exception("No se selecciono ninguna plaza");		

					$query="SELECT * FROM plazas_otr WHERE id=".$this->getId();
				}

				# Ejecucion 				
				$result = SQL::selectObject($query, new PlazaUsuario);
						
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
				$this->setNombre(trim($filas['nombre']));
				$this->setEstado($filas['estado']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setNombre('');
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

			CREATE TABLE [dbo].[plazas_otr](
				[id] [int] IDENTITY(1,1) NOT NULL,
				[nombre] [varchar](50) NOT NULL,
				[estado] [bit] NOT NULL,
			 CONSTRAINT [PK_plazas_otr] PRIMARY KEY CLUSTERED 
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


		


	}
?>







