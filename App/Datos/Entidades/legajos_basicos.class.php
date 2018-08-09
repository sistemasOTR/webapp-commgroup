<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';


	class LegajosBasicos
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }		
		
		private $_idcategoria;
		public function getIdCategoria(){ return $this->_idcategoria; }
		public function setIdCategoria($idcategoria){ $this->_idcategoria=$idcategoria; }		

		private $basico;
		public function getBasico(){ return $this->_basico; }
		public function setBasico($basico){ $this->_basico=$basico; }

		private $_hnormales;
		public function getHorasNormales(){ return $this->_hnormales; }
		public function setHorasNormales($hnormales){ $this->_hnormales=$hnormales; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }	

		private $_fecha_desde;
		public function getFechaDesde(){ return $this->_fecha_desde; }
		public function setFechaDesde($fecha_desde){ $this->_fecha_desde=$fecha_desde; }

		private $_fechahasta;
		public function getFechaHasta(){ return $this->_fechahasta; }
		public function setFechaHasta($fechahasta){ $this->_fechahasta=$fechahasta; }


				

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);			
			$this->setIdCategoria(0);			
			$this->setBasico(0);
			$this->setHorasNormales(0);
			$this->setEstado(true);
			$this->setFechaDesde('');
			$this->setFechaHasta('');
			
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {
				
				# Query 			
				$query="INSERT INTO legajos_basicos (
		        						id_categoria,		    
		        						basico,
		        						h_normales,
		        						estado,
		        						fecha_desde,
		        						fecha_hasta
		        						
		        						
	        			) VALUES (
	        							".$this->getIdCategoria().",   	
	        							".$this->getBasico().",   
										".$this->getHorasNormales().",   
										'".$this->getEstado()."',   
										'".$this->getFechaDesde()."',   
										'".$this->getFechaHasta()."'  
										  
										
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
					throw new Exception("Basico no identificado");			

				# Query 			
				$query="UPDATE legajos_basicos SET
								id_categoria=".$this->getIdCategoria().",								
								basico=".$this->getBasico().",
								estado='".$this->getEstado()."',
								h_normales=".$this->getHorasNormales().",
								fecha_desde='".$this->getFechaDesde()."',
								fecha_hasta='".$this->getFechaHasta()."'
								
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
					throw new Exception("Basicos no identificado");
			
				# Query 			
				$query="UPDATE legajos_basicos SET							
								estado='false'
							WHERE fecha_hasta='1900-01-01' AND id=".$this->getId();

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
					$query = "SELECT * FROM legajos_basicos WHERE estado='true' AND fecha_hasta='1900-01-01'";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id del Basico");		

					$query="SELECT * FROM legajos_basicos WHERE id=".$this->getId();
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new LegajosBasicos);
						
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
				// $u = new Usuario;
				// $u->setId($filas['id_usuario']);			
				// $u = $u->select();
				// $this->setUsuarioId($u);					
                $this->setId($filas['id']);				
				$this->setIdCategoria($filas['id_categoria']);				
				$this->setBasico($filas['basico']);				
				$this->setHorasNormales($filas['h_normales']);				
				$this->setEstado($filas['estado']);	
				$this->setFechaDesde($filas['fecha_desde']);			
				$this->setFechaHasta($filas['fecha_hasta']);							
				
			}
		}

		private function cleanClass()
		{
			$this->setId(0);			
			$this->setIdCategoria(0);			
			$this->setBasico(0);
			$this->setHorasNormales(0);
			$this->setEstado(true);
			$this->setFechaDesde('');
			$this->setFechaHasta('');
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';
		}

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/

		public function updatebasico($conexion)
		{
			try {

				# Validaciones 			
				if(empty($this->getId()))
					throw new Exception("Basico no identificado");			

				# Query 			
				$query="UPDATE legajos_basicos SET
								fecha_hasta='".$this->getFechaDesde()."'				
							WHERE id=".$this->getId();

	        	//echo $query;
	        	//exit();

				# Ejecucion 					
				return SQL::update($conexion,$query);	

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}		
		}
	
		// public function selectByCategoria($categoria)
		// {			
		// 	try {

		// 		if(empty($usuario))
		// 			throw new Exception("No se selecciono el Usuario");		

		// 		$query="SELECT TOP 1 * FROM legajos_basicos WHERE id_categoria=".$categoria;
				
		// 		# Ejecucion 					
		// 		$result = SQL::selectObject($query, new Legajos);
						
		// 		return $result;

		// 	} catch (Exception $e) {
		// 		throw new Exception($e->getMessage());						
		// 	}

		// }

		// public function enviarLegajo($id){
		// 	try {

		// 		# Validaciones 			
		// 		if(empty($id))
		// 			throw new Exception("Legajo no identificado");

		// 		# Query 			
		// 		$query="UPDATE legajos SET								
		// 						enviado=1
		// 					WHERE id=".$id;

	 //        	//echo $query;
	 //        	//exit();

		// 		# Ejecucion 					
		// 		return SQL::update($conexion,$query);					

		// 	} catch (Exception $e) {
		// 		throw new Exception($e->getMessage());
		// 	}
		// }

		// public function rechazarLegajo($id){
		// 	try {

		// 		# Validaciones 			
		// 		if(empty($id))
		// 			throw new Exception("Legajo no identificado");

		// 		# Query 			
		// 		$query="UPDATE legajos SET								
		// 						enviado=0
		// 					WHERE id=".$id;

	 //        	//echo $query;
	 //        	//exit();

		// 		# Ejecucion 					
		// 		return SQL::update($conexion,$query);					

		// 	} catch (Exception $e) {
		// 		throw new Exception($e->getMessage());
		// 	}
		// }

		// public function seleccionarByFiltros($usuario){
		// 	try {

		// 		if(empty($usuario))
		// 			$query="SELECT * FROM legajos WHERE enviado=1";
		// 		else
		// 			$query="SELECT * FROM legajos WHERE enviado=1 AND id_usuario=".$usuario;
				
		// 		# Ejecucion 					
		// 		$result = SQL::selectObject($query, new Legajos);
						
		// 		return $result;

		// 	} catch (Exception $e) {
		// 		throw new Exception($e->getMessage());						
		// 	}			
		// }

	}
?>