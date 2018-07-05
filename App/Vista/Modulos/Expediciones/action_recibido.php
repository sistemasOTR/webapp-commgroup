<?php

    include_once "../../../Config/config.ini.php";
    include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";


	$id = (isset($_GET["id"])?$_GET["id"]:'');
	$estado = (isset($_GET["estado"])?$_GET["estado"]:'');	
	$fdesde=(isset($_GET["fdesde"])?$_GET["fdesde"]:'');	
	$fhasta=(isset($_GET["fhasta"])?$_GET["fhasta"]:'');
	$ftipo=	(isset($_GET["ftipo"])?$_GET["ftipo"]:'');
	$festados=(isset($_GET["festados"])?$_GET["festados"]:'');
    $handler= new handlerexpediciones;
   /* echo $fdesde;
    echo $fhasta;
    exit();*/
    $err = "../../../../index.php?view=exp_seguimiento&fdesde=".$fdesde."&fhasta=".$fhasta."&festados=".$festados."&ftipo=".$ftipo."&err=";     		
	$info = "../../../../index.php?view=exp_seguimiento&fdesde=".$fdesde."&fhasta=".$fhasta."&festados=".$festados."&ftipo=".$ftipo."&info=";   

	if ($estado==2) {
		try {

		$estado=4;		
	    $handler->modificarRecibido($id,$estado);

        $msj="El estado fue cambiado con con éxito.";
		header("Location: ".$info.$msj);
	    } catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	       }
     } elseif ($estado==6) {
		try {

		$estado=7;
	    $handler->modificarRecibido($id,$estado);
	    $msj="El estado fue cambiado con con éxito.";
		header("Location: ".$info.$msj);
	    } catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	       }

     } else {
     	$msj="El estado No se puede modificar";
     	header("Location: ".$info.$msj);
     }

?>