<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";
		
	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'Entidades/kanban.class.php';
	include_once PATH_DATOS.'Entidades/kanban_historia.class.php';
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	include_once PATH_NEGOCIO."Funciones/Archivo/archivo.class.php"; 
	
	class HandlerKanban{

		public function selectSolicitudesByEstado($estado){
			try {
					
				$handler = new Kanban;
				$data= $handler->selectSolicitudesByEstado($estado);
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

		public function nuevaSolicitud($titulo,$descripcion,$fechaSol,$idSol,$prioridad,$plaza){
			try {
					
				$handler = new Kanban;
				$handler->setTitulo($titulo);     	
				$handler->setDescripcion($descripcion);
				$handler->setFechaSol($fechaSol);
				$handler->setIdSol($idSol);
				$handler->setPrioridad($prioridad);
				// $handler->setSector($sector);
				$handler->setPlaza($plaza);
				$handler->setEstado(true);
				
				$handler->insert(null);

				$last = $handler->getLastSolicitud();
				$f = new Fechas;
				$fechahora = $f->FechaHoraActual();

				$handlerHist = new KanbanHistoria;
				$handlerHist->setTitulo($last->getTitulo());     	
				$handlerHist->setDescripcion($last->getDescripcion());
				$handlerHist->setIdKanban($last->getId());
				$handlerHist->setIdOperador($last->getIdSol());
				// $handlerHist->setIdEnc(0);     	
				// $handlerHist->setInicioEst($last->getInicioEst());     	
				// $handlerHist->setFinEst($last->getFinEst());
				$handlerHist->setEstadoKb(0);
				$handlerHist->setPrioridad($last->getPrioridad());     	
				$handlerHist->setFechaHora($fechahora);     	
				// $handlerHist->setInicioReal($last->getInicioReal());     	
				// $handlerHist->setFinReal($last->getFinReal());
				// $handlerHist->setSector($last->getSector());
				$handlerHist->setTipoCambio(0);
				$handlerHist->setEstado(true);

				$handlerHist->insert(null);

				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
	}
