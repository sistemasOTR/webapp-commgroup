  <?php
	include_once "../../../Config/config.ini.php";
	include_once PATH_NEGOCIO."Importacion/handlerimportacion.class.php";	
	include_once PATH_NEGOCIO.'Funciones/Fechas/fechas.class.php';		

	$dFecha = new Fechas;
	
	$fecha = (isset($_POST['fecha_importacion'])? $_POST['fecha_importacion']:'');
	$fecha_hora = (isset($_POST['fecha_hora'])? $_POST['fecha_hora']:'');

	$tipo_importacion = (isset($_POST['tipo_importacion'])? $_POST['tipo_importacion']:'');
	$id_empresa_sistema = (isset($_POST['id_empresa_sistema'])? $_POST['id_empresa_sistema']:'');
	$plaza = (isset($_POST['plaza'])? $_POST['plaza']:'');
	$cols = (isset($_POST['cols'])? $_POST['cols']:'');
	$rows = (isset($_POST['rows'])? $_POST['rows']:'');
	$forms = (isset($_POST['forms'])? $_POST['forms']:'');


	if(!empty($forms)){
		$err = "../../../../index.php?view=".$forms."&err=";     		
		$info = "../../../../index.php?view=".$forms."&info=";     		
	}
	else{
		$err = "../../../../index.php?view=importacion&err=";     		
		$info = "../../../../index.php?view=importacion&info=";     				
	}

	try {
		for ($i = 1; $i < $rows; ++$i) {
						
			for ($j = 0; $j < $cols; ++ $j) {
				$tag = $i."_".$j;
				$data[$i][$j] = (isset($_POST[$tag])? $_POST[$tag]:'');		

				if($j==1){
							
					if($dFecha->SumarDiasFechaActual(15)<date("Y-m-d", strtotime($data[$i][$j]))){
						header("Location: ".$err."No puede cargar registros con fecha mayor a los 15 dias. Ver registro nro ".$i);
						return;
					}

					if($dFecha->FechaActual()>date("Y-m-d", strtotime($data[$i][$j]))){
						header("Location: ".$err."No puede cargar registros con fecha menor al dia de la fecha. Ver registro nro ".$i);
						return;
					}					

				}
			}											
		}		

		if(!empty($forms)){
			$hd = (isset($_POST['horario_desde'])? $_POST['horario_desde']:'');
			$hh = (isset($_POST['horario_hasta'])? $_POST['horario_hasta']:'');

			$_POST["1_15"] = $hd." a ".$hh;
			$data[1][15] = $_POST["1_15"];
		}

		$handler = new handlerimportacion;    

		if($tipo_importacion==1)
        	$handler->guardarRegistrosTipo1($fecha,$fecha_hora,$id_empresa_sistema,$tipo_importacion,$plaza,$data);	

       	if($tipo_importacion==2)
       		$handler->guardarRegistrosTipo2($fecha,$fecha_hora,$id_empresa_sistema,$tipo_importacion,$plaza,$data);	

       	if($tipo_importacion==3)
       		$handler->guardarRegistrosTipo3($fecha,$fecha_hora,$id_empresa_sistema,$tipo_importacion,$plaza,$data);	

        $msj="Se guardaron todos los registros de la importación";
		header("Location: ".$info.$msj);
	}
	catch(Exception $e)
	{
		header("Location: ".$err.$e->getMessage());
	}

?>