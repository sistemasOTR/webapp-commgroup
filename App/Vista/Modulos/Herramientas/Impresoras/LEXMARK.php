<?php
  $arrConsumos = $handlerimpresoras->getConsumos($fserialNro);
?>

<table class="table table-striped table-condensed" id="tabla-plaza" cellspacing="0" width="100%" style="text-align:center;">
  <thead>
    <tr>
      <th class='text-center' width="100">Fecha</th>
      <th class='text-center' width="100">Plaza</th>
      <th class='text-center' width="150">Contador</th>
      <th class='text-center' width="100">Tonner</th>
      <th class='text-center' width="150">Unidad de Imagen</th>
      <th class='text-center' width="150">Kit de Mantenimiento</th>
      <th class='text-left'>Observaciones</th>
      <th class='text-left'>Usuario</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      if(!empty($arrConsumos)){
      foreach ($arrConsumos as $consumo) {
        //Armado de los datos
        $fechaConsumo = $consumo->getFechaConsumo()->format('d-m-Y');
        $plaza = $consumo->getPlaza();
        $contador = $consumo->getContador();
        if ($consumo->getCambioTonner()) {
          $tonner = '<i class="fa fa-check text-green"></i>';
        } else {
          $tonner = '<i class="fa fa-refresh text-red"></i>';
        }
        $UI = $consumo->getUI();
        if ($consumo->getCambioUI()) {
          $cambioUI = '<i class="fa fa-check text-green"></i>';
        } else {
          $cambioUI = '<i class="fa fa-refresh text-red"></i>';
        }
        $kitM = $consumo->getKitM();
        if ($consumo->getCambioKitM()) {
          $cambioKitM = '<i class="fa fa-check text-green"></i>';
        } else {
          $cambioKitM = '<i class="fa fa-refresh text-red"></i>';
        }
        $consObs = $consumo->getConsObs();
        $usuarioId = $consumo->getUserId();
        $usuario = $handlerUs->selectById($usuarioId);

        //Impresión de los datos
        echo "<tr>
          <td>".$fechaConsumo."</td>
          <td>".$plaza."</td>
          <td>".$contador."</td>
          <td>".$tonner."</td>
          <td>".$UI." ".$cambioUI."</td>
          <td>".$kitM." ".$cambioKitM."</td>
          <td class='text-left'>".$consObs."</td>
          <td class='text-left'>".$usuario->getNombre()." ".$usuario->getApellido()."</td>
        </tr>";
      }}
     ?>

  </tbody>
  </table>