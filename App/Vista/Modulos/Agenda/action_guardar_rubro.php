<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handleragenda.class.php";       
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";
	
	$handler = new HandlerAgenda();
	$handlerFecha = new Fechas;
		
	$nombre = (isset($_POST["nombre"])?$_POST["nombre"]:'');
	$id = (isset($_POST["idRubro"])?$_POST["idRubro"]:'');
	$accion = (isset($_POST["accion"])?$_POST["accion"]:'');
	$fecha_hora = $handlerFecha->FechaHoraActual();
	
	
	try {
		
		$err = "../../../../index.php?view=agenda_rubros&err=";     		
		$info = "../../../../index.php?view=agenda_rubros&info=";

			if ($accion == 'nuevo') {
				$handler->guardarRubro($nombre);
			} elseif ($accion == 'editar') {
				$handler->actualizarRubro($nombre,$id);
			} elseif ($accion == 'baja') {
				$handler->bajaRubro($id);
			} elseif ($accion == 'alta') {
				$handler->altaRubro($id);
			}
		
		
		$msj="Empresa ".$nombre." guardada con éxito";
		header("Location: ".$info.$msj);																						
		
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>