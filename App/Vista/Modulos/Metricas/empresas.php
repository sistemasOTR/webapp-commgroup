      <?php 

        $handlerplazas=new HandlerPlazaUsuarios();
        $plazasOtr=$handlerplazas->selectTodas();
        $url_action_select_empleados=PATH_VISTA.'Modulos/Metricas/action_select_empleados.php';
        $id = (isset($_GET["plaza"])?$_GET["plaza"]:0);
        $url_action_select_plazas=PATH_VISTA.'Modulos/Metricas/action_select_plazas.php';
        $asd = 0; 
        $asdepm = 0; 


        $listaEmpresas = '';
        if (!empty($empresas)) {
          foreach ($arrEmpresas as $empresa_chk) { 
            if ($empresa_chk->EMPTT91_ACTIVA == 'S') {
              foreach ($empresas as $key => $vlv) { 
                if($empresa_chk->EMPTT11_CODIGO == $vlv){
                  $listaEmpresas[] = $empresa_chk;
                }
              }
            }
          }
        } else {
          $listaEmpresas = $arrEmpresas;
        }

        // var_dump($listaEmpresas);
        // exit();
       ?>


      <div class="col-md-12 ">
        <?php
        // var_dump($arrEmpresas,$empresas);
        // exit();
          $consulta = $handler->consultaMetricas($fdesde, $fhasta, $fdesdeR, $fhastaR, null);
          if(!empty($consulta)){
        ?>
        <div class="col-md-12 no-padding">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title" style="text-transform: uppercase;">POR EMPRESA</h3>
                
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
                        $total_servicios_T = 0;
                        $total_servicios_T_CERRADO = 0;
                        $total_servicios_T_ENV = 0;
                        $total_servicios_T_CERRADO_PARCIAL = 0;
                        $total_servicios_T_RE_PACTADO = 0;
                        $total_servicios_T_RE_LLAMAR = 0;
                        $total_servicios_T_NEGATIVO = 0;
                        $total_servicios_T_PROBLEMAS = 0;
                        $total_servicios_T_A_LIQUIDAR = 0;
                        $total_servicios_T_CANCELADO = 0;
                        $total_servicios_T_NEGATIVO_BO = 0;
                        $total_servicios_T_PROBLEMAS_BO = 0;
                        $total_servicios_T_LIQUIDAR_C_PARCIAL = 0;
                        $total_servicios_T_NO_EFECTIVAS = 0;

                    foreach ($listaEmpresas as $empresa) {
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

                        foreach ($consulta as $key => $value) { 
                          if (!empty($plaa)) {
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
                                $total_servicios_T = $total_servicios_T + $value->TOTAL_SERVICIOS;
                                $total_servicios_T_CERRADO = $total_servicios_T_CERRADO + $value->CERRADO;
                                $total_servicios_T_ENV = $total_servicios_T_ENV + $value->ENV;
                                $total_servicios_T_CERRADO_PARCIAL = $total_servicios_T_CERRADO_PARCIAL + $value->CERRADO_PARCIAL;
                                $total_servicios_T_RE_PACTADO = $total_servicios_T_RE_PACTADO + $value->RE_PACTADO;
                                $total_servicios_T_RE_LLAMAR = $total_servicios_T_RE_LLAMAR + $value->RE_LLAMAR;
                                $total_servicios_T_NEGATIVO = $total_servicios_T_NEGATIVO + $value->NEGATIVO;
                                $total_servicios_T_PROBLEMAS = $total_servicios_T_PROBLEMAS + $value->PROBLEMAS;
                                $total_servicios_T_A_LIQUIDAR = $total_servicios_T_A_LIQUIDAR + $value->A_LIQUIDAR;
                                $total_servicios_T_NEGATIVO_BO = $total_servicios_T_NEGATIVO_BO + $value->NEGATIVO_BO;
                                $total_servicios_T_PROBLEMAS_BO = $total_servicios_T_PROBLEMAS_BO + $value->PROBLEMAS_BO;
                                $total_servicios_T_LIQUIDAR_C_PARCIAL = $total_servicios_T_LIQUIDAR_C_PARCIAL + $value->LIQUIDAR_C_PARCIAL;
                                $total_servicios_T_NO_EFECTIVAS = $total_servicios_T_NO_EFECTIVAS + $value->NO_EFECTIVAS;
                                $total_servicios_T_CANCELADO  = $total_servicios_T_CANCELADO + $value->CANCEL;
                              }
                            }

                          } elseif (!empty($empleados)) {
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
                                $total_servicios_T = $total_servicios_T + $value->TOTAL_SERVICIOS;
                                $total_servicios_T_CERRADO = $total_servicios_T_CERRADO + $value->CERRADO;
                                $total_servicios_T_ENV = $total_servicios_T_ENV + $value->ENV;
                                $total_servicios_T_CERRADO_PARCIAL = $total_servicios_T_CERRADO_PARCIAL + $value->CERRADO_PARCIAL;
                                $total_servicios_T_RE_PACTADO = $total_servicios_T_RE_PACTADO + $value->RE_PACTADO;
                                $total_servicios_T_RE_LLAMAR = $total_servicios_T_RE_LLAMAR + $value->RE_LLAMAR;
                                $total_servicios_T_NEGATIVO = $total_servicios_T_NEGATIVO + $value->NEGATIVO;
                                $total_servicios_T_PROBLEMAS = $total_servicios_T_PROBLEMAS + $value->PROBLEMAS;
                                $total_servicios_T_A_LIQUIDAR = $total_servicios_T_A_LIQUIDAR + $value->A_LIQUIDAR;
                                $total_servicios_T_NEGATIVO_BO = $total_servicios_T_NEGATIVO_BO + $value->NEGATIVO_BO;
                                $total_servicios_T_PROBLEMAS_BO = $total_servicios_T_PROBLEMAS_BO + $value->PROBLEMAS_BO;
                                $total_servicios_T_LIQUIDAR_C_PARCIAL = $total_servicios_T_LIQUIDAR_C_PARCIAL + $value->LIQUIDAR_C_PARCIAL;
                                $total_servicios_T_NO_EFECTIVAS = $total_servicios_T_NO_EFECTIVAS + $value->NO_EFECTIVAS;
                                $total_servicios_T_CANCELADO  = $total_servicios_T_CANCELADO + $value->CANCEL;
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
                            $total_servicios_T = $total_servicios_T + $value->TOTAL_SERVICIOS;
                            $total_servicios_T_CERRADO = $total_servicios_T_CERRADO + $value->CERRADO;
                            $total_servicios_T_ENV = $total_servicios_T_ENV + $value->ENV;
                            $total_servicios_T_CERRADO_PARCIAL = $total_servicios_T_CERRADO_PARCIAL + $value->CERRADO_PARCIAL;
                            $total_servicios_T_RE_PACTADO = $total_servicios_T_RE_PACTADO + $value->RE_PACTADO;
                            $total_servicios_T_RE_LLAMAR = $total_servicios_T_RE_LLAMAR + $value->RE_LLAMAR;
                            $total_servicios_T_NEGATIVO = $total_servicios_T_NEGATIVO + $value->NEGATIVO;
                            $total_servicios_T_PROBLEMAS = $total_servicios_T_PROBLEMAS + $value->PROBLEMAS;
                            $total_servicios_T_A_LIQUIDAR = $total_servicios_T_A_LIQUIDAR + $value->A_LIQUIDAR;
                            $total_servicios_T_NEGATIVO_BO = $total_servicios_T_NEGATIVO_BO + $value->NEGATIVO_BO;
                            $total_servicios_T_PROBLEMAS_BO = $total_servicios_T_PROBLEMAS_BO + $value->PROBLEMAS_BO;
                            $total_servicios_T_LIQUIDAR_C_PARCIAL = $total_servicios_T_LIQUIDAR_C_PARCIAL + $value->LIQUIDAR_C_PARCIAL;
                            $total_servicios_T_NO_EFECTIVAS = $total_servicios_T_NO_EFECTIVAS + $value->NO_EFECTIVAS;
                            $total_servicios_T_CANCELADO  = $total_servicios_T_CANCELADO + $value->CANCEL;
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
                      ?>
                      <?php 
                      if ($total_servicios_T > 0) {
                        

                        if ($fvista == '1' || empty($fvista)) { ?>
                      <tr>
                      <td <?php if ($fvista !== '1') { echo 'rowspan="2"';} ?> style="text-align: left;">TOTALES</td>
                      <td style="text-align: center;"><?php echo $total_servicios_T_CERRADO ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_T_ENV ?></td>
                      <td  style="text-align: center;"><?php echo $total_servicios_T_A_LIQUIDAR ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_T_CERRADO_PARCIAL ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_T_RE_PACTADO ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_T_RE_LLAMAR ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_T_NEGATIVO ?></td><td style="text-align: center;"><?php echo $total_servicios_T_PROBLEMAS ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_T_NEGATIVO_BO ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_T_PROBLEMAS_BO ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_T_LIQUIDAR_C_PARCIAL ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_T_NO_EFECTIVAS ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_T_CANCELADO ?></td>
                      <td style="text-align: center;"><?php echo ($total_servicios_T_CERRADO + $total_servicios_T_ENV + $total_servicios_T_A_LIQUIDAR) ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios_T ?></td>
                    </tr>
                  <?php } ?>
                  <?php if ($fvista == '2' || empty($fvista)) { ?>
                    <tr>
                      <?php if ($fvista == '2') { ?>
                        <td style="text-align: left;">TOTALES</td>
                      <?php } ?>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_T_CERRADO/$total_servicios_T*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_T_ENV/$total_servicios_T*100),2) ?> %</td>
                      <td  style="text-align: center;"><?php echo number_format(($total_servicios_T_A_LIQUIDAR/$total_servicios_T*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_T_CERRADO_PARCIAL/$total_servicios_T*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_T_RE_PACTADO/$total_servicios_T*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_T_RE_LLAMAR/$total_servicios_T*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_T_NEGATIVO/$total_servicios_T*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_T_PROBLEMAS/$total_servicios_T*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_T_NEGATIVO_BO/$total_servicios_T*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_T_PROBLEMAS_BO/$total_servicios_T*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_T_LIQUIDAR_C_PARCIAL/$total_servicios_T*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_T_NO_EFECTIVAS/$total_servicios_T*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_T_CANCELADO/$total_servicios_T*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format((($total_servicios_T_CERRADO + $total_servicios_T_ENV + $total_servicios_T_A_LIQUIDAR)/$total_servicios_T*100),2) ?> %</td>
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_T/$total_servicios_T*100),2) ?> %</td>
                    </tr>
                  <?php   }
                      } else {
                        echo "<tr>";
                        echo "<td colspan='15'> No hay resultados para esta consulta </td>";
                        echo "</tr>";
                      } ?>
                  </tbody>
                  
                </table>

              </div>
            </div>
        </div>
          <?php 
          } ?>
</div>
