<?php
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
    include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";  
    include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";
    include_once PATH_DATOS.'Entidades/usuario.class.php'; 
    include_once PATH_NEGOCIO."Usuarios/handlerplazausuarios.class.php"; 
    include_once PATH_NEGOCIO."Modulos/handlerasistencias.class.php";
    include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";

    $dFecha = new Fechas;    
    $handler = new HandlerSistema;
    $handlertickets = new HandlerTickets;
    $handlerUsuario = new Usuario; 
    $handlerUser = new HandlerUsuarios; 
    $user = $usuarioActivoSesion;
    $handlerPlaza = new HandlerPlazaUsuarios;
    $handlerAsistencia= new HandlerAsistencias;
    $arrPlaza = $handlerPlaza->selectTodas();
  



    $dataAsistencia=0;
    $presente=0;
    $ausente=0;
 
    // if (!empty($arruser)) {

    // foreach ($arruser as $value ) {

           $fechaDesde = date('Y-m-d',strtotime($fdesde));
           $fechaHasta = date('Y-m-d',strtotime($fhasta));
           $FECHA = $dFecha->FormatearFechas($fechaDesde,"Y-m-d","Y-m-d");
           $HASTA = $dFecha->FormatearFechas($fechaHasta,"Y-m-d","Y-m-d");
           while (strtotime($FECHA) <= strtotime($HASTA)) {
           $asistencias=$handlerAsistencia->selectAsistenciasByFiltro($FECHA,$FECHA,$id_gestor); 
            
            
         if(!empty($asistencias)) {

                 $presente+=1;
           }else{
            $diadelasemana= date('N',strtotime($FECHA));
            $fechadata=$FECHA." 00:00:00.000";
            $feriado=$handlertickets->selecionarFechasInhabilitadasByFecha($fechadata);   
             if (is_null($feriado) && ($diadelasemana!=7)){
               $ausente+=1;
              }
            }

              $FECHA = date('Y-m-d',strtotime('+1 day',strtotime($FECHA)));  
    
         }
      

  
  
  $labelsAsistencia="'Asistencias','Inasistencias'";

  $dataAsistencia=$presente.",".$ausente;
   

   
     if ($dataAsistencia!='0,0') {

      if (!empty($id_gestor)) {
        $Usuarios=$handlerUser->selectById($id_gestor);
        $nombreCompleto=$Usuarios->getNombre()." ".$Usuarios->getApellido();
      }else{
        $nombreCompleto=$user->getNombre()." ".$user->getApellido();
      }
  
?>

<div class="col-md-12 nopadding">
  <div class="box box-solid">    
    <div class="box-header">
      <h3 class="box-title" style="width: 100%;">
        <i class="ion-speedometer"> </i> Asistencia <span><b><?php echo $nombreCompleto ?></b></span>
        <small class="pull-right" style="font-size: 15px;"><span class='text-yellow '><b><?php echo $dFecha->FormatearFechas($fdesde,'Y-m-d','d/m/Y');echo "-".$dFecha->FormatearFechas($fhasta,'Y-m-d','d/m/Y'); ?></b></span></small>
      </h3>
    </div>
    <div class="box-body text-center">
   <canvas id="budget_asistencias_gestor" class="col-xs-12 chart"></canvas>
     </div>
  </div>
</div>

<!-- SCRIPTS PARA GRAFICAR -->


<script>


    var config_dias_asistencias_gestor = {

type: 'pie',
    data: {
      
      labels: [<?php echo $labelsAsistencia ?>],
      datasets: [{ 
        label: '% Asistencias',
        data: [<?php echo $dataAsistencia ?>],
        fill: false,
        borderColor: 'white',
        backgroundColor:['#D7DBDD','#87CEFA','#A2D9CE','#E59866'], 
      
      }]
    },
    options: {
      responsive: true,
      legend: {display:true,position:'right'},
      title: {
        display: false,
      },
    }
  };

</script>  
 
<?php
    }

?>

