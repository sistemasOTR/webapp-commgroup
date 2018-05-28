<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";
		
	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'Entidades/asoc_lineas.class.php';
	include_once PATH_DATOS.'Entidades/equipos.class.php';
	include_once PATH_DATOS.'Entidades/lineas.class.php';
	//include_once PATH_DATOS.'Entidades/consumos_mes.class.php';
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	
	class HandlerCelulares{
				
		public function getLineasEntregadas(){
			try {
				$handlerLinea = new LineaUsuario;								
				$data = $handlerLinea->getLineasEntregadas();
				
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
		public function getLineaEntregada($entId){
			try {
				$handlerLinea = new LineaUsuario;								
				$data = $handlerLinea->getLineaEntregada($entId);
				
				if(count($data)==0){
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
				
		public function getLineasLibres(){
			try {
				$handlerLinea = new Lineas;								
				$data = $handlerLinea->getLineasLibres();
				
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
				
		public function getEquiposLibres(){
			try {
				$handlerLinea = new Equipos;
				$data = $handlerLinea->getEquiposLibres();
				
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
		
		public function getEquipoLinea($IMEI){
			try {
				$handlerEquipo = new Equipos;								
				$data = $handlerEquipo->getEquipoLinea($IMEI);
				
				if(count($data)==0){
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
		
		public function getUsuarioLinea($asocUs){
			try {
				$handlerEquipo = new LineaUsuario;								
				$data = $handlerEquipo->getUsuarioLinea($asocUs);
				
				if(count($data)==0){
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
		
		public function getEntrega($nroLinea){
			try {
				$handlerEquipo = new LineaUsuario;								
				$data = $handlerEquipo->getEntrega($nroLinea);
				
				if(count($data)==0){
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
		
		public function getHistEntregas($nroLinea){
			try {
				$handlerEquipo = new LineaUsuario;								
				$data = $handlerEquipo->getHistEntregas($nroLinea);
				
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
		
		public function getHistEntregasXIMEI($IMEI){
			try {
				$handlerEquipo = new LineaUsuario;								
				$data = $handlerEquipo->getHistEntregasXIMEI($IMEI);
				
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
		
		public function entregar($fechaEntrega,$nroLinea,$equipo,$usuarioId,$obs){
			try {
				$handlerEntrega = new LineaUsuario;
				$handlerLinea = new Lineas;
				$handlerEquipo = new Equipos;

				$handlerEntrega->setNroLinea($nroLinea);
				$handlerEntrega->setIMEI($equipo);
				$handlerEntrega->setFechaEntrega($fechaEntrega);
				$handlerEntrega->setUsId($usuarioId);
				$handlerEntrega->setObsEntrega($obs);

				$handlerLinea->setNroLinea($nroLinea);
				$handlerLinea->entregada(false);
				if ($equipo!='') {
					$handlerEquipo->setIMEI($equipo);
					$handlerEquipo->entregado(false);
				}
				
				$handlerEntrega->insert(false);


			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		
		public function devolverLinea($entId,$fechaDev,$devNroLinea,$devIMEI,$obs){
			try {
				$handlerEntrega = new LineaUsuario;
				$handlerLinea = new Lineas;
				$handlerEquipo = new Equipos;

				$handlerEntrega->setEntId($entId);
				$handlerEntrega->setFechaDev($fechaDev);
				$handlerEntrega->setObsDev($obs);

				$handlerLinea->setNroLinea($devNroLinea);
				$handlerLinea->devolver(false);
				if ($devIMEI!='') {
					$handlerEquipo->setIMEI($devIMEI);
					$handlerEquipo->devolver(false);
				}
				
				$handlerEntrega->devolver(false);


			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		
		public function nuevaLinea($fechaAlta,$nroLinea,$empresa,$plan,$costo,$consumo,$obs){
			try {
				$handlerLinea = new Lineas;

				$handlerLinea->setNroLinea($nroLinea);
				$handlerLinea->setFechaAlta($fechaAlta);
				$handlerLinea->setEmpresa($empresa);
				$handlerLinea->setNombrePlan($plan);
				$handlerLinea->setCosto($costo);
				$handlerLinea->setConsEstimado($consumo);
				$handlerLinea->setObs($obs);

				$handlerLinea->insert(false);


			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		
		public function getDatosByNroLinea($nroLinea){
			try {
				$handlerLinea = new Lineas;
				$data = $handlerLinea->getDatosByNroLinea($nroLinea);
				
				if(count($data)==0){
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
		
		public function getDatosByIMEI($IMEI){
			try {
				$handlerEquipo = new Equipos;
				$data = $handlerEquipo->getEquipoLinea($IMEI);
				
				if(count($data)==0){
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
		
		public function nuevoEquipo($fechaCompra,$IMEI,$marca,$modelo,$precioCompra){
			try {
				$handlerEquipo = new Equipos;

				$handlerEquipo->setIMEI($IMEI);
				$handlerEquipo->setFechaCompra($fechaCompra);
				$handlerEquipo->setMarca($marca);
				$handlerEquipo->setModelo($modelo);
				$handlerEquipo->setPrecioCompra($precioCompra);
				
				$handlerEquipo->insert(false);


			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		
		public function bajaEquipo($IMEI,$fechaBaja,$obs,$tipoBaja){
			try {
				$handlerEquipo = new Equipos;
				$handlerEquipo->setIMEI($IMEI);

				if ($tipoBaja == 'roto') {
					$handlerEquipo->setFechaBaja($fechaBaja);
					$handlerEquipo->setObsBaja($obs);
					$handlerEquipo->rotura(false);
				} elseif ($tipoBaja == 'robo') {
					$handlerEquipo->setFechaRobo($fechaBaja);
					$handlerEquipo->setObsRobo($obs);
					$handlerEquipo->robo(false);
				} elseif ($tipoBaja == 'perd') {
					$handlerEquipo->setFechaPerd($fechaBaja);
					$handlerEquipo->setObsPerd($obs);
					$handlerEquipo->perdida(false);
				}

				


			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}


	}

?>
