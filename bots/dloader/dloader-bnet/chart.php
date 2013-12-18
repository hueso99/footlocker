<?php

include("./includes/pdata.php");
include("./includes/pchart.php");

if (!isset($_GET['cc']) || !isset($_GET['cn'])) exit();
$cc=explode(",", $_GET['cc']);
$cn=explode(",", $_GET['cn']);

$data = new pData;
$data -> AddPoint($cn, "Serie1");
$data -> AddPoint($cc, "Serie2");
$data -> AddAllSeries();
$data -> SetAbsciseLabelSerie("Serie2");
$chart = new pChart(350, 180);
$chart -> createColorGradientPalette(235, 72, 225, 6, 199, 244, 5);
$chart -> setFontProperties("includes/tahoma.dat", 8);
$chart -> AntialiasQuality = 0;
$chart -> drawPieGraph($data -> GetData(), $data -> GetDataDescription(), 150, 90, 90, PIE_PERCENTAGE_LABEL, FALSE, 35, 15, 5);
$chart -> drawPieLegend(300, 20, $data -> GetData(), $data -> GetDataDescription(), 255, 255, 255);
$chart -> Stroke();

?>