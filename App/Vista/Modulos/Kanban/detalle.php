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


  $url_action_cambio_estado = PATH_VISTA.'Modulos/Kanban/action_cambio_estado.php';
  $url_action_nuevo_comentario = PATH_VISTA.'Modulos/Kanban/action_nuevo_comentario.php';
  $respuesta = '';

  $solicitud = $handlerKB->selectById($id);

  $arrSolHistorico=$handlerKB->selectHistoricoById($id);
  $arrSolComentarios=$handlerKB->selectComentariosById($id);

  switch ($solicitud->getPrioridad()) {
        case 0:
              $prior = '<span><i class="fa fa-arrow-down text-green"></i></span>';
              break;
            case 1:
              $prior = '<span><i class="fa fa-arrow-right text-yellow"></i></span>';
              break;
            case 2:
              $prior = '<span><i class="fa fa-arrow-up text-red"></i></span>';
              break;
            
            default:
              $prior = '<span><i class="fa fa-arrow-down text-green"></i></span>';
              break;
      }

      if ($solicitud->getIdEnc() == 0) {
        $asig = '<span class="asig-user-image" style="border: 1px dashed #d2d6de !important;"><i class="fa fa-lg text-gray fa-user-plus"></i></span><span class="text-black">Asignado a:<br><b> Nadie </b></span>';
        $userAsignado = '';
      } else {
        $usuario = $handlerUs->selectById(intval($solicitud->getIdEnc()));
        $userAsignado = $usuario->getId();

        $asig = '<span class="bg-teal asig-user-image">'.strtoupper($usuario->getNombre()[0].' '.$usuario->getApellido()[0]).'</span><span class="text-black">Asignado a:<br><b>'.$usuario->getNombre().' '.$usuario->getApellido().'</b></span>';
      }

      if ($solicitud->getFinEst()->format('Y-m-d') != '1900-01-01' ) {
        $inicio = "Entrega estimada:<br><b>".$solicitud->getFinEst()->format('d-m')."</b>";
      } else {
        $inicio = '<i class="fa fa-lg fa-calendar-plus-o asig-user-image"></i> Entrega estimada:<br><b> Ninguna </b>';
      }

      if ($solicitud->getFinEst()->format('Y-m-d') != '1900-01-01' && $solicitud->getEstadoKb() == 3) {
        $inicio .= "<br>Entrega real:<br><b>".$solicitud->getFinReal()->format('d-m')."</b>";
      }



      switch ($solicitud->getEstadoKb()) {
        case 0:
          if ($solicitud->getFinEst()->format('Y-m-d') == '1900-01-01' || $solicitud->getIdEnc() == 0) {
            $btn_accion = '<button class="btn btn-danger pull-right btn-accion" data-idoperador="'.$id_operador.'" data-id="'.$solicitud->getId().'" data-estado="10" style="margin-right:10px;">Eliminar</button> ';
          } else {
            $btn_accion = ' <button class="btn btn-warning pull-right btn-accion" data-idoperador="'.$id_operador.'" data-id="'.$solicitud->getId().'" data-estado="1">Iniciar</button>';
          }
          
          break;
        case 1:
          $btn_accion = ' <a href="#" class="btn btn-info pull-right btn-accion" data-idoperador="'.$id_operador.'" data-id="'.$solicitud->getId().'" data-estado="2">Revisar</a>';
          break;
        case 2:
          $btn_accion = ' <a href="#" class="btn btn-success pull-right btn-accion" data-idoperador="'.$id_operador.'" data-id="'.$solicitud->getId().'" data-estado="3">Terminar</a> <a href="#" class="btn btn-warning pull-right btn-accion" data-idoperador="'.$id_operador.'" data-id="'.$solicitud->getId().'" data-estado="1" style="margin-right:10px;">Reiniciar</a>';
          break;
        case 3:
          $btn_accion = '<i class="fa fa-check text-green pull-right"></i>';
          break;
        
        default:
          # code...
          break;
      }


      $respuesta.= '<div class="box box-solid">
                  <div class="box-header with-border">
                    <h2 class="box-title">'.$solicitud->getTitulo().'</h2>
                    '.$btn_accion.'
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body div-conteiner">';
    if ($solicitud->getEstadoKb() != 3) {
      $respuesta .= '<div class="asignaciones col-xs-12 with-border"><a href="#" id="fecha_'.$solicitud->getId().'" data-id="'.$solicitud->getId().'" data-fin="'.$solicitud->getFinEst()->format('Y-m-d').'" data-toggle="modal" data-target="#modal-fechas" class="col-md-4 col-xs-6 text-black" onclick="asigFecha('.$solicitud->getId().')">'.$inicio.'</a><a href="#" id="asig_'.$solicitud->getId().'" data-id="'.$solicitud->getId().'" data-iduser="'.$userAsignado.'" data-toggle="modal" data-target="#modal-usuario" class="col-md-4 col-xs-6 text-black" onclick="asigUser('.$solicitud->getId().')">'.$asig.'</a><a href="" class="col-md-4 col-xs-12 text-black">Prioridad:<br>'.$prior.'</a></span></div>';
    } else {
      $respuesta .= '<div class="asignaciones col-xs-12 with-border"><span class="col-md-4 col-xs-6 text-black" >'.$inicio.'</span><span class="col-md-4 col-xs-6 text-black">'.$asig.'</span><span class="col-md-4 col-xs-12 text-black">Prioridad:<br>'.$prior.'</span></span></div>';
    }

    
  $respuesta .= '<div class="col-xs-12"><h3>Descripción</h3></div>';
  $respuesta .= '<div class="col-xs-12" style="border: 1px solid #eee;border-radius:5px;min-height:150px;" id="desc_detalle"  contenteditable="true">'.$solicitud->getDescripcion().'</div>';

  $respuesta .= '<div class="comentarios">';
  if (!empty($arrSolComentarios)) {
    $respuesta .= '<div class="col-xs-12"><h4>Comentarios</h4></div>';
    $respuesta .= '<div class="col-xs-12 historia" style="border-bottom:1px solid #ccc;">';
      foreach ($arrSolComentarios as $comentario) {
        $operador = $handlerUs->selectById(intval($comentario->getIdOperador()));

        $respuesta .= '<li style="padding: 5px 0; color: #333;" class="item-flex"><span class="btn-sol"><b>'.strtoupper($operador->getNombre()[0].'. '.$operador->getApellido()).'</b><span class="direct-chat-text">'.$comentario->getComentario().'.</span></span><span class="lsa"><b>'.$comentario->getFechaHora()->format('d-m H:i').'</b></span></li>';

      }
    $respuesta .= '</div>';
  }

  $respuesta .= '</div>';
  $respuesta .= '<div class="col-xs-12"><h4>Historico</h4></div>';
  $respuesta .= '<div class="col-xs-12 historia">';
  if (!empty($arrSolHistorico)) {
    foreach ($arrSolHistorico as $histo) {
      $operador = $handlerUs->selectById(intval($histo->getIdOperador()));


     switch ($histo->getTipoCambio()) {
       case 0:
         $respuesta .= '<li style="padding: 5px 0;" class="item-flex"><span class="btn-sol"><b>'.strtoupper($operador->getNombre()[0].'. '.$operador->getApellido()).'</b> creó la solicitud</span><span class="lsa"><b>'.$histo->getFechaHora()->format('d-m H:i').'</b></span></li>';
         break;
       case 1:
          switch ($histo->getEstadoKb()) {
            case 1:
              $cambio = 'puso la tarea en curso';
              break;
            case 2:
              $cambio = 'pasó la tarea a revisión';
              break;
            case 3:
              $cambio = 'dió por terminada la tarea';
              break;
            
            default:
              # code...
              break;
          }
         $respuesta .= '<li style="padding: 5px 0;" class="item-flex"><span class="btn-sol"><b>'.strtoupper($operador->getNombre()[0].'. '.$operador->getApellido()).'</b> '.$cambio.'.</span><span class="lsa"><b>'.$histo->getFechaHora()->format('d-m H:i').'</b></span></li>';
         break;
       case 2:
          $encargado = $handlerUs->selectById(intval($histo->getIdEnc()));
         $respuesta .= '<li style="padding: 5px 0;" class="item-flex"><span class="btn-sol"><b>'.strtoupper($operador->getNombre()[0].'. '.$operador->getApellido()).'</b> asignó la tarea a <b>'.strtoupper($encargado->getNombre()[0].'. '.$encargado->getApellido()).'</b></span><span class="lsa"><b>'.$histo->getFechaHora()->format('d-m H:i').'</b></span></li>';
         break;
       case 3:
         $respuesta .= '<li style="padding: 5px 0;" class="item-flex"><span class="btn-sol"><b>'.strtoupper($operador->getNombre()[0].'. '.$operador->getApellido()).'</b> asignó la fecha de entrega para el '.$histo->getFinEst()->format('d-m').'</span><span class="lsa"><b>'.$histo->getFechaHora()->format('d-m H:i').'</b></span></li>';
         break;
       case 4:
         $respuesta .= '<li style="padding: 5px 0;" class="item-flex"><span class="btn-sol"><b>'.strtoupper($operador->getNombre()[0].'. '.$operador->getApellido()).'</b> creó la solicitud</span><span class="lsa"><b>'.$histo->getFechaHora()->format('d-m H:i').'</b></span></li>';
         break;
       
       default:
         # code...
         break;
     }
    }
  }



