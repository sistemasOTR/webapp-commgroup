<?php
    ##############################
    # Calculo de datos de legajo #
    ##############################
    
    $legajo = $handlerLeg->seleccionarByFiltros($sueldo->getIdUsuario());
    $arrBasicos = $handlerLeg->seleccionarLegajosBasicosByCat(intval(trim($legajo[""]->getCategoria())));
    $basico = 0;
    $hr_norm = 0;
    if (!empty($arrBasicos)) {
      foreach ($arrBasicos as $key => $value) {
        if (strtotime($sueldo->getPeriodo()->format('Y-m-d')) >= strtotime($value->getFechaDesde()->format('Y-d-m'))) {
          $basico = $value->getBasico();
          $hr_norm = $value->getHorasNormales();
          break;
        }
      }
    }

    if ($hr_norm>0) {
      $tipo_jornada = $legajo[""]->getHoras()/$hr_norm;
      if ($tipo_jornada<=0.5) {
        $jornada = 0.5;
      } elseif ($tipo_jornada > 0.5 && $tipo_jornada < 1) {
        $jornada = 2/3;
      } else {
        $jornada = 1;
      }
    } else {
      $jornada = 1;
    }

    $categoria = $handlerLeg->selecionarCategoriaById(intval(trim($legajo[""]->getCategoria())));

    $fHoy = date('Y-m-d',strtotime($dFechas->FechaActual()));
    $fIngreso = $legajo[""]->getFechaIngreso()->format('Y-m-d');

    $diasDif = $dFechas->DiasDiferenciaFechas($fIngreso,$fHoy,'Y-m-d');
    $antig = intval($diasDif/365);

    
?>