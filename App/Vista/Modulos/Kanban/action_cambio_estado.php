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
  $estado = $_POST['estado'];
  $id_operador=$_POST["id_operador"];
  if ($estado != 10) {
    $err ="index.php?view=kanban&id_sol=".$id."&err=";        
    $info ="index.php?view=kanban&id_sol=".$id."&info=";
  } else {
    $err ="index.php?view=kanban&err=";        
    $info ="index.php?view=kanban&info=";
  }

  try {

    $handlerKB->cambiarEstadoKB($id,$estado,$id_operador);

    $msj="Cambio de estado realizado con éxito";
    echo $info.$msj;
          
  } catch (Exception $e) {
   echo $err.$e->getMessage();
  }  

  ?>