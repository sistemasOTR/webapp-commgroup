<style>
</style>

<?php 
	$arrEnCurso = $handlerKB->selectSolicitudesByEstado(1);
	$cantEnCurso = count($arrEnCurso);

	$list_EnCurso = '';
	if (!empty($arrEnCurso)) {
		foreach ($arrEnCurso as $key => $value) {
			switch ($value->getPrioridad()) {
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

			if ($value->getIdEnc() == 0) {
				$asig = '<i class="fa fa-lg text-gray fa-user-plus"></i>';
				$userAsignado = '';
			} else {
				$usuario = $handlerUs->selectById(intval($value->getIdEnc()));
				$avatar = strtoupper($usuario->getNombre()[0]." ".$usuario->getApellido()[0]);
				$userAsignado = $usuario->getId();

				$asig = '<span data-toggle="tooltip" data-original-title="'.$usuario->getNombre().' '.$usuario->getApellido().'">'.$avatar.'</span>';
			}

			if ($value->getFinEst()->format('Y-m-d') != '1900-01-01') {
				$inicio = $value->getFinEst()->format('d-m');
			} else {
				$inicio = '<i class="fa fa-lg fa-calendar-plus-o"></i>';
			$list_EnCurso .= '<li class="item-flex"><a href="#" class="btn-sol" data-idsol="'.$value->getId().'" data-idoperador="'.$user->getId().'">'.$value->getTitulo().' </a><span class="lsp"><a href="#" id="fecha_'.$value->getId().'" data-id="'.$value->getId().'" data-fin="'.$value->getFinEst()->format('Y-m-d').'" data-toggle="modal" data-target="#modal-fechas" class="btn-enc" onclick="asigFecha('.$value->getId().')">'.$inicio.'</a><a href="#" id="asig_'.$value->getId().'" data-id="'.$value->getId().'" data-iduser="'.$userAsignado.'" data-toggle="modal" data-target="#modal-usuario" class="btn-enc" onclick="asigUser('.$value->getId().')">'.$asig.'</a><span id="'.$value->getId().'_prioridad"><a href="#" id="prior_'.$value->getId().'" data-id="'.$value->getId().'" data-prior="'.$value->getPrioridad().'" data-toggle="modal" data-target="#modal-prioridad" class="btn-enc" onclick="asigPrior('.$value->getId().')">'.$prior.'</a></span></span></li>';
		}
	}


 ?>



 