<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";
		
	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';	
	include_once PATH_DATOS.'Entidades/asistencias.class.php';
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	
	class HandlerAsistencias{

		public function newAsistencia($user_id,$observacion,$fecha,$ingreso){
			try {
					
				$handler = new Asistencias;

				$handler->setIdUsuario($user_id);		
				$handler->setObservacion($observacion);		
				$handler->setFecha($fecha);		
				$handler->setIngreso($ingreso);		
				$handler->insert(false);		
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}

		public function updateAsistencia($id,$hora,$observacion){
			try {
					
				$handler = new Asistencias;				
				$handler->setId($id);
				$handler=$handler->select();

                $handler->setId($id); 
				$handler->setFecha($hora);
				$handler->setObservacion($observacion);

				$handler->update(false);		
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}

		public function selectAsistencias(){
			try {
					
				$handler = new Asistencias;
				$data= $handler->select();	
				if(count($data)==1){
					$data = array('' => $data );                   
					return $data;
				}				
				else{
					return $data;
				}										
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}

		public function selectAsistenciasById($id){
			try {
					
				$handler = new Asistencias;
				$data= $handler->selectById($id);	
				
				if(count($data)==1){
					$data = array('' => $data );                   
					return $data;
				}				
				else{
					return $data;
				}								
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		public function selectAsistenciasByIdUser($id_user){
			try {
					
				$handler = new Asistencias;
				$data= $handler->selectByIdUser($id_user);	

				if(count($data)==1){
					$data = array($data );                   
					return $data;
				}				
				else{
					return $data;
				}								
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		public function selectAsistenciasByFiltro($fecha,$usuario){
			try {
					
				$handler = new Asistencias;
				$data= $handler->selectByFiltro($fecha,$usuario);	

				if(count($data)==1){
					$data = array($data );                   
					return $data;
				}				
				else{
					return $data;
				}								
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}

		 public function selecTop($id_user)
		{		
			try {
				
				$query = "SELECT TOP 1 * FROM asistencias WHERE estado='true'  AND id_usuario=".$id_user." ORDER BY id DESC";
				
				# Ejecucion 				
				$result = SQL::selectObject($query, new Asistencias);

				return $result;


			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}					
		}

	  public function selecTopAyer($id_user,$fecha)
		{		
			try {
				
				$query = "SELECT TOP 1 * FROM asistencias WHERE estado='true' AND format(fecha,'yyyy-MM-dd')='".$fecha."' AND id_usuario=".$id_user." ORDER BY id DESC";
				
				# Ejecucion 				
				$result = SQL::selectObject($query, new Asistencias);

				return $result;


			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}					
		}



	
	}

?>