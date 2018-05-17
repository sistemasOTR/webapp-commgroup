<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";
		
	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'Entidades/impresoras_plaza.class.php';
	include_once PATH_DATOS.'Entidades/impresoras.class.php';
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	
	class HandlerImpresoras{
				
		public function PlazaImpresoras($serialNro){
			try {
				$handlerImp = new ImpresorasPlaza;								
				$data = $handlerImp->selectXSerial($serialNro);
				

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
		
		public function AllImpresoras($plaza,$gestorId){
			try {
				$handlerImp = new Impresoras;								
				if(($plaza != '' && $plaza != '0') && ($gestorId == '' || $gestorId == 0)){
					$data = $handlerImp->selectXPlaza($plaza);
				} elseif ($gestorId !='' && $gestorId != 0) {
					$data = $handlerImp->selectXGestor($gestorId);
				} else {
					$data = $handlerImp->select();
				}

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
		
		public function getDatosConSerial($serialNro){
			try {
				$handlerImp = new Impresoras;								
				$data = $handlerImp->getMarcaConSerial($serialNro);
				
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
		

		public function guardarImpresora($serialNro,$fechaCompra,$marca,$modelo,$precioCompra,$estado){
			try {
				if($estado=="NUEVO"){
					$handler = new Impresoras;

					$handler->setSerialNro($serialNro);
					$handler->setMarca($marca);
					$handler->setModelo($modelo);
					if($fechaCompra != ''){
						$handler->setFechaCompra($fechaCompra);
					}
					if($precioCompra != ''){
						$handler->setPrecioCompra($precioCompra);
					}
					
					
					$handler->insert(false);
				}



			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		
		public function asignarImpresora($serialNro,$fechaAsig,$plaza,$gestorId,$obs){
			try {
				
					$handler = new ImpresorasPlaza;

					$handler->setSerialNro($serialNro);
					$handler->setPlaza($plaza);
					$handler->setGestorId(intval($gestorId));
					if($fechaAsig != ''){
						$handler->setFechaAsig($fechaAsig);
					}
					$handler->setObs($obs);

					$handler->insert(false);
				


			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		
		public function devolverImpresora($asigId,$fechaDev,$obs){
			try {
				
					$handler = new ImpresorasPlaza;

					$handler->setAsigId($asigId);
					$handler->setFechaDev($fechaDev);
					$handler->setObs($obs);

					$handler->devolver(false);
				


			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		
		public function getAsignaciones($serialNro){
			try {
				$handlerImp = new ImpresorasPlaza;								
				$data = $handlerImp->getAsignaciones($serialNro);
				
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
		
		public function selectById($asigId){
			try {
				$handlerImp = new ImpresorasPlaza;								
				$data = $handlerImp->selectById($asigId);
				
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
		
		public function bajaImpresora($serialNro,$fechaBaja,$obs){
			try {
				
					$handler = new Impresoras;

					$handler->setSerialNro($serialNro);
					$handler->setFechaBaja($fechaBaja);
					$handler->setObs($obs);

					$handler->bajaImpresora(false);
				


			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}


	}

?>
