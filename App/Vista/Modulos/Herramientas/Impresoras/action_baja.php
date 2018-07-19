<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerimpresoras.class.php";
	
	$hanlder = new HandlerImpresoras();

	$serialNro = (isset($_POST["bajaSerialNro"])?$_POST["bajaSerialNro"]:'');
	
	$fechaBaja = (isset($_POST["fechaBaja"])?$_POST["fechaBaja"]:'');
	$tipoBaja = (isset($_POST["txtTipoBaja"])?$_POST["txtTipoBaja"]:'');
	$obs = (isset($_POST["txtObsImp"])?$_POST["txtObsImp"]:'');
	
	$err = "../../../../../index.php?view=impresorasxplaza&err=";     		
	$info = "../../../../../index.php?view=impresorasxplaza&info=";     		

	try {

		$hanlder->bajaImpresora($serialNro,$fechaBaja,$tipoBaja,$obs);
		
		
		$msj="Impresora dada de baja con éxito.";
				
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>