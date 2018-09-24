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
  $desc = $_POST['desc'];
  $id_operador = $_POST['id_operador'];

  $err = "index.php?view=kanban&err=";        
  $info = "index.php?view=kanban&info=";
  $rta ='';
  try {

    $handlerKB->editDescKanban($desc,intval($id),intval($id_operador));

    // $arrComments = $handlerKB->selectComentariosById($id_kanban);
    // if (!empty($arrComments)) {
    //   $rta .= '<div class="col-xs-12"><h4>Comentarios</h4></div>';
    //   $rta .= '<div class="col-xs-12 historia" style="border-bottom:1px solid #ccc;">';
    //   foreach ($arrComments as $comentario) {
    //     $operador = $handlerUs->selectById(intval($comentario->getIdOperador()));

    //     $rta .= '<li style="padding: 5px 0; color:#333;" class="item-flex"><span class="btn-sol"><b>'.strtoupper($operador->getNombre()[0].'. '.$operador->getApellido()).'</b><br><span class="direct-chat-text">'.$comentario->getComentario().'.</span></span><span class="lsa"><b>'.$comentario->getFechaHora()->format('d-m H:i').'</b></span></li>';

    //   }
    //   $rta .= '</div>';
    // }

    $msj="Cambio de estado realizado con éxito";
    echo $rta;
          
  } catch (Exception $e) {
    header("Location: ".$err.$e->getMessage());
  }  

  ?>