<?php 
    session_start();
    
	require_once('inc/session.php');
	require_once('inc/config.php');
	require_once('inc/html_grund.php');
	include('inc/functions.php');
	include("ip_files/countries.php");
	
	require ('GChartPhp/gChart.php');
	
	$query_1 = mysql_query("SELECT COUNT(*) FROM clients ");
	$item_count = mysql_result($query_1, 0);
	$query_1 = mysql_query("SELECT * FROM clients ORDER BY id ");
	
	//error handler function
function customError($errno, $errstr)
  {
  
  }
  
  //set error handler
set_error_handler("customError");
	
$online = mysql_query("SELECT * FROM clients WHERE status LIKE 'Online'");
$offline = mysql_query("SELECT * FROM clients WHERE status LIKE 'Offline'");
$dead = mysql_query("SELECT * FROM clients WHERE status LIKE 'Dead'");
$admintrue = mysql_query("SELECT * FROM clients WHERE admin LIKE 'True'");
$adminfalse = mysql_query("SELECT * FROM clients WHERE admin LIKE 'False'");
$windows7 = mysql_query("SELECT * FROM clients WHERE os LIKE '%7%'");
$windowsvista = mysql_query("SELECT * FROM clients WHERE os LIKE '%vista%'");
$windowsxp = mysql_query("SELECT * FROM clients WHERE os LIKE '%xp%'");
$unknown = mysql_query("SELECT * FROM clients WHERE os LIKE 'Unknown'");
$ccs = mysql_query("SELECT DISTINCT cc FROM clients");
$totalbots = mysql_num_rows(mysql_query("SELECT * FROM clients"));

$onlinecount = 0;
$offlinecount = 0;
$deadcount = 0;

$admintruecount = 0;
$adminfalsecount = 0;

$windows7count = 0;
$windowsvistacount = 0;
$windowsxpcount = 0;
$unknowncount = 0;

while($row = mysql_fetch_array($online))
				{
				$onlinecount++;
			 	}
			 	
while($row = mysql_fetch_array($offline))
				{
				$offlinecount++;
			 	}
			 	
while($row = mysql_fetch_array($dead))
				{
				$deadcount++;
			 	}
			 	
while($row = mysql_fetch_array($admintrue))
				{
				$admintruecount++;
			 	}
			 	
while($row = mysql_fetch_array($adminfalse))
				{
				$adminfalsecount++;
			 	}
			 	
while($row = mysql_fetch_array($windows7))
				{
				$windows7count++;
			 	}
			 	
while($row = mysql_fetch_array($windowsvista))
				{
				$windowsvistacount++;
			 	}
			 	
while($row = mysql_fetch_array($windowsxp))
				{
				$windowsxpcount++;
			 	}
			 	
while($row = mysql_fetch_array($unknown))
				{
				$unknowncount++;
			 	}

$statustotal = $onlinecount + $offlinecount + $deadcount;
$admintotal = $admintruecount + $adminfalsecount;
$ostotal = $windows7count + $windowsvistacount + $windowsxpcount + $unknowncount;

$piChart1 = new gPieChart(250, 125);
$piChart1->addDataSet(array($onlinecount,$offlinecount,$deadcount));
$piChart1->setLegend(array("Online","Offline","Dead"));
$piChart1->setLabels(array( round($onlinecount / $statustotal * 100, 0) ."%", round($offlinecount/ $statustotal * 100, 0) ."%", round($deadcount/ $statustotal * 100, 0) ."%"));
$piChart1->setColors(array("5D8AA8", "B4CDCD", "E32636"));
$piChart1->addBackgroundFill('bg', '000000');

$piChart2 = new gPieChart(250, 125);
$piChart2->addDataSet(array($admintruecount,$adminfalsecount));
$piChart2->setLegend(array("Admin","User"));
$piChart2->setLabels(array( round($admintruecount/ $statustotal * 100, 0) ."%", round($adminfalsecount/ $statustotal * 100, 0) ."%"));
$piChart2->setColors(array("5D8AA8", "B4CDCD"));
$piChart2->addBackgroundFill('bg', '000000');

$piChart3 = new gPieChart(250, 125);
$piChart3->addDataSet(array($windows7count,$windowsvistacount,$windowsxpcount,$unknowncount));
$piChart3->setLegend(array("7","Vista","XP","Unknown"));
$piChart3->setLabels(array( round($windows7count/ $statustotal * 100, 0) ."%", round($windowsvistacount/ $statustotal * 100, 0) ."%", round($windowsxpcount/ $statustotal * 100, 0) ."%", round($unknowncount/ $statustotal * 100, 0) ."%"));
$piChart3->setColors(array("5D8AA8", "B4CDCD", "E32636", "EFDECD"));
$piChart3->addBackgroundFill('bg', '000000');

$cclist = array();
$ccvalues = array();

while($row = mysql_fetch_array($ccs))
			 {
			 array_push($cclist, $row[0]);
			 $values = mysql_query("SELECT * FROM clients WHERE cc LIKE '$row[0]'");
			 array_push($ccvalues, mysql_num_rows($values)/$totalbots * 100);
			 }

$map1 = new gMapChart();
$map1 -> setZoomArea('world');
$map1 -> setStateCodes($cclist);
$map1 -> addDataSet($ccvalues);
$map1 -> setColors('000000', array('0099FF','002288'));
$map1->addBackgroundFill('bg', '000000');

	echo '<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		
	<script type="text/javascript">
    	$(document).ready(function(){
      		refreshBotsOnline();
    	});
    	
    	function refreshBotsOnline(){
        	$(\'#navi\').load(\'inc/html_menu.php\');
        	setTimeout(refreshBotsOnline, 5000);
    	}
	</script>';
	echo "
<center>
<table width='100%' border='0'>
  <tr>
    <td colspan='2' ><div id = 'bbord'><img src="; print $map1->getUrl(); echo " /></div></td>
    <td><table width='100%' frame='below'>
      <tr>
        <td>Bots Online:".mysql_num_rows($online)."</td>
      </tr>
      <tr>
        <td>Bots Offline:".mysql_num_rows($offline)."</td>
      </tr>
      <tr>
        <td>Bots Dead:".mysql_num_rows($dead)."</td>
      </tr>
    </table>
      <table width='100%'>
        <tr>
          <td>Total Bots:".$totalbots."</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><center><div id = 'bbord'><img src="; print $piChart1->getUrl(); echo " /></div></center></td>
    <td><center><div id = 'bbord'><img src="; print $piChart3->getUrl(); echo " /></div></center></td>
    <td><center><div id = 'bbord'><img src="; print $piChart2->getUrl(); echo " /></div></center></td>
  </tr>
</table>
</center>";
	require_once('inc/html_footer.php');

?>