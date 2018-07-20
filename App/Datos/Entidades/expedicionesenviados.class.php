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
	
 

	class ExpedicionesEnviados
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

		private $_fecha;
		public function getFecha(){ return $this->_fecha; }
		public function setFecha($fecha){ $this->_fecha=$fecha; }
	
		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }	

		private $_recibido;
		public function getRecibido(){ return var_export($this->_recibido,true); }
		public function setRecibido($recibido){ $this->_recibido=$recibido; }

		
		
		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setPlaza(0);					
			$this->setFecha('');
			$this->setEstado(true);
			$this->setRecibido(false);
			
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
				$query="INSERT INTO expediciones_enviados (
		        						plaza,
		        						fecha,
		        						estado,
		        						recibido
	        			) VALUES (
	        							   	
	        							'".$this->getPlaza()."', 	   	
	        							'".$this->getFecha()."',   	
	        							'".$this->getEstado()."',  	
	        							'".$this->getRecibido()."'  	
	        							   	
	        							
	        			)";
	        		// var_dump($query);
	        		// exit();

				# Ejecucion 					
				return SQL::insert($conexion,$query);
			
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}


		public function select()
		{			
			try {
											
				# Query
					$query="SELECT * FROM expediciones_enviados";
				
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ExpedicionesEnviados);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}public function selectUltimosEnviados()
		{			
			try {
											
				# Query
					$query="SELECT TOP 10 * FROM expediciones_enviados ORDER BY id DESC ";

					// var_dump($query);
					// exit();
				
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ExpedicionesEnviados);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}
        
        public function selecTop()
		{			
			try {
											
				# Query
					$query="SELECT TOP 1 * FROM expediciones_enviados WHERE estado='true' ORDER BY id DESC";
				
				// var_dump($query);
	   //      		exit();
				# Ejecucion 					
				$result = SQL::selectObject($query, new ExpedicionesEnviados);
						
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
				$this->setPlaza($filas['plaza']);	
				$this->setFecha($filas['fecha']);				
				$this->setEstado($filas['estado']);
				$this->setRecibido($filas['recibido']);
				
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setPlaza(0);					
			$this->setFecha('');
			$this->setEstado(true);
			$this->setRecibido(false);
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