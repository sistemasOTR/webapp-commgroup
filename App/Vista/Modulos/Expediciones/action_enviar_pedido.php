<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 

	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	
	$f= new Fechas;
	$fecha=$f->FechaActual();

	$i=(isset($_GET["id"])?$_GET["id"]:'');
	$fdesde=(isset($_GET["fdesde"])?$_GET["fdesde"]:'');
	$fhasta=(isset($_GET["fhasta"])?$_GET["fhasta"]:'');
	$fplaza=(isset($_GET["fplaza"])?$_GET["fplaza"]:'');
	$plaza=(isset($_GET["plaza"])?$_GET["plaza"]:'');
	$cantpedida=(isset($_GET["cantpedida"])?$_GET["cantpedida"]:'');
	$cantentregada=(isset($_GET["cantentregada"])?$_GET["cantentregada"]:'');
    $id=intval($i);
	// var_dump($id,$plaza,$fecha);
	// exit();

	try {


	    $sinpedir=0;
    	$handler = new HandlerExpediciones();
 
	   //$handler->cargarEnviados($plaza,$fecha);
   		$handler->modificarSinPedir($id,$sinpedir);


    	$err = "../../../../index.php?view=exp_control_coordinador&fdesde=".$fdesde."&fhasta=".$fhasta."&fplaza=".$fplaza."&festados=9&err=";    		
		$info = "../../../../index.php?view=exp_control_coordinador&fdesde=".$fdesde."&fhasta=".$fhasta."&fplaza=".$fplaza."&plazaEnv=".$plaza."&festados=9&info="; 

		$msj="El estado fue cambiado con con éxito.";
		header("Location: ".$info.$msj); 

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}


?>	