<?php


function str_to_hex($string) {
	$hex = '';
	$i = 0;

	while ($i < strlen( $string )) {
		$hex .= str_pad( dechex( ord( $string[$i] ) ), 2, '0', STR_PAD_LEFT );
		++$i;
	}

	return $hex;
}

function pdf_ASCIIHexEncode($string) {
	return str_to_hex( $string ) . '>';
}

function pdf_FlateEncode($string) {
	return gzcompress( $string );
}

function pdf_ASCII85Encode($string) {
	ASCII85;
	$ascii85 = new (  );
	return $ascii85->encode( $string );
}

function RandomNonASCIIString($count) {
	$result = '';
	$i = 0;

	while ($i < $count) {
		$result = $result . chr( rand( 128, 255 ) );
		++$i;
	}

	return $result;
}

function ioDef($id) {
	return $id . ' 0 obj
';
}

function ioRef($id) {
	return $id . ' 0 R';
}

include( 'ascii85.php' );
?>
