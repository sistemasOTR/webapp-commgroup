<?php

    include_once "../../../Config/config.ini.php";
    include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";
 	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";

 	$_fecha=new Fechas;
 	$fecha=$_fecha->FechaActual();
	$id = (isset($_GET["idpedido"])?$_GET["idpedido"]:'');
	$iditem = (isset($_GET["iditem"])?$_GET["iditem"]:'');
	$usuario=(isset($_GET["usuario"])?$_GET["usuario"]:'');
	$cantidad=(isset($_GET["cantidad"])?$_GET["cantidad"]:'');
	$stock=(isset($_GET["stock"])?$_GET["stock"]:'');
	$fdesde=(isset($_GET["fdesde"])?$_GET["fdesde"]:'');
	$fhasta=(isset($_GET["fhasta"])?$_GET["fhasta"]:'');


	$actualizarstock=($stock+$cantidad);

   

     
/*	$estado = (isset($_GET["estado"])?$_GET["estado"]:'');	
	$fdesde=(isset($_GET["fdesde"])?$_GET["fdesde"]:'');	
	$fhasta=(isset($_GET["fhasta"])?$_GET["fhasta"]:'');
	$ftipo=	(isset($_GET["ftipo"])?$_GET["ftipo"]:'');
	$festados=(isset($_GET["festados"])?$_GET["festados"]:'');
    
    echo $fdesde;
    echo $actualizarstock;
    exit();
	
    */

    $handler= new handlerexpediciones;
    $handler2= new handlerexpediciones;

    $err = "../../../../index.php?view=exp_compra&err=";     		
	$info = "../../../../index.php?view=exp_compra&info";   

	
		try {

		$recibido=1;		
	    $handler->modificarCompraRecibida(intval($id),$recibido,intval($usuario),$fecha);
	    $handler2->modificarStock(intval($iditem),intval($actualizarstock));

        $msj="El estado fue cambiado con con éxito.";
		header("Location: ".$info.$msj);
	    } catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	       }


?>