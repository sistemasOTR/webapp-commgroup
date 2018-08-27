<table class="table table-striped table-condensed" id="tabla" cellspacing="0" width="100%">
  <thead>        
    <tr>             
      <th class='text-center'>Fecha</th>
      <th class='text-center'>Nro</th>
      <th class='text-left'>ID.Oport.</th>  
      <!-- <th class='text-left'>E.Vtas</th>  -->
      <th class='text-left'>DNI</th>            
      <th class='text-left'>Nombre</th>      
      <th class='text-left'>Telefono</th>      
      <th class='text-left'>Localidad</th>      
      <th class='text-left'>Estado</th>  
      <th class='text-left'>Observaciones</th>    
      
      <th style="width: 5%;" class='text-center'></th>
      <th style="width: 5%;" class='text-center'></th>
    </tr>
  </thead>

  <tbody>
    <?php    
      if(!empty($arrDatos)){
        foreach ($arrDatos as $key => $value) {                    
          
          if($value->SERTT91_OBSERV == $value->SERTT91_OBRESPU)
            $observaciones = $value->SERTT91_OBSERV;
          else
            $observaciones = $value->SERTT91_OBSERV."<br>".$value->SERTT91_OBRESPU; 

          $observaciones = $observaciones."<br>".$value->SERTT91_OBSEENT ;

          $filtros_listado = "&fdoc=".$fdoc."&fdesde=".$fdesde."&fhasta=".$fhasta."&festado=".$festado."&fequipoventa=".$fequipoventa."&fcliente=".$fcliente."&fgerente=".$fgerente."&fcoordinador=".$fcoordinador."&fgestor=".$fgestor."&foperador=".$foperador;      
          $url_hist = $url_detalle."&fechaing=".$value->SERTT11_FECSER->format('Y-m-d')."&nroing=".$value->SERTT12_NUMEING."&nrodoc=".$value->SERTT31_PERNUMDOC."&empresa=".$usuarioActivoSesion->getUserSistema().$filtros_listado;       

          echo "<tr>";

              //FECHA
              echo "<td class='text-center'>".$value->SERTT11_FECSER->format('d/m/Y')."</td>";              

              //NUMERO
              echo "<td class='text-center'>".$value->SERTT12_NUMEING."</td>";

              //ID OPORTUNIDAD
              echo "<td class='text-left'>".$value->SERTT91_IDOPORT."</td>";                          


              //EQUIPO DE VENTAS
              /*
              if(!empty(trim(strip_tags($value->TEPE91_EQUIPVTA))))
                if(strlen(trim(strip_tags($value->TEPE91_EQUIPVTA)))>5)
                  echo "<td class='text-left'>".substr(trim(strip_tags($value->TEPE91_EQUIPVTA)),0,5)."... <i class='fa fa-search-plus pull-right' data-toggle='tooltip' title='' data-original-title='".trim(strip_tags($value->TEPE91_EQUIPVTA))."'></i></td>";
                else
                  echo "<td class='text-left'>".trim(strip_tags($value->TEPE91_EQUIPVTA))."</td>";
              else
                echo "<td class='text-left'></td>";
              */

              //DNI              
              echo "<td class='text-left'>".$value->SERTT31_PERNUMDOC."</td>";              

              //NOMBRE
              if(!empty(trim(strip_tags($value->SERTT91_NOMBRE))))
                if(strlen(trim(strip_tags($value->SERTT91_NOMBRE)))>15)
                  echo "<td class='text-left'>".substr(trim(strip_tags($value->SERTT91_NOMBRE)),0,15)."... <i class='fa fa-search-plus pull-right' data-toggle='tooltip' title='' data-original-title='".trim(strip_tags($value->SERTT91_NOMBRE))."'></i></td>";
                else
                  echo "<td class='text-left'>".trim(strip_tags($value->SERTT91_NOMBRE))."</td>";
              else
                echo "<td class='text-left'></td>";

              //TELEFONO              
              if(!empty(trim(strip_tags($value->SERTT91_TELEFONO))))
                if(strlen(trim(strip_tags($value->SERTT91_TELEFONO)))>15)
                  echo "<td class='text-left'>".substr(trim(strip_tags($value->SERTT91_TELEFONO)),0,15)."... <i class='fa fa-search-plus pull-right' data-toggle='tooltip' title='' data-original-title='".trim(strip_tags($value->SERTT91_TELEFONO))."'></i></td>";
                else
                  echo "<td class='text-left'>".trim(strip_tags($value->SERTT91_TELEFONO))."</td>";
              else
                echo "<td class='text-left'></td>";

              //LOCALIDAD
              if(!empty(trim(strip_tags($value->SERTT91_LOCALIDAD))))
                if(strlen(trim(strip_tags($value->SERTT91_LOCALIDAD)))>20)
                  echo "<td class='text-left'>".substr(trim(strip_tags($value->SERTT91_LOCALIDAD)),0,20)."... <i class='fa fa-search-plus pull-right' data-toggle='tooltip' title='' data-original-title='".trim(strip_tags($value->SERTT91_LOCALIDAD))."'></i></td>";
                else
                  echo "<td class='text-left'>".trim(strip_tags($value->SERTT91_LOCALIDAD))."</td>";
              else
                echo "<td class='text-left'></td>";


              //ESTADOS
              $f_array = new FuncionesArray;
              $class_estado = $f_array->buscarValor($allEstados,"1",$value->ESTADOS_DESCCI,"3");
              echo "<td class='text-left'><span class='".$class_estado."'>".$value->ESTADOS_DESCCI."</span></td>";
              

              //OBSERVACIONES
              if(!empty(trim(strip_tags($observaciones))))
                if(strlen(trim(strip_tags($observaciones)))>25)
                  echo "<td class='text-left'>".substr(trim(strip_tags($observaciones)),0,25)."... <i class='fa fa-search-plus pull-right' data-toggle='tooltip' title='' data-original-title='".trim(strip_tags($observaciones))."'></i></td>";
                else 
                  echo "<td class='text-left'>".trim(strip_tags($observaciones))."</td>";
              else
                echo "<td class='text-left'></td>";         
              
              //$adjuntosCompletos = $handlerUF->adjuntosCompletos($value->SERTT11_FECSER->format('Y-m-d'),$value->SERTT12_NUMEING,$value->SERTT91_CODEMPRE);            
              $estaPublicado = $handlerUF->estaPublicado($value->SERTT11_FECSER->format('Y-m-d'),$value->SERTT12_NUMEING);

              $url_downloadfile = BASE_URL.PATH_VISTA."Modulos/Servicio/UploadFile/action_downloadfile.php?fechaing=".$value->SERTT11_FECSER->format('Y-m-d')."&nroing=".$value->SERTT12_NUMEING."&usuario=".$usuarioActivoSesion->getEmail();

              if($estaPublicado){
                $display_download = "";
                $class_boton = "btn btn-success";
                $class_font = "fa fa-download";
              }
              else{
                $display_download = "display:none;";
                $class_boton = "";
                $class_font = "";
              }

              echo "<td class='text-center'>
                      <a href='".$url_downloadfile."' class='".$class_boton." btn-xs' style='".$display_download."'><i class='".$class_font."'></i></a>
                    </td>
                    <td class='text-center'>
                      <a href='".$url_hist."' class='btn btn-default btn-xs'><b>Detalle</b></a>                      
                    </td>";                            

            echo "</tr>";
        }
      }
              
    ?>                        
  </tbody>
</table> 

<script type="text/javascript">   

  $(document).ready(function() {
    $('#tabla').DataTable({
      "dom": 'Bfrtip',
      "buttons": ['copy', 'csv', 'excel', 'print'],
      "iDisplayLength":100,
      "oSearch": {"sSearch": "<?php echo $f_dd_dni; ?>"},
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

</script>
