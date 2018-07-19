<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerimpresoras.class.php";
	
	$hanlder = new HandlerImpresoras();

	$asigId = (isset($_POST["asigId"])?$_POST["asigId"]:'');
	
	$fechaDev = (isset($_POST["fechaDev"])?$_POST["fechaDev"]:'');
	$obs = (isset($_POST["txtObs"])?$_POST["txtObs"]:'');
	$gestorId = (isset($_POST["userId"])?$_POST["userId"]:0);
	$txtTipoBaja = (isset($_POST["txtTipoBaja"])?$_POST["txtTipoBaja"]:0);
	$devSerialNro = (isset($_POST["devSerialNro"])?$_POST["devSerialNro"]:0);
	
	$err = "../../../../../index.php?view=impresorasxplaza&err=";     		
	$info = "../../../../../index.php?view=impresorasxplaza&info=";     		

	try {


		$hanlder->devolverImpresora($asigId,$fechaDev,$obs);
		
		if ($txtTipoBaja != 'condi') {
			$hanlder->bajaImpresora($devSerialNro,$fechaDev,$txtTipoBaja,$obs);
		}
		$msj="Impresora devuelta con éxito.";
		if ($gestorId == 0) {
			header("Location: ".$info.$msj);
		} else {
			header("Location: ".$info.$msj.'&pop=yes&fID='.$asigId.'&fTipo='.$txtTipoBaja);
		}
		

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>