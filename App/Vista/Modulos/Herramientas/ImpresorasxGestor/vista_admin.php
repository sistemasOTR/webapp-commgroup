<?php 
  $arrDatos = $handlerimpresoras->AllImpresoras($fplaza);
?>


<div class="box box-solid">
  <div class="box-header with-border">
    <i class="fa fa-list"></i>
    <h3 class="box-title">Listado de Impresoras <small>Por Plaza</small></h3>
  </div>

  <div class="box-body table-responsive"> 
    <table class="table table-striped table-condensed" id="tabla-plaza" cellspacing="0" width="100%" style="text-align:center;">
      <thead>
        <tr>
          <th class='text-center'>Serial</th>
          <th class='text-center'>Marca</th>
          <th class='text-center'>Modelo</th>
          <th class='text-center'>Estado</th>
          <th class='text-center' width="150">Plaza</th>
          <th class='text-center' width="150">Asignación</th>
          <th style="width: 5%;" class='text-center'></th>
          <th style="width: 3%;" class='text-center'></th>
        </tr>
      </thead>

      <tbody>
      <?php    
        if(!empty($arrDatos)){
          foreach ($arrDatos as $key => $value) {                    

            if(is_null($handlerimpresoras->PlazaImpresoras($value->getSerialNro()))){
              $fecha = '-';
              $plaza = '-';
            } else {
              $fecha = $handlerimpresoras->PlazaImpresoras($value->getSerialNro())["_fechaAsig"]->format('d-m-Y');
              $plaza = $handlerimpresoras->PlazaImpresoras($value->getSerialNro())["_plaza"];
            }

            if(is_null($value->getFechaBaja())){
              $estado = '<span class = "text-green">Activa</span>';
            } else {
              $estado = '<span class = "text-red">Inactiva</span>';
            }


            echo 
            "<tr>
                <td>".$value->getSerialNro()."</td>
                <td>".$value->getMarca()."</td>
                <td>".$value->getModelo()."</td>
                <td>".$estado."</td>
                <td>".$plaza."</td>
                <td>".$fecha."</td>

            </tr>";
          }
        }

      ?>                        
      </tbody>
    </table> 
  </div>             
</div>
<script type="text/javascript">   

  $(document).ready(function() {
    $('#tabla-plaza').DataTable({
      "dom": 'Bfrtip',
      "buttons": ['copy', 'csv', 'print'],
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
