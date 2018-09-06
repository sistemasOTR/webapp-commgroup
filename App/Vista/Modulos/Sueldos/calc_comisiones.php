<?php
    #########################
    # Calculo de comisiones #
    #########################

    $userPuntaje = $handlerUsuarios->selectById($sueldo->getIdUsuario());
    $total_servicios = 0;
    $total_servicios_cerrados = 0;
    $total_efectividad = 0;
    $total_puntajes_cerrados = 0;

    $total_servicios_enviadas = 0;
    $total_puntajes_enviadas = 0;

    $fDesdeCom = date('Y-m-01',strtotime($fDesde.' -1 days'));
    $fHastaCom = date('Y-m-t',strtotime($fDesde.' -1 days'));

    $objetivo=0;
    $consulta = $handlerConsultas->consultaPuntajes($fDesdeCom, $fHastaCom, $userPuntaje->getUserSistema());

    if(!empty($consulta))
    {
        foreach ($consulta as $key => $value) {
            $fechaPuntajeActual = $handlerPuntaje->buscarFechaPuntaje();
        
        if ($fechaPuntajeActual->format('Y-m-d') <= $value->FECHA->format('Y-m-d')) {
            $objetivo = $handlerPuntaje->buscarObjetivo($value->COD_GESTOR); 
        }else{
            $objetivo = $handlerPuntaje->buscarPuntajeFechaGestor($value->COD_GESTOR,$fHastaInv);                        
            }
        
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
        
        if(empty($objetivo))                                                  
            $objetivo = 0;

        if (($value->FECHA->format('d-m-Y') >= date('d-m-Y',strtotime('01-06-2018')) && $value->FECHA->format('d-m-Y') <= date('d-m-Y',strtotime('31-06-2018'))) && ($value->COD_EMPRESA == 39 || $value->COD_EMPRESA==41) && $localidad == 'ROSARIO') {

            if(empty($puntaje))
            $puntaje_enviadas = 0;
            else
            $puntaje_enviadas = round($value->TOTAL_SERVICIOS*$puntaje,2);

            $total_puntajes_enviadas = $total_puntajes_enviadas + $puntaje_enviadas;

        }else{
            if(empty($puntaje))
            $puntaje_cerrados = 0;
            else
            $puntaje_cerrados = round($value->CERRADO*$puntaje,2);

            if(empty($puntaje))
            $puntaje_enviadas = 0;
            else
            $puntaje_enviadas = round($value->ENVIADO*$puntaje,2);

            $total_puntajes_cerrados = $total_puntajes_cerrados + $puntaje_cerrados;
            $total_puntajes_enviadas = $total_puntajes_enviadas + $puntaje_enviadas; 
        }

        $total_servicios = $total_servicios + $value->TOTAL_SERVICIOS;
        $total_servicios_cerrados = $total_servicios_cerrados + $value->CERRADO;
        $total_servicios_enviadas = $total_servicios_enviadas + $value->ENVIADO;
        }
    }

    if($objetivo != 0){
        if ($total_puntajes_enviadas > $objetivo) {
            $clase_medidor = 'class="info-box bg-green"';
            $puntajePorciento = round(($total_puntajes_enviadas - $objetivo)*100/$objetivo,2);
            $txtPuntajePorciento = round($total_puntajes_enviadas * 100/$objetivo,2);
            } else {
            $clase_medidor = 'class="info-box bg-yellow"';
            $puntajePorciento = round(($total_puntajes_enviadas) * 100 /$objetivo,2);
            $txtPuntajePorciento = round($total_puntajes_enviadas * 100/$objetivo,2);
            }

        } else {
            $clase_medidor = 'class="info-box bg-yellow"';
            $puntajePorciento = 50;
            $txtPuntajePorciento = 50;
        }

        if(!empty($total_servicios)){
            $total_efectividad = round(($total_servicios_enviadas+$total_servicios_cerrados)*100/$total_servicios,2) ;
            if ($total_efectividad > 70) {
            $clase_efectividad = 'class="text-center text-green"';
            } else if($total_efectividad < 60){
            $clase_efectividad = 'class="text-center text-red"';
            } else {
            $clase_efectividad = 'class="text-center text-yellow"';
            }
            } else {
            $total_efectividad = 0;
            $clase_efectividad = 'class="text-center text-red"';
        }
?>