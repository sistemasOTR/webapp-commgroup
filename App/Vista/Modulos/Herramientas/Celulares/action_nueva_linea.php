<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlercelulares.class.php";
	
	$hanlder = new HandlerCelulares();

	
	$fechaAlta = (isset($_POST["txtFechaAlta"])?$_POST["txtFechaAlta"]:'');
	$nroLinea = (isset($_POST["txtNroLinea"])?$_POST["txtNroLinea"]:'');
	$empresa = (isset($_POST["txtEmpresa"])?$_POST["txtEmpresa"]:'');
	$plan = (isset($_POST["txtPlan"])?$_POST["txtPlan"]:'');
	$costo = (isset($_POST["txtCosto"])?$_POST["txtCosto"]:'');
	$consumo = (isset($_POST["txtConsumo"])?$_POST["txtConsumo"]:'');
	$obs = (isset($_POST["txtObs"])?$_POST["txtObs"]:'');
	//var_dump($equipo);
	//exit();
	$err = "../../../../../index.php?view=celulares&err=";     		
	$info = "../../../../../index.php?view=celulares&info=";     		

	try {

		$hanlder->nuevaLinea($fechaAlta,$nroLinea,$empresa,$plan,$costo,$consumo,$obs);
		
		
		$msj="Línea ".$nroLinea." dada de alta con éxito";
				
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>