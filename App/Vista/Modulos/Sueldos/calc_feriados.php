<?php
    ############################
    # Calculo de dias feriados #
    ############################
    $fDesdeFeriados = $sueldo->getPeriodo()->format('Y-m-1');
    $fHastaFeriados = $sueldo->getPeriodo()->format('Y-m-t');
    $feriados=0;

    while (strtotime($fDesdeFeriados) <= strtotime($fHastaFeriados)) {
        $arrFeriado = $handlerTickets->selecionarFechasInhabilitadasByFecha($fDesdeFeriados);
        
        if(!empty($arrFeriado)) {
        foreach ($arrFeriado as $key => $value) {
            if (trim($value['motivo']) == 'Feriado' ) {
            $feriados += 1;
            }
        }
        }
        $fDesdeFeriados = date('Y-m-d',strtotime('+1 day',strtotime($fDesdeFeriados)));
    }
?>