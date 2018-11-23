<?php
	include_once "../../../Config/config.ini.php";


  $plaa = (isset($_POST["id"])?$_POST["id"]:0);
  $empresas = (isset($_POST["empresas"])?$_POST["empresas"]:0);
  $fdesde = (isset($_POST["fechad"])?$_POST["fechad"]:'');
  $fhasta = (isset($_POST["fechah"])?$_POST["fechah"]:'');
  $fdesdeR = (isset($_POST["fechadR"])?$_POST["fechadR"]:'');
  $fhastaR = (isset($_POST["fechahR"])?$_POST["fechahR"]:'');
  $tipo = (isset($_POST["tipo"])?$_POST["tipo"]:'');
  $fvista = (isset($_POST["fvista"])?$_POST["fvista"]:'');


header("location:../../../../index.php?view=metricas_tt&fdesde=".$fdesde."&fhasta=".$fhasta."&fdesdeR=".$fdesdeR."&fhastaR=".$fhastaR."&tipo=".intval($tipo)."&fvista=".$fvista."&plaa=".serialize($plaa)."&empresas=".serialize($empresas));
 


?>