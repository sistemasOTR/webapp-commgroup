  <?php 
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";

    $dFechas = new Fechas;
    $fdesde=$dFechas->RestarDiasFechaActual(90);
    $fHoy = $dFechas->FechaActual();
    if ($esCoordinador) {
      $fplaza = $usuarioActivoSesion->getAliasUserSistema();
    } else {
      $fplaza = null;
    }
      

    $handlerSist = new HandlerSistema;
    $arrCerrProb = $handlerSist->getCerrProb($fdesde,$fHoy,$fplaza);
    $total = 0;
    if (!empty($arrCerrProb)) {
      foreach ($arrCerrProb as $key => $value) {
        $total = $total + $value->CANT;

      }
    }

    $url_servicios = "index.php?view=servicio&fdesde=".$fdesde."&fhasta=".$fHoy."&festado=8&fcliente=";
 

  ?>

  <?php if(($esCoordinador || $esSupervisor || $esBO || $esGerencia) && $total>0 ){ ?>
    <li class="dropdown notifications-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-exclamation-triangle" data-toggle='tooltip' data-placement="bottom"  title='CERRADAS EN PROBLEMAS'></i> 
        <span id="contador_noti_user" class="label" style="font-size:12px;"></span>
          <span id="contador_noti_empresa" class="label label-danger" data-toggle='tooltip' data-placement="bottom"  title='CERRADAS EN PROBLEMAS' style="font-size:12px;">
            <?php echo ($total); ?>
          </span>
      </a>
      <ul class="dropdown-menu">
        
        <li>
          <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
            <ul class="menu" style="overflow: auto; width: 100%; height: auto;">
              <?php foreach ($arrCerrProb as $key => $value) { ?>
                <li>
                  <a href='<?php echo $url_servicios.$value->CODEMP; ?>'>
                    <?php echo strtoupper($value->EMP) ?><span class="badge bg-red pull-right">
                      <?php echo $value->CANT; ?>
                    </span>
                  </a>
                </li>
              <?php } ?>
            </ul>
            <ul class="menu" style="overflow: auto; width: 100%; height: auto;">
              <li>
                  <a href='<?php echo $url_servicios; ?>'>
                    Total: <span class="badge bg-red pull-right"><?php echo $total; ?></span>
                </a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </li>
  <?php } ?>