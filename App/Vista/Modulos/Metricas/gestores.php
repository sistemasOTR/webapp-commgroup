    <?php 
        $fempresa = (isset($_GET["fempresa"])?$_GET["fempresa"]:'');   
       ?>      
      <div class="col-md-12 ">
        <?php
          $consulta = $handler->consultaPuntajes($fdesde, $fhasta, null);
          if(!empty($consulta)){
        ?>
        <div class="col-md-12 no-padding">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title" style="text-transform: uppercase;">POR gestor</h3>
                <div class="col-md-3 pull-right">
                  <select name="slt_empresa" id="slt_empresa" class="form-control" onchange="crearHrefEmpresa()">
                    <option value="0">TODAS...</option>
                    <?php 
                      foreach ($arrEmpresas as $sltEmp) {
                        if ($sltEmp->EMPTT91_ACTIVA == 'S') {
                          if ($sltEmp->EMPTT11_CODIGO == $fempresa) {
                            echo "<option value='".$sltEmp->EMPTT11_CODIGO."' selected>".$sltEmp->EMPTT21_NOMBREFA."</option>";
                          } else {
                             echo "<option value='".$sltEmp->EMPTT11_CODIGO."'>".$sltEmp->EMPTT21_NOMBREFA."</option>";
                          }
                        }
                      }
                     ?>
                  </select>
                </div>
                <div class="col-md-2 pull-right text-right">
                  <label >Empresa</label>
                </div>
              </div>    
              <div class="box-body table-responsive no-paddig">
                <table class="table no-border table-condensed" id="tabla" cellspacing="0" width="100%" style="text-align: center;" >
                  <thead>
                    <tr class="bg-black">
                      <td style="text-align: left;">Gestor</td>
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
                    foreach ($arrGestores as $gestor) {
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
                        $total_servicios_CANCEL = 0;
                        $total_servicios_cerrados = 0;
                        $total_efectividad = 0;
                        $total_puntajes_cerrados = 0;

                        $total_servicios_enviadas = 0;
                        $total_puntajes_enviadas = 0;

                        foreach ($consulta as $key => $value) {
                          if (!empty($fempresa)) {
                            if ($value->COD_GESTOR == $gestor[0] && $value->COD_EMPRESA == $fempresa) {
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
                              $total_servicios_CANCEL = $total_servicios_CANCEL + $value->CANCEL;
                            }
                          } elseif ($value->COD_GESTOR == $gestor[0]) {
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
                            $total_servicios_CANCEL = $total_servicios_CANCEL + $value->CANCEL;
                          }
                        } 

                        if($total_servicios > 0){

                          ?>


                    <tr>
                      <td rowspan="2" style="text-align: left;"><?php echo $gestor[1] ?></td>
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
                      <td style="text-align: center;background: #fffff0"><?php echo $total_servicios_CANCEL ?></td>
                      <td style="text-align: center;background: #e8ab98;"><?php echo ($total_servicios_CERRADO + $total_servicios_ENV + $total_servicios_A_LIQUIDAR) ?></td>
                      <td style="text-align: center;background: #fdfbcb;"><?php echo $total_servicios ?></td>
                    </tr>
                    <tr>
                      <!-- <td style="text-align: left;"><?php echo $gestor[1] ?></td> -->
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
                      <td style="text-align: center;background: #fffff0"><?php echo number_format(($total_servicios_CANCEL/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;background: #e8ab98;"><?php echo number_format((($total_servicios_CERRADO + $total_servicios_ENV + $total_servicios_A_LIQUIDAR)/$total_servicios*100),2) ?> %</td>
                      <td style="text-align: center;background: #fdfbcb;"><?php echo number_format(($total_servicios/$total_servicios*100),2) ?> %</td>
                    </tr>
                        
                      <?php }}  
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
                $total_servicios_CANCEL = $total_servicios_CANCEL + $value->CANCEL;
              }
            }
                      ?>
                      <tr>
                      <td rowspan="2" style="text-align: left;">TOTALES</td>
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
                      <td style="text-align: center;"><?php echo $total_servicios_CANCEL ?></td>
                      <td style="text-align: center;"><?php echo ($total_servicios_CERRADO + $total_servicios_ENV + $total_servicios_A_LIQUIDAR) ?></td>
                      <td style="text-align: center;"><?php echo $total_servicios ?></td>
                    </tr>
                    <tr>
                      <td style="text-align: center;"><?php echo $total_servicios_CERRADO ?></td>
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
                      <td style="text-align: center;"><?php echo number_format(($total_servicios_CANCEL/$total_servicios*100),2) ?> %</td>
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


<script type="text/javascript">
  $(document).ready(function() {
      $('#tabla').DataTable({
        "dom": 'Bfrtip',
        "buttons": ['copy', 'csv', 'excel', 'print'],
        "order":[],
        "iDisplayLength":100,
        "language": {
            "sProcessing":    "Procesando...",
            "sLengthMenu":    "Mostrar _MENU_ registros",
            "sZeroRecords":   "No se encontraron resultados",
            "sEmptyTable":    "Ningún dato disponible en esta tabla",
            "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":   "",
            "sSearch":        "Buscar:",
            "sUrl":           "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":    "Último",
                "sNext":    "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
          }                                
      });
  });
  function crearHrefEmpresa()
  {
      aStart = $("#start").val();
      aEnd = $("#end").val();

      f_inicio = aStart[2] +"-"+ aStart[1] +"-"+ aStart[0];
      f_fin = aEnd[2] +"-"+ aEnd[1] +"-"+ aEnd[0];                                 

      // f_usuario = $("#slt_usuario").val();   

      // f_plaza = $("#slt_plaza").val();
      f_tipo = $("#slt_tipo").val();
      f_empresa = $("#slt_empresa").val();

      url_filtro_reporte="index.php?view=metricas_tt&fdesde="+aStart+"&fhasta="+aEnd;


    // if(f_plaza!=undefined)
    //   if(f_plaza!='' && f_plaza!=0)
    //     url_filtro_reporte= url_filtro_reporte +"&fplaza="+f_plaza;  

    //   if(f_usuario!=undefined)
    //     if(f_usuario>0)
    //       url_filtro_reporte= url_filtro_reporte + "&fusuario="+f_usuario; 

        if(f_tipo!=undefined)
          url_filtro_reporte= url_filtro_reporte + "&tipo="+f_tipo;

        if(f_empresa!=undefined)
          if (f_empresa>'0')
            url_filtro_reporte= url_filtro_reporte + "&fempresa="+f_empresa;
      
      
      $("#filtro_reporte").attr("href", url_filtro_reporte);
  } 

  function filtrarReporte()
  {
    crearHref();
    window.location = $("#filtro_reporte").attr("href");
  }
</script>