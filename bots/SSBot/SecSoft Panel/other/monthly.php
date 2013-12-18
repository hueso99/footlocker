<?php 
require_once('../inc/session.php');
require_once('jpgraph/jpgraph.php');
require_once('jpgraph/jpgraph_line.php');
require_once('../inc/config.php');

$datay1 = array();

$today = date('Y-m');

function retdate($a){
	$query = mysql_query("SELECT * FROM bots WHERE install LIKE '%$a%'");
	return mysql_num_rows($query);
}

$today_count = retdate($today);

strtotime($today);
if(date('m',strtotime($today)) == '01'){
	array_push($datay1,retdate($today));
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
}else if(date('m',strtotime($today)) == '02'){
	array_push($datay1,retdate(date('Y-m',strtotime('-1 month'))));
	array_push($datay1,retdate($today));
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
}else if(date('m',strtotime($today)) == '03'){
	array_push($datay1,retdate(date('Y-m',strtotime('-2 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-1 month'))));
	array_push($datay1,retdate($today));
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
}else if(date('m',strtotime($today)) == '04'){
	array_push($datay1,retdate(date('Y-m',strtotime('-3 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-2 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-1 month'))));
	array_push($datay1,retdate($today));
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
}else if(date('m',strtotime($today)) == '05'){
	array_push($datay1,retdate(date('Y-m',strtotime('-4 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-3 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-2 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-1 month'))));
	array_push($datay1,retdate($today));
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
}else if(date('m',strtotime($today)) == '06'){
	array_push($datay1,retdate(date('Y-m',strtotime('-5 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-4 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-3 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-2 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-1 month'))));
	array_push($datay1,retdate($today));
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
}else if(date('m',strtotime($today)) == '07'){
	array_push($datay1,retdate(date('Y-m',strtotime('-6 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-5 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-4 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-3 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-2 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-1 month'))));
	array_push($datay1,retdate($today));
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
}else if(date('m',strtotime($today)) == '08'){
	array_push($datay1,retdate(date('Y-m',strtotime('-7 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-6 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-5 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-4 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-3 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-2 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-1 month'))));
	array_push($datay1,retdate($today));
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
}else if(date('m',strtotime($today)) == '09'){
	array_push($datay1,retdate(date('Y-m',strtotime('-8 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-7 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-6 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-5 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-4 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-3 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-2 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-1 month'))));
	array_push($datay1,retdate($today));
	array_push($datay1,'0');
	array_push($datay1,'0');
	array_push($datay1,'0');
}else if(date('m',strtotime($today)) == '10'){
	array_push($datay1,retdate(date('Y-m',strtotime('-9 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-8 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-7 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-6 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-5 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-4 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-3 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-2 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-1 month'))));
	array_push($datay1,retdate($today));
	array_push($datay1,'0');
	array_push($datay1,'0');
}else if(date('m',strtotime($today)) == '11'){
	array_push($datay1,retdate(date('Y-m',strtotime('-10 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-9 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-8 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-7 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-6 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-5 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-4 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-3 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-2 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-1 month'))));
	array_push($datay1,retdate($today));
	array_push($datay1,'0');
}else if(date('m',strtotime($today)) == '12'){
	array_push($datay1,retdate(date('Y-m',strtotime('-11 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-10 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-9 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-8 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-7 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-6 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-5 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-4 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-3 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-2 month'))));
	array_push($datay1,retdate(date('Y-m',strtotime('-1 month'))));
	array_push($datay1,retdate($today));
}									
	
	
//$datay1 = array(20,15,23,15,55,35,45);
//$query1 = mysql_query("SELECT FROM bots WHERE install LIKE '%%'");

// Setup the graph
$graph = new Graph(370,230);
$graph->SetScale("textlin");

$theme_class = new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('Monats Statistik');
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels(array('Jan','Feb','Maer','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Dez'));
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

