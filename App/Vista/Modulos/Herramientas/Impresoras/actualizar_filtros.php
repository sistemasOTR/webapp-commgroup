<?php
	include_once "../../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerusuarios.class.php";
	include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  
	if(isset($_REQUEST["opcion"]))
 {
    $opciones = '<option value="0">"Elige la ciudad"</option>';
    $arrGestor = $handler->selectAllGestor($_REQUEST["opcion"]);
    foreach ($arrGestor as $gestor) {
    	# code...
    }
       $opciones.='<option value="'.$gestor->GESTOR11_CODIGO.'">'.$gestor->GESTOR21_ALIAS.'</option>';
    }


    echo $opciones;
 }






	//$fplaza = (isset($_POST["f_plaza"])?$_POST["f_plaza"]:'');

	//echo $fplaza;
	
	
?>