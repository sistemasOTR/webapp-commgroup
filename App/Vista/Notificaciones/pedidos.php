  <?php 
    include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";
    include_once PATH_DATOS.'Entidades/expediciones.class.php';
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";

    $handlerNotificacionExp = new HandlerExpediciones;
    $userPlaza = $usuarioActivoSesion->getAliasUserSistema();
    $dFechas = new Fechas;
    $pendientes= $handlerNotificacionExp->pendientes();
    $entregados= $handlerNotificacionExp->entregados($userPlaza);
    $rec_parciales= $handlerNotificacionExp->recParciales();
    $ent_parciales= $handlerNotificacionExp->entParciales($userPlaza);


    // var_dump();
    // exit();

    $fechaActual = $dFechas->FechaActual();
    // $countEnviados=$handlerNotificacionExp->contarEnviados();
    if (!empty($pendientes)) {
      $countPendiente = count($pendientes);
      if ($countPendiente > 1) {
        $fechaPendiente = $pendientes[0]->getFecha()->format('Y-m-d');
      } else {
        $fechaPendiente = $pendientes[""]->getFecha()->format('Y-m-d');
      }
      $url_pendientes = 'index.php?view=exp_control&fdesde='.$fechaPendiente.'&fhasta='.$fechaActual.'&fplaza=&festados=1';
    } else {
      $countPendiente = 0;
    }
    if (!empty($rec_parciales)) {
      $countRParcial = count($rec_parciales);
      if ($countRParcial > 1) {
        $fechaRParcial = $rec_parciales[0]->getFecha()->format('Y-m-d');
      } else {
        $fechaRParcial = $rec_parciales[""]->getFecha()->format('Y-m-d');
      }
      $url_rec_parciales = 'index.php?view=exp_control&fdesde='.$fechaRParcial.'&fhasta='.$fechaActual.'&fplaza=&festados=7';
    } else {
      $countRParcial = 0;
    }
       if (!empty($entregados)) {
      $countEntregado = count($entregados);
      if ($countEntregado > 1) {
        $fechaEntregado = $entregados[0]->getFecha()->format('Y-m-d');
      } else {
        $fechaEntregado = $entregados[""]->getFecha()->format('Y-m-d');
      }
      $url_entregados = 'index.php?view=exp_seguimiento&fdesde='.$fechaEntregado.'&fhasta='.$fechaActual.'&fplaza=&festados=2';
    } else {
      $countEntregado = 0;
    }
    if (!empty($ent_parciales)) {
      $countEParcial = count($ent_parciales);
      if ($countEParcial > 1) {
        $fechaEParcial = $ent_parciales[0]->getFecha()->format('Y-m-d');
      } else {
        $fechaEParcial = $ent_parciales[""]->getFecha()->format('Y-m-d');
      }
      if ($userPlaza != '') {
       $url_ent_parciales = 'index.php?view=exp_seguimiento&fdesde='.$fechaEParcial.'&fhasta='.$fechaActual.'&fplaza=&festados=6';
      } else {
        $url_ent_parciales = 'index.php?view=exp_control&fdesde='.$fechaEParcial.'&fhasta='.$fechaActual.'&fplaza=&festados=6';
      }
      
    } else {
      $countEParcial = 0;
    }
        
    // var_dump($fechaActual);
    // exit();
    
  ?>

  <?php if($esBO || $esGerencia && (($countPendiente)>0 || ($countRParcial)>0 || ($countEParcial)>0) ){ ?>
    <li class="dropdown notifications-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-cubes"></i> 
        <span id="contador_noti_user" class="label" style="font-size:12px;"></span>

        <?php if(($countPendiente)>0 || ($countRParcial)>0  || ($countEParcial)>0){ ?>
          <span id="contador_noti_empresa" class="label label-danger" style="font-size:12px;">
            <?php echo ($countPendiente+$countRParcial+$countEParcial); ?>
          </span>
        <?php } ?>
      </a>
      <ul class="dropdown-menu">
        <li>
          <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
            <ul class="menu" style="overflow: auto; width: 100%; height: auto;">
              <?php if (($countPendiente)>0): ?>
                <li>
                  <a href="<?php echo $url_pendientes; ?>">
                    <b>Pendientes</b><span class="badge bg-red pull-right">
                      <?php echo $countPendiente; ?>
                    </span>
                  </a>
                </li>
              <?php endif ?>
              <?php if (($countRParcial)>0 ): ?>
                <li>
                  <a href="<?php echo $url_rec_parciales; ?>">
                    <b>Recibido Parcial</b><span class="badge bg-red pull-right">
                      <?php echo $countRParcial; ?>
                    </span>
                  </a>
                </li>
              <?php endif ?>
              <?php if (($countEParcial)>0): ?>
                <li>
                  <a href="<?php echo $url_ent_parciales; ?>">
                    <b>Entregado Parcial</b><span class="badge bg-red pull-right">
                      <?php echo $countEParcial; ?>
                    </span>
                  </a>
                </li>
              <?php endif ?>
              
            </ul>
          </div>
        </li>
      </ul>
    </li>
  <?php } ?>
  <?php if($esCoordinador && (($countEntregado)>0 || ($countEParcial)>0)){ ?>
    <li class="dropdown notifications-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-cubes"></i> 
        <span id="contador_noti_user" class="label" style="font-size:12px;"></span>

        <?php if(($countEntregado)>0 || ($countEParcial)>0){ ?>
          <span id="contador_noti_empresa" class="label label-danger" style="font-size:12px;">
            <?php echo ($countEntregado+$countEParcial); ?>
          </span>
        <?php } ?>
      </a>
      <ul class="dropdown-menu">
        <li>
          <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
            <ul class="menu" style="overflow: auto; width: 100%; height: auto;">
              <?php if (($countEntregado)>0): ?>
                <li>
                  <a href="<?php echo $url_entregados; ?>">
                    <b>Entregados</b><span class="badge bg-red pull-right">
                      <?php echo $countEntregado; ?>
                    </span>
                  </a>
                </li>
              <?php endif ?>
              <?php if (($countEParcial)>0): ?>
                <li>
                  <a href="<?php echo $url_ent_parciales; ?>">
                    <b>Entregado Parcial</b><span class="badge bg-red pull-right">
                      <?php echo $countEParcial; ?>
                    </span>
                  </a>
                </li>
              <?php endif ?>
              
            </ul>
          </div>
        </li>
      </ul>
    </li>
  <?php } ?>