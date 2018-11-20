      
      <div class="col-md-12">
        <?php
          
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
              }
            }

            if(!empty($consulta)){
        ?>
        <div class="col-md-12 no-padding">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title" style="text-transform: uppercase;">GOBAL</h3>
              </div>    
              <div class="box-body table-responsive">
                <table class="table no-border table-striped table-condensed" id="tabla" cellspacing="0" width="100%" style="text-align: center;" >
                  <thead>
                    <tr class="bg-black">
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
                    <tr>
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
                    <tr>
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
                  </tbody>
                  
                </table>

              </div>
            </div>
        </div>
          <?php 
          } ?>
</div>