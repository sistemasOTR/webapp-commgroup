<?php 
	if(!empty($consulta))
  {
    $gestPlaza = '';
    $nomGestores = '';
    foreach ($consulta as $key => $value) { 
      if ($gestPlaza == '') {
        $gestPlaza[] = $value->COD_GESTOR;
        $nomGestores[$value->COD_GESTOR] = $value->NOM_GESTOR;
      }
      if (!in_array($value->COD_GESTOR, $gestPlaza)) {
        $gestPlaza[] = $value->COD_GESTOR;
        $nomGestores[$value->COD_GESTOR] = $value->NOM_GESTOR;
      }
      // $objetivo = $handlerP->buscarObjetivoCoordinador($value->NOM_COORDINADOR);
      
      $fechaPuntajeActual = $handlerPuntaje->buscarFechaPuntaje();
                    $localidad = strtoupper($value->LOCALIDAD);
                    $localidad = str_replace('(', '', $localidad);
                    $localidad = str_replace(')', '', $localidad);
      if ($value->FECHA->format('d-m-Y')>= $fechaPuntajeActual->format('d-m-Y')) {
                  $puntaje = $handlerPuntaje->buscarPuntaje($value->COD_EMPRESA);
                  if ($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $localidad == 'ROSARIO') {
                    $puntaje = 2;
                  }
                } else {
                  $puntaje = $handlerPuntaje->buscarPuntajeFecha($value->COD_EMPRESA,$value->FECHA->format('Y-m-d'));
                  if ($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $localidad == 'ROSARIO') {
                    $puntaje = 2;
                  }
                }

                if (($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && $value->FECHA->format('d-m-Y') <= date('d-m-Y',strtotime('31-06-2018'))) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $localidad == 'ROSARIO') {

                  if(empty($puntaje))
                    $puntaje_enviadas = 0;
                  else
                    $puntaje_enviadas = round($value->TOTAL_SERVICIOS*$puntaje,2);

                  	$total_coord_puntajes_enviadas += $puntaje_enviadas;

                }else{
                  if(empty($puntaje))
                    $puntaje_cerrados = 0;
                  else
                    $puntaje_cerrados = round($value->CERRADO*$puntaje,2);

                  if(empty($puntaje))
                    $puntaje_enviadas = 0;
                  else
                    $puntaje_enviadas = round($value->ENVIADO*$puntaje,2);

                  	$total_coord_puntajes_enviadas += $puntaje_enviadas; 
                }

                $total_coord_servicios += $value->TOTAL_SERVICIOS;
                $total_coord_servicios_cerrados += $value->CERRADO;
                $total_coord_servicios_enviadas += $value->ENVIADO;                      
    }
  }

 ?>