<?php
    include_once "../../../../Config/config.ini.php";

  include_once PATH_DATOS.'BaseDatos/conexionapp.class.php';
  include_once PATH_DATOS.'BaseDatos/sql.class.php';
  include_once PATH_DATOS.'Entidades/usuarioperfil.class.php';
  include_once PATH_NEGOCIO.'Funciones/Fechas/fechas.class.php'; 


  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";
  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerlegajos.class.php";
  include_once PATH_NEGOCIO."Modulos/handlerimpresoras.class.php";
  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php";

  $handler = new HandlerSistema;
  $handlerimpresoras = new HandlerImpresoras;
  $handlerUs = new HandlerUsuarios;
  $handlerLeg = new HandlerLegajos;

  $fserialNro=(isset($_GET["fserialNro"])?$_GET["fserialNro"]:'');
  $fgestor=(isset($_GET["fgestor"])?$_GET["fgestor"]:'');
  $fasigId=(isset($_GET["fasigId"])?$_GET["fasigId"]:'');
  $gestor= $handlerUs->selectById($fgestor);
  $impresora = $handlerimpresoras->getDatosConSerial($fserialNro);
  $legajo_gestor = $handlerLeg->seleccionarLegajos($fgestor);
  $asignacion = $handlerimpresoras->selectById($fasigId);
  $fmes = $asignacion['_fechaAsig']->format('m');
  $fdia = $asignacion['_fechaAsig']->format('d');
  $fyear = $asignacion['_fechaAsig']->format('Y');
  $ffechaAsig = $asignacion['_fechaAsig']->format('d-m-Y');

  switch ($fmes) {
    case '01':
      $mes = 'Enero';
      break;
    case '02':
      $mes = 'Febrero';
      break;
    case '03':
      $mes = 'Marzo';
      break;
    case '04':
      $mes = 'Abril';
      break;
    case '05':
      $mes = 'Mayo';
      break;
    case '06':
      $mes = 'Junio';
      break;
    case '07':
      $mes = 'Julio';
      break;
    case '08':
      $mes = 'Agosto';
      break;
    case '09':
      $mes = 'Septiembre';
      break;
    case '10':
      $mes = 'Octubre';
      break;
    case '11':
      $mes = 'Noviembre';
      break;
    case '12':
      $mes = 'Diciembre';
      break;
    
    default:
      # code...
      break;
  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Imprimir Comodato</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <!-- Font Awesome -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />       
  <!-- Ionicons -->
  <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
  <!-- Theme style -->
  <link href=<?php echo PATH_VISTA.'assets/dist/css/AdminLTE.min.css'; ?> rel="stylesheet" type="text/css" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
    p {line-height: 25px; text-align: justify;}
  </style>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
    <section class="invoice" style="margin: 0 100px;">

    <div class="row">
      <div class="col-md-12">

        <h3 class="text-center">CONTRATO DE COMODATO</h3>
        <br>
        <p>Entre COMMERCIAL GROUP S.R.L., representada en este acto por su socio gerente, Sr. FRANCO DAVID ANFOSSI, DNI 32.903.094 según surge del contrato social inscripto al T 163, Fº 15.790, Nº 997, Sec. Contratos, Reg. Comercio de Rosario, con domicilio en calle San Luis 912, de Rosario, Provincia de Santa Fe, CUIT 30-71239507-5, en adelante llamada en adelante EL COMODANTE, y el Sr/a <?php echo $legajo_gestor->getNombre(); ?> titular del CUIL <?php echo $legajo_gestor->getCuit() ?> domiciliado en <?php echo $legajo_gestor->getDireccion() ?>, en adelante, el COMODATARIO, se conviene la firma del contrato que se regirá por las siguientes cláusulas:</p>
        <p>El COMODANTE cede en comodato gratuito al COMODATARIO el siguiente bien mueble: Multifunción <?php echo $impresora['_marca']; ?> <?php echo $impresora['_modelo']; ?> con Nº de serie <?php echo $fserialNro; ?> en perfecto estado de funcionamiento. Este comodato se inicia el día <?php echo $ffechaAsig; ?> y durará hasta el momento que se extinga la relación laboral.</p>
        <p>2. Serán obligaciones del COMODATARIO:</p>
        <p>2.1. Utilizar el bien recibido en comodato, exclusivamente, para el cumplimiento de las tareas asignadas.</p>
        <p>2.2. Mantener, a su cargo, en perfecto estado de conservación, uso y funcionamiento, el bien referido y sus accesorios.-</p>
        <p>2.3. Responder ante EL COMODANTE por el valor del bien en cuestión en caso de extravío, hurto y/o robo. Esta responsabilidad se extenderá al caso destrucción
        un caso fortuito o de fuerza mayor.</p>
        <p>2.4. En caso de desperfecto, proceder a ingresarlo para su reparación, en agente oficial, en el término de tres días hábiles de advertido el desperfecto o vicio de
        funcionamiento.</p>
        <p>2.5. Restituir, al vencimiento del presente, el bien de mención, en el mismo
        perfecto estado de uso y funcionamiento en que es recibido.-</p>
        <p>3. Serán obligaciones del COMODANTE:</p>
        <p>3.1. Entregar el bien referido conjuntamente con la firma del presente.</p>
        <p>3.2. Recibir el mismo al ser restituido por el COMODATARIO al vencimiento
        del plazo pactado y/o en caso de que por razones ajenas al COMODATARIO el
        bien objeto del presente haya dejado de funcionar o se haya tornado no apto para
        satisfacer la finalidad buscada a través del presente contrato.</p>
        <p>4. En caso de incumplimiento del COMODATARIO de las obligaciones
        emergentes del presente contrato, el COMODANTE podrá, a su elección: a)
        resolver el contrato, en cuyo caso el COMODATARIO deberá restituir el bien
        objeto del comodato en el término de 48 Hs. de comunicada la decisión por
        medio fehaciente, quedando facultado el COMODANTE a reclamar la reparación
        de los daños y perjuicios causados por dicho incumplimiento; b) exigir el
        cumplimiento del contrato, pudiendo reclamar la indemnización correspondiente
        por los daños y perjuicios que el incumplimiento contractual pudiera causarle.</p>
        <p>5. El COMODATARIO no podrá transferir, ceder y/o subarrendar el bien
        recibido en comodato, ni dar su uso en préstamo.</p>
        <p>6. Las partes acuerdan someter cualquier cuestión derivada del presente contrato
        a los Tribunales Ordinarios de la ciudad de Rosario, renunciando a cualquier otro
        fuero o jurisdicción que pudiere corresponder. Incluso al fuero federal.-
        Se firman dos ejemplares del mismo tenor en la ciudad de Rosario, a los <?php echo $fdia; ?> días
        del mes de <?php echo $mes; ?> de <?php echo $fyear ?>.-</p>
        <p style="line-height: 100px;">Firma:</p>
        <p>Aclaración:</p>
        <p>D.N.I.:</p>

      </div>

    </div>
  </section>


</div>
</body>
</html>
