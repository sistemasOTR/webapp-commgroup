<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlercelulares.class.php";
	
	$hanlder = new HandlerCelulares();

	$entId = (isset($_POST["entId"])?$_POST["entId"]:'');
	$fechaDev = (isset($_POST["fechaDev"])?$_POST["fechaDev"]:'');
	$devNroLinea = (isset($_POST["devNroLinea"])?$_POST["devNroLinea"]:'');
	$devIMEI = (isset($_POST["devIMEI"])?$_POST["devIMEI"]:'');
	$obs = (isset($_POST["txtObsDev"])?$_POST["txtObsDev"]:'');
	$tipo = (isset($_POST["txtTipoBaja"])?$_POST["txtTipoBaja"]:'');
	
	$err = "../../../../../index.php?view=celulares&err=";     		
	$info = "../../../../../index.php?view=celulares&info=";     		

	try {

		$hanlder->devolverLinea($entId,$fechaDev,$devNroLinea,$devIMEI,$obs);
		if ($tipo == 'roto01' || $tipo == 'roto02') {
			$tipoBaja='roto';
			$hanlder->bajaEquipo($devIMEI,$fechaDev,$obs,$tipoBaja);
		} elseif ($tipo == 'robo') {
			$hanlder->bajaEquipo($devIMEI,$fechaDev,$obs,$tipo);
		} elseif ($tipo == 'perd') {
			$hanlder->bajaEquipo($devIMEI,$fechaDev,$obs,$tipo);
		}
		
		
		$msj="Línea devuelta con éxito.";
				
		header("Location: ".$info.$msj.'&pop=yes&fID='.$entId.'&fTipo='.$tipo);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>