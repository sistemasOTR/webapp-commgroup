<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';

	include_once PATH_DATOS.'Entidades/usuario.class.php';

	class LegajosCategorias
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }		
		
		private $_categoria;
		public function getCategoria(){ return $this->_categoria; }
		public function setCategoria($categoria){ $this->_categoria=$categoria; }		

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }	

		

				

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);			
			$this->setCategoria('');			
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
				$query="INSERT INTO legajos_categorias (
		        						categoria,		    
		        						estado
		        						
		        						
	        			) VALUES (
	        							'".$this->getCategoria()."',   	   
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
					throw new Exception("categoria no identificado");			

				# Query 			
				$query="UPDATE legajos_categorias SET
								categoria='".$this->getCategoria()."',								
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
					throw new Exception(" categoria no identificado");
			
				# Query 			
				$query="UPDATE legajos_categorias SET							
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
					$query = "SELECT * FROM legajos_categorias WHERE estado='true'";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id de Categoria");		

					$query="SELECT * FROM legajos_categorias WHERE id=".$this->getId();
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new LegajosCategorias);
						
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
				$this->setCategoria($filas['categoria']);				
				$this->setEstado($filas['estado']);	
										
				
			}
		}

		private function cleanClass()
		{
			$this->setId(0);			
			$this->setCategoria('');			
			$this->setEstado(true);
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';
		}

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/
	
		public function selectById($id)
		{			
			try {

				if(empty($id))
					throw new Exception("No se selecciono el Usuario");		

				$query="SELECT * FROM legajos_categorias WHERE id=".$id;
				
				# Ejecucion 					
				$result = SQL::selectArray($query, new LegajosCategorias);
						
				return $result;

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