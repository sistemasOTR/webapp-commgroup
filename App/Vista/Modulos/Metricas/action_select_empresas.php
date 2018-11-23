<?php
	include_once "../../../Config/config.ini.php";


  $empresas = (isset($_POST["empresas"])?$_POST["empresas"]:0);
  $fdesde = (isset($_POST["fechad"])?$_POST["fechad"]:'');
  $fhasta = (isset($_POST["fechah"])?$_POST["fechah"]:'');
  $tipo = (isset($_POST["tipo"])?$_POST["tipo"]:'');
  $fvista = (isset($_POST["fvista"])?$_POST["fvista"]:'');


header("location:../../../../index.php?view=metricas_tt&fdesde=".$fdesde."&fhasta=".$fhasta."&tipo=".intval($tipo)."&fvista=".$fvista."&empresas=".serialize($empresas));
 


?>