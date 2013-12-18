<?php


include( '../config.php' );
include( '../include/sql.php' );
include( '../include/visitors.php' );
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
document.getElementById("visitors").innerHTML = ';
echo $countVisitors;
echo ';
document.getElementById("exploited").innerHTML = ';
echo $countExploitedVisitors;
echo ';
document.getElementById("percentage").innerHTML = ';
echo $exploitedPercentage;
echo ';
';
?>
