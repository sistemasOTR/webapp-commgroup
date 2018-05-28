<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlercelulares.class.php";
	
	$hanlder = new HandlerCelulares();

	$IMEI = (isset($_POST["txtIMEI"])?$_POST["txtIMEI"]:'');
	
	$fechaBaja = (isset($_POST["txtFecha"])?$_POST["txtFecha"]:'');
	$obs = (isset($_POST["txtObs"])?$_POST["txtObs"]:'');
	$tipoBaja = (isset($_POST["txtTipoBaja"])?$_POST["txtTipoBaja"]:'');
	
	$info = "../../../../../index.php?view=celulares&info=";     		
	$err = "../../../../../index.php?view=celulares&err=";     		

	try {
		
		$hanlder->bajaEquipo($IMEI,$fechaBaja,$obs,$tipoBaja);
		
		
		$msj="Equipo dado de baja con éxito.";
				
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>