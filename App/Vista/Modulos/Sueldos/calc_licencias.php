<?php
    ###############################
    # Calculo de días de licencia #
    ###############################
    $fDesdeLicencia = $sueldo->getPeriodo()->format('Y-m-1');
    $fHastaLicencia = $sueldo->getPeriodo()->format('Y-m-t');
    $deLicSGS=0;
    $deLicCGS=0;

    while (strtotime($fDesdeLicencia) <= strtotime($fHastaLicencia)) {
        $arrLicencias = $handlerLic->seleccionarByFiltrosRRHH($fDesdeLicencia,$fDesdeLicencia,$sueldo->getIdUsuario(),2);
        
        if(!empty($arrLicencias)) {
        foreach ($arrLicencias as $key => $value) {
            if (!$value->getRechazado()) {
            if($value->getAprobado()) {
                if ($fDesdeLicencia <= $value->getFechaFin()->format('Y-m-d')) {
                if (trim($value->getTipoLicenciasId()->getNombre()) == 'Licencia sin goce de sueldo') {
                    $deLicSGS += 1;
                } else {
                    $deLicCGS += 1;
                }
                }
            }
            }
        }
        }
        $fDesdeLicencia = date('Y-m-d',strtotime('+1 day',strtotime($fDesdeLicencia)));
    }
?>