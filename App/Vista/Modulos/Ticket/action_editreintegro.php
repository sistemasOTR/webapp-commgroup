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
	$cant_op = (isset($_POST["cant_op"])?$_POST["cant_op"]:0);
	$url_retorno = (isset($_POST["url_retorno"])?$_POST["url_retorno"]:0);

	try {
		
		$err = "../../../../".$url_retorno."&err=";     		
		$info = "../../../../".$url_retorno."&info=";   		

		$handler->guardarReintegro($id,$estado,$fechaini,$codigopostal,$descripcion,$reintegro,$plaza,$aled,$cant_op);
		
		$msj="Reintegro Guardado";
		header("Location: ".$info.$msj);																						
		
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}


?>