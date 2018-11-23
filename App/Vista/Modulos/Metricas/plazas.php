    <?php 
      $listaPlaza = '';
        if (!empty($plaa)) {
            foreach ($arrCoord as $sltPlaza) {
              if ($sltPlaza->CORDI91_ALIGTE == 'ZARATE' || $sltPlaza->CORDI91_ALIGTE == 'CORIA') {
                foreach ($plaa as $key => $vlv) { 
                  if($sltPlaza->CORDI11_ALIAS==$vlv){
                  $listaPlaza[] = $sltPlaza;
                }
              }
            }
          }
        } else {
          $listaPlaza = $arrCoord;
        }

       ?>
      
      <div class="col-md-12 ">
        <?php
          $consulta = $handler->consultaMetricas($fdesde, $fhasta, $fdesdeR, $fhastaR, null);
          if(!empty($consulta)){
        ?>
        <div class="col-md-12 no-padding">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title" style="text-transform: uppercase;">POR PLAZA</h3>
                <div class="col-md-2 pull-right text-right">
                  <label >Empresa</label>
                </div>
              </div>    
              <div class="box-body table-responsive no-paddig">
                <table class="table no-border table-striped table-condensed" id="tabla" cellspacing="0" width="100%" style="text-align: center;" >
                  <thead>
                    <tr class="bg-black">

                      <td style="text-align: left;">Plaza</td>
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


                    foreach ($listaPlaza as $plaza) {
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
                          if (!empty($empresas)) {
                            foreach ($empresas as $fempresa) {
                              if ($value->NOM_COORDINADOR == $plaza->CORDI11_ALIAS && $value->COD_EMPRESA == $fempresa) {
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
                                $total_servicios_CANCELADO = $total_servicios_CANCELADO + $value->CANCEL;
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
                                $total_servicios_T_CANCELADO = $total_servicios_T_CANCELADO + $value->CANCEL;
                              }
                            }
                          } elseif ($value->NOM_COORDINADOR == $plaza->CORDI11_ALIAS) {
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
                            $total_servicios_CANCELADO = $total_servicios_CANCELADO + $value->CANCEL;
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
                            $total_servicios_T_CANCELADO = $total_servicios_T_CANCELADO + $value->CANCEL;
                          }
                        } 

                        if($total_servicios > 0){
                          if ($fvista == '1' || empty($fvista)) {

                          ?>


                    <tr>
                      <td <?php if ($fvista !== '1') { echo 'rowspan="2"';} ?> style="text-align: left;"><?php echo $plaza->CORDI11_ALIAS ?></td>
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
                      <td style="text-align: left;"><?php echo $plaza->CORDI11_ALIAS ?></td>
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