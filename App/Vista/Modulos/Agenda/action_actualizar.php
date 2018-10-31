<?php
	include_once "../../../Config/config.ini.php";	

	include_once PATH_NEGOCIO."Modulos/handleragenda.class.php";       
  	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";
	
	$handler = new HandlerAgenda();
	$handlerFecha = new Fechas;
		
	$id = (isset($_POST["id"])?$_POST["id"]:'');
	$nombre = (isset($_POST["nombre"])?$_POST["nombre"]:'');
	$rubro = (isset($_POST["rubro"])?$_POST["rubro"]:'');
	$domicilio = (isset($_POST["domicilio"])?$_POST["domicilio"]:'');
	$web = (isset($_POST["web"])?$_POST["web"]:'');
	$per_contacto_1 = (isset($_POST["per_contacto_1"])?$_POST["per_contacto_1"]:'');
	$puesto_1 = (isset($_POST["puesto_1"])?$_POST["puesto_1"]:'');
	$telefono_1 = (isset($_POST["telefono_1"])?$_POST["telefono_1"]:'');
	$email_1 = (isset($_POST["email_1"])?$_POST["email_1"]:'');
	$per_contacto_2 = (isset($_POST["per_contacto_2"])?$_POST["per_contacto_2"]:'');
	$puesto_2 = (isset($_POST["puesto_2"])?$_POST["puesto_2"]:'');
	$telefono_2 = (isset($_POST["telefono_2"])?$_POST["telefono_2"]:'');
	$email_2 = (isset($_POST["email_2"])?$_POST["email_2"]:'');
	$plaza = (isset($_POST["plaza"])?$_POST["plaza"]:'');
	$instancia = (isset($_POST["instancia"])?$_POST["instancia"]:'');
	$fecha_hora = $handlerFecha->FechaHoraActual();
	
	try {
		
		$err = "../../../../index.php?view=agenda_detalle&fid=".$id."&err=";     		
		$info = "../../../../index.php?view=agenda_detalle&fid=".$id."&info=";

			$handler->actualizarEmpresa($id,$fecha_hora,$nombre,$rubro,$domicilio,$web,$per_contacto_1,$puesto_1,$telefono_1,$email_1,$per_contacto_2,$puesto_2,$telefono_2,$email_2,$plaza,$instancia);
		
		
		$msj="Empresa ".$nombre." guardada con éxito";
		header("Location: ".$info.$msj);																						
		
	} catch (Exception $e) {
		header("Location: ".$err.$e->getMessage());
	}
	
?>