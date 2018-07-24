<?php 
   include_once "../../../Config/config.ini.php";	
   include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 
   include_once PATH_DATOS.'Entidades/expediciones.class.php';
   include_once PATH_DATOS.'Entidades/expedicionesenvios.class.php';
   include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	
	$f= new Fechas;
	$id2=(isset($_POST['id2'])?$_POST['id2']:'');
	$idremito=(isset($_POST['id'])?$_POST['id']:'');
	$countenvios=(isset($_POST['countenvios'])?$_POST['countenvios']:'');
	$cantidad=(isset($_POST['cantidadnueva'])?$_POST['cantidadnueva']:0);
	$handler= new handlerexpediciones;
	$handlerxp= new Expediciones;
	$handlerenvios= new ExpedicionesEnvios;
	$recibido=0;
	$norecibido=0;
  	
    try {

    	foreach ($id2 as $key => $id_pedido) {
            $falta=$cantidad[($key)];           
    		$env = 'enviado_'.$id_pedido;
			$valor=(isset($_POST[$env])?intval($_POST[$env]):0);
			if ($valor == 1) {
				 $items=$handler->selectByIdEnvio($id_pedido);
			 if ($items->getEstadosExpediciones()==2) {
			 	 $estado=4;		 
			 	 }	 
              elseif ($items->getEstadosExpediciones()==6) {
              	$estado=7;
              }
				$recibido+=1;
    	  		$handlerxp->updateEstadoItemExpedicion($id_pedido,$estado);
			} else {
                $items=$handler->selectByIdEnvio($id_pedido);
                $faltante=$items->getEntregada()-$falta;
				
				$estado=5;
    	  		$handlerxp->updateEstadoItemExpedicion($id_pedido,$estado);
    	  		$handler->modificarEstadoExpedicion($id_pedido,$estado,"",$faltante);
    	  	   $handlerenvios->updateCantidadFaltante($id_pedido,$falta);
                $norecibido+=1;
			}
    	  	   
    	 }  
    	     if ($countenvios == $recibido) {

    	     	$handler->modificarEnviadoRecibido($idremito,$recibir=1); 
    	     	$msj="Los estados fueron modificados con con éxito.";
    	     }
    	     else{
    	     	$handler->modificarEnviadoRecibido($idremito,$recibir=2);
    	     	$msj="faltaron Items";
    	     }
               
		$err = "../../../../index.php?view=exp_seguimiento_remito&err=";    		
		$info = "../../../../index.php?view=exp_seguimiento_remito&info="; 

		
		header("Location: ".$info.$msj); 
		
   
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}



?>