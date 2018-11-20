<?php
	include_once "../../../Config/config.ini.php";


  $empleados = (isset($_POST["empleados"])?$_POST["empleados"]:0);
  $fdesde = (isset($_POST["fechad"])?$_POST["fechad"]:'');
  $fhasta = (isset($_POST["fechah"])?$_POST["fechah"]:'');
  $estados = (isset($_POST["s_estados"])?$_POST["s_estados"]:'');

  // var_dump($estados);
  // exit();


header("location:../../../../index.php?view=asistencias_comparativas&modo=gerencia&fdesde=".$fdesde."&fhasta=".$fhasta."&estados=".intval($estados)."&empleados=".serialize($empleados));
 


?>