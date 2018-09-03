<?php 
	#######################
	# Calculo de importes #
	#######################

	$diasLab = 30-$deLicSGS-$deLicCGS-$feriados;
	$basicoACob = floatval(number_format($diasLab*$basico*$jornada/30,2,'.',''));
	$feriadosACob = floatval(number_format($feriados*$basico*$jornada/25,2,'.',''));
	$licConACob = floatval(number_format($deLicCGS*$basico*$jornada/25,2,'.',''));
	$licSinACob = floatval(number_format(0,2,'.',''));
	$antigACob = floatval(number_format(($basicoACob+$feriadosACob+$licConACob+$licSinACob)*$antig/100,2,'.',''));
	$presentACob = floatval(number_format(($basicoACob+$feriadosACob+$licConACob+$licSinACob+$antigACob)*$concepto[0]['valor']/$concepto[0]['base'],2,'.',''));

	if ($total_puntajes_enviadas > $objetivo) {
		$comisionesACob = floatval(number_format(($total_puntajes_enviadas-$objetivo)*$concepto[1]['valor']/$concepto[1]['base'],2,'.',''));
		$comisionesValor = $total_puntajes_enviadas - $objetivo;
	} else {
		$comisionesACob = 0;
		$comisionesValor = 0;
	}
	

	$subtotalACob = $basicoACob+$feriadosACob+$licConACob+$licSinACob+$antigACob+$presentACob+$comisionesACob;

	$descJubilacion = floatval(number_format($subtotalACob * $concepto[2]['valor']/$concepto[2]['base'],2,'.',''));
	$descLey19032 = floatval(number_format($subtotalACob * $concepto[3]['valor']/$concepto[3]['base'],2,'.',''));
	$descObraSocial = floatval(number_format($subtotalACob * $concepto[4]['valor']/$concepto[4]['base'],2,'.',''));
	$descAEC = floatval(number_format($subtotalACob * $concepto[5]['valor']/$concepto[5]['base'],2,'.',''));
	$descFAECyS = floatval(number_format($subtotalACob * $concepto[6]['valor']/$concepto[6]['base'],2,'.',''));
	$descOSECAC = floatval(number_format(100,2,'.',''));

	$subtotalDesc = $descOSECAC+$descAEC+$descLey19032+$descJubilacion+$descFAECyS+$descObraSocial;

	$viaticos = floatval(number_format($reintegroTotal,2,'.',''));


 ?>