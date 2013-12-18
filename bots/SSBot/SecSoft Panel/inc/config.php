<?php 
$settings = array('server' => 'localhost',
				  'user'   => 'root',
				  'pass'   => '',
				  'db'	   => 'secsoftbot');

$seconds = 660;			
	  
mysql_connect($settings['server'],$settings['user'],$settings['pass']);mysql_select_db($settings['db']);;
?>