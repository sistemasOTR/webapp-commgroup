<?php
	if(realpath("App/Config/config.ini.php"))
		include_once "App/Config/config.ini.php";
	
	if(realpath("../../Config/config.ini.php"))
		include_once "../../Config/config.ini.php";
		
	include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
	include_once PATH_DATOS.'Entidades/equipos_asoc.class.php';
	include_once PATH_DATOS.'Entidades/equipos.class.php';
	include_once PATH_DATOS.'Entidades/lineas.class.php';
	include_once PATH_DATOS.'Entidades/planes.class.php';
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	
	class HandlerCelulares{
				
		public function getCelus($plaza,$gestorId){
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


	}

?>
