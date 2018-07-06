<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";
		
	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'BaseDatos/sql.class.php';
	
	include_once PATH_DATOS.'Entidades/expediciones.class.php';
	include_once PATH_DATOS.'Entidades/expedicionescompras.class.php';
    include_once PATH_DATOS.'Entidades/expedicionesenvios.class.php';
	include_once PATH_DATOS.'Entidades/expedicionestipo.class.php';
	include_once PATH_DATOS.'Entidades/expedicionesestados.class.php';
	include_once PATH_DATOS.'Entidades/expedicionesitem.class.php';

	include_once PATH_NEGOCIO.'Sistema/handlerconsultascontrol.class.php';

	include_once PATH_NEGOCIO.'Notificaciones/handlernotificaciones.class.php';

	include_once PATH_NEGOCIO.'Sistema/handlersistema.class.php';

	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 	
	
	class HandlerExpediciones{	

		public function cargarEnvios($id,$fecha,$cantidad_env,$user){
			try {
				$handler = new ExpedicionesEnvios;
                $handler->setIdPedido($id);
                $handler->setFecha($fecha);
                $handler->setCantidad(intval($cantidad_env));           
                $handler->setUsuario($user);           
              //  $handler->setUsuario($user);           
                // var_dump($handler);
                // exit();
				 $handler->insert(false);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		public function selecionarEnvios($id){
			try {
				$handler = new ExpedicionesEnvios;
				$data = $handler->selectByIdPedido($id);
				// var_dump($data);
				// exit();
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

		public function selecionarItem(){
			try {
				$handler = new ExpedicionesItem;								

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

		public function selecionarApedir(){
			try {
				$handler = new ExpedicionesItem;								

				$data = $handler->selectApedir();
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

		public function selecionarTipo(){
			try {
				$handler = new ExpedicionesTipo;								

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

		public function selecionarEstados(){
			try {
				$handler = new ExpedicionesEstados;								

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

		public function seleccionarByFiltros($fdesde, $fhasta, $tipo_expe, $estados_expe, $fplaza){

				try {
					
				$handler = new HandlerConsultasControl;

				$data = $handler->seleccionarExpedicionesByFiltros($fdesde, $fhasta, $tipo_expe, $estados_expe, $fplaza);

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

		public function seleccionarComprasByFiltros($fdesde, $fhasta, $tipo_expe, $estados_expe){
			

			try {
				$handler = new HandlerConsultasControl;

				$data = $handler->seleccionarComprasByFiltros($fdesde, $fhasta,$tipo_expe,$estados_expe);

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

		public function guardarItemExpedicion($fecha,$usuario,$detalle,$observaciones,$item,$cant,$estados,$entregada,$plaza){
			try {

				$handler = new Expediciones;
				$h_estados = new ExpedicionesEstados;

				$estados = $h_estados->getPendiente()->getId();
				$observaciones = " ";				

				$handler->setItemExpediciones(intval($item));
				$handler->setEstadosExpediciones(intval($estados));
				$handler->setEntregada($entregada);
				$handler->setUsuarioId(intval($usuario));
				$handler->setFecha($fecha);
				$handler->setCantidad(intval($cant));
				$handler->setDetalle($detalle);
				$handler->setObservaciones($observaciones);
				$handler->setPlaza($plaza);
				$handler->setSinPublicar(true);
				$handler->setEstado(true);
                
				$handler->insert(false);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}
		}

		public function agregarCompra($id,$usuario,$cantidad,$fecha){
			try {

				$handler = new ExpedicionesCompras;	
				$handler->setItemExpediciones($id);
				$handler->setFecha($fecha);
				$handler->setCantidad($cantidad);
				$handler->setUsuarioPidio($usuario);
				$handler->setUsuarioRecibio(0);
				$handler->setSinPedir(true);
				$handler->setEstado(true);
				$handler->setRecibido(false);
				$handler->setFechaRecibido('');
                
				$handler->insert(false);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}
		}

		public function eliminarItemExpedicion($id){
			try {

				$handler = new Expediciones;
				$handler->setId($id);
				$handler->select();

				$handler->delete(false);				
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}
		}
		public function eliminarItemCompra($id){
			try {

				$handler = new ExpedicionesCompras;
				$handler->setId($id);
			  //$handler->select();

				$handler->delete(false);				
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}
		}

		public function publicarItems($id_usuario)
		{
			try {			
				$datos = $this->seleccionarSinPublicar($id_usuario);

				if(!empty($datos)){

					if(count($datos)<=1)
	                  $consulta_tmp[0]=$datos;
	                else
	                  $consulta_tmp=$datos;

                 

					foreach ($consulta_tmp as $key => $value) {
						 
						$exp = new Expediciones;
						$exp->setId($value->getId());
						$exp = $exp->select();

						$exp->setItemExpediciones($exp->getItemExpediciones()->getId());
						$exp->setEstadosExpediciones($exp->getEstadosExpediciones()->getId());
						$exp->setEntregada($exp->getEntregada()->getId()); 
						$exp->setPlaza($exp->getPlaza()->getId());
						$exp->setUsuarioId($exp->getUsuarioId()->getId());
						$exp->setFecha($exp->getFecha()->format('Y-m-d'));						
						$exp->setSinPublicar(false);
						
						$exp->update(false);
					}

					//####################
					//## NOTIFICACIONES ##
					$u = new Usuario;
					$u->setId($id_usuario);
					$u = $u->select();				

					$alias = $u->getAliasUserSistema();

					$hanlder_sistema = new HandlerSistema;
					$arrDatos = $hanlder_sistema->getPlazaByCordinador($alias);
					$plaza = $arrDatos[0]->PLAZA;

					$origen = "EXPEDICION [solicitud]";
					$detalle = "<b>".$u->getNombre()."</b> envió una nueva solicitud de stock";

					$n_handler = new HandlerNotificaciones;				
					$n_handler->guardarNotificacion($id_usuario,$origen,$detalle,0,$plaza);

				}

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}
		}
			public function publicacionItems($id_usuario)
		{
			try {			
				$datos = $this->seleccionarSinPublicar($id_usuario);

				if(!empty($datos)){

					if(count($datos)<=1)
	                  $consulta_tmp[0]=$datos;
	                else
	                  $consulta_tmp=$datos;


                 

					foreach ($consulta_tmp as $key => $value) {
						$id_sol = $value->getId();
                            $handler= new Expediciones;
                            $handler->updateNuevo($id_sol);
                            

							}

					//####################
					//## NOTIFICACIONES ##
					$u = new Usuario;
					$u->setId($id_usuario);
					$u = $u->select();				

					$alias = $u->getAliasUserSistema();

					$hanlder_sistema = new HandlerSistema;
					$arrDatos = $hanlder_sistema->getPlazaByCordinador($alias);
					$plaza = $arrDatos[0]->PLAZA;

					$origen = "EXPEDICION [solicitud]";
					$detalle = "<b>".$u->getNombre()."</b> envió una nueva solicitud de stock";

					$n_handler = new HandlerNotificaciones;				
					$n_handler->guardarNotificacion($id_usuario,$origen,$detalle,0,$plaza);

				}

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}
		}

   public function publicarItemCompra($id_usuario)
		{
			try {			
				$datos = $this->seleccionarSinPedir($id_usuario);

				if(!empty($datos)){

					if(count($datos)<=1)
	                  $consulta_tmp[0]=$datos;
	                else
	                  $consulta_tmp=$datos;


                 

					foreach ($consulta_tmp as $key => $value) {
						$id_sol = $value->getId();
                            $handler= new ExpedicionesCompras;
                            $handler->updateCompra($id_sol);
                            

							}

					//####################
					//## NOTIFICACIONES ##
					$u = new Usuario;
					$u->setId($id_usuario);
					$u = $u->select();				

					$alias = $u->getAliasUserSistema();

					$hanlder_sistema = new HandlerSistema;
					$arrDatos = $hanlder_sistema->getPlazaByCordinador($alias);
					$plaza = $arrDatos[0]->PLAZA;

					$origen = "EXPEDICION [solicitud]";
					$detalle = "<b>".$u->getNombre()."</b> envió una nueva solicitud de stock";

					$n_handler = new HandlerNotificaciones;				
					$n_handler->guardarNotificacion($id_usuario,$origen,$detalle,0,$plaza);

				}

			} catch (Exception $e) {
				throw new Exception($e->getMessage());		
			}
		}

		public function guardarExpedicion($fecha,$usuario,$detalle,$observaciones,$tipo,$cant,$estados){
			try {

				$handler = new Expediciones;
				$h_estados = new ExpedicionesEstados;

				$estados = $h_estados->getPendiente()->getId();
				$observaciones = "";				

				$handler->setItemExpediciones($tipo);
				$handler->setEstadosExpediciones($estados);
				$handler->setUsuarioId($usuario);
				$handler->setFecha($fecha);
				$handler->setCantidad($cant);
				$handler->setDetalle($detalle);
				$handler->setObservaciones($observaciones);

				$handler->insert(false);

				//####################
				//## NOTIFICACIONES ##
				$u = new Usuario;
				$u->setId($usuario);
				$u = $u->select();				

				$alias = $u->getAliasUserSistema();

				$hanlder_sistema = new HandlerSistema;
				$arrDatos = $hanlder_sistema->getPlazaByCordinador($alias);
				$plaza = $arrDatos[0]->PLAZA;

				$origen = "EXPEDICION [solicitud]";
				$detalle = "<b>".$u->getNombre()."</b> envió una nueva solicitud de stock";

				$n_handler = new HandlerNotificaciones;				
				$n_handler->guardarNotificacion($usuario,$origen,$detalle,0,$plaza);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}
		}

		public function cambiarEstadoExpedicion($id,$estados,$observaciones){
			try {			

				$handler = new Expediciones;
				$handler->setId($id);
				$handler = $handler->select();	

				$usuario = $handler->getUsuarioId()->getId();
				$tipo_expedicion = $handler->getItemExpediciones()->getNombre();

				if($estados == $handler->getEstadosExpediciones()->getId())
					throw new Exception("El estado nuevo tiene que ser distinto al estado actual.");
					

				$handler->setFecha($handler->getFecha()->format('Y-m-d'));				
				$handler->setItemExpediciones($handler->getItemExpediciones()->getId());				
				$handler->setUsuarioId($handler->getUsuarioId()->getId());				

				$handler->setEstadosExpediciones($estados);				

				$text_obs=$observaciones." || ".$handler->getObservaciones();
				$handler->setObservaciones($text_obs);

				$handler->update(false);

				//####################
				//## NOTIFICACIONES ##
				//####################
				$u = new Usuario;
				$u->setId($usuario);
				$u = $u->select();

				$alias = $u->getAliasUserSistema();

				$hanlder_sistema = new HandlerSistema;
				$arrDatos = $hanlder_sistema->getPlazaByCordinador($alias);
				$plaza = $arrDatos[0]->PLAZA;

				$origen = "EXPEDICION [cambio estado]";
				$detalle = "Se modificó el estado del registro ".$tipo_expedicion;

				$n_handler = new HandlerNotificaciones;				
				$n_handler->guardarNotificacion($usuario,$origen,$detalle,0,$plaza);

			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		public function modificarEstadoExpedicion($id,$estado,$observaciones,$cantidad_env){
			try {			

				$handler = new Expediciones;
				//$handler->setId($id);
				//$handler->setObservaciones($observaciones);
				$handler->updateEstado($id,$estado,$observaciones,$cantidad_env);	
				/*echo "<pre>";
				var_dump($handler);
				echo "</pre>";
				exit();

				$usuario = $handler->getUsuarioId()->getId();
				$tipo_expedicion = $handler->getItemExpediciones()->getNombre();

				if($estados == $handler->getEstadosExpediciones()->getId())
					throw new Exception("El estado nuevo tiene que ser distinto al estado actual."); 

				//####################
				//## NOTIFICACIONES ##
				//####################
				$u = new Usuario;
				$u->setId($usuario);
				$u = $u->select();

				$alias = $u->getAliasUserSistema();

				$hanlder_sistema = new HandlerSistema;
				$arrDatos = $hanlder_sistema->getPlazaByCordinador($alias);
				$plaza = $arrDatos[0]->PLAZA;

				$origen = "EXPEDICION [cambio estado]";
				$detalle = "Se modificó el estado del registro ".$tipo_expedicion;

				$n_handler = new HandlerNotificaciones;				
				$n_handler->guardarNotificacion($usuario,$origen,$detalle,0,$plaza); */

			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}

		public function guardarTipoABM($nombre,$id,$accion){
			try {

				if($accion=="editar"){
					$handler = new ExpedicionesTipo;
					$handler2 = new ExpedicionesTipo;

					$handler->setId($id);	
				    $handler->setGrupo($nombre);							
					$handler->update(false);

					
				}
				if($accion=="nuevo")
				{
					$handler = new ExpedicionesTipo;

					$handler->setGrupo($nombre);
					$handler->insert(false);
				}
				
						
			} catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}
		}

        public function guardarItemABM($nombre,$descripcion,$id,$grupo,$estado){
			try {

				if($estado=="editar"){
					$handler = new ExpedicionesItem;

					$handler->setId($id);	
				    $handler->setNombre($nombre);							
				    $handler->setDescripcion($descripcion);							
				    $handler->setGruponum($grupo);		

					$handler->update(false);

					
				}
				if($estado=="nuevo")
				{
					$handler = new ExpedicionesItem;

					$handler->setNombre($nombre);
					$handler->setDescripcion($descripcion);	
					$handler->setGruponum($grupo);	

					$handler->insert(false);
				}
				
						
			} catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}
		}
		public function eliminarTipoABM($id){
                  try {
               
					$handler = new ExpedicionesTipo;

					$handler->setId($id);
					$handler->delete(false);
				
                  } catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}


		}	
		public function eliminarItemABM($id){
                  try {
               
					$handler = new ExpedicionesItem;

					$handler->setId($id);
					$handler->delete(false);
				
                  } catch (Exception $e) {
				throw new Exception($e->getMessage());					
			}


		}	
 
		public function seleccionarSinPublicar($usuario){
			try {
					
				$handler = new Expediciones;

				$data = $handler->seleccionarSinPublicar($usuario);

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

		public function seleccionarSinPedir($usuario){
			try {
					
				$handler = new ExpedicionesCompras;

				$data = $handler->seleccionarSinPedir($usuario);

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


		public function selectById($item)
		{
			try {
					
				$handler = new ExpedicionesItem;

				$result = $handler->selectById($item);

				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}


		public function selectEstado($id_estado)
		{
			try {
					
				$handler = new ExpedicionesEstados;
				$handler->setId($id_estado);

				$result = $handler->select();

				return $result;

			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}

		public function rechazadoExpedicion($id,$observaciones){
			try {			

				$handler = new Expediciones;
		
				$handler->updateRechazado($id,$observaciones);


		} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		public function canceladoExpedicion($id,$observaciones){
			try {			

				$handler = new Expediciones;
		
				$handler->updateCancelado($id,$observaciones);


		} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		public function modificarRecibido($id,$estado){
			try {			

				$handler = new Expediciones;
		
				$handler->updateRecibido($id,$estado);


		} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		public function modificarStock($iditem,$actualizarstock,$apedir){
			try {			

				$handler = new ExpedicionesItem;

				$handler->updateStock($iditem,$actualizarstock,$apedir);


		} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		public function modificarCompraRecibida($id,$recibido,$usuario,$fecha){
			try {			

				$handler = new ExpedicionesCompras;
		
				$handler->updateCompraRecibida($id,$recibido,$usuario,$fecha);


		} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		public function pendientes(){
			try {			

				$handler = new Expediciones;
		
				$data = $handler->pendientes();
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

		public function recParciales(){
			try {			

				$handler = new Expediciones;
		
				$data = $handler->recParciales();
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

		public function entregados($userPlaza){
			try {			

				$handler = new Expediciones;
		
				$data = $handler->entregados($userPlaza);
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

		public function entParciales($userPlaza){
			try {			

				$handler = new Expediciones;
		
				$data = $handler->entParciales($userPlaza);
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


