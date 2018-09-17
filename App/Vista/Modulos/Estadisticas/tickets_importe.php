<?php
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";
    include_once PATH_DATOS.'Entidades/usuario.class.php'; 
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php";  

    $dFecha = new Fechas;    
    $handler = new HandlerSistema;
    $handlertickets = new HandlerTickets;
    $handlerUsuario = new Usuario;
  
    $user = $usuarioActivoSesion;
    $handlerPlaza = new HandlerPlazaUsuarios;
    $arrPlaza = $handlerPlaza->selectTodas();
         foreach ($arrPlaza as $key => $valor) {
    $arrUsuarios=$handlerUsuario->selectByPlaza($valor->getId());
   
    //PARA TRABAJAR MAS COMODOS EN MODO DESARROLLO
    if(!PRODUCCION)
      $fHOY = "2018-08-27";
    $importeGasoil=0;
    $importeNafta=0;
    $importeGnc=0;
    
    $dataImporte=0;
    if (!empty($arrUsuarios)) {
     
    foreach ($arrUsuarios as $value ) {
   $arrImporte=$handlertickets->seleccionarByConcepto($fdesde,$fhasta,$value->getId());

      if( !empty($arrImporte)) {

              foreach ($arrImporte as $val) {
                if (trim($val->getConcepto())=='GASOIL' ) {
                 $importeGasoil+=$val->getImporte();
               }
               elseif (trim($val->getConcepto())=='NAFTA') {
                 $importeNafta+=$val->getImporte();
               }
               elseif (trim($val->getConcepto())=='GNC') {
                 $importeGnc+=$val->getImporte();
               }
      }

    }
  }
}
     $dataImporte =$importeNafta.",".$importeGasoil.",".$importeGnc;

     if ($dataImporte!="0,0,0") {

     $arrImporteTickets[]=array('PLAZA'=>$valor->getId());
     // var_dump($arrImporte);
       

?>

<div class="col-md-12 nopadding">
  <div class="box box-solid">    
    <div class="box-header">
        <h3 class="box-title" style="width: 100%;">
        <i class="ion-speedometer"> </i> Importe <span><b></b></span>
        <small class="pull-right" style="font-size: 15px;"><span class='text-yellow '><b><?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y');echo "-".$dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?></b></span></small>
      </h3>
    </div>
    <div class="box-body text-center">
   <canvas id="budget_importe_<?php echo $valor->getId(); ?>" class="col-xs-12 chart"></canvas>
     </div>
  </div>
</div>

<!-- SCRIPTS PARA GRAFICAR -->


<script>


  var config_importe<?php echo $valor->getId(); ?> = {

type: 'bar',
    data: {
      
      labels: ['NAFTA','GASOIL','GNC'],
      datasets: [{ 
        label: 'Importe',
        data: [<?php echo $dataImporte ?>],
        fill: false,
        borderColor: 'cornflowerblue',
        backgroundColor:['#2980B9','#5D6D7E','#138D75'], 
        borderWidth: 0,
        lineTension: 0,
        pointRadius: 1,
      }]
    },
    options: {
      responsive: true,
      legend: {display:false},
      title: {
        display: false,
      },
      scales: {
        
        xAxes:[{
          gridLines: {
            display: false,
          },
          ticks:{
            stepSize:1,
            autoSkip: false

          },
        }],
        yAxes:[{
          ticks: {
            min: 0,
            gridLines: {
              display: false,
            },
          }
        }]
      },
      tooltips: {
        xPadding:20,
        yPadding:20,
      },
    }
  };


</script> 
<?php
  }
}
?>


