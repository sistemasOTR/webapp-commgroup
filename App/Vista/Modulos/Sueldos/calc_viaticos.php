<?php
    #######################
    # Calculo de viaticos #
    #######################
    $fDesdeTicket = date('Y-m-26',strtotime($fDesde.' -1 days'));
    $fHastaTicket = date('Y-m-25',strtotime($fDesde.' 0 days'));

    $resumenTickets = $handlerTickets->resumenGestor($sueldo->getIdUsuario(), $fDesdeTicket, $fHastaTicket);
    $reintegroTotal = 0;
    if (!empty($resumenTickets)) {
        foreach ($resumenTickets as $viatico) {
        $reintegroTotal += $viatico->getImporteReintegro(); 
        }
    }
?>