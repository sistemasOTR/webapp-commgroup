<?php
	include_once "../../../Config/config.ini.php";


  $plaa = (isset($_POST["id"])?$_POST["id"]:0);
  $empleados = (isset($_POST["empleados"])?$_POST["empleados"]:0);
  $empresas = (isset($_POST["empresas"])?$_POST["empresas"]:0);
  $fdesde = (isset($_POST["start"])?$_POST["start"]:'');
  $fhasta = (isset($_POST["end"])?$_POST["end"]:'');
  $fdesdeR = (isset($_POST["startR"])?$_POST["startR"]:'');
  $fhastaR = (isset($_POST["endR"])?$_POST["endR"]:'');
  $tipo = (isset($_POST["slt_tipo"])?$_POST["slt_tipo"]:'');
  $fvista = (isset($_POST["slt_vista"])?$_POST["slt_vista"]:'');

$url="location:../../../../index.php?view=metricas_tt&fdesde=".$fdesde."&fhasta=".$fhasta."&fdesdeR=".$fdesdeR."&fhastaR=".$fhastaR."&tipo=".intval($tipo)."&fvista=".$fvista."&plaa=".serialize($plaa)."&empresas=".serialize($empresas)."&empleados=".serialize($empleados);

// var_dump($url);
// exit;

header($url);
 


?>