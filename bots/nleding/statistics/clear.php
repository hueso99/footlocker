<?php


include( '../config.php' );
include( '../include/sql.php' );
include( '../include/visitors.php' );
CSQL;
$sql = new ( $sqlSettings );
$sql->open(  );
CVisitors;
$cvisitors = new ( $sql, $sqlSettings );
$cvisitors->clearVisitors(  );
header( 'Location: statistics.php' );
exit(  );
?>
