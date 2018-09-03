<?php 
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handlersueldos.class.php"; 
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php"; 

	$handler = new HandlerSueldos;

	$idsueldo=(isset($_POST["idsueldo"])?$_POST["idsueldo"]:'');
	$basico=(isset($_POST["basico"])?$_POST["basico"]:'');
	$jornada=(isset($_POST["jornada"])?$_POST["jornada"]:'');
	$categoria=(isset($_POST["categoria"])?$_POST["categoria"]:'');
	$remu_totales=(isset($_POST["remu_totales"])?$_POST["remu_totales"]:'');
	$desc_totales=(isset($_POST["desc_totales"])?$_POST["desc_totales"]:'');
	$no_remu_totales=(isset($_POST["no_remu_totales"])?$_POST["no_remu_totales"]:'');

	$cant=(isset($_POST["cant_totales"])?$_POST["cant_totales"]:0);

	$datos='';
	for ($i=1; $i <= intval($cant) ; $i++) { 
		$datos[] = array('concepto' => $_POST['concepto_'.$i],
						'unidad' => $_POST['unidades_'.$i],
						'remunerativo' => $_POST['remu_'.$i],
						'descuento' => $_POST['desc_'.$i],
						'no_remunerativo' => $_POST['no_remu_'.$i] );
	}

	$err = "../../../../index.php?view=sueldos_form&idsueldo=".$idsueldo."&err=";
	$info = "../../../../index.php?view=sueldos_remun&info=";

	try {

		if (!empty($datos)) {
			foreach ($datos as $key => $value) {
				$handler->newItem($idsueldo,$value['concepto'],$value['unidad'],$value['remunerativo'],$value['descuento'],$value['no_remunerativo']);
			}
		}

		$handler->actualizarSueldo($idsueldo,$basico,$jornada,$categoria,$remu_totales,$desc_totales,$no_remu_totales);
		
		$msj="Sueldo creado con éxito";
		header("Location: ".$info.$msj);

	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}


 ?>