<?php
	@error_reporting(0);
	@ini_set('display_errors', 'Off');
	@set_time_limit(30);
	@header('Content-Type: text/html; charset=UTF-8');
	@ob_start();
	
	include('config.php');
	include('database.class.php');
	include('functions.class.php');
	
	$DB = new Database();
	$FNC = new Functions();
?>