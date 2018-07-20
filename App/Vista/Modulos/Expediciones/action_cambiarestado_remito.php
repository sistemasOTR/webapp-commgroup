<?php 
   include_once "../../../Config/config.ini.php";	
   include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php"; 

	$id=(isset($_POST['id'])?$_POST['id']:'');
	$id2=(isset($_POST['id2'])?$_POST['id2']:'');
	$valor=(isset($_POST['enviado'])?$_POST['enviado']:'');

	$handler= new handlerexpediciones;

	var_dump($id,$valor);
	exit();


    try {
           
       

   
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}



?>