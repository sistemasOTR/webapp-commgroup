<?php 


	include_once "../../../Config/config.ini.php";
	include_once '../../../Datos/BaseDatos/conexionapp.class.php';
	include_once '../../../Datos/BaseDatos/sql.class.php';
	include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
	include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
	include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";     
	include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 
	include_once PATH_NEGOCIO."Modulos/handlerkanban.class.php"; 
	include_once PATH_NEGOCIO."Funciones/String/string.class.php";
	$handlerUs = new HandlerUsuarios;
	$dFecha = new Fechas;
	$handlerKB = new HandlerKanban;
	$id = $_POST['id'];
	$id_operador = $_POST['id_operador'];
	$prioridad = $_POST['prioridad'];

  $respuesta = '';
  $err ="index.php?view=kanban&id_sol=".$id."&err=";        
  $info ="index.php?view=kanban&id_sol=".$id."&info=";


  try {

    $handlerKB->cambiarPrioridad($id,$prioridad,$id_operador);

    $msj="Cambio de estado realizado con éxito";
    echo $info.$msj;
          
  } catch (Exception $e) {
   echo $err.$e->getMessage();
  }  

 ?>