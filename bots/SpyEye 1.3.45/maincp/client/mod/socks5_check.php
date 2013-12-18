<?
	include_once "../common.php";
	if( !$user->Check() ) exit;
		
	if (function_exists('curl_init') === false) die("<font class='error'>Unknown.</font><br>Plz, install CURL for PHP");

	$socks = $_GET['s'];
	$url = 'http://www.google.com';
	$oktext1 = '302 Moved';
	$oktext2 = 'Google';
	$headers[] = 'Connection: Close';
	$ua = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
	$compression = 'gzip';
	$timeout = 20;
	$cnt = 1;
	// ~~~
	$process = curl_init($url);
	curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($process, CURLOPT_HEADER, 0);
	curl_setopt($process, CURLOPT_USERAGENT, $ua);
	curl_setopt($process, CURLOPT_ENCODING , $compression);
	curl_setopt($process, CURLOPT_TIMEOUT, $timeout);
	curl_setopt($process, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	curl_setopt($process, CURLOPT_HTTPPROXYTUNNEL, 1);
	curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($process, CURLOPT_PROXY, $socks);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
	$start = microtime(1);
	for ($i < 0; $i < $cnt; $i++) $return = curl_exec($process);
	$finish = microtime(1);
	curl_close($process);

	if ( strpos($return, $oktext1) != false || strpos($return, $oktext2) != false )
	{
		$time = ($finish - $start) / $cnt;
		$time = round($time, 2);
		echo "<font class='ok'>$time sec.</font>";
	}
	else echo "<font class='error'>Dead ? <!-- {" . $return . "} --></font>";	
	
?>