<?php
	include_once "../../../Config/config.ini.php";


  $plaa = (isset($_POST["id"])?$_POST["id"]:0);
  $fdesde = (isset($_POST["fechad"])?$_POST["fechad"]:'');
  $fhasta = (isset($_POST["fechah"])?$_POST["fechah"]:'');
  $estados = (isset($_POST["s_estados"])?$_POST["s_estados"]:'');


header("location:../../../../index.php?view=asistencias_gerencia_comparativas&fdesde=".$fdesde."&fhasta=".$fhasta."&estados=".intval($estados)."&plaa=".serialize($plaa));
 


?>
