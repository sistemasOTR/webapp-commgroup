<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';

	class ExpedicionesTipo
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }


		private $_nombre;
		public function getGrupo(){ return $this->_nombre; }
		public function setGrupo($nombre){ $this->_nombre=$nombre; }
       

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }			

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);			
			$this->setGrupo('');					
			$this->setEstado(true);
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				# Validaciones 			
				if(empty($this->getGrupo()))
					throw new Exception("Grupo Vacio");

				
				# Query 			
				$query="INSERT INTO expediciones_tipo2 (		        						
		        						nombre_grupo,		        			
		        						estado
	        			) VALUES (	        							
	        							  	
	        							'".$this->getGrupo()."',   		        							
	        					 		        							
	        							'".$this->getEstado()."'
	        			)";        
			
	        	//echo $query;
	        	//exit();

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
					throw new Exception("Tipo de expedición no identificado");

				if(empty($this->getGrupo()))
					throw new Exception("Grupo Vacio");				

								
				# Query 			
				$query="UPDATE expediciones_tipo2 SET								
								nombre_grupo='".$this->getGrupo()."',
								estado = '".$this->getEstado()."'	
																	
							WHERE tipo_id=".$this->getId();
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
					throw new Exception("Tipo de expedición no identificado");
			
				# Query 			
				$query="UPDATE expediciones_tipo2 SET							
								estado='false'
							WHERE tipo_id=".$this->getId();

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
				$query="SELECT * FROM expediciones_tipo2 WHERE estado = 'true'";

				# Ejecucion 					
				$result = SQL::selectObject($query, new ExpedicionesTipo);
						
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
				$this->setId($filas['tipo_id']);
				$this->setGrupo(trim($filas['nombre_grupo']));				
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

			// USE [Prueba_AppWeb]
			// GO

			// /****** Object:  Table [dbo].[expediciones_tipo2]    Script Date: 03.07.18 12:01:50 ******/
			// SET ANSI_NULLS ON
			// GO

			// SET QUOTED_IDENTIFIER ON
			// GO

			// SET ANSI_PADDING ON
			// GO

			// CREATE TABLE [dbo].[expediciones_tipo2](
			// 	[tipo_id] [int] IDENTITY(1,1) NOT NULL,
			// 	[nombre_grupo] [varchar](50) NOT NULL,
			// 	[estado] [bit] NULL,
			//  CONSTRAINT [PK_expediciones_tipo2] PRIMARY KEY CLUSTERED 
			// (
			// 	[tipo_id] ASC
			// )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
			// ) ON [PRIMARY]

			// GO

			// SET ANSI_PADDING OFF
			// GO


		}

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/
		
	}
?>