<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";
		
	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';

	include_once PATH_DATOS.'Entidades/objetivos.class.php';
	include_once PATH_DATOS.'Entidades/objetivos_gc.class.php';

	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";
	
	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
	include_once PATH_NEGOCIO."Sistema/HandlerSupervisor.class.php";

	class HandlerObjetivos{	

		// Objetivos Actuales
		// ============================
		
		public function objetivosActuales(){
			try {

				$handler = new Objetivos;				
				$data = $handler->select();
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

		// Objetivos x plaza
		// ============================

		public function objetivosXPlaza($plaza){
			try {

				$handler = new Objetivos;				
				$data = $handler->objetivosXPlaza($plaza);
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

		// Nuevo Objetivo por plaza
		// ============================

		public function nuevoObjetivo($plaza,$basico,$basicoGC,$vigencia,$cantCoord){
			try {

				$handler = new Objetivos;				
				$handler->setPlaza($plaza);
				$handler->setBasico($basico);
				$handler->setBasicoGC($basicoGC);
				$handler->setVigencia($vigencia);
				$handler->setCantCoord($cantCoord);

				$handler->insert(null);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}

		// Cambiar Objetivo por plaza
		// ============================

		public function cambiarObjetivo($idObj,$plaza,$basico,$basicoGC,$fechaDesde,$cantCoord){
			try {

				$handlerElim = new Objetivos;
				$handlerElim->setId($idObj);

				$handlerElim->delete(null);

				$handler = new Objetivos;				
				$handler->setPlaza($plaza);
				$handler->setBasico($basico);
				$handler->setBasicoGC($basicoGC);
				$handler->setVigencia($fechaDesde);
				$handler->setCantCoord($cantCoord);

				$handler->insert(null);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}	

		// Objetivos Actuales
		// ============================
		
		public function allGestCoor(){
			try {

				$handler = new ObjetivosGC;				
				$data = $handler->select();
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

		// Nuevo Objetivo por plaza
		// ============================

		public function nuevoGestCoor($id_gestor,$fechaInicio){
			try {

				$handler = new ObjetivosGC;
				$handler->setIdGestor(intval($id_gestor));
				$handler->setFechaInicio($fechaInicio);

				$handler->insert(null);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}

		// Nuevo Objetivo por plaza
		// ============================

		public function eliminarGestCoor($id){
			try {

				$handler = new ObjetivosGC;
				$handler->setId($id);

				$handler->delete(null);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}
	}
?>