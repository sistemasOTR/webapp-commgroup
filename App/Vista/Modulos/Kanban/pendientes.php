<style>
	.lsp {flex-grow: 1;padding:10px 0px;}
	.lsp a {padding: 5px}
	.item-flex {display: flex !important;}
	.btn-sol {flex-grow: 100;}
</style>

<?php 
	$arrPend = $handlerKB->selectSolicitudesByEstado(0);
	$cantPend = count($arrPend);

	$list_pendientes = '';
	if (!empty($arrPend)) {
		foreach ($arrPend as $key => $value) {
			switch ($value->getPrioridad()) {
				case 0:
					$prior = '<i class="fa fa-lg fa-battery-empty text-green"></i>';
					break;
				case 1:
					$prior = '<i class="fa fa-lg fa-battery-half text-yellow"></i>';
					break;
				case 2:
					$prior = '<i class="fa fa-lg fa-battery-full text-red"></i>';
					break;
				
				default:
					$prior = '<i class="fa fa-lg fa-battery-empty text-green"></i>';
					break;
			}

			if ($value->getIdEnc() == '') {
				$asig = '<i class="fa fa-lg text-gray fa-user-plus"></i>';
			} else {
				$usuario = $handlerUs->selectById(intval($value->getIdEnc()));
				$avatar = $usuario->getNombre()[0].$usuario->getApellido()[0];

				$asig = '<span data-toggle="tooltip" data-original-title="'.$usuario->getNombre().' '.$usuario->getApellido().'">'.$avatar.'</span>';
			}

			if (!is_null($value->getInicioEst())) {
				$inicio = $value->getInicioEst()->format('d-m');
			} else {
				$inicio = '<i class="fa fa-lg fa-calendar-plus-o"></i>';
			}
			$list_pendientes .= '<li class="item-flex"><a href="#" class="btn-sol" data-idsol="'.$value->getId().'">'.$value->getTitulo().' </a><span class="pull-right lsp"><a href="">'.$inicio.'</a><a href="">'.$asig.'</a><a href="">'.$prior.'</a></span></li>';
		}
	}


 ?>



 