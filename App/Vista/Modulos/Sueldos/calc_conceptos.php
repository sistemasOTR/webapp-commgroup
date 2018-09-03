<?php 
	########################
	# Calculo de conceptos #
	########################

	$arrConceptos = $handlerSueldos->selectConceptos();

	if (!empty($arrConceptos)) {
		foreach ($arrConceptos as $key => $value) {
			$concepto[] = array('valor' => $value->getValor() , 
								'base' => $value->getBase());
		}
	}

 ?>