$respuesta.= '</div>
                </div>';
                if ($solicitud->getEstadoKb() != 3) {
                  $respuesta .= '<div class="box-footer">
                    <a href="#" id="coment_'.$solicitud->getId().'" data-id="'.$solicitud->getId().'" data-toggle="modal" data-target="#modal-comentarios" class="text-black pull-right" onclick="comentar('.$solicitud->getId().')">Comentar 
                    <i class="fa fa-comment-o fa-lg"></i></a>
                  </div>';
                }
                
$respuesta .= '</div>';
  echo $respuesta;
?>

<script type="text/javascript">
  $(document).ready(function(){                
    $(".btn-accion").on('click',function(){
      
      var id = $(this).attr("data-id"),
          estado = $(this).attr("data-estado"),
          id_operador = $(this).attr("data-idoperador"),
          self=this;

          // console.log(id,estado);
          $.ajax({
              type: "POST",
              url: '<?php echo $url_action_cambio_estado; ?>',
              data: {
                  id: id,
                  id_operador: id_operador,
                  estado: estado
              },
              success: function(data){
                  window.location = data;
              }
          });
    });



    try{
      CKEDITOR.disableAutoInline = true;
    CKEDITOR.inline( 'desc_detalle' );
    }catch(e){}

  });
</script>