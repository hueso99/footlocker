<?php
// Credits to Orgy from HF for his nice and clean functions
function nice_escape($unescapedString)
{
	if (get_magic_quotes_gpc())
	{
		$unescapedString = stripslashes($unescapedString);
	}
	$semiEscapedString = mysql_real_escape_string($unescapedString);
	$escapedString = addcslashes($semiEscapedString, "%_");
	return $escapedString;
} 

function nice_output($escapedString)
{
	$patterns = array();
	$patterns[0] = '/\\\%/';
	$patterns[1] = '/\\\_/';
	$replacements = array();
	$replacements[0] = '%';
	$replacements[1] = '_';
	$output = preg_replace($patterns, $replacements, $escapedString);
	return $output;
} 

function cleanstring($string)
{
	$done = nice_output(nice_escape($string));
	return $done;
}

function iptocountry($ip) {
	$numbers = preg_split( "/\./", $ip);
	include("ip_files/".$numbers[0].".php");
	$code=($numbers[0] * 16777216) + ($numbers[1] * 65536) + ($numbers[2] * 256) + ($numbers[3]);
	foreach($ranges as $key => $value){
		if($key<=$code){
			if($ranges[$key][0]>=$code){$two_letter_country_code=$ranges[$key][1];break;}
			}
	}
	if ($two_letter_country_code==""){$two_letter_country_code="unkown";}
	return $two_letter_country_code;
}
?>