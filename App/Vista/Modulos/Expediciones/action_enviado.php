<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 

	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	
	$f= new Fechas;
	$fecha=$f->FechaActual();

	$i=(isset($_POST["id"])?$_POST["id"]:'');
	$fdesde=(isset($_GET["fdesde"])?$_GET["fdesde"]:'');
	$fhasta=(isset($_GET["fhasta"])?$_GET["fhasta"]:'');
	$fplaza=(isset($_GET["fplaza"])?$_GET["fplaza"]:'');
	$plazaEnv=(isset($_GET["plazaEnv"])?$_GET["plazaEnv"]:'');
	$nombreItem=(isset($_POST["nombreItem"])?$_POST["nombreItem"]:'');
	$cantidadItem=(isset($_POST["cantidadItem"])?$_POST["cantidadItem"]:'');

	
	
	try {


       $handler = new HandlerExpediciones();
       $handler2 = new HandlerExpediciones();
       $handler->cargarEnviados($plazaEnv,$fecha);

       $array=$handler2->publicarEnviado();
       $ultimaId=$array[0];
       $ultimaFecha=$array[1];
       $datos=$handler->selectSinEnviar();
       if(count($datos)==1){
					$datos = array('' => $datos );					
				}

       // var_dump($datos);
       // exit();
       	if(!empty($datos)){
			foreach ($datos as $key => $value) {
				$handlerenvios= new ExpedicionesEnvios;
                $handlerenvios->updateEstadoNro($value->getId(),$ultimaId,$ultimaFecha);
                $handlerxp= new Expediciones;
                $exp=$handlerxp->selectById($value->getIdPedido());	

                if ($exp->getCantidad()-$exp->getEntregada()==0) {
                 $itemexpedicion=2;	
                 $handlerxp->updateEstadoItemExpedicion($value->getIdPedido(),$itemexpedicion);              		
                 }  
                 else {
                 	$itemexpedicion=6;	
                    $handlerxp->updateEstadoItemExpedicion($value->getIdPedido(),$itemexpedicion); 
                 }         

			}

		}

    	$err = "../../../../index.php?view=exp_control_coordinador&fdesde=".$fdesde."&fhasta=".$fhasta."&fplaza=".$fplaza."&festados=9&err=";    		
		$info = "../../../../index.php?view=exp_control_coordinador&fdesde=".$fdesde."&fhasta=".$fhasta."&fplaza=".$fplaza."&festados=9&info="; 

		$msj="Los items fueron enviados con con éxito.";

		header("Location:".$info.$msj.'&pop=yes&pedID='.$ultimaId.'&plazaEnv='.$plazaEnv);

      //; window.open('".PATH_VISTA."Modulos/Expediciones/imprimir_enviado?pedID=".$ultimaId."&info1=".$info."&msj=".$msj."&cantidadItem=".$cantidadItem."&nombreItem=".$nombreItem."')

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}


?>	