<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";
		
	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'Entidades/agenda_accion.class.php';
	include_once PATH_DATOS.'Entidades/agenda_empresa.class.php';
	include_once PATH_DATOS.'Entidades/agenda_rubro.class.php';
	include_once PATH_DATOS.'Entidades/agenda_historico.class.php';
	include_once PATH_DATOS.'Entidades/agenda_estados.class.php';
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	
	class HandlerAgenda{

		public function selectAllEmpresas(){
			try {
				$handlerAg = new AgendaEmpresa;								
				$data = $handlerAg->select();
				
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

		public function selectEmpresaById($empresaId){
			try {
				$handlerAg = new AgendaEmpresa;	
				$handlerAg->setId($empresaId);							
				$data = $handlerAg->select();
				
				
					return $data;
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}

		public function selectEmpresaByRubro($rubro,$estado,$plaza){
			try {
				$handlerAg = new AgendaEmpresa;	
				$handlerAg->setRubro($rubro);							
				$data = $handlerAg->selectEmpresaByRubro($rubro,$estado,$plaza);
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

		public function historicoEmpresa($empresaId){
			try {
				$handlerAg = new AgendaHistorico;

				$data = $handlerAg->historicoEmpresa($empresaId);

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

		public function selectAllRubros(){
			try {
				$handlerAg = new AgendaRubro;								
				$data = $handlerAg->select();
				
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


		public function selectRubroById($idRubro){
			try {
				$handlerAg = new AgendaRubro;
				$handlerAg->setId($idRubro);

				$data = $handlerAg->select();
				
				
					return $data;
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}

		public function selectAllAcciones(){
			try {
				$handlerAg = new AgendaAccion;								
				$data = $handlerAg->select();
				
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

		public function guardarEmpresa($fecha_hora,$nombre,$rubro,$domicilio,$web,$per_contacto_1,$puesto_1,$telefono_1,$email_1,$per_contacto_2,$puesto_2,$telefono_2,$email_2,$plaza,$instancia){
			try {
				
				$fecha=substr($fecha_hora,0,10);
				$hora =substr($fecha_hora,11,5);
				$fecha_hora = $fecha." ".$hora;
				
				$t = new AgendaEmpresa;
				$t->setFechaAlta($fecha);
				$t->setFechaUltContacto($fecha_hora);
				$t->setNombre($nombre);
				$t->setRubro($rubro);
				$t->setDomicilio($domicilio);
				$t->setWeb($web);
				$t->setPerContacto1($per_contacto_1);
				$t->setPuesto1($puesto_1);
				$t->setTelefono1($telefono_1);
				$t->setEmail1($email_1);
				$t->setPerContacto2($per_contacto_2);
				$t->setPuesto2($puesto_2);
				$t->setTelefono2($telefono_2);
				$t->setEmail2($email_2);
				$t->setPlaza($plaza);
				$t->setInstancia($instancia);

				$t->insert(false);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}
		}

		public function actualizarEmpresa($id,$fecha_hora,$nombre,$rubro,$domicilio,$web,$per_contacto_1,$puesto_1,$telefono_1,$email_1,$per_contacto_2,$puesto_2,$telefono_2,$email_2,$plaza,$instancia){
			try {
				
				$fecha=substr($fecha_hora,0,10);
				$hora =substr($fecha_hora,11,5);
				$fecha_hora = $fecha." ".$hora;
				
				$t = new AgendaEmpresa;
				$t->setId(intval($id));
				$t->setFechaUltContacto($fecha_hora);
				$t->setNombre($nombre);
				$t->setRubro($rubro);
				$t->setDomicilio($domicilio);
				$t->setWeb($web);
				$t->setPerContacto1($per_contacto_1);
				$t->setPuesto1($puesto_1);
				$t->setTelefono1($telefono_1);
				$t->setEmail1($email_1);
				$t->setPerContacto2($per_contacto_2);
				$t->setPuesto2($puesto_2);
				$t->setTelefono2($telefono_2);
				$t->setEmail2($email_2);
				$t->setPlaza($plaza);
				$t->setInstancia($instancia);

				$t->actualizar(false);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}
		}

		public function contactar($fecha_hora,$usuario,$empresa,$tipo,$contacto,$obs,$instancia){
			try {
				
				$fecha=substr($fecha_hora,0,10);
				$hora =substr($fecha_hora,11,5);
				$fecha_hora = $fecha." ".$hora;
				
				$t = new AgendaEmpresa;
				$t->setFechaUltContacto($fecha_hora);
				$t->setInstancia($instancia);
				$t->setId(intval($empresa));
				
				$t->ultContacto(false);

				$handlerHist = new AgendaHistorico;
				$handlerHist->setFechaHora($fecha_hora);
				$handlerHist->setEmpresaId(intval($empresa));
				$handlerHist->setUsuarioId(intval($usuario));
				$handlerHist->setTipoId($tipo);
				$handlerHist->setContacto($contacto);
				$handlerHist->setObs($obs);
				$handlerHist->setInstancia($instancia);

				$handlerHist->insert(false);

				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}
		}

		public function guardarRubro($nombre){
			try {
				
				$t = new AgendaRubro;
				$t->setNombre($nombre);
				
				$t->insert(false);

				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}
		}

		public function actualizarRubro($nombre,$id){
			try {
				
				$t = new AgendaRubro;
				$t->setNombre($nombre);
				$t->setId($id);
				
				$t->update(false);

				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}
		}

		public function bajaRubro($id){
			try {
				
				$t = new AgendaRubro;
				$t->setId($id);
				
				$t->delete(false);

				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}
		}

		public function altaRubro($id){
			try {
				
				$t = new AgendaRubro;
				$t->setId($id);
				
				$t->alta(false);

				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}
		}

		// Estados
		// ============================

		public function selectEstados(){
			try {
				$handlerAg = new AgendaEstados;								
				$data = $handlerAg->select();
				
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

		public function newEstado($nombre,$color){
			try {
				$handler = new AgendaEstados;

				$handler->setNombre($nombre);
				$handler->setColor($color);

				$handler->insert(false);			
			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}

		public function updateEstados($id,$nombre,$color){
			try {
				$handler = new AgendaEstados;

				$handler->setId($id);
				$handler->setNombre($nombre);
				$handler->setColor($color);

				$handler->update(false);			
			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}

		public function selectEstadoById($id){
			try {
				$handlerAg = new AgendaEstados;	
				$handlerAg->setId($id);
				$data = $handlerAg->select();
				
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
	}

?>
