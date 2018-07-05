<?php
include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlertickets.class.php"; 

   // $err = "../../../../index.php?view=tickets_carga&err=";     		
  // $info = "../../../../index.php?view=tickets_carga&info=";    

	$handler = new HandlerTickets();

	$id = (isset($_POST["reintegro_id"])?$_POST["reintegro_id"]:'');
    $estado = (isset($_POST["estado"])?$_POST["estado"]:'');
	$fechaini = (isset($_POST["fechaini"])?$_POST["fechaini"]:'');
	$codigopostal = (isset($_POST["codigopostal"])?$_POST["codigopostal"]:'');	
	$descripcion = (isset($_POST["descripcion"])?$_POST["descripcion"]:'');	
	$reintegro = (isset($_POST["reintegro"])?$_POST["reintegro"]:'');	
	$plaza = (isset($_POST["plaza"])?$_POST["plaza"]:'');
	$aled = (isset($_POST["aled"])?$_POST["aled"]:0);

	try {
		
		$err = "../../../../index.php?view=tickets_reintegros&err=";     		
		$info = "../../../../index.php?view=tickets_reintegros&info=";   		

		$handler->guardarReintegro($id,$estado,$fechaini,$codigopostal,$descripcion,$reintegro,$plaza,$aled);
		
		$msj="Reintegro Guardado";
		header("Location: ".$info.$msj);																						
		
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}


?>