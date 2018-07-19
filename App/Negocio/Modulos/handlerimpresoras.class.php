<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";
		
	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'Entidades/impresoras_plaza.class.php';
	include_once PATH_DATOS.'Entidades/impresoras.class.php';
	include_once PATH_DATOS.'Entidades/consumos_impresoras.class.php';
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
		

		public function guardarImpresora($serialNro,$fechaCompra,$marca,$modelo,$precioCompra,$estado,$userCarga){
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
					$handler->setUserCarga(intval($userCarga));
					$handler->setAprobado(false);
					
					$handler->insert(false);
				}



			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}

		public function editarImpresora($serialNro,$fechaCompra,$precioCompra,$userAprobacion,$fechaActual){
			try {
				$handler = new Impresoras;

				$handler->setSerialNro($serialNro);
				$handler->setFechaCompra($fechaCompra);
				$handler->setPrecioCompra($precioCompra);
				$handler->setUserAprobacion(intval($userAprobacion));
				$handler->setAprobado(true);
				$handler->setFechaHoraAprobacion($fechaActual);
				
				$handler->editarImpresora(false);
			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		
		public function asignarImpresora($serialNro,$fechaAsig,$plaza,$gestorId,$obs){
			try {
				
					$handler = new ImpresorasPlaza;
					$handlerImp = new Impresoras;
					$handlerImp->setSerialNro($serialNro);
					// var_dump($handlerImp);
					// exit();
					$handlerImp->cambiarEstado(false,2);

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
		
		public function devolverImpresora($asigId,$fechaDev,$obs,$tipo){
			try {
				
					$handler = new ImpresorasPlaza;
					$handlerImp = new Impresoras;

					$handler->setAsigId($asigId);
					$impresora = $handler->selectById($asigId);

					$handlerImp->setSerialNro($impresora['_serialNro']);
					$handlerImp->cambiarEstado(false,1);
					$handler->setFechaDev($fechaDev);
					$handler->setObsDev($obs);
					$handler->setTipoDev($tipo);

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
		
		public function bajaImpresora($serialNro,$fechaBaja,$tipoBaja,$obs){
			try {
				
					$handler = new Impresoras;
					$handlerImp = new Impresoras;

					$handler->setSerialNro($serialNro);
					$handler->setFechaBaja($fechaBaja);
					$handler->setTipoBaja($tipoBaja);
					$handler->setObs($obs);
					$handlerImp->setSerialNro($serialNro);
					switch ($tipoBaja) {
						case 'roto':
							$tipo = 3;
							break;
						case 'robo':
							$tipo = 5;
							break;
						case 'perdida':
							$tipo = 6;
							break;
						
						default:
							# code...
							break;
					}
					$handlerImp->cambiarEstado(false,$tipo);

					$handler->bajaImpresora(false);
				


			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		
		public function guardarConsumo($serialNro,$fechaConsumo,$plaza,$contador,$cambioTonner,$KitA,$cambioKitA,$KitB,$cambioKitB,$consSamsung,$cambioConsSamsung,$UI,$cambioUI,$kitM,$cambioKitM,$consObs,$userId){
			try {
				
					$handler = new ConsumoImpresora;

					$handler->setSerialNro($serialNro);
					$handler->setPlaza($plaza);
					$handler->setContador(intval($contador));
					$handler->setFechaConsumo($fechaConsumo);
					if ($cambioTonner == 1) {
						$handler->setCambioTonner(true);
					} else {
						$handler->setCambioTonner(false);
					}
					$handler->setKitA($KitA);
					if ($cambioKitA == 1) {
						$handler->setCambioKitA(true);
					} else {
						$handler->setCambioKitA(false);
					}
					$handler->setKitB($KitB);
					if ($cambioKitB == 1) {
						$handler->setCambioKitB(true);
					} else {
						$handler->setCambioKitB(false);
					}
					$handler->setConsSamsung($consSamsung);
					if ($cambioConsSamsung == 1) {
						$handler->setCambioConsSamsung(true);
					} else {
						$handler->setCambioConsSamsung(false);
					}
					$handler->setUI($UI);
					if ($cambioUI == 1) {
						$handler->setCambioUI(true);
					} else {
						$handler->setCambioUI(false);
					}
					$handler->setKitM($kitM);
					if ($cambioKitM == 1) {
						$handler->setCambioKitM(true);
					} else {
						$handler->setCambioKitM(false);
					}
					$handler->setConsObs($consObs);
					$handler->setUserId(intval($userId));

					
					$handler->insert(false);
				


			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}
		
		public function getConsumos($serialNro){
			try {
				$handlerImp = new ConsumoImpresora;								
				$data = $handlerImp->getConsumos($serialNro);
				
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
