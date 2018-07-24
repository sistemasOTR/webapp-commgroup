<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 
	
	
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	
	$f= new Fechas;
	$fecha=$f->FechaActual();	
	
	
	$id = (isset($_POST["id"])?$_POST["id"]:'');
	$iditem = (isset($_POST["iditem"])?$_POST["iditem"]:'');
	$i=intval($id);
	
	$observaciones = (isset($_POST["observaciones"])?$_POST["observaciones"]:'');
	$usuario = (isset($_POST["usuario2"])?$_POST["usuario2"]:'');
	$cantidad_env=(isset($_POST["cantidadenviada"])?$_POST["cantidadenviada"]:0);
	$cantidad_parcial=(isset($_POST["entregada"])?$_POST["entregada"]:0);
	$cantidad_origin=(isset($_POST["cantidadoriginal"])?$_POST["cantidadoriginal"]:0);
	$cantidad_stock=(isset($_POST["stock"])?$_POST["stock"]:0);
	$ppedido=(isset($_POST["ppedido"])?$_POST["ppedido"]:0);

	$cantidadtotalenviada=$cantidad_parcial+$cantidad_env;
	$nuevo_stock = $cantidad_stock - $cantidad_env;
	$user=intval($usuario);
	if ($nuevo_stock <= $ppedido) {
		$apedir = true;
	} else {
		$apedir = false;
	}


     	try {


     	$estado=9;	
		$hanlder = new HandlerExpediciones();
		$handler2 = new HandlerExpediciones();
		$handler3 = new HandlerExpediciones();


		$hanlder->modificarEstadoExpedicion($i,$estado,$observaciones,$cantidadtotalenviada);
         
        $handler2->cargarEnvios($i,$fecha,$cantidad_env,$user);

        $handler3->modificarStock(intval($iditem),intval($nuevo_stock),$apedir);


      

        $err = "../../../../".$_POST['url_redireccion']."&err=";     		
		$info = "../../../../".$_POST['url_redireccion']."&info="; 
		$msj="El estado fue cambiado con con éxito.";
		header("Location: ".$info.$msj); 

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
     
	
?>