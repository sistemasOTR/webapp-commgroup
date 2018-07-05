<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';

	include_once PATH_DATOS.'Entidades/expedicionesestados.class.php';
	include_once PATH_DATOS.'Entidades/expedicionestipo.class.php';
	include_once PATH_DATOS.'Entidades/expedicionesitem.class.php';
	include_once PATH_DATOS.'Entidades/usuario.class.php';
	
 

	class ExpedicionesEnvios
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }

		private $_idpedido;
		public function getIdPedido(){ return $this->_idpedido; }
		public function setIdPedido($idpedido){ $this->_idpedido=$idpedido; }

		private $_fecha;
		public function getFecha(){ return $this->_fecha; }
		public function setFecha($fecha){ $this->_fecha=$fecha; }

		private $_cantidad;
		public function getCantidad(){ return $this->_cantidad; }
		public function setCantidad($cantidad){ $this->_cantidad=$cantidad; }

		private $_usuario;
		public function getUsuario(){ return $this->_usuario; }
		public function setUsuario($usuario){ $this->_usuario=$usuario; }
		
		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setIdPedido(0);					
			$this->setFecha('');
			$this->setCantidad('');
			$this->setUsuario(0);
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				# Validaciones 			

				// if(empty($this->getIdPedido()))
				// 	throw new Exception("IdPedido Vacio");

				// if(empty($this->getFecha()))
				// 	throw new Exception("fecha Vacio");
				
				// if(empty($this->getCantidad()))
				// 	throw new Exception("cantidad vacio");

				// if(empty($this->getUsuario()))
				// 	throw new Exception("usuario vacio");
				# Query 			
				$query="INSERT INTO expediciones_envios (
		        						id_pedido,
		        						fecha_envio,
		        						cantidad_enviada,
		        						id_usuario
	        			) VALUES (
	        							   	
	        							".$this->getIdPedido().",   	   	
	        							'".$this->getFecha()."',   	
	        							".$this->getCantidad().",   	
	        							".$this->getUsuario()."   	
	        							
	        			)";
	        		// var_dump($query);
	        		// exit();

				# Ejecucion 					
				return SQL::insert($conexion,$query);
			
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}


		public function selectByIdPedido($id)
		{			
			try {
											
				# Query
					$query="SELECT * FROM expediciones_envios WHERE id_pedido=".$id."  ORDER BY fecha_envio DESC";
				
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ExpedicionesEnvios);
						
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
				$this->setIdPedido($filas['id_pedido']);	
				$this->setFecha($filas['fecha_envio']);				
				$this->setCantidad($filas['cantidad_enviada']);
				$this->setUsuario($filas['id_usuario']);
				
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setIdPedido(0);					
			$this->setFecha('');
			$this->setCantidad(0);
			$this->setUsuario(0);
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';

// 			USE [Prueba_AppWeb]
			// GO

			// /****** Object:  Table [dbo].[expediciones_envios]    Script Date: 03.07.18 12:00:12 ******/
			// SET ANSI_NULLS ON
			// GO

			// SET QUOTED_IDENTIFIER ON
			// GO

			// CREATE TABLE [dbo].[expediciones_envios](
			// 	[id] [int] IDENTITY(1,1) NOT NULL,
			// 	[id_pedido] [int] NOT NULL,
			// 	[fecha_envio] [date] NOT NULL,
			// 	[cantidad_enviada] [int] NOT NULL,
			// 	[id_usuario] [int] NULL,
			//  CONSTRAINT [PK_expediciones_envios] PRIMARY KEY CLUSTERED 
			// (
			// 	[id] ASC
			// )WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
			// ) ON [PRIMARY]

			// GO


		}

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/
	

	}
?>