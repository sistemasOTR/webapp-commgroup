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
      <th class='text-center' width="150">KitA</th>
      <th class='text-center' width="150">KitB</th>
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
        $kitA = $consumo->getKitA();
        if ($consumo->getCambioKitA()) {
          $cambioKitA = '<i class="fa fa-check text-green"></i>';
        } else {
          $cambioKitA = '<i class="fa fa-refresh text-red"></i>';
        }
        $kitB = $consumo->getKitB();
        if ($consumo->getCambioKitB()) {
          $cambioKitB = '<i class="fa fa-check text-green"></i>';
        } else {
          $cambioKitB = '<i class="fa fa-refresh text-red"></i>';
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
          <td>".$kitA." ".$cambioKitA."</td>
          <td>".$kitB." ".$cambioKitB."</td>
          <td class='text-left'>".$consObs."</td>
          <td class='text-left'>".$usuario->getNombre()." ".$usuario->getApellido()."</td>
        </tr>";
      }}
     ?>

  </tbody>
  </table>
