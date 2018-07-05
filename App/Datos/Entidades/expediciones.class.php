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

	class Expediciones
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

		private $_estadosExpediciones;
		public function getEstadosExpediciones(){ return $this->_estadosExpediciones; }
		public function setEstadosExpediciones($estadosExpediciones){ $this->_estadosExpediciones=$estadosExpediciones; }
		
		private $_usuarioId;
		public function getUsuarioId(){ return $this->_usuarioId; }
		public function setUsuarioId($usuario_id){ $this->_usuarioId=$usuario_id; }

		private $_fecha;
		public function getFecha(){ return $this->_fecha; }
		public function setFecha($fecha){ $this->_fecha=$fecha; }

		private $_cantidad;
		public function getCantidad(){ return $this->_cantidad; }
		public function setCantidad($cantidad){ $this->_cantidad=$cantidad; }

		private $_detalle;
		public function getDetalle(){ return $this->_detalle; }
		public function setDetalle($detalle){ $this->_detalle=$detalle; }
		
		private $_observaciones;
		public function getObservaciones(){ return $this->_observaciones; }
		public function setObservaciones($observaciones){ $this->_observaciones=$observaciones; }

		private $_sinPublicar;
		public function getSinPublicar(){ return var_export($this->_sinPublicar,true); }
		public function setSinPublicar($sinPublicar){ $this->_sinPublicar=$sinPublicar; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }	

		private $_entregada;
		public function getEntregada(){ return $this->_entregada; }
		public function setEntregada($entregada){ $this->_entregada=$entregada; }

		private $_plaza;
		public function getPlaza(){ return $this->_plaza; }
		public function setPlaza($plaza){ $this->_plaza=$plaza; }		

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setEstadosExpediciones(0);						
			$this->setItemExpediciones(0);	
			$this->setUsuarioId(0);						
			$this->setFecha('');
			$this->setDetalle('');
			$this->setObservaciones('');
			$this->setCantidad(0);						
			$this->setEstado(true);
			$this->setSinPublicar(true);
			$this->setEntregada(0);
			$this->setPlaza('');

		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				# Validaciones 			
				/*if(empty($this->getEstadosExpediciones()))
					throw new Exception("Estado Vacio");

				if(empty($this->getItemExpediciones()))
					throw new Exception("Item Vacio");

				if(empty($this->getUsuarioId()))
					throw new Exception("Usuario Vacio");	

				if(empty($this->getCantidad()))
					throw new Exception("Cantidad Vacia");	
				*/
				# Query 			
				$query="INSERT INTO expediciones (
		        						item_expediciones_id,					
		        						estados_expediciones_id,
		        						usuario_id,
		        						fecha,		        						
		        						detalle,
		        						cantidad,		 
		        						observaciones,       						
		        						sin_publicar,
		        						estado,
		        						cant_entregada,
		        						plaza
	        			) VALUES (
	        							".$this->getItemExpediciones().",   	
	        							".$this->getEstadosExpediciones().",   	
	        							".$this->getUsuarioId().",   	
	        							'".$this->getFecha()."',   	
	        							'".$this->getDetalle()."',   	
	        							".$this->getCantidad().",
	        							'".$this->getObservaciones()."',   	
	        							'".$this->getSinPublicar()."',
	        							'".$this->getEstado()."',
	        							".$this->getEntregada().",
	        							'".$this->getPlaza()."'
	        			)";
	        		//var_dump($query);
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
					throw new Exception("Expedición no identificada");

				if(empty($this->getEstadosExpediciones()))
					throw new Exception("Estado Vacio");

				if(empty($this->getItemExpediciones()))
					throw new Exception("item Vacio");
				
				if(empty($this->getUsuarioId()))
					throw new Exception("Usuario vacio");

				if(empty($this->getCantidad()))
					throw new Exception("Cantidad Vacia");	

				# Query 			
				$query="UPDATE expediciones SET
								item_expediciones_id=".$this->getItemExpediciones().",
								estados_expediciones_id=".$this->getEstadosExpediciones().",
								usuario_id=".$this->getUsuarioId().",
								fecha='".$this->getFecha()."',
								detalle='".$this->getDetalle()."',
								cantidad=".$this->getCantidad().",								
								cant_entregada=".$this->getEntregada().",
								plaza='".$this->getPlaza()."',								
								observaciones='".$this->getObservaciones()."',
								sin_publicar=".$this->getSinPublicar().",
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
					throw new Exception("Expedición no identificada");
			
				# Query 			
				$query="UPDATE expediciones SET							
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
					$query = "SELECT * FROM expediciones WHERE estado='true' ORDER BY fecha DESC";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id de la expedición");		

					$query="SELECT * FROM expediciones WHERE id=".$this->getId()." ORDER BY fecha DESC";
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Expediciones);
						
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
				$this->setItemExpediciones($filas['item_expediciones_id']);	
				$this->setEstadosExpediciones($filas['estados_expediciones_id']);
				$this->setUsuarioId($filas['usuario_id']);
				$this->setFecha($filas['fecha']);				
				$this->setDetalle(trim($filas['detalle']));
				$this->setCantidad($filas['cantidad']);		
				$this->setObservaciones(trim($filas['observaciones']));		
				$this->setEstado($filas['estado']);
				$this->setSinPublicar($filas['sin_publicar']);
				$this->setEntregada($filas['cant_entregada']);
				$this->setPlaza($filas['plaza']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setEstadosExpediciones(0);						
			$this->setItemExpediciones(0);	
			$this->setUsuarioId(0);	
			$this->setFecha('');
			$this->setDetalle('');
			$this->setCantidad(0);
			$this->setObservaciones('');			
			$this->setEstado(true);
			$this->setSinPublicar(true);
			$this->setEntregada(0);
			$this->setPlaza('');
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';
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
					$query="SELECT * FROM expediciones WHERE estado='true' AND usuario_id=".$usuario_id." ORDER BY fecha DESC";
				}
				else
				{			
					throw new Exception("No se selecciono el usuario.");							
				}

				//echo $query;
				//exit();
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Expediciones);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}	

		public function seleccionarSinPublicar($usuario)	
		{
			try {
				
				if(!empty($usuario)){
					$query="SELECT * FROM expediciones WHERE estado='true' AND usuario_id=".$usuario." AND sin_publicar='true' ORDER BY fecha DESC";
				}
				else{
					throw new Exception("No se selecciono el usuario.");
				}

				//var_dump($query);
				//exit();
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Expediciones);

				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}

		public function updateNuevo($id_sol)
		{			
			try {
				$conexion = false;							
					$query="UPDATE expediciones SET
								
								sin_publicar=0
								
							WHERE id=".$id_sol;
							
				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}
		public function updateRechazado($id,$observaciones)
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
		public function updateRecibido($id,$estado)
		{			
			try {
				$conexion = false;							
					$query="UPDATE expediciones SET
								
								estados_expediciones_id=".$estado."
								
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
		}

		public function pendientes()
		{			
			try {						
					$query="SELECT * FROM expediciones 
							WHERE estados_expediciones_id=1 AND sin_publicar = 'false'
							order by fecha ASC";
						
				# Ejecucion 					
				return SQL::selectObject($query, new Expediciones);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		public function recParciales()
		{			
			try {						
					$query="SELECT * FROM expediciones 
							WHERE estados_expediciones_id=7 AND sin_publicar = 'false'
							order by fecha ASC";
						
				# Ejecucion 					
				return SQL::selectObject($query, new Expediciones);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		public function entregados($userPlaza)
		{			
			try {						
					$query="SELECT * FROM expediciones 
							WHERE estados_expediciones_id=2 AND sin_publicar = 'false'  AND plaza = '".$userPlaza."'
							order by fecha ASC";
						
				# Ejecucion 					
				return SQL::selectObject($query, new Expediciones);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}

		public function entParciales($userPlaza)
		{			
			try {						
					$query="SELECT * FROM expediciones 
							WHERE estados_expediciones_id=6 AND sin_publicar = 'false' AND plaza = '".$userPlaza."'
							order by fecha ASC";
						
				# Ejecucion 					
				return SQL::selectObject($query, new Expediciones);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}


	}
?>