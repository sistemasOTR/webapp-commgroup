<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlercelulares.class.php";
	
	$hanlder = new HandlerCelulares();

	
	$fechaEntrega = (isset($_POST["fechaEntrega"])?$_POST["fechaEntrega"]:'');
	$nroLinea = (isset($_POST["slt_nroLinea"])?$_POST["slt_nroLinea"]:'');
	$equipo = (isset($_POST["slt_equipo"])?$_POST["slt_equipo"]:'');
	$usuarioId = (isset($_POST["slt_usuario"])?$_POST["slt_usuario"]:'');
	$obs = (isset($_POST["txtObs"])?$_POST["txtObs"]:'');
	//var_dump($equipo);
	//exit();
	$err = "../../../../../index.php?view=celulares&err=";     		
	$info = "../../../../../index.php?view=celulares&info=";     		

	try {

		$hanlder->entregar($fechaEntrega,$nroLinea,$equipo,$usuarioId,$obs);
		
		
		$msj="Línea y equipo entregados con éxito.";
				
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>