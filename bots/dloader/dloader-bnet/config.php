<?php

$config["user"] = "admin";
$config["pass"] = "pass";
$config["dbhost"] = "localhost";
$config["dbuser"] = "root";
$config["dbpass"] = "";
$config["dbname"] = "task";

$config["language"] = "ru";
$config["ttl"] = 60; // in minutes

define("DEBUG", "0");
define("WEB_ROOT", "http://" . $_SERVER['HTTP_HOST'] . ($_SERVER['SERVER_PORT'] == 80 ? "" : ":" . $_SERVER['SERVER_PORT']) . rtrim(str_replace('\\', '/', dirname($_SERVER['PHP_SELF'])), '/'));
define("SECRET_KEY", "********************************");

define("CACHE_DIRECTORY", "cache/");
define("GRABBERS_PATH", "modules/grabbers/grabbers.dat");
define("SNIFFERS_PATH", "modules/sniffers/sniffers.dat");

?>