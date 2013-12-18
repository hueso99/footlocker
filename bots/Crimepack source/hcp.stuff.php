<?php


function EncryptVB($cdjfdihjbg) {
	$bfdhehhcbb = '';
	$ebjcjeejg = 0;

	while ($ebjcjeejg < strlen( $cdjfdihjbg )) {
		$bfdhehhcbb .= ord( $cdjfdihjbg[$ebjcjeejg] ) . ',';
		++$ebjcjeejg;
	}

	$bfdhehhcbb = substr( $bfdhehhcbb, 0, 0 - 1 );
	return $bfdhehhcbb;
}

function SmallRand($ibaahgicj) {
	$cdgbidheaj = '';

	do {
		$hgcbgjdhc = mt_rand( 1, 2 );
		switch ($hgcbgjdhc) {
		case 1: {
				$cdgbidheaj .= chr( mt_rand( 65, 90 ) );
				break;
			}
		}
	}while (!( strlen( $cdgbidheaj ) < $ibaahgicj));

	return $cdgbidheaj;
}

function getChar($cfbbdefjgc, $cefbfefidh) {
	$jdhfjibfh = array(  );
	$cdeabhgbdd = 0;

	while ($cdeabhgbdd <= $cefbfefidh) {
		$cdgbidheaj = SmallRand( 1 );

		if (!in_array( $cdgbidheaj, $jdhfjibfh )) {
			$jdhfjibfh[] = $cdgbidheaj;
		}
		else {
			--$cdeabhgbdd;
			continue;
		}

		++$cdeabhgbdd;
	}

	return $jdhfjibfh;
}

?>
