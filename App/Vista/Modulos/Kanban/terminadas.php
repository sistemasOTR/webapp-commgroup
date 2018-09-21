<style>
</style>

<?php 
	$arrTerminadas = $handlerKB->selectSolicitudesByEstado(3);
	$cantTerminadas = count($arrTerminadas);

	$list_terminadas = '';
	if (!empty($arrTerminadas)) {
		foreach ($arrTerminadas as $key => $value) {
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
			}
			$list_terminadas .= '<li class="item-flex"><a href="#" class="btn-sol" data-idsol="'.$value->getId().'" data-idoperador="'.$user->getId().'">'.$value->getTitulo().' </a><span class="lsp"><span>'.$inicio.'</span><span>'.$asig.'</span><span>'.$prior.'</span></span></li>';
		}
	}


 ?>



 