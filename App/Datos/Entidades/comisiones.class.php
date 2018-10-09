<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';

	include_once PATH_DATOS.'Entidades/usuario.class.php';

	class Comisiones
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }
		
		private $_valor;
		public function getValor(){ return $this->_valor; }
		public function setValor($valor){ $this->_valor=$valor; }
		
		private $_fechaVigencia;
		public function getFechaVigencia(){ return $this->_fechaVigencia; }
		public function setFechaVigencia($fechaVigencia){ $this->_fechaVigencia=$fechaVigencia; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }	

		

				

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setValor(0);			
			$this->setFechaVigencia('');			
			$this->setEstado(true);
			
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				# Validaciones 				
				
				# Query 			
				$query="INSERT INTO comisiones (
		        						valor,		    
		        						fecha_vigencia,		    
		        						estado
		        						
		        						
	        			) VALUES (
	        							".$this->getValor().",   	   
	        							'".$this->getFechaVigencia()."',   	   
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
					throw new Exception("Concepto no identificado");			

				# Query 			
				$query="UPDATE comisiones SET						
								valor=".$this->getValor().",								
								fecha_vigencia='".$this->getFechaVigencia()."',								
								estado='".$this->getEstado()."'
								
							WHERE id=".$this->getId();

	        	//echo $query;
	        	//exit();

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
					throw new Exception(" concepto no identificado");
			
				# Query 			
				$query="UPDATE comisiones SET							
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
				if(empty($this->getId()))
				{
					$query = "SELECT * FROM comisiones WHERE estado='true'";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id de Concepto");		

					$query="SELECT * FROM comisiones WHERE id=".$this->getId();
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Comisiones);
						
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
				$this->setValor($filas['valor']);
				$this->setFechaVigencia($filas['fecha_vigencia']);
				$this->setEstado($filas['estado']);
										
				
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setValor(0);
			$this->setFechaVigencia('');
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

			CREATE TABLE [dbo].[comisiones](
				[id] [int] IDENTITY(1,1) NOT NULL,
				[valor] [decimal](18, 2) NOT NULL,
				[fecha_vigencia] [date] NOT NULL,
				[estado] [bit] NOT NULL,
			 CONSTRAINT [PK_comisiones] PRIMARY KEY CLUSTERED 
			(
				[id] ASC
			)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
			) ON [PRIMARY]

			GO


			*/
		}		

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/
	
		public function selectById($id)
		{			
			try {

				if(empty($id))
					throw new Exception("No se selecciono el Usuario");		

				$query="SELECT * FROM comisiones WHERE id=".$id;
				
				# Ejecucion 					
				$result = SQL::selectArray($query, new Comisiones);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		// Retorno valor segun fecha
		// ============================
	
		public function selectByDate($fecha)
		{			
			try {

				$query="SELECT TOP 1 * FROM comisiones WHERE fecha_vigencia <= '".$fecha."' ORDER BY fecha_vigencia DESC";
				
				# Ejecucion 					
				$result = SQL::selectArray($query, new Comisiones);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}
	}
?>
