      <?php 

        $handlerplazas=new HandlerPlazaUsuarios();
        $plazasOtr=$handlerplazas->selectTodas();
        $empleados = unserialize(isset($_GET["empleados"])?$_GET["empleados"]:'');
        $url_action_select_empleados=PATH_VISTA.'Modulos/Metricas/action_select_empleados.php';
        $id = (isset($_GET["plaza"])?$_GET["plaza"]:0);
        $plaa = unserialize(isset($_GET["plaa"])?$_GET["plaa"]:'');
        $url_action_select_plazas=PATH_VISTA.'Modulos/Metricas/action_select_plazas.php';
        $asd = 0; 
        $asdepm = 0; 
       ?>


      <div class="col-md-12 ">
        <?php

          $consulta = $handler->consultaPuntajes($fdesde, $fhasta, null);
          if(!empty($consulta)){
        ?>
        <div class="col-md-12 no-padding">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title" style="text-transform: uppercase;">POR EMPRESA</h3>
                <div class="col-md-2 pull-right">
                  <!-- <label>ESCOGER PLAZAS</label>  -->
                  <a data-toggle='modal' data-target='#modal-nuevo' class="btn btn-block btn-primary">Plazas</a>
                </div> 
                <div class="col-md-2 pull-right">
                  <!-- <label>ESCOGER PLAZAS</label>  -->
                  <a data-toggle='modal' data-target='#modal-nuevo-empleados' class="btn btn-block btn-primary">Gestores</a>
                </div>
                
              </div>    
              <div class="box-body table-responsive no-paddig">
                <table class="table no-border table-condensed" id="tabla" cellspacing="0" width="100%" style="text-align: center;" >
                  <thead>
                    <tr class="bg-black">

                      <td style="text-align: left;">Cuenta</td>
                      <td>Cerr.</td>
                      <td>Env.</td>
                      <td>A Liq.</td>
                      <td>Cerr. Par</td>
                      <td>Repac.</td>
                      <td>Rellam.</td>
                      <td>Neg.</td>
                      <td>Cerr. Prob.</td>
                      <td>Neg. BO</td>
                      <td>Prob BO</td>
                      <td>Liq. C. Parcial</td>
                      <td>No Efec.</td>
                      <td>Cancel.</td>
                      <td>Cerr. Total</td>
                      <td>TOTAL</td>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    foreach ($arrEmpresas as $empresa) {
                        $total_servicios = 0;
                        $total_servicios_CERRADO = 0;
                        $total_servicios_ENV = 0;
                        $total_servicios_CERRADO_PARCIAL = 0;
                        $total_servicios_RE_PACTADO = 0;
                        $total_servicios_RE_LLAMAR = 0;
                        $total_servicios_NEGATIVO = 0;
                        $total_servicios_PROBLEMAS = 0;
                        $total_servicios_A_LIQUIDAR = 0;
                        $total_servicios_CANCELADO = 0;
                        $total_servicios_NEGATIVO_BO = 0;
                        $total_servicios_PROBLEMAS_BO = 0;
                        $total_servicios_LIQUIDAR_C_PARCIAL = 0;
                        $total_servicios_NO_EFECTIVAS = 0;
                        $total_servicios_cerrados = 0;
                        $total_efectividad = 0;
                        $total_puntajes_cerrados = 0;

                        $total_servicios_enviadas = 0;
                        $total_puntajes_enviadas = 0;

                        foreach ($consulta as $key => $value) { 
                          if (!empty($empleados)) {
                            foreach ($empleados as $itemEmp) {
                              if ($value->COD_EMPRESA == $empresa->EMPTT11_CODIGO && $value->COD_GESTOR == $itemEmp) {
                                $total_servicios = $total_servicios + $value->TOTAL_SERVICIOS;
                                $total_servicios_CERRADO = $total_servicios_CERRADO + $value->CERRADO;
                                $total_servicios_ENV = $total_servicios_ENV + $value->ENV;
                                $total_servicios_CERRADO_PARCIAL = $total_servicios_CERRADO_PARCIAL + $value->CERRADO_PARCIAL;
                                $total_servicios_RE_PACTADO = $total_servicios_RE_PACTADO + $value->RE_PACTADO;
                                $total_servicios_RE_LLAMAR = $total_servicios_RE_LLAMAR + $value->RE_LLAMAR;
                                $total_servicios_NEGATIVO = $total_servicios_NEGATIVO + $value->NEGATIVO;
                                $total_servicios_PROBLEMAS = $total_servicios_PROBLEMAS + $value->PROBLEMAS;
                                $total_servicios_A_LIQUIDAR = $total_servicios_A_LIQUIDAR + $value->A_LIQUIDAR;
                                $total_servicios_NEGATIVO_BO = $total_servicios_NEGATIVO_BO + $value->NEGATIVO_BO;
                                $total_servicios_PROBLEMAS_BO = $total_servicios_PROBLEMAS_BO + $value->PROBLEMAS_BO;
                                $total_servicios_LIQUIDAR_C_PARCIAL = $total_servicios_LIQUIDAR_C_PARCIAL + $value->LIQUIDAR_C_PARCIAL;
                                $total_servicios_NO_EFECTIVAS = $total_servicios_NO_EFECTIVAS + $value->NO_EFECTIVAS;
                                $total_servicios_CANCELADO  = $total_servicios_CANCELADO + $value->CANCEL;
                              }
                            }

                          } elseif (!empty($plaa)) {
                            foreach ($plaa as $itemPlaza) {
                              if ($value->COD_EMPRESA == $empresa->EMPTT11_CODIGO && $value->NOM_COORDINADOR == $itemPlaza) {
                                $total_servicios = $total_servicios + $value->TOTAL_SERVICIOS;
                                $total_servicios_CERRADO = $total_servicios_CERRADO + $value->CERRADO;
                                $total_servicios_ENV = $total_servicios_ENV + $value->ENV;
                                $total_servicios_CERRADO_PARCIAL = $total_servicios_CERRADO_PARCIAL + $value->CERRADO_PARCIAL;
                                $total_servicios_RE_PACTADO = $total_servicios_RE_PACTADO + $value->RE_PACTADO;
                                $total_servicios_RE_LLAMAR = $total_servicios_RE_LLAMAR + $value->RE_LLAMAR;
                                $total_servicios_NEGATIVO = $total_servicios_NEGATIVO + $value->NEGATIVO;
                                $total_servicios_PROBLEMAS = $total_servicios_PROBLEMAS + $value->PROBLEMAS;
                                $total_servicios_A_LIQUIDAR = $total_servicios_A_LIQUIDAR + $value->A_LIQUIDAR;
                                $total_servicios_NEGATIVO_BO = $total_servicios_NEGATIVO_BO + $value->NEGATIVO_BO;
                                $total_servicios_PROBLEMAS_BO = $total_servicios_PROBLEMAS_BO + $value->PROBLEMAS_BO;
                                $total_servicios_LIQUIDAR_C_PARCIAL = $total_servicios_LIQUIDAR_C_PARCIAL + $value->LIQUIDAR_C_PARCIAL;
                                $total_servicios_NO_EFECTIVAS = $total_servicios_NO_EFECTIVAS + $value->NO_EFECTIVAS;
                                $total_servicios_CANCELADO  = $total_servicios_CANCELADO + $value->CANCEL;
                              }
                            }

                          } elseif ($value->COD_EMPRESA == $empresa->EMPTT11_CODIGO) {
                            $total_servicios = $total_servicios + $value->TOTAL_SERVICIOS;
                            $total_servicios_CERRADO = $total_servicios_CERRADO + $value->CERRADO;
                            $total_servicios_ENV = $total_servicios_ENV + $value->ENV;
                            $total_servicios_CERRADO_PARCIAL = $total_servicios_CERRADO_PARCIAL + $value->CERRADO_PARCIAL;
                            $total_servicios_RE_PACTADO = $total_servicios_RE_PACTADO + $value->RE_PACTADO;
                            $total_servicios_RE_LLAMAR = $total_servicios_RE_LLAMAR + $value->RE_LLAMAR;
                            $total_servicios_NEGATIVO = $total_servicios_NEGATIVO + $value->NEGATIVO;
                            $total_servicios_PROBLEMAS = $total_servicios_PROBLEMAS + $value->PROBLEMAS;
                            $total_servicios_A_LIQUIDAR = $total_servicios_A_LIQUIDAR + $value->A_LIQUIDAR;
                            $total_servicios_NEGATIVO_BO = $total_servicios_NEGATIVO_BO + $value->NEGATIVO_BO;
                            $total_servicios_PROBLEMAS_BO = $total_servicios_PROBLEMAS_BO + $value->PROBLEMAS_BO;
                            $total_servicios_LIQUIDAR_C_PARCIAL = $total_servicios_LIQUIDAR_C_PARCIAL + $value->LIQUIDAR_C_PARCIAL;
                            $total_servicios_NO_EFECTIVAS = $total_servicios_NO_EFECTIVAS + $value->NO_EFECTIVAS;
                            $total_servicios_CANCELADO  = $total_servicios_CANCELADO + $value->CANCEL;
                          }
                        } 

                        if($total_servicios > 0){
                          if ($fvista == '1' || empty($fvista)) {
                            
                          ?>

                    
                    <tr>
                      <td <?php if ($fvista !== '1') { echo 'rowspan="2"';} ?> style="text-align: left;"><?php echo $empresa->EMPTT21_NOMBREFA ?></td>
                      <td style="text-align: center;background: #94bcf6;"><?php echo $total_servicios_CERRADO ?></td>
                      <td style="text-align: center;background: #c2d1ad;"><?php echo $total_servicios_ENV ?></td>
                      <td  style="text-align: center;background: #c2f9ad;"><?php echo $total_servicios_A_LIQUIDAR ?></td>
                      <td style="text-align: center;background: #b9edfd;"><?php echo $total_servicios_CERRADO_PARCIAL ?></td>
                      <td style="text-align: center;background: #a7e7c5;"><?php echo $total_servicios_RE_PACTADO ?></td>
                      <td style="text-align: center;background: #f4b74a;"><?php echo $total_servicios_RE_LLAMAR ?></td>
                      <td style="text-align: center;background: #f77365;"><?php echo $total_servicios_NEGATIVO ?></td>
                      <td style="text-align: center;background: #ead1cc;"><?php echo $total_servicios_PROBLEMAS ?></td>
                      <td style="text-align: center;background: #da70d6;"><?php echo $total_servicios_NEGATIVO_BO ?></td>
                      <td style="text-align: center;background: #f08080"><?php echo $total_servicios_PROBLEMAS_BO ?></td>
                      <td style="text-align: center;background: #eec2b4;"><?php echo $total_servicios_LIQUIDAR_C_PARCIAL ?></td>
                      <td style="text-align: center;background: #e8ab98;"><?php echo $total_servicios_NO_EFECTIVAS ?></td>
                      <td style="text-align: center;background: #fffff0"><?php echo $total_servicios_CANCELADO ?></td>
                      <td style="text-align: center;background: #e8ab98;"><?php echo ($total_servicios_CERRADO + $total_servicios_ENV + $total_servicios_A_LIQUIDAR) ?></td>
                      <td style="text-align: center;background: #fdfbcb;"><?php echo $total_servicios ?></td>
                    </tr>
                  <?php } ?>
                  <?php if ($fvista == '2' || empty($fvista)) { ?>
                    <tr>
                      <?php if ($fvista == '2') { ?>
                        <td style="text-align: left;"><?php echo $empresa->EMPTT21_NOMBREFA ?></td>
                      <?php } ?>
                      <td style="text-align: center;background: #94bcf6;"><?php echo number_format(($total_servicios_CERRADO/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;background: #c2d1ad;"><?php echo number_format(($total_servicios_ENV/$total_servicios*100),2) ?> %</td>
                      <td  style="text-align: center;background: #c2f9ad;"><?php echo number_format(($total_servicios_A_LIQUIDAR/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;background: #b9edfd;"><?php echo number_format(($total_servicios_CERRADO_PARCIAL/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;background: #a7e7c5;"><?php echo number_format(($total_servicios_RE_PACTADO/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;background: #f4b74a;"><?php echo number_format(($total_servicios_RE_LLAMAR/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;background: #f77365;"><?php echo number_format(($total_servicios_NEGATIVO/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;background: #ead1cc;"><?php echo number_format(($total_servicios_PROBLEMAS/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;background: #da70d6;"><?php echo number_format(($total_servicios_NEGATIVO_BO/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;background: #f08080"><?php echo number_format(($total_servicios_PROBLEMAS_BO/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;background: #eec2b4;"><?php echo number_format(($total_servicios_LIQUIDAR_C_PARCIAL/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;background: #e8ab98;"><?php echo number_format(($total_servicios_NO_EFECTIVAS/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;background: #fffff0"><?php echo number_format(($total_servicios_CANCELADO/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;background: #e8ab98;"><?php echo number_format((($total_servicios_CERRADO + $total_servicios_ENV + $total_servicios_A_LIQUIDAR)/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;background: #fdfbcb;"><?php echo number_format(($total_servicios/$total_servicios*100),2) ?> %</td>
                    </tr>
                        
                      <?php }}} 
                      $total_servicios = 0;
            $total_servicios_CERRADO = 0;
            $total_servicios_ENV = 0;
            $total_servicios_CERRADO_PARCIAL = 0;
            $total_servicios_RE_PACTADO = 0;
            $total_servicios_RE_LLAMAR = 0;
            $total_servicios_NEGATIVO = 0;
            $total_servicios_PROBLEMAS = 0;
            $total_servicios_A_LIQUIDAR = 0;
            $total_servicios_CANCELADO = 0;
            $total_servicios_NEGATIVO_BO = 0;
            $total_servicios_PROBLEMAS_BO = 0;
            $total_servicios_LIQUIDAR_C_PARCIAL = 0;
            $total_servicios_NO_EFECTIVAS = 0;
            $total_servicios_cerrados = 0;
            $total_efectividad = 0;
            $total_puntajes_cerrados = 0;

            $total_servicios_enviadas = 0;
            $total_puntajes_enviadas = 0;

            $objetivo=0;
            $consulta = $handler->consultaPuntajes($fdesde, $fhasta, null);
            // var_dump($consulta);
            // exit();

            if(!empty($consulta))
            {
               foreach ($consulta as $key => $value) { 
                          if (!empty($empleados)) {
                            foreach ($empleados as $itemEmp) {
                              if ($value->COD_GESTOR == $itemEmp) {
                                $total_servicios = $total_servicios + $value->TOTAL_SERVICIOS;
                                $total_servicios_CERRADO = $total_servicios_CERRADO + $value->CERRADO;
                                $total_servicios_ENV = $total_servicios_ENV + $value->ENV;
                                $total_servicios_CERRADO_PARCIAL = $total_servicios_CERRADO_PARCIAL + $value->CERRADO_PARCIAL;
                                $total_servicios_RE_PACTADO = $total_servicios_RE_PACTADO + $value->RE_PACTADO;
                                $total_servicios_RE_LLAMAR = $total_servicios_RE_LLAMAR + $value->RE_LLAMAR;
                                $total_servicios_NEGATIVO = $total_servicios_NEGATIVO + $value->NEGATIVO;
                                $total_servicios_PROBLEMAS = $total_servicios_PROBLEMAS + $value->PROBLEMAS;
                                $total_servicios_A_LIQUIDAR = $total_servicios_A_LIQUIDAR + $value->A_LIQUIDAR;
                                $total_servicios_NEGATIVO_BO = $total_servicios_NEGATIVO_BO + $value->NEGATIVO_BO;
                                $total_servicios_PROBLEMAS_BO = $total_servicios_PROBLEMAS_BO + $value->PROBLEMAS_BO;
                                $total_servicios_LIQUIDAR_C_PARCIAL = $total_servicios_LIQUIDAR_C_PARCIAL + $value->LIQUIDAR_C_PARCIAL;
                                $total_servicios_NO_EFECTIVAS = $total_servicios_NO_EFECTIVAS + $value->NO_EFECTIVAS;
                                $total_servicios_CANCELADO  = $total_servicios_CANCELADO + $value->CANCEL;
                              }
                            }

                          } elseif (!empty($plaa)) {
                            foreach ($plaa as $itemPlaza) {
                              if ($value->NOM_COORDINADOR == $itemPlaza) {
                                $total_servicios = $total_servicios + $value->TOTAL_SERVICIOS;
                                $total_servicios_CERRADO = $total_servicios_CERRADO + $value->CERRADO;
                                $total_servicios_ENV = $total_servicios_ENV + $value->ENV;
                                $total_servicios_CERRADO_PARCIAL = $total_servicios_CERRADO_PARCIAL + $value->CERRADO_PARCIAL;
                                $total_servicios_RE_PACTADO = $total_servicios_RE_PACTADO + $value->RE_PACTADO;
                                $total_servicios_RE_LLAMAR = $total_servicios_RE_LLAMAR + $value->RE_LLAMAR;
                                $total_servicios_NEGATIVO = $total_servicios_NEGATIVO + $value->NEGATIVO;
                                $total_servicios_PROBLEMAS = $total_servicios_PROBLEMAS + $value->PROBLEMAS;
                                $total_servicios_A_LIQUIDAR = $total_servicios_A_LIQUIDAR + $value->A_LIQUIDAR;
                                $total_servicios_NEGATIVO_BO = $total_servicios_NEGATIVO_BO + $value->NEGATIVO_BO;
                                $total_servicios_PROBLEMAS_BO = $total_servicios_PROBLEMAS_BO + $value->PROBLEMAS_BO;
                                $total_servicios_LIQUIDAR_C_PARCIAL = $total_servicios_LIQUIDAR_C_PARCIAL + $value->LIQUIDAR_C_PARCIAL;
                                $total_servicios_NO_EFECTIVAS = $total_servicios_NO_EFECTIVAS + $value->NO_EFECTIVAS;
                                $total_servicios_CANCELADO  = $total_servicios_CANCELADO + $value->CANCEL;
                              }
                            }

                          } else {
                            $total_servicios = $total_servicios + $value->TOTAL_SERVICIOS;
                            $total_servicios_CERRADO = $total_servicios_CERRADO + $value->CERRADO;
                            $total_servicios_ENV = $total_servicios_ENV + $value->ENV;
                            $total_servicios_CERRADO_PARCIAL = $total_servicios_CERRADO_PARCIAL + $value->CERRADO_PARCIAL;
                            $total_servicios_RE_PACTADO = $total_servicios_RE_PACTADO + $value->RE_PACTADO;
                            $total_servicios_RE_LLAMAR = $total_servicios_RE_LLAMAR + $value->RE_LLAMAR;
                            $total_servicios_NEGATIVO = $total_servicios_NEGATIVO + $value->NEGATIVO;
                            $total_servicios_PROBLEMAS = $total_servicios_PROBLEMAS + $value->PROBLEMAS;
                            $total_servicios_A_LIQUIDAR = $total_servicios_A_LIQUIDAR + $value->A_LIQUIDAR;
                            $total_servicios_NEGATIVO_BO = $total_servicios_NEGATIVO_BO + $value->NEGATIVO_BO;
                            $total_servicios_PROBLEMAS_BO = $total_servicios_PROBLEMAS_BO + $value->PROBLEMAS_BO;
                            $total_servicios_LIQUIDAR_C_PARCIAL = $total_servicios_LIQUIDAR_C_PARCIAL + $value->LIQUIDAR_C_PARCIAL;
                            $total_servicios_NO_EFECTIVAS = $total_servicios_NO_EFECTIVAS + $value->NO_EFECTIVAS;
                            $total_servicios_CANCELADO  = $total_servicios_CANCELADO + $value->CANCEL;
                          }
                        } 
            }
                      ?>
                      <?php   if ($fvista == '1' || empty($fvista)) { ?>
                      <tr>
                      <td <?php if ($fvista !== '1') { echo 'rowspan="2"';} ?> style="text-align: left;">TOTALES</td>
                      <td style="text-align: center;"><?php echo $total_servicios_CERRADO ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_ENV ?></td>
                      <td  style="text-align: center;"><?php echo $total_servicios_A_LIQUIDAR ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_CERRADO_PARCIAL ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_RE_PACTADO ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_RE_LLAMAR ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_NEGATIVO ?></td><td style="text-align: center;"><?php echo $total_servicios_PROBLEMAS ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_NEGATIVO_BO ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_PROBLEMAS_BO ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_LIQUIDAR_C_PARCIAL ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_NO_EFECTIVAS ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_CANCELADO ?></td>
                      <td style="text-align: center;"><?php echo ($total_servicios_CERRADO + $total_servicios_ENV + $total_servicios_A_LIQUIDAR) ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios ?></td>
                    </tr>
                  <?php } ?>
                  <?php if ($fvista == '2' || empty($fvista)) { ?>
                    <tr>
                      <?php if ($fvista == '2') { ?>
                        <td style="text-align: left;">TOTALES</td>
                      <?php } ?>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_CERRADO/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_ENV/$total_servicios*100),2) ?> %</td>
                      <td  style="text-align: center;"><?php echo number_format(($total_servicios_A_LIQUIDAR/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_CERRADO_PARCIAL/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_RE_PACTADO/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_RE_LLAMAR/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_NEGATIVO/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_PROBLEMAS/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_NEGATIVO_BO/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_PROBLEMAS_BO/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_LIQUIDAR_C_PARCIAL/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_NO_EFECTIVAS/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_CANCELADO/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format((($total_servicios_CERRADO + $total_servicios_ENV + $total_servicios_A_LIQUIDAR)/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios/$total_servicios*100),2) ?> %</td>
                    </tr>
                  <?php   } ?>
                  </tbody>
                  
                </table>

              </div>
            </div>
        </div>
          <?php 
          } ?>
</div>


<!-- Modal plazas -->

<div class="modal modal-primary fade" id="modal-nuevo">
     <div class="modal-dialog" >
    <div class="modal-content">

      <form action="<?php echo $url_action_select_plazas ;?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="usuario" value="">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 id="pla" class="modal-title">PLAZAS</h4>
        </div>      
             
        <div class="modal-body">
            <div class="row">
            <input type="hidden" id="ini" name="fechad" value="<?php echo $fdesde ?>"> 
            <input type="hidden" id="finn" name="fechah" value="<?php echo $fhasta ?>"> 
             <input type="hidden" id="tipo" value="<?php echo $tipo ?>" name="tipo">
             <input type="hidden" id="fvista" value="<?php echo $fvista ?>" name="fvista"> 
           <div class="col-xs-12">
             
            <?php if (empty($plaa)) { ?>
               <ul>
             <li   class="col-md-12"> <input type="checkbox" checked="" name="all" id="all" ><label> TODAS</label><br> 
             <ul>   
            <?php  foreach ($arrCoord as $sltPlaza) { 
              if ($sltPlaza->CORDI91_ALIGTE == 'ZARATE' || $sltPlaza->CORDI91_ALIGTE == 'CORIA') { ?>
             <li  class="col-md-6"><input type="checkbox" checked=""  id="<?php echo $asd+=1 ?>" class="plazas" name="id[]" value="<?php echo $sltPlaza->CORDI11_ALIAS ?>"> <?php echo $sltPlaza->CORDI11_ALIAS; ?> </li> 
            <?php }} ?>
            </ul>
          </li>
          </ul>
            <?php } else{ ?> 
             <ul>
             <li class="col-md-12"> <input type="checkbox" name="all" id="all" ><label> TODAS</label><br> 
             <ul>   
            <?php  foreach ($arrCoord as $sltPlaza) {
              if ($sltPlaza->CORDI91_ALIGTE == 'ZARATE' || $sltPlaza->CORDI91_ALIGTE == 'CORIA') {
                 foreach ($plaa as $key => $vlv) { 
                   if($sltPlaza->CORDI11_ALIAS==$vlv){
                     $chek="checked";
                     break;
                      }else{
                      $chek="";
                      }
                   }  ?>                                                                              
             <li class="col-md-6"><input type="checkbox" <?php echo $chek ?> id="<?php echo $asd+=1 ?>" class="plazas" name="id[]" value="<?php echo $sltPlaza->CORDI11_ALIAS?>"> <?php echo $sltPlaza->CORDI11_ALIAS; ?> </li> 
            <?php   }}  ?>
            </ul>
          </li>
          </ul>

  <?php } ?> 

           </div>      
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id='enviar' class="btn btn-primary">OK</button>
        </div>
      </form>

    </div>
  </div>
</div>
 <div class="modal modal-primary fade" id="modal-nuevo-empleados">
     <div class="modal-dialog" style="width: 60vw;">
    <div class="modal-content">

      <form action="<?php echo $url_action_select_empleados ;?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="usuario" value="">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 id="pla" class="modal-title">GESTORES</h4>
        </div>      
             
        <div class="modal-body">
            <div class="row">
            <input type="hidden" id="ini" name="fechad" value="<?php echo $fdesde ?>"> 
            <input type="hidden" id="finn" name="fechah" value="<?php echo $fhasta ?>"> 
             <input type="hidden" id="tipo" value="<?php echo $tipo ?>" name="tipo"> 
             <input type="hidden" id="fvista" value="<?php echo $fvista ?>" name="fvista"> 
           <div class="col-xs-12">

             <?php if (empty($empleados)) { ?>
             <ul>
             <li> <input type="checkbox" name="all" checked="" id="all_emp" ><label> TODOS</label><br> 
             <ul>   
            <?php foreach ($arrGestores as $gestor) { 
              if ($gestor[5] == 'S') {
                  ?>
             <li class="col-md-4"><input type="checkbox" name="empleados[]" checked="" id="emp<?php echo $asdepm+=1 ?>" class="empleados" value="<?php echo $gestor[0]?>"> <?php echo $gestor[1]; ?> </li> 
            <?php }} ?>
            </ul>
          </li>
          </ul>
          <?php } else{ ?>
            <ul>
             <li> <input type="checkbox" name="all" id="all_emp" ><label> TODOS</label><br> 
             <ul>   
            <?php foreach ($arrGestores as $gestor) { 
              if ($gestor[5] == 'S') {
                foreach ($empleados as $key => $vlv) { 
                   if($gestor[0]==$vlv){
                     $chek="checked";
                     break;
                      }else{
                      $chek="";
                     }  
                    }  ?>                      
             <li class="col-md-4"><input type="checkbox" name="empleados[]"  <?php echo $chek; ?> id="emp<?php echo $asdepm+=1; ?>" class="empleados" value="<?php echo $gestor[0] ?>"> <?php echo $gestor[1]; ?> </li> 
            <?php  }} ?>
            </ul>
          </li>
          </ul>

          <?php } ?>
           </div>      
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit"id='enviar_emp' class="btn btn-primary">OK</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script type="text/javascript">

   $(document).ready(function(){

       $('.plazas').click(function(event) { 
       var cantidad = $(".plazas").length;
       console.log(cantidad); 
       for (var i = 1; i <= cantidad; i++) {
        // var c='#'+i;
         if ( $('#'+i).prop('checked')) {
           $('#enviar').show();
           console.log('t');
           break;
         }else{
          $('#enviar').hide();
          console.log($('#'+i).val());
         }
       }      
      
     });

     $('#all').click(function(event) {   
        if(this.checked) {
           $('#enviar').show();
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;                        
            });
        } else {
             $('#enviar').hide();
            $(':checkbox').each(function() {
                this.checked = false;                       
            });
        }
    });
   });

   $(document).ready(function(){
        $('.empleados').click(function(event) { 
       var cantidad = $(".empleados").length;
       console.log(cantidad); 
       for (var i = 1; i <= cantidad; i++) {
        // var c='#'+i;
         if ( $('#emp'+i).prop('checked')) {
           $('#enviar_emp').show();
           console.log('t');
           break;
         }else{
          $('#enviar_emp').hide();
          console.log($('#emp'+i).val());
         }
       }      
      
     });
       $('#all_emp').click(function(event) {   
        if(this.checked) {
          $('#enviar_emp').show();
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;                        
            });
        } else {
            $('#enviar_emp').hide();
            $(':checkbox').each(function() {
                this.checked = false;                       
            });
        }
    });
     });

  function crearHrefPlaza()
  {
      aStart = $("#start").val();
      aEnd = $("#end").val();

      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];                                 

      // f_usuario = $("#slt_usuario").val();   

      // f_plaza = $("#slt_plaza").val();
      f_tipo = $("#slt_tipo").val();
      f_plaza = $("#slt_plaza").val();
      f_vista = $("#slt_vista").val();

      url_filtro_reporte="index.php?view=metricas_tt&fdesde="+aStart+"&fhasta="+aEnd;


    // if(f_plaza!=undefined)
    //   if(f_plaza!='' && f_plaza!=0)
    //     url_filtro_reporte= url_filtro_reporte +"&fplaza="+f_plaza;  

    //   if(f_usuario!=undefined)
    //     if(f_usuario>0)
    //       url_filtro_reporte= url_filtro_reporte + "&fusuario="+f_usuario; 

        if(f_tipo!=undefined)
          url_filtro_reporte= url_filtro_reporte + "&tipo="+f_tipo;

        if(f_plaza!=undefined)
          if (f_plaza>'0')
            url_filtro_reporte= url_filtro_reporte + "&fplaza="+f_plaza;

        if(f_vista!=undefined)
          if (f_vista>'0')
            url_filtro_reporte= url_filtro_reporte + "&fvista="+f_vista;
      
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

  function filtrarReporte()
  {
    crearHref();
    window.location = $("#filtro_reporte").attr("href");
  }
</script>