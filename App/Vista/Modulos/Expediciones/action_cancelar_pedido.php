<?php

    include_once "../../../Config/config.ini.php";
	include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";


	$id = (isset($_POST["id_cancelar"])?$_POST["id_cancelar"]:'');
	$observaciones=(isset($_POST["observaciones"])?$_POST["observaciones"]:'');


	try {

         $handler = new HandlerExpediciones;
         $handler->canceladoExpedicion($id,$observaciones);


        $err = "../../../../".$_POST['url_redireccion']."&err=";     		
		$info = "../../../../".$_POST['url_redireccion']."&info=";
		 
   		$msj="Item Cancelado";
		header("Location: ".$info.$msj);
   
   		} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
		}


?>	