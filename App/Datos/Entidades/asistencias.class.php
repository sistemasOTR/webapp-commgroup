<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';

	include_once PATH_DATOS.'Entidades/usuario.class.php';

	class Asistencias
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }

		private $_idUsuario;
		public function getIdUsuario(){ return $this->_idUsuario; }
		public function setIdUsuario($idUsuario){ $this->_idUsuario =$idUsuario; }

		private $_fecha;
		public function getFecha(){ return $this->_fecha; }
		public function setFecha($fecha){ $this->_fecha =$fecha; }

		// private $_hora;
		// public function getHora(){ return $this->_hora; }
		// public function setHora($hora){ $this->_hora =$hora; }


		private $_ingreso;
		public function getIngreso(){ return var_export($this->_ingreso,true); }
		public function setIngreso($ingreso){ $this->_ingreso=$ingreso; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }	

		private $observacion;
		public function getObservacion(){ return $this->_observacion; }
		public function setObservacion($observacion){ $this->_observacion =$observacion; }

		

				

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setIdUsuario(0);
			$this->setFecha('');
			// $this->setHora('');		
			$this->setObservacion('');		
			$this->setEstado(true);
			$this->setIngreso(true);
			
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				# Validaciones 				
				
				# Query 			
				$query="INSERT INTO asistencias (
							id_usuario,
							fecha,
							ingreso,
							estado,
							observacion 
	        			) VALUES (
	        				".$this->getIdUsuario().",  
							'".$this->getFecha()."',
							".$this->getIngreso().",
							'".$this->getEstado()."',
							'".$this->getObservacion()."'
							
	        			)";        
			
	        	// echo $query;
	        	// exit();

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
				$query="UPDATE asistencias SET
							fecha='".$this->getFecha()."',	
							id_usuario=".$this->getIdUsuario().",
							ingreso=".$this->getIngreso().",
							estado='".$this->getEstado()."',
							observacion='".$this->getObservacion()."'
								
							WHERE id=".$this->getId();

	        	// echo $query;
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
				if(empty($this->getId()))
					throw new Exception(" concepto no identificado");
			
				# Query 			
				$query="UPDATE asistencias SET							
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
					$query = "SELECT * FROM asistencias WHERE estado='true'";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id de Concepto");	

					$query="SELECT * FROM asistencias WHERE id=".$this->getId();
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Asistencias);
						
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
				$this->setIdUsuario($filas['id_usuario']);
				$this->setFecha($filas['fecha']);
				$this->setObservacion($filas['observacion']);
				$this->setIngreso($filas['ingreso']);	
				$this->setEstado($filas['estado']);	
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setIdUsuario(0);
			$this->setFecha('');
			$this->setObservacion('');	
			$this->setEstado(true);
			$this->setIngreso(true);
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

				$query="SELECT * FROM asistencias WHERE id=".$id;
				
				# Ejecucion 					
				$result = SQL::selectArray($query, new Asistencias);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}

		}

		public function selectByIdUser($id_user)
		{			
			try {

				if(empty($id_user))
					throw new Exception("No se selecciono el Usuario");	

				$query="SELECT * FROM asistencias WHERE estado='true' AND id_usuario=".$id_user;
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Asistencias);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}

		}

		public function selectByFiltro($fdesde,$fhasta,$usuario)
		{			
			// try {


			// 	$query="SELECT * FROM asistencias WHERE estado='true' AND format(fecha,'yyyy-MM-dd')='".$fecha."' AND id_usuario=".$usuario;
				
			// 	# Ejecucion 					
			// 	$result = SQL::selectObject($query, new Asistencias);
						
			// 	return $result;

			// } catch (Exception $e) {
			// 	throw new Exception($e->getMessage());		
			// }


				try {
				
				$f = new Fechas;

				if($fdesde==$fhasta)
				{
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "format(fecha,'yyyy-MM-dd')= '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "format(fecha,'yyyy-MM-dd')='".$tmp."' AND ";
					}
				}
				else
				{					
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "format(fecha,'yyyy-MM-dd') >= '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "format(fecha,'yyyy-MM-dd') <=  '".$tmp."' AND ";
					}
				}
               
               $filtro_usuario="";
				if(!empty($usuario))								
					$filtro_usuario = "id_usuario = '".$usuario."' AND ";
				
				
				$filtro_estado = "estado =1";			

				$query = "SELECT * FROM asistencias 
								WHERE 									 
									".$filtro_fdesde." 
									".$filtro_fhasta." 												
									".$filtro_usuario." 												
									".$filtro_estado."
								ORDER BY fecha ASC";


				$result = SQL::selectObject($query, new Asistencias);	

				if(count($result)==1)
					$resultFinal[0] = $result;		
				else
					$resultFinal = $result;									

				return $resultFinal;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}

		}
	
		// public function selectSueldos($id_plaza,$id_usuario)
		// {			
		// 	try {

		// 		$filtro_plaza = '';
		// 		if(!empty($id_plaza))
		// 			$filtro_plaza = ' id_plaza = '.$id_plaza.' AND ';

		// 		$filtro_usuario = '';
		// 		if(!empty($id_usuario))
		// 			$filtro_usuario = ' id_usuario = '.$id_usuario.' AND ';

		// 		$filtro_estado = "estado = 'true' " ;

		// 		$query="SELECT * FROM sueldos 
		// 				WHERE 
		// 				".$filtro_plaza."
		// 				".$filtro_usuario."
		// 				".$filtro_estado;

		// 		# Ejecucion 					
		// 		$result = SQL::selectArray($query, new Sueldos);
						
		// 		return $result;

		// 	} catch (Exception $e) {
		// 		throw new Exception($e->getMessage());		
		// 	}

		// }
	}
?>