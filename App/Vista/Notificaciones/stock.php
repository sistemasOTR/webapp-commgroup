 <?php 
    include_once PATH_NEGOCIO."Expediciones/handlerexpediciones.class.php";
    include_once PATH_DATOS.'Entidades/expediciones.class.php';
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php";

    $handlerNotificacionExp = new HandlerExpediciones;
    $userPlaza = $usuarioActivoSesion->getAliasUserSistema();
    $dFechas = new Fechas;
    $SinStock=$handlerNotificacionExp->selecionarItem();
    $apedir=$handlerNotificacionExp->selecionarApedir();

    $pendientes= $handlerNotificacionExp->pendientes();
    $entregados= $handlerNotificacionExp->entregados($userPlaza);
    $rec_parciales= $handlerNotificacionExp->recParciales();
    $ent_parciales= $handlerNotificacionExp->entParciales($userPlaza);
    $countapedir=count($apedir);
    $url_pendientes='index.php?view=exp_item_abm&apedir=1';
    
  ?>

  <?php if($esBO && ($countapedir)>0 ){ ?>
    <li class="dropdown notifications-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <i class="fa fa-cart-arrow-down"></i> 
        <span id="contador_noti_user" class="label" style="font-size:12px;"></span>

        <?php if(($countapedir)>0 ){ ?>
          <span id="contador_noti_empresa" class="label label-danger" style="font-size:12px;">
            <?php echo ($countapedir); ?>
          </span>
        <?php } ?>
      </a>
      <ul class="dropdown-menu">
        <li>
          <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: auto;">
            <ul class="menu" style="overflow: auto; width: 100%; height: auto;">
              <?php if (($countapedir)>0): ?>
                <li>
                  <a href="<?php echo $url_pendientes; ?>">
                    <b>Pendientes</b><span class="badge bg-red pull-right">
                      <?php echo $countapedir; ?>
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
