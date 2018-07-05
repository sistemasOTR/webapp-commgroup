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

	class ExpedicionesCompras
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }

		private $_itemExpediciones;
		public function getItemExpediciones(){ return $this->_itemExpediciones; }
		public function setItemExpediciones($itemExpediciones){ $this->_itemExpediciones=$itemExpediciones; }

		private $_cantidad;
		public function getCantidad(){ return $this->_cantidad; }
		public function setCantidad($cantidad){ $this->_cantidad=$cantidad; }

		private $_fecha;
		public function getFecha(){ return $this->_fecha; }
		public function setFecha($fecha){ $this->_fecha=$fecha; }

		private $_fecharecibido;
		public function getFechaRecibido(){ return $this->_fecharecibido; }
		public function setFechaRecibido($fecharecibido){ $this->_fecharecibido=$fecharecibido; }

		
		private $_usuariopidio;
		public function getUsuarioPidio(){ return $this->_usuariopidio; }
		public function setUsuarioPidio($usuariopidio){ $this->_usuariopidio=$usuariopidio; }

		private $_usuariorecibio;
		public function getUsuarioRecibio(){ return $this->_usuariorecibio; }
		public function setUsuarioRecibio($usuariorecibio){ $this->_usuariorecibio=$usuariorecibio; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }	

	
		private $_sinpedir;
		public function getSinPedir(){ return var_export($this->_sinpedir,true); }
		public function setSinPedir($sinpedir){ $this->_sinpedir=$sinpedir; }

		private $_recibido;
		public function getRecibido(){ return $this->_recibido; }
		public function setRecibido($recibido){ $this->_recibido=$recibido; }
	/*		


		
		
		private $_observaciones;
		public function getObservaciones(){ return $this->_observaciones; }
		public function setObservaciones($observaciones){ $this->_observaciones=$observaciones; }

		*/	

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);						
			$this->setItemExpediciones(0);	
			$this->setCantidad(0);	
			$this->setFecha('');					
			$this->setUsuarioPidio(0);	
			$this->setUsuarioRecibio(0);	
			$this->setEstado(true);
			$this->setSinPedir(true);
			$this->setRecibido(false);
			$this->setFechaRecibido('');

		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				
				$query="INSERT INTO expediciones_compras (
		        						id_item,					
		        						cantidad,
		        						fecha,
		        						usuario_pidio,		
		        						usuario_recibio,
		        						estado,		 
		        						sin_pedir,			
		        						recibido,
		        						fecha_recibido			
		        						
	        			) VALUES (
	        							".$this->getItemExpediciones().",
	        							".$this->getCantidad().", 
	        							'".$this->getFecha()."',   	
					  	                ".$this->getUsuarioPidio().",
	        							".$this->getUsuarioRecibio().",
	        							'".$this->getEstado()."',
	        							'".$this->getSinPedir()."',
	        							'".$this->getRecibido()."',
	        							'".$this->getFechaRecibido()."'
	        							
	        			)";
	        	//	var_dump($query);
	        	//	exit();

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
			/*	if(empty($this->getId()))
					throw new Exception("Expedición no identificada");

				if(empty($this->getEstadosExpediciones()))
					throw new Exception("Estado Vacio");

				if(empty($this->getItemExpediciones()))
					throw new Exception("item Vacio");
				
				if(empty($this->getUsuarioId()))
					throw new Exception("Usuario vacio");

				if(empty($this->getCantidad()))
					throw new Exception("Cantidad Vacia");	*/

				# Query 			
				$query="UPDATE expediciones_compras SET
								id_item=".$this->getItemExpediciones().",
								cantidad=".$this->getCantidad().",	
								fecha='".$this->getFecha()."',
								usuario_pidio=".$this->getUsuarioPidio().",
								usuario_recibio=".$this->getUsuarioRecibio().",
								estado='".$this->getEstado()."',
								sin_pedir='".$this->getSinPedir()."',
								recibido='".$this->getRecibido()."',
                                fecha_recibido='".$this->getFechaRecibido()."',
								
								
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
					throw new Exception("Expedición no identificada");
			
				# Query 			
				$query="UPDATE expediciones_compras SET							
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
					$query = "SELECT * FROM expediciones_compras WHERE estado='true' ORDER BY fecha DESC";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id de la expedición");		

					$query="SELECT * FROM expediciones WHERE id=".$this->getId()." ORDER BY fecha DESC";
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ExpedicionesCompras);
						
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
				$this->setItemExpediciones($filas['id_item']);	
				$this->setCantidad($filas['cantidad']);
				$this->setFecha($filas['fecha']);
				$this->setUsuarioPidio($filas['usuario_pidio']);				
				$this->setUsuarioRecibio(trim($filas['usuario_recibio']));			
				$this->setEstado($filas['estado']);
				$this->setSinPedir($filas['sin_pedir']);
				$this->setRecibido($filas['recibido']);
				$this->setFechaRecibido($filas['fecha_recibido']);
				
			}
		}

		private function cleanClass()
		{
			$this->setId(0);						
			$this->setItemExpediciones(0);	
			$this->setCantidad(0);	
			$this->setFecha('');					
			$this->setUsuarioPidio(0);	
			$this->setUsuarioRecibio(0);	
			$this->setEstado(true);
			$this->setSinPedir(true);
			$this->setRecibido(false);
			$this->setFechaRecibido('');
			
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

			CREATE TABLE [dbo].[expediciones](
				[id] [int] IDENTITY(1,1) NOT NULL,
				[fecha] [date] NOT NULL,
				[item_expediciones_id] [int] NOT NULL,
				[usuario_id] [int] NOT NULL,
				[detalle] [text] NOT NULL,
				[cantidad] [int] NOT NULL,
				[estados_expediciones_id] [int] NOT NULL,
				[observaciones] [text] NOT NULL,
				[estado] [bit] NOT NULL,
				[sin_publicar] [bit] NOT NULL,
				[plaza] [varchar](50) NOT NULL,
				[cant_entregada] [int] NOT NULL,
			 CONSTRAINT [PK_expediciones_1] PRIMARY KEY CLUSTERED 
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
		
		public function selectByUsuario($usuario_id)
		{			
			try {
											
				# Query
				if(!empty($usuario_id))
				{
					$query="SELECT * FROM expediciones_compras WHERE estado='true' AND usuario_pidio=".$usuario_id." ORDER BY fecha DESC";
				}
				else
				{			
					throw new Exception("No se selecciono el usuario.");							
				}

				//echo $query;
				//exit();
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ExpedicionesCompras);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}	

		public function seleccionarSinPedir($usuario)	
		{
			try {
				
				if(!empty($usuario)){
					$query="SELECT * FROM expediciones_compras WHERE estado='true' AND usuario_pidio=".$usuario." AND sin_pedir='true' ORDER BY fecha DESC";
				}
				else{
					throw new Exception("No se selecciono el usuario.");
				}

				//var_dump($query);
				//exit();
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new ExpedicionesCompras);

				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}

		public function updateCompra($id_sol)
		{			
			try {
				$conexion = false;							
					$query="UPDATE expediciones_compras SET
								
								sin_pedir=0
								
							WHERE id=".$id_sol;


							
				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}	

		public function updateCompraRecibida($id,$recibido,$usuario,$fecha)
		{			
			try {
				$conexion = false;							
					$query="UPDATE expediciones_compras SET
	
								  	usuario_recibio=".$usuario.",
									recibido=".$recibido.",
                                	fecha_recibido='".$fecha."'
								
								
							WHERE id=".$id;
							
				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}
		/*public function updateRechazado($id,$observaciones)
		{			
			try {
				$conexion = false;							
					$query="UPDATE expediciones SET
								
								estados_expediciones_id=3,
								
							observaciones='".$observaciones."'	
								
							WHERE id=".$id;
							
				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}
		public function updateCancelado($id,$observaciones)
		{			
			try {
				$conexion = false;							
					$query="UPDATE expediciones SET	
								estados_expediciones_id=8,
								observaciones='".$observaciones."'
								
							WHERE id=".$id;
							
				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}
	
		public function updateEstado($id,$estado,$observaciones,$cantidad_env)
		{			
			try {
				$conexion = false;							
					$query="UPDATE expediciones SET
								
								estados_expediciones_id=".$estado.",
								observaciones='".$observaciones."',
								cant_entregada=".$cantidad_env."
								
							WHERE id=".$id;
							
				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		} */

     
	}
?>