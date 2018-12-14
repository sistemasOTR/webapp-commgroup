<?php 
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerobjetivos.class.php"; 

	$handlerObj = new HandlerObjetivos;

	$id=(isset($_POST["id"])?$_POST["id"]:'');
	$plaza=(isset($_POST["slt_plaza"])?$_POST["slt_plaza"]:'');
	$basico=(isset($_POST["basico"])?$_POST["basico"]:'');
	$basicoGC=(isset($_POST["basicoGC"])?$_POST["basicoGC"]:'');
	$fechaDesde=(isset($_POST["vigencia"])?$_POST["vigencia"]:'');
	$cantCoord=(isset($_POST["cantCoord"])?$_POST["cantCoord"]:'');


	$err = "../../../../index.php?view=objetivos&vista=1&err=";     		
	$info = "../../../../index.php?view=objetivos&vista=1&info=";

	// var_dump($id);
	// exit();

	try {

		$handlerObj->cambiarObjetivo($id,$plaza,$basico,$basicoGC,$fechaDesde,$cantCoord);

		$msj="Configuración de objetivo cargada con éxito";
		header("Location: ".$info.$msj);
	  			
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}  		


?>