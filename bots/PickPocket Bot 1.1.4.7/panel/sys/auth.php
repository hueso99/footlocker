<?php
include ('../config.php');
if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] !== $username || ($_SERVER['PHP_AUTH_PW']) !== $password)
{
	header('WWW-Authenticate: Basic realm = "Hello!"');
	header('HTTP/1.0 401 Unauthorized');
	die();
}

?>