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

	$handlerKB->cambiarPrioridad($id,$prioridad,$id_operador);

	$solicitud = $handlerKB->selectById($id);

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

      // var_dump($solicitud);

	$respuesta .= '<a href="#" id="prior_'.$solicitud->getId().'" data-id="'.$solicitud->getId().'" data-prior="'.$solicitud->getPrioridad().'" data-toggle="modal" data-target="#modal-prioridad" class="btn-enc" onclick="asigPrior('.$solicitud->getId().')">'.$prior.'</a>|<a href="#" id="prior_'.$solicitud->getId().'" data-id="'.$solicitud->getId().'" data-prior="'.$solicitud->getPrioridad().'" data-toggle="modal" data-target="#modal-prioridad" class="btn-enc col-md-4 col-xs-12 text-black" onclick="asigPrior('.$solicitud->getId().')">Prioridad:<br>'.$prior.'</a>|';

	$arrSolHistorico=$handlerKB->selectHistoricoById($id);

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
        switch ($histo->getPrioridad()) {
        case 0:
              $prior = 'BAJA';
              break;
            case 1:
              $prior = 'MEDIA';
              break;
            case 2:
              $prior = 'ALTA';
              break;
            
            default:
              $prior = 'BAJA';
              break;
      }


         $respuesta .= '<li style="padding: 5px 0;" class="item-flex"><span class="btn-sol"><b>'.strtoupper($operador->getNombre()[0].'. '.$operador->getApellido()).'</b> cambió la prioridad de la tarea a '.$prior.'</span><span class="lsa"><b>'.$histo->getFechaHora()->format('d-m H:i').'</b></span></li>';
         break;
       
       default:
         # code...
         break;
     }
    }
  }

	echo $respuesta;

 ?>