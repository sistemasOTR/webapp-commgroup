<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";
		
	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'Entidades/kanban.class.php';
	include_once PATH_DATOS.'Entidades/kanban_historia.class.php';
	include_once PATH_DATOS.'Entidades/kanban_comentarios.class.php';
	include_once PATH_DATOS.'Entidades/kanban_notificaciones.class.php';
	include_once PATH_DATOS.'Entidades/usuario.class.php';
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	include_once PATH_NEGOCIO."Funciones/Archivo/archivo.class.php";
	include_once PATH_NEGOCIO."Funciones/Email/email.class.php";
	
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
				$handlerHist->setTipoCambio(0);
				$handlerHist->setEstado(true);

				$handlerHist->insert(null);

				$handlerNoti = new KanbanNotificaciones;

				$handlerNoti->setDescripcion('Se ha creado la solicitud "'.$last->getTitulo().'"');
				$handlerNoti->setIdKanban($last->getId());
				$handlerNoti->setIdUser(3);    	
				$handlerNoti->setFechaHora($fechahora);
				$handlerNoti->setEstado(true);

				$handlerNoti->insert(null);
				
				$handlerNoti->setIdUser(10082);

				$handlerNoti->insert(null);    	

				$handlerNoti->setIdUser(20174);

				$handlerNoti->insert(null); 

				$handlerUs = new Usuario;
				$handlerUs->setId($idSol);
				$usuario = $handlerUs->select();
				switch ($prioridad) {
					case 0:
						$desc_prior = 'BAJA';
						break;
					case 1:
						$desc_prior = 'MEDIA';
						break;
					case 2:
						$desc_prior = 'ALTA';
						break;
					
					default:
						$desc_prior = 'BAJA';
						break;
				}
				$correos[] = array('pablobruno@commgroup.com.ar','Pablo Bruno','');
				$correos[] = array('milton@commgroup.com.ar','Milton Ojeda','');
				
				$email = new Email;
				$dest = $correos;
				// var_dump($dest);
				// exit;
				$email->setDestinatario($dest);
				$email->setAsunto("Nueva solicitud");
				$email->setHtmlCuerpo('<p>Título: <b>'.$last->getTitulo().'</b> <a href="http://app.otrgroup.com.ar/index.php?view=kanban&id_sol='.$last->getId().'">[ver tarea]</a></p><p><small>Prioridad: '.$desc_prior.'</small><small style="padding-left:60px;">Solicitó: '.$usuario->getNombre()[0].'. '.$usuario->getApellido().'</small></p><p><small>Descripción:</small></p>'.$descripcion);
				$email->notificarKanban();
				
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

				$handlerUs = new Usuario;
				$handlerUs->setId($id_enc);
				$usuario = $handlerUs->select();


				$handlerNoti = new KanbanNotificaciones;

				$handlerNoti->setDescripcion('Se ha asignado la solicitud "'.$last->getTitulo().'" a '.strtoupper($usuario->getNombre()[0].'.'.$usuario->getApellido()));
				$handlerNoti->setIdKanban($last->getId());
				$handlerNoti->setIdUser(3);    	
				$handlerNoti->setFechaHora($fechahora);
				$handlerNoti->setEstado(true);

				$handlerNoti->insert(null);
				
				if ($id_enc != 10082) {

					$handlerNoti->setIdUser(10082);

					$handlerNoti->insert(null);    	
				}
				
				if ($id_enc != 20174) {

					$handlerNoti->setIdUser(20174);

					$handlerNoti->insert(null);
				}

				$handlerNoti->setIdUser($last->getIdSol());

				$handlerNoti->insert(null);

				$handlerNoti->setIdUser($id_enc);
				$handlerNoti->setDescripcion('Se te ha asignado la solicitud "'.$last->getTitulo().'"');

				$handlerNoti->insert(null);  
				
				
				$correos[] = array('pablobruno@commgroup.com.ar','Pablo Bruno','');
				$correos[] = array('milton@commgroup.com.ar','Milton Ojeda','');
				if ($last->getIdSol() != 10082 && $last->getIdSol() != 20174){
					$handlerUs->setId($last->getIdSol());
					$usuario = $handlerUs->select();
					$correos[] = array($usuario->getEmail(), $usuario->getNombre()." ".$usuario->getApellido(),"");
				}

				if ($id_enc != 10082 && $id_enc != 20174){
					$handlerUs->setId($id_enc);
					$usuario = $handlerUs->select();
					$correos[] = array($usuario->getEmail(), $usuario->getNombre()." ".$usuario->getApellido(),"");
				}

					$handlerUs->setId($id_enc);
					$usuario = $handlerUs->select();

					$email = new Email;
					$dest = $correos;
					// var_dump($dest);
					// exit;
					$email->setDestinatario($dest);
					$email->setAsunto("Asignación de solicitud");
					$email->setHtmlCuerpo('<p>Título: <b>'.$last->getTitulo().'</b> <a href="http://app.otrgroup.com.ar/index.php?view=kanban&id_sol='.$last->getId().'">[ver tarea]</a></p><p>La tarea fué asignada a '.$usuario->getNombre()[0].'. '.$usuario->getApellido().'</p>');
					$email->notificarKanban();
				

				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
		public function cambiarPrioridad($id,$prioridad,$id_operador){
			try {
					
				$handler = new Kanban;
				$handler->updatePrioridad(null,$id,$prioridad);

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
				$handlerHist->setTipoCambio(4);
				$handlerHist->setEstado(true);

				$handlerHist->insert(null);

				$handlerNoti = new KanbanNotificaciones;

				$handlerNoti->setDescripcion('Se ha cambiado la prioridad de la solicitud "'.$last->getTitulo().'"');
				$handlerNoti->setIdKanban($last->getId());
				$handlerNoti->setIdUser(3);    	
				$handlerNoti->setFechaHora($fechahora);
				$handlerNoti->setEstado(true);

				$handlerNoti->insert(null);    
				
				if ($last->getIdEnc() != 10082) {

					$handlerNoti->setIdUser(10082);

					$handlerNoti->insert(null);    	
				}
				
				if ($last->getIdEnc() != 20174) {

					$handlerNoti->setIdUser(20174);

					$handlerNoti->insert(null);
				}

				if ($last->getIdEnc() != 0) {

					$handlerNoti->setIdUser($last->getIdEnc());

					$handlerNoti->insert(null); 
				}

				$handlerNoti->setIdUser($last->getIdSol());

				$handlerNoti->insert(null);
				
				switch ($prioridad) {
					case 0:
						$desc_prior = 'BAJA';
						break;
					case 1:
						$desc_prior = 'MEDIA';
						break;
					case 2:
						$desc_prior = 'ALTA';
						break;
					
					default:
						$desc_prior = 'BAJA';
						break;
				}

				$correos[] = array('pablobruno@commgroup.com.ar','Pablo Bruno','');
				$correos[] = array('milton@commgroup.com.ar','Milton Ojeda','');
				$handlerUs = new Usuario;
				if ($last->getIdSol() != 10082 && $last->getIdSol() != 20174){
					$handlerUs->setId($last->getIdSol());
					$usuario = $handlerUs->select();
					$correos[] = array($usuario->getEmail(), $usuario->getNombre()." ".$usuario->getApellido(),"");
				}

				if ($last->getIdEnc() != 10082 && $last->getIdEnc() != 20174){
					$handlerUs->setId($last->getIdEnc());
					$usuario = $handlerUs->select();
					$correos[] = array($usuario->getEmail(), $usuario->getNombre()." ".$usuario->getApellido(),"");
				}

					$email = new Email;
					$dest = $correos;
					// var_dump($dest);
					// exit;
					$email->setDestinatario($dest);
					$email->setAsunto("Cambio de prioridad");
					$email->setHtmlCuerpo('<p>Título: <b>'.$last->getTitulo().'</b> <a href="http://app.otrgroup.com.ar/index.php?view=kanban&id_sol='.$last->getId().'">[ver tarea]</a></p><p>La prioridad de tarea fué cambiada a '.$desc_prior.'</p>');
					$email->notificarKanban();

				
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

				$handlerHist->insert(null);

				$handlerNoti = new KanbanNotificaciones;

				$handlerNoti->setDescripcion('Se ha asignado una fecha límite a la solicitud "'.$last->getTitulo().'"');
				$handlerNoti->setIdKanban($last->getId());
				$handlerNoti->setIdUser(3);    	
				$handlerNoti->setFechaHora($fechahora);
				$handlerNoti->setEstado(true);

				$handlerNoti->insert(null);    
				
				if ($last->getIdEnc() != 10082) {

					$handlerNoti->setIdUser(10082);

					$handlerNoti->insert(null);    	
				}
				
				if ($last->getIdEnc() != 20174) {

					$handlerNoti->setIdUser(20174);

					$handlerNoti->insert(null);
				}

				if ($last->getIdEnc() != 0) {

					$handlerNoti->setIdUser($last->getIdEnc());

					$handlerNoti->insert(null); 
				}

				$handlerNoti->setIdUser($last->getIdSol());

				$handlerNoti->insert(null);

				$correos[] = array('pablobruno@commgroup.com.ar','Pablo Bruno','');
				$correos[] = array('milton@commgroup.com.ar','Milton Ojeda','');
				$handlerUs = new Usuario;
				if ($last->getIdSol() != 10082 && $last->getIdSol() != 20174){
					$handlerUs->setId($last->getIdSol());
					$usuario = $handlerUs->select();
					$correos[] = array($usuario->getEmail(), $usuario->getNombre()." ".$usuario->getApellido(),"");
				}

				if ($last->getIdEnc() != 10082 && $last->getIdEnc() != 20174 && $last->getIdEnc() != 0){
					$handlerUs->setId($last->getIdEnc());
					$usuario = $handlerUs->select();
					$correos[] = array($usuario->getEmail(), $usuario->getNombre()." ".$usuario->getApellido(),"");
				}

					$email = new Email;
					$dest = $correos;
					// var_dump($dest);
					// exit;
					$email->setDestinatario($dest);
					$email->setAsunto("Asignación de fecha de entrega");
					$email->setHtmlCuerpo('<p>Título: <b>'.$last->getTitulo().'</b> <a href="http://app.otrgroup.com.ar/index.php?view=kanban&id_sol='.$last->getId().'">[ver tarea]</a></p><p>Se ha programado la fecha de entrega para el '.$last->getFinEst()->format('d-m-Y').'</p>');
					$email->notificarKanban();

				
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

				$handlerHist->insert(null);

				$handlerNoti = new KanbanNotificaciones;

				if ($estado != 3) {
					$handlerNoti->setDescripcion('Se ha cambiado el estado de la solicitud "'.$last->getTitulo().'"');
					$link='http://app.otrgroup.com.ar/index.php?view=kanban&id_sol='.$last->getId();
				} else {
					$handlerNoti->setDescripcion('Se ha finalizado la solicitud "'.$last->getTitulo().'"');
					$link='http://app.otrgroup.com.ar/index.php?view=kanban_terminadas&id_sol='.$last->getId();
				}

				if ($estado != 10) {
					$handlerNoti->setIdKanban($last->getId());
					$handlerNoti->setIdUser(3);    	
					$handlerNoti->setFechaHora($fechahora);
					$handlerNoti->setEstado(true);
	
					$handlerNoti->insert(null);
					
					if ($last->getIdEnc() != 10082) {
	
						$handlerNoti->setIdUser(10082);
	
						$handlerNoti->insert(null);    	
					}
					
					if ($last->getIdEnc() != 20174) {
	
						$handlerNoti->setIdUser(20174);
	
						$handlerNoti->insert(null);
					}
	
					if ($last->getIdEnc() != 0) {
	
						$handlerNoti->setIdUser($last->getIdEnc());
	
						$handlerNoti->insert(null); 
					}
	
					$handlerNoti->setIdUser($last->getIdSol());
	
					$handlerNoti->insert(null);
					switch ($estado) {
						case 1:
							$desc_estado = 'EN CURSO';
							break;
						case 2:
							$desc_estado = 'A REVISIÓN';
							break;
						case 3:
							$desc_estado = 'TERMINADA';
							break;
						
						default:
							$desc_estado = 'EN CURSO';
							break;
					}

					$correos[] = array('pablobruno@commgroup.com.ar','Pablo Bruno','');
					$correos[] = array('milton@commgroup.com.ar','Milton Ojeda','');
					$handlerUs = new Usuario;
					if ($last->getIdSol() != 10082 && $last->getIdSol() != 20174){
						$handlerUs->setId($last->getIdSol());
						$usuario = $handlerUs->select();
						$correos[] = array($usuario->getEmail(), $usuario->getNombre()." ".$usuario->getApellido(),"");
					}

					if ($last->getIdEnc() != 10082 && $last->getIdEnc() != 20174 && $last->getIdEnc() != 0){
						$handlerUs->setId($last->getIdEnc());
						$usuario = $handlerUs->select();
						$correos[] = array($usuario->getEmail(), $usuario->getNombre()." ".$usuario->getApellido(),"");
					}

						$email = new Email;
						$dest = $correos;
						// var_dump($dest);
						// exit;
						$email->setDestinatario($dest);
						$email->setAsunto("Cambio de estado de una tarea");
						$email->setHtmlCuerpo('<p>Título: <b>'.$last->getTitulo().'</b> <a href="'.$link.'">[ver tarea]</a></p><p>Se colocó la tarea en '.$desc_estado.'</p>');
						$email->notificarKanban();
				}

				

				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function editDescKanban($id,$desc,$id_operador){
			try {

				$f = new Fechas;
				$fechahora = $f->FechaHoraActual();
				$fechaFin = $f->FechaActual();

				$handler = new Kanban;
				$handler->editDescKanban($id,$desc);

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
				$handlerHist->setTipoCambio(4);
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

		public function selectNotificacionesByUser($id_user){
			try {
					
				$handler = new KanbanNotificaciones;

				$data = $handler->selectNotificacionesByUser($id_user);
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

		public function borrarNotificacion($id){
			try {
					
				$handler = new KanbanNotificaciones;

				$handler->setId($id);
				$handler->delete(false);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

	}
