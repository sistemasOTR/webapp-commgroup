<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handleragenda.class.php";       
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";
	
	$handler = new HandlerAgenda();
	$handlerFecha = new Fechas;
		
	$usuario = (isset($_POST["usuario"])?$_POST["usuario"]:0);
	$empresa = (isset($_POST["empresa"])?$_POST["empresa"]:0);
	$tipo = (isset($_POST["tipo"])?$_POST["tipo"]:'');
	$contacto = (isset($_POST["contacto"])?$_POST["contacto"]:'');
	$obs = (isset($_POST["obs"])?$_POST["obs"]:'');
	$url = (isset($_POST["url_retorno"])?$_POST["url_retorno"]:'');
	$instancia = (isset($_POST["instancia"])?$_POST["instancia"]:'');
	$fecha_hora = $handlerFecha->FechaHoraActual();

	try {
		
		$err = "../../../../index.php?".$url."&err=";     		
		$info = "../../../../index.php?".$url."&info=";

			$handler->contactar($fecha_hora,$usuario,$empresa,$tipo,$contacto,$obs,$instancia);
		
		
		$msj="Contacto agendado";
		header("Location: ".$info.$msj);																						
		
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>