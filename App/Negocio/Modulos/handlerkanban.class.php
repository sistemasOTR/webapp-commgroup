<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";
		
	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'Entidades/kanban.class.php';
	include_once PATH_DATOS.'Entidades/kanban_historia.class.php';
	include_once PATH_DATOS.'Entidades/kanban_comentarios.class.php';
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
				$handlerHist->setIdEnc(0);
				$handlerHist->setFinEst('');
				$handlerHist->setEstadoKb(0);
				$handlerHist->setPrioridad($last->getPrioridad());     	
				$handlerHist->setFechaHora($fechahora);
				$handlerHist->setFinReal('');
				// $handlerHist->setSector($last->getSector());
				$handlerHist->setTipoCambio(0);
				$handlerHist->setEstado(true);

				$handlerHist->insert(null);

				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function asignarUsuario($id,$id_enc,$id_operador){
			try {
					
				$handler = new Kanban;

				$handler->updateEncargado(null,$id,$id_enc);

				$last = $handler->getSolById($id);
				$f = new Fechas;
				$fechahora = $f->FechaHoraActual();

				$handlerHist = new KanbanHistoria;
				$handlerHist->setTitulo($last->getTitulo());     	
				$handlerHist->setDescripcion($last->getDescripcion());
				$handlerHist->setIdKanban($id);
				$handlerHist->setIdOperador($id_operador);
				$handlerHist->setIdEnc($id_enc);
				$handlerHist->setFinEst($last->getFinEst()->format('Y-m-d'));
				$handlerHist->setEstadoKb($last->getEstadoKb());
				$handlerHist->setPrioridad($last->getPrioridad());     	
				$handlerHist->setFechaHora($fechahora);
				$handlerHist->setFinReal($last->getFinReal()->format('Y-m-d'));
				$handlerHist->setTipoCambio(2);
				$handlerHist->setEstado(true);

				$handlerHist->insert(null);

				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function asignarFechasEst($id,$fin_est,$id_operador){
			try {
					
				$handler = new Kanban;

				$handler->updateFechas(null,$id,$fin_est);

				$last = $handler->getSolById($id);
				$f = new Fechas;
				$fechahora = $f->FechaHoraActual();

				$handlerHist = new KanbanHistoria;
				$handlerHist->setTitulo($last->getTitulo());     	
				$handlerHist->setDescripcion($last->getDescripcion());
				$handlerHist->setIdKanban($id);
				$handlerHist->setIdOperador($id_operador);
				$handlerHist->setIdEnc($last->getIdEnc());
				$handlerHist->setFinEst($last->getFinEst()->format('Y-m-d'));
				$handlerHist->setEstadoKb($last->getEstadoKb());
				$handlerHist->setPrioridad($last->getPrioridad());     	
				$handlerHist->setFechaHora($fechahora);
				$handlerHist->setFinReal($last->getFinReal()->format('Y-m-d'));
				$handlerHist->setTipoCambio(3);
				$handlerHist->setEstado(true);

				// var_dump($handlerHist);
				// exit();

				$handlerHist->insert(null);

				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function cambiarEstadoKB($id,$estado,$id_operador){
			try {

				$f = new Fechas;
				$fechahora = $f->FechaHoraActual();
				$fechaFin = $f->FechaActual();

				$handler = new Kanban;
				if ($estado != 3) {
					$handler->cambiarEstadoKB(null,$id,$estado);
				} else {
					$handler->terminar(null,$id,$estado,$fechaFin);
				}

				$last = $handler->getSolById($id);
				$f = new Fechas;
				$fechahora = $f->FechaHoraActual();

				$handlerHist = new KanbanHistoria;
				$handlerHist->setTitulo($last->getTitulo());     	
				$handlerHist->setDescripcion($last->getDescripcion());
				$handlerHist->setIdKanban($id);
				$handlerHist->setIdOperador($id_operador);
				$handlerHist->setIdEnc($last->getIdEnc());
				$handlerHist->setFinEst($last->getFinEst()->format('Y-m-d'));
				$handlerHist->setEstadoKb($last->getEstadoKb());
				$handlerHist->setPrioridad($last->getPrioridad());     	
				$handlerHist->setFechaHora($fechahora);
				$handlerHist->setFinReal($last->getFinReal()->format('Y-m-d'));
				$handlerHist->setTipoCambio(1);
				$handlerHist->setEstado(true);

				// var_dump($handlerHist);
				// exit();

				$handlerHist->insert(null);

				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function selectById($id){
			try {
					
				$handler = new Kanban;

				$data = $handler->getSolById($id);
				return $data;
				

				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function selectHistoricoById($id){
			try {
					
				$handler = new KanbanHistoria;

				$data = $handler->selectHistoricoById($id);
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

		public function selectComentariosById($id){
			try {
					
				$handler = new KanbanComentarios;

				$data = $handler->selectComentariosById($id);
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

		public function nuevoComentario($comentario,$id_kanban,$id_operador){
			try {

				$f = new Fechas;
				$fechahora = $f->FechaHoraActual();

				$handlerComent = new KanbanComentarios;    	
				$handlerComent->setComentario($comentario);
				$handlerComent->setIdKanban($id_kanban);
				$handlerComent->setIdOperador($id_operador);	
				$handlerComent->setFechaHora($fechahora);
				$handlerComent->setEstado(true);

				$handlerComent->insert(null);

				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
	}
