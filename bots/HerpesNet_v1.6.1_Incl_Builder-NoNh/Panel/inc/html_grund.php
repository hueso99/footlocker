<?php
session_start();

require_once('inc/session.php');
require_once('inc/config.php');



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Herpes 2012</title>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<style type="text/css">
#sddm
{	z-index: 30}

#sddm li
{	list-style: none;}

#sddm li a
{	text-align: center;
	text-decoration: none}

#sddm div
{	position: absolute;
	visibility: hidden;
	margin: 0;
	padding: 0;
	background: #EAEBD8;
	border: 1px solid #5970B2}

	#sddm div a
	{	position: relative;
		display: block;
		margin: 0;
		padding: 5px 10px;
		width: auto;
		white-space: nowrap;
		text-align: left;
		text-decoration: none;
		background: #EAEBD8;
		color: #2875DE;}

	#sddm div a:hover
	{	background: #49A3FF;
		color: #FFF}
		
</style>
<div id="wrapper">
<div id="header"><a href="index.php"><img src="./img/herplogo.png" alt="" height="100%" style="border: 0px;" /></a></div>
<div id="navi">
	<ul id="sddm">
		<li style="float: right; margin-right: 10px;"><div id="botsOnlineHolder">Bots Online: </div> </li>
		<li><a href="stats.php"><img src="img/stats.png" alt="" style="border: 0px;" />&nbsp;Statistics</a></li>
		<li>|</li>
		<li><a href="clients.php"><img src="img/clients.png" alt="" style="border: 0px;" />&nbsp;Clients</a></li>
		<li>|</li>
		<li><a href="tasks.php"><img src="img/tasks.png" alt="" style="border: 0px;" />&nbsp;Task Manager</a></li>
        	<li>|</li>
        	<li><a href="about.php"><img src="img/about.png" alt="" style="border: 0px;" />&nbsp;About</a></li>
        	<li>|</li>
		<li><a href="logout.php"><img src="img/logout.png" alt="" style="border: 0px;" />&nbsp;Log Out</a></li>
	</ul>
</div>
<div id="content" class="clearfix">