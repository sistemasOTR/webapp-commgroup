<?php 
    include_once PATH_NEGOCIO."Modulos/handlertickets.class.php";       
    include_once PATH_NEGOCIO."Funciones/Fechas/fechas.class.php"; 
//  include_once PATH_NEGOCIO."Funciones/Array/funcionesarray.class.php"; 
//  include_once PATH_NEGOCIO."Usuarios/handlerusuarios.class.php";
//  include_once PATH_NEGOCIO."Sistema/handlersistema.class.php";

    $handlerTickets= new HandlerTickets();
    $reintegra= $handlerTickets->selecionarReintegros();

?>

<div class="content-wrapper">  
  <section class="content-header">
    <h1>
      Ticket
      <small>Operacion de Reintegro </small>
    </h1>
  </section>   




