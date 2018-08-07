<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";

	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';

	include_once PATH_DATOS.'Entidades/usuario.class.php';
	include_once PATH_DATOS.'Entidades/tipolicencias.class.php';

	class Licencias
	{			
		/*#####################################*/
		/* DECLARACIONES / GETTERS AND SETTERS */
		/*#####################################*/

		private $_id;
		public function getId(){ return $this->_id; }
		public function setId($id){ $this->_id =$id; }		
		
		private $_usuarioId;
		public function getUsuarioId(){ return $this->_usuarioId; }
		public function setUsuarioId($usuario_id){ $this->_usuarioId=$usuario_id; }

		private $_tipoLicenciasId;
		public function getTipoLicenciasId(){ return $this->_tipoLicenciasId; }
		public function setTipoLicenciasId($tipoLicenciasId){ $this->_tipoLicenciasId=$tipoLicenciasId; }

		private $_fecha;
		public function getFecha(){ return $this->_fecha; }
		public function setFecha($fecha){ $this->_fecha=$fecha; }				

		private $_fechaInicio;
		public function getFechaInicio(){ return $this->_fechaInicio; }
		public function setFechaInicio($fechaInicio){ $this->_fechaInicio=$fechaInicio; }

		private $_fechaFin;
		public function getFechaFin(){ return $this->_fechaFin; }
		public function setFechaFin($fechaFin){ $this->_fechaFin=$fechaFin; }

		private $_observaciones;
		public function getObservaciones(){ return $this->_observaciones; }
		public function setObservaciones($observaciones){ $this->_observaciones=$observaciones; }

		private $_adjunto1;
		public function getAdjunto1(){ return $this->_adjunto1; }
		public function setAdjunto1($adjunto1){ $this->_adjunto1=$adjunto1; }

		private $_adjunto2;
		public function getAdjunto2(){ return $this->_adjunto2; }
		public function setAdjunto2($adjunto2){ $this->_adjunto2=$adjunto2; }

		private $_estado;
		public function getEstado(){ return var_export($this->_estado,true); }
		public function setEstado($estado){ $this->_estado=$estado; }			

		private $_aprobado;
		public function getAprobado(){ return var_export($this->_aprobado,true); }
		public function setAprobado($aprobado){ $this->_aprobado=$aprobado; }			

		private $_rechazado;
		public function getRechazado(){ return var_export($this->_rechazado,true); }
		public function setRechazado($rechazado){ $this->_rechazado=$rechazado; }

		private $_fechaRechazo;
		public function getFechaRechazo(){ return $this->_fechaRechazo; }
		public function setFechaRechazo($fechaRechazo){ $this->_fechaRechazo=$fechaRechazo; }		

		private $_obsRechazo;
		public function getObsRechazo(){ return $this->_obsRechazo; }
		public function setObsRechazo($obsRechazo){ $this->_obsRechazo=$obsRechazo; }

		private $_aprobadoco;
		public function getAprobadoCo(){ return var_export($this->_aprobadoco,true); }
		public function setAprobadoCo($aprobadoco){ $this->_aprobadoco=$aprobadoco; }					

		/*#############*/
		/* CONSTRUCTOR */
		/*#############*/

		function __construct(){
			$this->setId(0);
			$this->setFecha('');
			$this->setFechaRechazo('');
			$this->setFechaInicio('');
			$this->setFechaFin('');
			$this->setUsuarioId(new Usuario);						
			$this->setTipoLicenciasId(new TipoLicencias);
			$this->setObservaciones('');	
			$this->setObsRechazo('');	
			$this->setAdjunto1('');
			$this->setAdjunto2('');
			$this->setEstado(true);
			$this->setAprobado(false);
			$this->setRechazado(false);
			$this->setAprobadoCo(false);
		}

		/*###################*/
		/* METODOS GENERICOS */
		/*###################*/

		public function insert($conexion)
		{
			try {

				# Validaciones 			
				if(empty($this->getUsuarioId()))
					throw new Exception("Usuario Vacio");	

				if(empty($this->getTipoLicenciasId()))
					throw new Exception("Tipo de Licencias Vacio");			
				
				# Query 			
				$query="INSERT INTO licencias (
		        						fecha,		        						
		        						id_usuario,
		        						id_tipo_licencia,		        						
		        						observaciones,		        								        						
		        						fecha_inicio,
		        						fecha_fin,
		        						adjunto1,
		        						adjunto2,
		        						aprobado,
		        						estado,
		        						rechazado,
		        						fecha_rechazo,
		        						obs_rechazo,
		        						aprobado_co
	        			) VALUES (
	        							'".$this->getFecha()."',   	
	        							".$this->getUsuarioId().",   	
	        							".$this->getTipoLicenciasId().",   	
	        							'".$this->getObservaciones()."',   		        							
	        							'".$this->getFechaInicio()."',   	
	        							'".$this->getFechaFin()."',   	
	        							'".$this->getAdjunto1()."',
	        							'".$this->getAdjunto2()."',
	        							'".$this->getAprobado()."',   
	        							'".$this->getEstado()."',
	        							'".$this->getRechazado()."',
	        							'".$this->getFechaRechazo()."',
	        							'".$this->getObsRechazo()."',
	        							'".$this->getAprobadoCo()."'
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
					throw new Exception("Licencia no identificada");

				if(empty($this->getUsuarioId()))
					throw new Exception("Usuario Vacio");	

				if(empty($this->getTipoLicenciasId()))
					throw new Exception("Tipo de Licencias Vacio");		

				# Query 			
				$query="UPDATE licencias SET
								id_usuario=".$this->getUsuarioId().",
								id_tipo_licencia=".$this->getTipoLicenciasId().",
								fecha='".$this->getFecha()."',
								fecha_inicio='".$this->getFechaInicio()."',
								fecha_fin='".$this->getFechaFin()."',														
								observaciones='".$this->getObservaciones()."',
								adjunto1='".$this->getAdjunto1()."',
								adjunto2='".$this->getAdjunto2()."',
								aprobado='".$this->getAprobado()."',
								estado='".$this->getEstado()."',
								rechazado='".$this->getRechazado()."',
								fecha_rechazo='".$this->getFechaRechazo()."',
								obs_rechazo='".$this->getObsRechazo()."',
								aprobado_co='".$this->getAprobado()."'
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
					throw new Exception("Licencia no identificada");
			
				# Query 			
				$query="UPDATE licencias SET							
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
					$query = "SELECT * FROM licencias WHERE estado='true' ORDER BY fecha DESC";
				}
				else
				{
					if(empty($this->getId()))
						throw new Exception("No se selecciono el Id de la Licencia");		

					$query="SELECT * FROM licencias WHERE id=".$this->getId()." ORDER BY fecha DESC";
				}
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Licencias);
						
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

				$u = new Usuario;
				$u->setId($filas['id_usuario']);			
				$u = $u->select();
				$this->setUsuarioId($u);					

				$l = new TipoLicencias;
				$l->setId($filas['id_tipo_licencia']);			
				$l = $l->select();
				$this->setTipoLicenciasId($l);

				$this->setFecha($filas['fecha']);				
				$this->setFechaInicio($filas['fecha_inicio']);				
				$this->setFechaFin($filas['fecha_fin']);							
				$this->setObservaciones(trim($filas['observaciones']));			
				$this->setAdjunto1(trim($filas['adjunto1']));		
				$this->setAdjunto2(trim($filas['adjunto2']));		
				$this->setAprobado($filas['aprobado']);
				$this->setRechazado($filas['rechazado']);
				$this->setFechaRechazo($filas['fecha_rechazo']);
				$this->setObsRechazo($filas['obs_rechazo']);
				$this->setEstado($filas['estado']);
				$this->setAprobadoCo($filas['aprobado_co']);
			}
		}

		private function cleanClass()
		{
			$this->setId(0);
			$this->setFecha('');
			$this->setFechaRechazo('');
			$this->setUsuarioId(new Usuario);						
			$this->setTipoLicenciasId(new TipoLicencias);
			$this->setObservaciones('');			
			$this->setObsRechazo('');			
			$this->setAdjunto1('');
			$this->setAdjunto2('');
			$this->setEstado(true);
			$this->setAprobado(false);
			$this->setRechazado(false);
			$this->setAprobadoCo(false);
		}

		private function createTable()
		{
			return 'CREATE TABLE IF NOT EXISTS';
		}

		/*########################*/
		/* METODOS PERSONALIZADOS */
		/*########################*/

		public function aprobarLicencias($id,$obs){
			try {

				# Validaciones 			
				if(empty($id))
					throw new Exception("Licencias no identificada");

				# Query 			
				$query="UPDATE licencias SET								
								aprobado=1,
								observaciones='".$obs."'
							WHERE id=".$id;

	        	//echo $query;
	        	//exit();

				# Ejecucion 					
				return SQL::update($conexion,$query);					

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
       
       public function aprobarLicenciasCoord($id){
			try {

				# Validaciones 			
				if(empty($id))
					throw new Exception("Licencias no identificada");

				# Query 			
				$query="UPDATE licencias SET								
								aprobado_co=1
							WHERE id=".$id;

	        	//echo $query;
	        	//exit();

				# Ejecucion 					
				return SQL::update($conexion,$query);					

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
		public function rechazarLicencias($id,$fRechazo,$obs){
			try {

				# Validaciones 			
				if(empty($id))
					throw new Exception("Licencias no identificada");

				# Query 			
				$query="UPDATE licencias SET								
								rechazado=1,
								fecha_rechazo='".$fRechazo."',
								obs_rechazo='".$obs."'
							WHERE id=".$id;

	        	//echo $query;
	        	//exit();

				# Ejecucion 					
				return SQL::update($conexion,$query);					

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function desaprobarLicencias($id){
			try {

				# Validaciones 			
				if(empty($id))
					throw new Exception("Licencia no identificada");

				# Query 			
				$query="UPDATE licencias SET								
								aprobado=0
							WHERE id=".$id;

	        	//echo $query;
	        	//exit();

				# Ejecucion 					
				return SQL::update($conexion,$query);					

			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}		
         
         

		
		public function seleccionarByFiltros($fdesde,$fhasta,$usuario,$estados){
			try {
				
				$f = new Fechas;

				if($fdesde==$fhasta)
				{
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "CAST (licencias.fecha_inicio AS DATE) <= '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "CAST (licencias.fecha_fin AS DATE) >=  '".$tmp."' AND ";
					}
				}
				else
				{					
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "CAST (licencias.fecha_inicio AS DATE) >= '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "CAST (licencias.fecha_inicio AS DATE) <=  '".$tmp."' AND ";
					}
				}
											
				$filtro_usuario="";
				if(!empty($usuario))								
					$filtro_usuario = "licencias.id_usuario = ".$usuario." AND ";

				$filtro_estados="";
				if(!empty($estados))
				   switch ($estados) {
				   		case '1':
				   	      $filtro_estados = "licencias.aprobado_co = 'false' AND licencias.rechazado ='false' AND ";							
				   			break;
				   		case '2':
				   	      $filtro_estados = "licencias.aprobado_co = 'true' AND ";
				   	        break;							
				   		case '3':
				   	      $filtro_estados = "licencias.rechazado = 'true' AND ";	
				   			break;						
				   					};								
					
				
				$filtro_estado = "licencias.estado = 'true'";


				$query="SELECT * FROM licencias 
								WHERE
									".$filtro_fdesde." 
									".$filtro_fhasta." 										
									".$filtro_usuario."
									".$filtro_estados."			
									".$filtro_estado;

				//echo $query;
				//exit();

				# Ejecucion 					
				$result = SQL::selectObject($query, new Licencias);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}			
		}

		public function seleccionarByFiltrosRRHH($fdesde,$fhasta,$usuario,$estados){
			try {
				
				$f = new Fechas;

				if($fdesde==$fhasta)
				{
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "CAST (licencias.fecha_inicio AS DATE) <= '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "CAST (licencias.fecha_fin AS DATE) >=  '".$tmp."' AND ";
					}
				}
				else
				{					
					$filtro_fdesde="";
					if(!empty($fdesde)){					
						$tmp = $f->FormatearFechas($fdesde,"Y-m-d","Y-m-d");				
						$filtro_fdesde = "CAST (licencias.fecha_inicio AS DATE) >= '".$tmp."' AND ";
					}

					$filtro_fhasta="";
					if(!empty($fhasta)){					
						$tmp = $f->FormatearFechas($fhasta,"Y-m-d","Y-m-d");				
						$filtro_fhasta = "CAST (licencias.fecha_inicio AS DATE) <=  '".$tmp."' AND ";
					}
				}
											
				$filtro_usuario="";
				if(!empty($usuario))								
					$filtro_usuario = "licencias.id_usuario = ".$usuario." AND ";

				$filtro_estados="";
				if(!empty($estados))
				   switch ($estados) {
				   		case '1':
				   	      $filtro_estados = "licencias.aprobado = 'false' AND licencias.rechazado ='false' AND ";							
				   			break;
				   		case '2':
				   	      $filtro_estados = "licencias.aprobado = 'true' AND ";
				   	        break;							
				   		case '3':
				   	      $filtro_estados = "licencias.rechazado = 'true' AND ";	
				   			break;						
				   					};								
					
				
				$filtro_estado = "licencias.estado = 'true' AND ";
				$filtro_aprobado_co="licencias.aprobado_co= 'true'";


				$query="SELECT * FROM licencias 
								WHERE
									".$filtro_fdesde." 
									".$filtro_fhasta." 										
									".$filtro_usuario."
									".$filtro_estados."			
									".$filtro_estado."
									".$filtro_aprobado_co;

				// var_dump($query);
				// exit();

				# Ejecucion 					
				$result = SQL::selectObject($query, new Licencias);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}			
		}

		public function selectMiLicencias($usuario)
		{			
			try {
															
				$query="SELECT * FROM licencias WHERE id_usuario=".$usuario." AND estado='true' ORDER BY fecha DESC";
				
				
				# Ejecucion 					
				$result = SQL::selectObject($query, new Licencias);
						
				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());						
			}

		}

		public function huboLicencias($usuario,$fecha){
			try {

				$query="SELECT * FROM licencias WHERE id_usuario=".$usuario." AND fecha_inicio<='".$fecha."' AND fecha_fin>='".$fecha."' AND estado='true' ORDER BY fecha DESC";
				
				//echo $query;
				//exit();

				# Ejecucion 					
				$result = SQL::selectObject($query, new Licencias);
						
				return $result;
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());							
			}
		}
	}
?>