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

		// Conceptos //

		public function newConcepto($concepto){
			try {
					
				$handler = new SueldosConceptos;
				$handler->setConcepto($concepto);

				$handler->insert(null);		
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());				
			}
		}

		public function updateConcepto($id,$concepto){
			try {
					
				$handler = new SueldosConceptos;
				$handler->setConcepto($concepto);
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
	}

?>
