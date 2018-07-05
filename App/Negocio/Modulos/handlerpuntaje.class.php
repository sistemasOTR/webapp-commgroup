<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";
		
	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	
	include_once PATH_DATOS.'Entidades/empresapuntaje.class.php';
	include_once PATH_DATOS.'Entidades/gestorobjetivo.class.php';
	include_once PATH_DATOS.'Entidades/coordinadorobjetivo.class.php';
	include_once PATH_DATOS.'Entidades/supervisorobjetivo.class.php';

	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	include_once PATH_NEGOCIO."Funciones/Archivo/archivo.class.php"; 
	
	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
	include_once PATH_NEGOCIO."Sistema/HandlerSupervisor.class.php";

	class HandlerPuntaje{		

		//#############
		// EMPRESA
		//#############
		public function buscarPuntaje($empresa_id){
			try {

				$handler = new EmpresaPuntaje;				
				$handler->setIdEmpresaSistema($empresa_id);
				$objPuntaje = $handler->select();																

				if(!empty($objPuntaje))				
					return $objPuntaje->getPuntaje();
				else
					return 0;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}
		public function buscarPuntajeFecha($empresa_id,$fechaOperacion){
			try {

				$handler = new EmpresaPuntaje;				
				$objPuntaje = $handler->buscarPuntajeFecha($empresa_id,$fechaOperacion);


				if(!empty($objPuntaje))				
					return $objPuntaje->getPuntaje();
				else
					return 0;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}
		public function buscarFechaPuntaje(){
			try {

				$handler = new EmpresaPuntaje;				
				$objPuntaje = $handler->selectActual();
				
				if(!empty($objPuntaje))				
					return $objPuntaje[0]->getFechaDesde();
				else
					return 0;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}
		public function guardarPuntajeByEmpresa($datos,$fechaCambioVigencia){
			try {
				
				$handler = new EmpresaPuntaje;				
				$handler->deBaja(null,$fechaCambioVigencia);

				foreach ($datos as $key => $value) {

					$handler1 = new EmpresaPuntaje;				

					if(!empty($value["puntaje"])){

						$handler1->setIdEmpresaSistema($value["empresa"]);
						$handler1->setPuntaje($value["puntaje"]);
						$handler1->setFechaDesde($fechaCambioVigencia);
						$handler1->insert(null);
						
					}											

				}
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
		public function existeConfiguracionPuntaje($empresa_id,$puntaje){
			try {
				
				$handler = new EmpresaPuntaje;
				$handler->setIdEmpresaSistema($empresa_id);
				$handler->setPuntaje($puntaje);

				$u=$handler->existePuntaje();

				if(!is_object($u))
					return false;
				else
					return true;


			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}		

		//#############
		// GESTOR
		//#############
		public function buscarObjetivo($gestor_id){
			try {

				$handler = new GestorObjetivo;				
				$handler->setIdGestorSistema($gestor_id);
				$objObjetivo = $handler->select();																

				if(!empty($objObjetivo))				
					return $objObjetivo->getObjetivo();
				else
					return 0;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}
		public function guardarObjetivoByGestor($datos){
			try {

				$handler = new GestorObjetivo;				
				$handler->limpiarTabla(null);

				foreach ($datos as $key => $value) {

					$handler1 = new GestorObjetivo;				

					if(!empty($value["objetivo"])){

						$handler1->setIdGestorSistema($value["gestor"]);
						$handler1->setObjetivo($value["objetivo"]);
				
						if($this->existeConfiguracionObjetio($handler1->getIdGestorSistema(),$handler1->getObjetivo())){								
							$handler1->update(null);
						}
						else{
							$handler1->insert(null);
						}	

					}											

				}
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}			

		public function existeConfiguracionObjetio($gestor_id,$objetivo){
			try {
				
				$handler = new GestorObjetivo;
				$handler->setIdGestorSistema($gestor_id);
				$handler->setObjetivo($objetivo);

				$u=$handler->existeObjetivo();

				if(!is_object($u))
					return false;
				else
					return true;


			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}		

		//#############
		// COORDINADOR
		//#############
		public function buscarObjetivoCoordinador($coordinador_alias){
			try {

				$handler = new CoordinadorObjetivo;				
				$handler->setIdCoordinadorSistema($coordinador_alias);
				$objObjetivo = $handler->select();																				

				if(!empty($objObjetivo))				
					return $objObjetivo->getObjetivo();
				else
					return 0;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}

		public function guardarObjetivoByCoordinador($datos){
			try {

				$handler = new CoordinadorObjetivo;				
				$handler->limpiarTabla(null);

				foreach ($datos as $key => $value) {

					$handler1 = new CoordinadorObjetivo;				

					if(!empty($value["objetivo"])){

						$handler1->setIdCoordinadorSistema($value["coordinador"]);
						$handler1->setObjetivo($value["objetivo"]);
				
						if($this->existeConfiguracionObjetioCoordinador($handler1->getIdCoordinadorSistema(),$handler1->getObjetivo())){								
							$handler1->update(null);
						}
						else{
							$handler1->insert(null);
						}	

					}											

				}
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}		

		public function existeConfiguracionObjetioCoordinador($coordinador_id,$objetivo){
			try {
				
				$handler = new CoordinadorObjetivo;
				$handler->setIdCoordinadorSistema($coordinador_id);
				$handler->setObjetivo($objetivo);

				$u=$handler->existeObjetivo();

				if(!is_object($u))
					return false;
				else
					return true;


			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}		

		public function obtenerPuntajeCoordinador($coordinador_alias){
			try {
			
				$handler = new HandlerSistema;
				$arrGestores = $handler->selectAllGestor($coordinador_alias);

				$total_objetivo = 0;
				if(!empty($arrGestores)){
					foreach ($arrGestores as $key => $value) {
					
						$gestorObj = new GestorObjetivo;
						$gestorObj->setIdGestorSistema($value->GESTOR11_CODIGO);
						$obj = $gestorObj->select();

						if(!empty($obj))
							$total_objetivo = $total_objetivo + $obj->getObjetivo();
					}
				}

				return $total_objetivo;		

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}
		//#############
		// SUPERVISOR
		//#############
		public function buscarObjetivoSupervisor($supervisor_id){
			try {

				$handler = new SupervisorObjetivo;				
				$handler->setIdSupervisorSistema($supervisor_id);
				$objObjetivo = $handler->select();																				

				if(!empty($objObjetivo))				
					return $objObjetivo->getObjetivo();
				else
					return 0;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}

		public function guardarObjetivoBySupervisor($datos){
			try {

				$handler = new SupervisorObjetivo;				
				$handler->limpiarTabla(null);

				foreach ($datos as $key => $value) {

					$handler1 = new SupervisorObjetivo;				

					if(!empty($value["objetivo"])){

						$handler1->setIdSupervisorSistema($value["supervisor"]);
						$handler1->setObjetivo($value["objetivo"]);
				
						if($this->existeConfiguracionObjetioSupervisor($handler1->getIdSupervisorSistema(),$handler1->getObjetivo())){								
							$handler1->update(null);
						}
						else{
							$handler1->insert(null);
						}	

					}											

				}
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}		

		public function existeConfiguracionObjetioSupervisor($supervisor_id,$objetivo){
			try {
				
				$handler = new CoordinadorObjetivo;
				$handler->setIdCoordinadorSistema($coordinador_id);
				$handler->setObjetivo($objetivo);

				$u=$handler->existeObjetivo();

				if(!is_object($u))
					return false;
				else
					return true;


			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}	

		public function obtenerPuntajeSupervisor($supervisor_id){
			try {
			
				$handler = new HandlerSupervisor;
				$arrPlazas = $handler->selectPlazasBySupervisorId($supervisor_id);
				
				$total_objetivo = 0;
				if(!empty($arrPlazas)){
					foreach ($arrPlazas as $key => $value) {
					
						$coorObj = new CoordinadorObjetivo;
						$coorObj->setIdCoordinadorSistema($value["alias"]);
						$obj = $coorObj->select();

						if(!empty($obj))
							$total_objetivo = $total_objetivo + $obj->getObjetivo();
					}
				}

				return $total_objetivo;		
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}	

		//#############
		// GERENCIA
		//#############
		public function obtenerPuntajeGerencia(){
			try {
			
				$handler = new HandlerSupervisor;
				$arrSupervisor = $handler->selectAllSupervisor();
				
				$total_objetivo = 0;
				if(!empty($arrSupervisor)){
					foreach ($arrSupervisor as $key => $value) {
					
						$superObj = new SupervisorObjetivo;
						$superObj->setIdSupervisorSistema($value["id"]);
						$obj = $superObj->select();

						if(!empty($obj))
							$total_objetivo = $total_objetivo + $obj->getObjetivo();
					}
				}

				return $total_objetivo;		
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());	
			}
		}									
	}