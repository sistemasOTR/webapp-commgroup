<?php
	include_once "../../../Config/config.ini.php";
	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
	include_once PATH_NEGOCIO."Modulos/handlerpuntaje.class.php"; 	

	$handler = new HandlerSistema;
	$arrCoordinador = $handler->selectAllPlazas();
	
	$datos="";
	foreach ($arrCoordinador as $key => $value) {
		$strReplace= str_replace(" ","_",$value->PLAZA);
		$datos[]= array('coordinador' => $value->PLAZA,
					  'objetivo' => $_POST["id_".$strReplace]);	
	}
	// var_dump($datos,$arrCoordinador);
	// exit();
	
	$fechaCambioVigencia = (isset($_POST["txtFechaVigencia"])?$_POST["txtFechaVigencia"]:'');

	$err = "../../../../index.php?view=configuraciones&config=config5&err=";
	$info = "../../../../index.php?view=configuraciones&config=config5&info=";	

	try
	{	
		if(!empty($datos)){

			$handlerTI = new HandlerPuntaje;			
			$handlerTI->guardarObjetivoByCoordinador($datos,$fechaCambioVigencia);					

			$msj="Se actualizaron todos los objetivos";
			header("Location: ".$info.$msj);				
		}
	}
	catch(Exception $e)
	{
		header("Location: ".$err.$e->getMessage());
	}
?>