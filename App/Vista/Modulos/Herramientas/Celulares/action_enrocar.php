<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlercelulares.class.php";
	
	$hanlder = new HandlerCelulares();

	
	$estado = (isset($_POST["estado"])?$_POST["estado"]:'');
	$fechaNueva = (isset($_POST["fechaNueva"])?$_POST["fechaNueva"]:'');
	$fechaACambiar = (isset($_POST["fechaACambiar"])?$_POST["fechaACambiar"]:'');
	$nroLineaACambiar = (isset($_POST["enroENroLinea"])?$_POST["enroENroLinea"]:'');
	$equipoACambiar = (isset($_POST["EnroEIMEI"])?$_POST["EnroEIMEI"]:'');
	$nroLineaNuevo = (isset($_POST["EnroLinea"])?$_POST["EnroLinea"]:'');
	$equipoNuevo = (isset($_POST["EnroEquipo"])?$_POST["EnroEquipo"]:'');
	$usuarioId = (isset($_POST["EnroEuserId"])?$_POST["EnroEuserId"]:0);
	$entId = (isset($_POST["EnroEEntId"])?$_POST["EnroEEntId"]:0);
	$obs = (isset($_POST["txtObs"])?$_POST["txtObs"]:'');
	$tipo = (isset($_POST["txtTipoBaja"])?$_POST["txtTipoBaja"]:'');

	//var_dump($usuarioId);
	// exit();
	$err = "../../../../../index.php?view=celulares&err=";     		
	$info = "../../../../../index.php?view=celulares&info=";     		

	try {

		$hanlder->devolverLinea($entId,$fechaNueva,$nroLineaACambiar,$equipoACambiar,$obs,$tipo);
		$obser = $obs;
		$obs = '';
		if ($estado == 'linea') {
			$hanlder->entregar($fechaNueva,$fechaACambiar,$nroLineaNuevo,$equipoACambiar,$usuarioId,$obs);
		} elseif ($estado == 'equipo') {
			$hanlder->entregar($fechaACambiar,$fechaNueva,$nroLineaACambiar,$equipoNuevo,$usuarioId,$obs);
			if ($tipo == 'roto01' || $tipo == 'roto02') {
				$tipoBaja='roto';
				$hanlder->bajaEquipo($equipoACambiar,$fechaNueva,$obser,$tipoBaja);
			} elseif ($tipo == 'robo') {
				$hanlder->bajaEquipo($equipoACambiar,$fechaNueva,$obser,$tipo);
			} elseif ($tipo == 'perd') {
				$hanlder->bajaEquipo($equipoACambiar,$fechaNueva,$obser,$tipo);
			}
		}

		
		// var_dump($fechaEntrega);
		// exit();
		
		
		$msj="Línea y equipo entregados con éxito.";
				
		header("Location: ".$info.$msj.'&pop=yes&fID='.$entId.'&fTipo='.$tipo);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>