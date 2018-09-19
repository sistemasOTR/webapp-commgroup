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

			if ($value->getIdEnc() == 0) {
				$asig = '<i class="fa fa-lg text-gray fa-user-plus"></i>';
				$userAsignado = '';
			} else {
				$usuario = $handlerUs->selectById(intval($value->getIdEnc()));
				$avatar = strtoupper($usuario->getNombre()[0].$usuario->getApellido()[0]);
				$userAsignado = $usuario->getId();

				$asig = '<span data-toggle="tooltip" data-original-title="'.$usuario->getNombre().' '.$usuario->getApellido().'">'.$avatar.'</span>';
			}

			if ($value->getInicioEst()->format('Y-m-d') != '1900-01-01') {
				$inicio = $value->getFinEst()->format('d-m');
			} else {
				$inicio = '<i class="fa fa-lg fa-calendar-plus-o"></i>';
			}
			$list_EnCurso .= '<li class="item-flex"><a href="#" class="btn-sol" data-idsol="'.$value->getId().'" data-idoperador="'.$user->getId().'">'.$value->getTitulo().' </a><span class="lsp"><a href="#" id="fecha_'.$value->getId().'" data-id="'.$value->getId().'" data-inicio="'.$value->getInicioEst()->format('Y-m-d').'" data-fin="'.$value->getFinEst()->format('Y-m-d').'" data-toggle="modal" data-target="#modal-fechas" class="btn-enc" onclick="asigFecha('.$value->getId().')">'.$inicio.'</a><a href="#" id="asig_'.$value->getId().'" data-id="'.$value->getId().'" data-iduser="'.$userAsignado.'" data-toggle="modal" data-target="#modal-usuario" class="btn-enc" onclick="asigUser('.$value->getId().')">'.$asig.'</a><a href="">'.$prior.'</a></span></li>';
		}
	}


 ?>



 