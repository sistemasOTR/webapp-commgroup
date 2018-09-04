<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";
		
	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'Entidades/legajos.class.php';
	include_once PATH_DATOS.'Entidades/legajos_basicos.class.php';
	include_once PATH_DATOS.'Entidades/legajos_categorias.class.php';
	include_once PATH_DATOS.'Entidades/sueldos_conceptos.class.php';
	include_once PATH_DATOS.'Entidades/sueldos_items.class.php';
	include_once PATH_DATOS.'Entidades/sueldos.class.php';
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	include_once PATH_NEGOCIO."Funciones/Archivo/archivo.class.php"; 
	
	class HandlerSueldos{

		public function selectSueldos($plaza,$usuario){
			try {
					
				$handler = new Sueldos;
				$data= $handler->selectSueldos($plaza,$usuario);
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

		public function newSueldo($fecha,$periodo,$usuario,$tipo,$plaza){
			try {
				$periodo_correct = $periodo. "-01";
					
				$handler = new Sueldos;
				$handler->setFecha($fecha);
				$handler->setPeriodo($periodo_correct);
				$handler->setIdUsuario($usuario);
				$handler->setTipo($tipo);
				$handler->setIdPlaza($plaza);

				$handler->insert(null);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function selectLastSueldos(){
			try {
					
				$handler = new Sueldos;
				$data= $handler->selectLastSueldo();
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

		public function selectLast2SueldosByUsuario($id_usuario,$periodo){
			try {
					
				$handler = new Sueldos;
				$data= $handler->selectLast2SueldosByUsuario($id_usuario,$periodo);
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

		public function actualizarSueldo($idsueldo,$basico,$jornada,$categoria,$remu_totales,$desc_totales,$no_remu_totales){
			try {
					
				$handler = new Sueldos;
				$handler->actualizarSueldo($idsueldo,$basico,$jornada,$categoria,$remu_totales,$desc_totales,$no_remu_totales);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
		

		public function selectSueldoById($id){
			try {
					
				$handler = new Sueldos;
				$handler->setId($id);

				$data = $handler->select();

				return $data;
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}
		

		public function cancelarSueldo($idsueldo){
			try {
					
				$handler = new Sueldos;
				$handler->setId($idsueldo);

				$handler->delete(null);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		// Conceptos //

		public function newConcepto($concepto,$valor,$base){
			try {
					
				$handler = new SueldosConceptos;
				$handler->setConcepto($concepto);
				$handler->setValor($valor);
				$handler->setBase($base);

				$handler->insert(null);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function updateConcepto($id,$concepto,$valor,$base){
			try {
					
				$handler = new SueldosConceptos;
				$handler->setConcepto($concepto);
				$handler->setValor($valor);
				$handler->setBase($base);
				$handler->setId($id);

				$handler->update(null);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function selectConceptos(){
			try {
					
				$handler = new SueldosConceptos;
				$data= $handler->select();
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

		// items //

		public function newItem($idsueldo,$concepto,$unidad,$remunerativo,$descuento,$no_remunerativo){
			try {
					
				$handler = new SueldosItems;
				$handler->setIdSueldo($idsueldo);
				$handler->setUnidad($unidad);
				$handler->setConcepto($concepto);
				$handler->setRemunerativo($remunerativo);
				$handler->setDescuento($descuento);
				$handler->setNoRemunerativo($no_remunerativo);

				$handler->insert(null);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		public function selectItemsBySueldo($id_sueldo){
			try {
					
				$handler = new SueldosItems;
				$data= $handler->selectItemsBySueldo($id_sueldo);
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

		public function deleteItemsBySueldo($id_sueldo){
			try {
					
				$handler = new SueldosItems;

				$handler->deleteItemsBySueldo($id_sueldo);
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

	}

?>
