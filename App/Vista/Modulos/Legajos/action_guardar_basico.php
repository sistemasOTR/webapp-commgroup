 <?php 

 	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php"; 
	
	$handler = new HandlerLegajos;
    
    $id=(isset($_POST["id"])?$_POST["id"]:'');
    $accion=(isset($_POST["accion"])?$_POST["accion"]:'');
    $tipoCategoria=(isset($_POST["tipo_categoria"])?$_POST["tipo_categoria"]:'');
    $catAnterior=(isset($_POST["categoria_anterior"])?$_POST["categoria_anterior"]:'');
    $basico=(isset($_POST["basico"])?$_POST["basico"]:'');
    $basicoAnterior=(isset($_POST["basico_anterior"])?$_POST["basico_anterior"]:'');
    $horasNormales=(isset($_POST["horas_normales"])?$_POST["horas_normales"]:'');
    $horasanteriores=(isset($_POST["horas_anteriores"])?$_POST["horas_anteriores"]:'');
    $fechaDesde=(isset($_POST["fecha_desde"])?$_POST["fecha_desde"]:'');
    // $fechaHasta=(isset($_POST["fecha_hasta"])?$_POST["fecha_hasta"]:'');

    // var_dump($accion);
    // exit();
		
	$err = "../../../../index.php?view=legajos_basicos&err=";     		
	$info = "../../../../index.php?view=legajos_basicos&info=";     		

if ($accion=='nuevo') {


	try {
		$handler->crearBasicos($tipoCategoria,$basico,$horasNormales,$fechaDesde,null);

		$msj="Basico Cargado";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}

} else {

   try {
   	    $handler->updateBasicos($id,$fechaDesde);
		$handler->crearBasicos($tipoCategoria,$basico,$horasNormales,$fechaDesde,null);

		$msj="Basico Editado y Cargado";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}

}


?>	