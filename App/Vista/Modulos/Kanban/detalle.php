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
  $respuesta = '';

  $solicitud = $handlerKB->selectById($id);

  $arrSolHistorico=$handlerKB->selectHistoricoById($id);

  switch ($solicitud->getPrioridad()) {
        case 0:
          $prior = '<span class="label label-success">BAJA</span>';
          break;
        case 1:
          $prior = '<span class="label label-warning">MEDIA</span>';
          break;
        case 2:
          $prior = '<span class="label label-danger">ALTA</span>';
          break;
        
        default:
          $prior = '<span class="label label-success">BAJA</span>';
          break;
      }

      if ($solicitud->getIdEnc() == 0) {
        $asig = '<i class="fa fa-lg text-gray fa-user-plus"></i> Sin usuario asigado';
        $userAsignado = '';
      } else {
        $usuario = $handlerUs->selectById(intval($solicitud->getIdEnc()));

        if(StringUser::emptyUser($usuario->getFotoPerfil()))
          $foto_perfil = PATH_VISTA."assets/dist/img/sinlogo_usuario.png";                                                        
        else                  
          $foto_perfil = PATH_CLIENTE.$usuario->getFotoPerfil();
        // $avatar = $usuario->getFotoPerfil();
        $userAsignado = $usuario->getId();

        $asig = '<span class="text-black"><img src='.$foto_perfil.' class="asig-user-image" alt="User Image"/></span><span class="text-black"> - '.$usuario->getNombre().' '.$usuario->getApellido().'</span>';
      }

      if ($solicitud->getInicioEst()->format('Y-m-d') != '1900-01-01') {
        $inicio = 'Inicio estimado: '.$solicitud->getInicioEst()->format('d-m')."<br>Final estimado: ".$solicitud->getFinEst()->format('d-m');
      } else {
        $inicio = '<i class="fa fa-lg fa-calendar-plus-o"></i> Sin fechas estimadas';
      }

      switch ($solicitud->getEstadoKb()) {
        case 0:
          $btn_accion = ' <button class="btn btn-warning pull-right btn-accion" data-idoperador="'.$id_operador.'" data-id="'.$solicitud->getId().'" data-estado="1">Iniciar <i class="fa fa-angle-double-right"></i></button>';
          break;
        case 1:
          $btn_accion = ' <a href="#" class="btn btn-info pull-right btn-accion" data-idoperador="'.$id_operador.'" data-id="'.$solicitud->getId().'" data-estado="2">A revisión <i class="fa fa-angle-double-right"></i></a>';
          break;
        case 2:
          $btn_accion = ' <a href="#" class="btn btn-success pull-right btn-accion" data-idoperador="'.$id_operador.'" data-id="'.$solicitud->getId().'" data-estado="3">Terminar <i class="fa fa-angle-double-right"></i></a>';
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
  
  $respuesta .= '<div class="asignaciones col-xs-12 with-border"><a href="#" id="fecha_'.$solicitud->getId().'" data-id="'.$solicitud->getId().'" data-inicio="'.$solicitud->getInicioEst()->format('Y-m-d').'" data-fin="'.$solicitud->getFinEst()->format('Y-m-d').'" data-toggle="modal" data-target="#modal-fechas" class="col-md-4 text-black" onclick="asigFecha('.$solicitud->getId().')">'.$inicio.'</a><a href="#" id="asig_'.$solicitud->getId().'" data-id="'.$solicitud->getId().'" data-iduser="'.$userAsignado.'" data-toggle="modal" data-target="#modal-usuario" class="col-md-4 text-black" onclick="asigUser('.$solicitud->getId().')">'.$asig.'</a><a href="" class="col-md-4 text-black">Prioridad: '.$prior.'</a></span></div>';
  $respuesta .= '<div class="col-xs-12"><hr></div>';
  $respuesta .= '<div class="col-xs-12"><h3>Descripción</h3></div>';
  $respuesta .= '<div class="col-xs-12" style="border: 1px solid #eee;border-radius:5px;min-height:150px;" id="descripcion">'.$solicitud->getDescripcion().'</div>';

  $respuesta .= '<div class="col-xs-12"><h3>Acciones</h3></div>';
  $respuesta .= '<div class="col-xs-12">';
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
         $respuesta .= '<li style="padding: 5px 0;" class="item-flex"><span class="btn-sol"><b>'.strtoupper($operador->getNombre()[0].'. '.$operador->getApellido()).'</b> estimó la tarea desde el '.$histo->getInicioEst()->format('d-m').' al '.$histo->getFinEst()->format('d-m').'</span><span class="lsa"><b>'.$histo->getFechaHora()->format('d-m H:i').'</b></span></li>';
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
                </div>
                </div>';
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
});
</script>