$(document).ready(function(){                
      $("#mnu_kanban").addClass("active");
    });
    $(document).ready(function(){                
      $("#mnu_kanban_listado").addClass("active");
    });

    try{
        CKEDITOR.replace( 'descripcion' );

    }catch(e){}

$(document).ready(function(){                
  $(".btn-new").on('click',function(){
    $('.editable').val('');
    CKEDITOR.instances.descripcion.setData( '' );
    $('.slt_editable').val(0);
  });
});

function asigUser(id) {
    id_tarea = document.getElementById('asig_'+id).getAttribute('data-id');
    id_user = document.getElementById('asig_'+id).getAttribute('data-iduser');

    console.log(id_tarea, id, id_user);


    document.getElementById('id_tarea').value = id_tarea;
    document.getElementById('slt_usuario').value = id_user;
}


    // $(document).ready(function() {
    //     $('#tabla-sueldos').DataTable({
    //       "dom": 'Bfrtip',
    //       "buttons": ['copy', 'csv', 'excel', 'print'],
    //       "iDisplayLength":100,
    //       "order": [[ 2, "desc" ]],
    //       "language": {
    //           "sProcessing":    "Procesando...",
    //           "sLengthMenu":    "Mostrar _MENU_ registros",
    //           "sZeroRecords":   "No se encontraron resultados",
    //           "sEmptyTable":    "Ningún dato disponible en esta tabla",
    //           "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    //           "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
    //           "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
    //           "sInfoPostFix":   "",
    //           "sSearch":        "Buscar:",
    //           "sUrl":           "",
    //           "sInfoThousands":  ",",
    //           "sLoadingRecords": "Cargando...",
    //           "oPaginate": {
    //               "sFirst":    "Primero",
    //               "sLast":    "Último",
    //               "sNext":    "Siguiente",
    //               "sPrevious": "Anterior"
    //           },
    //           "oAria": {
    //               "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
    //               "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    //           }
    //         }                                
    //     });
    // });

    // $(document).ready(function() {
    //   $("#slt_usuario").select2({
    //       placeholder: "Seleccionar un Usuario",                  
    //   }).on('change', function (e) { 
    //     filtrarReporte();
    //   });
    // });

    // $(document).ready(function() {
    //   $("#slt_plaza").select2({
    //       placeholder: "Seleccionar un Usuario",                  
    //   }).on('change', function (e) { 
    //     filtrarReporte();
    //   });
    // });
    
    // function crearHref()
    // {
    //     f_usuario = $("#slt_usuario").val();   
    //     f_plaza = $("#slt_plaza").val();   
        
    //     url_filtro_reporte="index.php?view=sueldos_remun";

    //     if(f_usuario!=undefined)
    //       if(f_usuario>0)
    //         url_filtro_reporte= url_filtro_reporte + "&fusuario="+f_usuario;

    //     if(f_plaza!=undefined)
    //       if(f_plaza>0)
    //         url_filtro_reporte= url_filtro_reporte + "&fplaza="+f_plaza;

    //     $("#filtro_reporte").attr("href", url_filtro_reporte);
    // }  

    // function filtrarReporte()
    // {
    //   crearHref();
    //   window.location = $("#filtro_reporte").attr("href");
    // }