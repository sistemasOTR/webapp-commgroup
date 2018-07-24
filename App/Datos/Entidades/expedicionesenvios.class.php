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

		private $_cantidadenviada;
		public function getCantidadEnviada(){ return $this->_cantidadenviada; }
		public function setCantidadEnviada($cantidadenviada){ $this->_cantidadenviada=$cantidadenviada; }

		private $_cantidadfaltante;
		public function getCantidadFaltante(){ return $this->_cantidadfaltante; }
		public function setCantidadFaltante($cantidadfaltante){ $this->_cantidadfaltante=$cantidadfaltante; }

		private $_usuario;
		public function getUsuario(){ return $this->_usuario; }
		public function setUsuario($usuario){ $this->_usuario=$usuario; }

		private $_nroenvio;
		public function getNroEnvio(){ return $this->_nroenvio; }
		public function setNroEnvio($nroenvio){ $this->_nroenvio=$nroenvio; }

		private $_sinenviar;
		public function getSinEnviar(){ return $this->_sinenviar; }
		public function setSinEnviar($sinenviar){ $this->_sinenviar=$sinenviar; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }
		
		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setIdPedido(0);					
			$this->setFecha('');
			$this->setCantidadEnviada('');
			$this->setUsuario(0);
			$this->setNroEnvio(0);
			$this->setSinEnviar(1);
			$this->setEstado(true);
			$this->setCantidadFaltante(0);
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
		        						id_usuario,
		        						nro_envio,
		        						sin_enviar,
		        						estado,
		        						cantidad_faltante
	        			) VALUES (
	        							   	
	        							".$this->getIdPedido().",   	   	
	        							'".$this->getFecha()."',   	
	        							".$this->getCantidadEnviada().",   	
	        							".$this->getUsuario().",   	
	        							".$this->getNroEnvio().",   	
	        							".$this->getSinEnviar().",   	
	        							'".$this->getEstado()."',
	        							".$this->getCantidadFaltante()."  	
	        							
	        			)";
	        		// var_dump($query);
	        		// exit();

				# Ejecucion 					
				return SQL::insert($conexion,$query);
			
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}
       
       public function updateApedir($id,$sinpedir)
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
				$conexion=false;		
				$query="UPDATE expediciones_envios SET								
								sin_enviar=".$sinpedir."

							WHERE sin_enviar=1 AND id_pedido=".$id;
	        		// var_dump($query);
	        		// exit();

				# Ejecucion 					
				return SQL::update($conexion,$query);
			
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		 public function updateEstadoNro($idped,$ultimaId,$fecha)
		{
			try {

			
				$conexion=false;		
				$query="UPDATE expediciones_envios SET								
								sin_enviar=2,
								nro_envio=".$ultimaId.",
								fecha_envio='".$fecha."'

							WHERE id=".$idped;
	        		// var_dump($query);
	        		// exit();

				# Ejecucion 					
				return SQL::update($conexion,$query);
			
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		} 
		public function updateCantidadEnviada($idped,$cantidad)
		{
			try {	
				$conexion=false;		
				$query="UPDATE expediciones_envios SET		
								cantidad_enviada='".$cantidad."'

							WHERE id_pedido=".$idped;
	        		// var_dump($query);
	        		// exit();

				# Ejecucion 					
				return SQL::update($conexion,$query);
			
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}
		public function updateCantidadFaltante($idped,$cantidad)
		{
			try {	
				$conexion=false;		
				$query="UPDATE expediciones_envios SET		
								cantidad_faltante='".$cantidad."'

							WHERE id_pedido=".$idped;
	        		// var_dump($query);
	        		// exit();

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
				
				# Query 			
				$query="UPDATE expediciones_envios SET							
								sin_enviar=1
							WHERE sin_enviar=0 AND id_pedido=".$this->getIdPedido();

							// var_dump($query);
	      //   				exit();

				# Ejecucion 	
				return SQL::delete($conexion,$query);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
		public function selectByIdPedido($id)
		{			
			try {
											
				# Query
					$query="SELECT * FROM expediciones_envios WHERE id_pedido=".$id." ORDER BY fecha_envio DESC";
				
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ExpedicionesEnvios);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function selectByNroEnvio($idenviado)
		{			
			try {
											
				# Query
					$query="SELECT * FROM expediciones_envios WHERE nro_envio=".$idenviado;
				
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ExpedicionesEnvios);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}
		public function selectByIdPedidoSinEnviar($id,$sinenviar)
		{			
			try {
											
				# Query
					$query="SELECT * FROM expediciones_envios WHERE id_pedido=".$id." AND sin_enviar=".$sinenviar." ORDER BY fecha_envio DESC";
				
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ExpedicionesEnvios);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}
         public function selectApedir()
		{			
			try {
											
				# Query
					$query="SELECT * FROM expediciones_envios WHERE estado='true' AND sin_enviar=0  ORDER BY id DESC";
				
				// var_dump($query);
	   //      		exit();
				# Ejecucion 					
				$result = SQL::selectObject($query, new ExpedicionesEnvios);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		} 

		 public function selectAprobado()
		{			
			try {
											
				# Query
					$query="SELECT * FROM expediciones_envios WHERE estado='true' AND sin_enviar=1  ORDER BY id DESC";
				
				// var_dump($query);
	   //      		exit();
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
				$this->setCantidadEnviada($filas['cantidad_enviada']);
				$this->setUsuario($filas['id_usuario']);
				$this->setNroEnvio($filas['nro_envio']);
				$this->setSinEnviar($filas['sin_enviar']);
				$this->setEstado($filas['estado']);
				$this->setCantidadFaltante($filas['cantidad_faltante']);
				
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setIdPedido(0);					
			$this->setFecha('');
			$this->setCantidadEnviada('');
			$this->setUsuario(0);
			$this->setNroEnvio(0);
			$this->setSinEnviar(1);
			$this->setEstado(true);
			$this->setCantidadFaltante(0);
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