<?php
require_once('../inc/session.php');
require_once('jpgraph/jpgraph.php');
require_once('jpgraph/jpgraph_line.php');
require_once('../inc/config.php');

$datay1 = array();

$today = date('Y-m-d');

function retdate($a){
	$query = mysql_query("SELECT * FROM bots WHERE install LIKE '%$a%'");
	return mysql_num_rows($query);
}

$today_count = retdate($today);

strtotime($today);
if(date('l',strtotime($today)) == 'Monday'){
	array_push($datay1,retdate($today));
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
}else if(date('l',strtotime($today)) == 'Tuesday'){
	array_push($datay1,retdate(date('Y-m-d',strtotime('-1 day'))));
	array_push($datay1,$today_count);
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
}else if(date('l',strtotime($today)) == 'Wednesday'){
	array_push($datay1,retdate(date('Y-m-d',strtotime('-2 day'))));
	array_push($datay1,retdate(date('Y-m-d',strtotime('-1 day'))));
	array_push($datay1,$today_count);
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
}else if(date('l',strtotime($today)) == 'Thursday'){
	array_push($datay1,retdate(date('Y-m-d',strtotime('-3 day'))));
	array_push($datay1,retdate(date('Y-m-d',strtotime('-2 day'))));
	array_push($datay1,retdate(date('Y-m-d',strtotime('-1 day'))));
	array_push($datay1,$today_count);
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
}else if(date('l',strtotime($today)) == 'Friday'){
	array_push($datay1,retdate(date('Y-m-d',strtotime('-4 day'))));
	array_push($datay1,retdate(date('Y-m-d',strtotime('-3 day'))));
	array_push($datay1,retdate(date('Y-m-d',strtotime('-2 day'))));
	array_push($datay1,retdate(date('Y-m-d',strtotime('-1 day'))));
	array_push($datay1,$today_count);
	array_push($datay1,'0');
	array_push($datay1,'0');
}else if(date('l',strtotime($today)) == 'Saturday'){
	array_push($datay1,retdate(date('Y-m-d',strtotime('-5 day'))));
	array_push($datay1,retdate(date('Y-m-d',strtotime('-4 day'))));
	array_push($datay1,retdate(date('Y-m-d',strtotime('-3 day'))));
	array_push($datay1,retdate(date('Y-m-d',strtotime('-2 day'))));
	array_push($datay1,retdate(date('Y-m-d',strtotime('-1 day'))));
	array_push($datay1,$today_count);
	array_push($datay1,'0');
}else if(date('l',strtotime($today)) == 'Sunday'){
	array_push($datay1,retdate(date('Y-m-d',strtotime('-6 day'))));
	array_push($datay1,retdate(date('Y-m-d',strtotime('-5 day'))));
	array_push($datay1,retdate(date('Y-m-d',strtotime('-4 day'))));
	array_push($datay1,retdate(date('Y-m-d',strtotime('-3 day'))));
	array_push($datay1,retdate(date('Y-m-d',strtotime('-2 day'))));
	array_push($datay1,retdate(date('Y-m-d',strtotime('-1 day'))));
	array_push($datay1,$today_count);
}

//$datay1 = array(20,15,23,15,55,35,45);
$query1 = mysql_query("SELECT FROM bots WHERE install LIKE '%%'");

// Setup the graph
$graph = new Graph(370,230);
$graph->SetScale("textlin");

$theme_class = new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('Wochen Statistik');
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels(array('Mo','Di','Mi','Do','Fr','Sa','So'));
$graph->xgrid->SetColor('#E3E3E3');

// Create the first line
$p1 = new LinePlot($datay1);
$graph->Add($p1);
$p1->SetColor("#6495ED");
$p1->SetLegend('Bots');

$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();

?>

