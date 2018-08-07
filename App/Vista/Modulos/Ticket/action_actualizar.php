<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlertickets.class.php"; 
	
	$handler = new HandlerTickets();
	

	$id = (isset($_POST["idTicket"])?$_POST["idTicket"]:'');	
	$tipo = (isset($_POST["tipo"])?$_POST["tipo"]:'');	
	$punto_venta = (isset($_POST["punto_venta"])?$_POST["punto_venta"]:'');	
	$numero = (isset($_POST["numero"])?$_POST["numero"]:'');	
	$razon_social = (isset($_POST["razon_social"])?$_POST["razon_social"]:'');	
	$cuit = (isset($_POST["cuit"])?$_POST["cuit"]:'');	
	$iibb = (isset($_POST["iibb"])?$_POST["iibb"]:'');	
	$domicilio = (isset($_POST["domicilio"])?$_POST["domicilio"]:'');	
	$condicion_fiscal = (isset($_POST["condicion_fiscal"])?$_POST["condicion_fiscal"]:'');	
	$importe = (isset($_POST["importe"])?$_POST["importe"]:'');	
	$adjunto = (isset($_FILES["adjunto"])?$_FILES["adjunto"]:'');	
	$concepto = (isset($_POST["concepto"])?$_POST["concepto"]:'');	
	$tipo_usuario = (isset($_POST["tipo_usuario"])?$_POST["tipo_usuario"]:'');	
	$adjActual = (isset($_POST["adjActual"])?$_POST["adjActual"]:'');	
	
	try {

		
   		$handler->updateTickets($id,$tipo,$punto_venta,$numero,$razon_social,$cuit,$iibb,$domicilio,$condicion_fiscal,$importe,$adjunto,$concepto,$adjActual);

   		if ($tipo_usuario == 'COORDINADOR') {
   			$err = "../../../../index.php?view=tickets_control&err=";     		
			$info = "../../../../index.php?view=tickets_control&info=";
   		} elseif ($tipo_usuario == 'BACK OFFICE') {
   			
   			$err = "../../../../".$_POST['url_retorno']."&err=";
			$info = "../../../../".$_POST['url_retorno']."&info=";
   		} else {
   			$err = "../../../../index.php?view=tickets_carga&err=";
			$info = "../../../../index.php?view=tickets_carga&info=";
   		}
   		
		
		
		$msj="Tickets Guardado";
		header("Location: ".$info.$msj);																						
		
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>