<?php


include( '../config.php' );
include( '../include/sql.php' );
include( '../include/visitors.php' );
session_start(  );

if ($_SESSION['login'] == false) {
	header( 'Location: login.php' );
	exit(  );
}

CSQL;
$sql = new ( $sqlSettings );
$sql->open(  );
CVisitors;
$cvisitors = new ( $sql, $sqlSettings );
$countVisitors = $cvisitors->getUniqueVisitorsCount(  );
$countExploitedVisitors = $cvisitors->getVisitorsExploitedCount(  );
$countNotExploitedVisitors = $countVisitors - $countExploitedVisitors;

if (( $countVisitors == 0 || $countExploitedVisitors == 0 )) {
	$exploitedPercentage = 0;
}
else {
	$exploitedPercentage = round( $countExploitedVisitors * 100 / $countVisitors, 2 );
}

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<title>Statistics</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css" />
	';

if ($ajax_stats) {
	echo '	';
	echo '<s';
	echo 'cript>
	function Update()
	{
		if (window.XMLHttpRequest)
		{
			xmlhttp=new XMLHttpRequest();
		}else{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				eval(xmlhttp.responseText);
				setTimeout("Update()", ';
	echo $ajax_delay;
	echo ');
			}
		}
		xmlhttp.open("GET","update.php",true);
		xmlhttp.send();
	}
	</script>
	';
}

echo '	</head>

';

if ($ajax_stats) {
	echo '<body onload=\'Update();\'>';
}
else {
	echo '<body>';
}

echo '
	<div id="wrapper" class="clearfix">
		<div id="main-header">
			<div id="main-header-banner"></div>
		</div>

		<!-- NAVIGATION STARTS -->
		<div class="navigation">
			<ul class="nav-links">

				<li class="spacer">
				</li>
				<li class="spacer">
				</li>
				<li class="clear">
					<a href="clear.php" title="Clear">Clear</a>
				</li>

				<li class="middlebar">
	';
echo '			</li>

				<li class="logout">
					<a href="logout.php" title="Logout">Logout</a>
				</li>
				<li class="spacer2">
				</li>
				<li class="spacer1">
				</li>
				<li class="spacer">
				</li>

			</ul>
		</div>
		<!-- NAVIGATION ENDS -->

		<!-- CONTENT STARTS -->
		<div id="main-body">

			<div id="main-body-top">
				<div class="top-box">
					<div class="top-box-title';
echo '"><h4><b>Overall Statistics</b></h4></div>
					<table>
						<tr>
							<td><b>Unique</b></td>
							<td><b>Exploited</b></td>
							<td><b>%</b></td>
						</tr>
						<tr>
							<td><div id=\'visitors\'>';
echo $countVisitors;
echo '</div></td>
							<td><div id=\'exploited\'>';
echo $countExploitedVisitors;
echo '</div></td>
							<td><div id=\'percentage\'>';
echo $exploitedPercentage;
echo '</div></td>
						</tr>
					</table>
				</div>
			</div>
			<div id="main-body-referrer">
				<div class="referrer-box">
					<div class="referrer-box-title"><h4><b>Statistics: Referrers</b></h4></div>
					';
$cvisitors->showVisitorsReferrerTop(  );
echo '				</div>
			</div>
			<div id="main-body-left">
				<div class="content-box" style="margin-top: 5px;">
					<div class="content-box-title"><h4><b>Statistics: Exploits</b></h4></div>

					';
$cvisitors->showExploitsTable(  );
echo '
				</div>
				<div class="content-box" style="margin-top: 5px;">
					<div class="content-box-title"><h4><b>Statistics: Country</b></h4></div>
					';
$cvisitors->showVisitorsCountryTop(  );
echo '				</div>
			</div>
			<div id="main-body-right">
				<div class="content-box" style="margin-top: 5px;">
					<div class="content-box-title"><h4><b>Statistics: Operating System</b></h4></div>
					';
$cvisitors->showOSInformation(  );
echo '				</div>
				<div class="content-box" style="margin-top: 5px;">
					<div class="content-box-title"><h4><b>Statistics: Browser</b></h4></div>
					';
$cvisitors->showBrowserInformation(  );
echo '				</div>
			</div>
		</div>
	</div>
</body>
</html>
';
?>
