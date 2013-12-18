<?php
    //Connection
    require_once('inc/config.php');
    require_once('other/safe.php');
     
	$grabberpage = mysql_query("SELECT page FROM pages");
	while($row = mysql_fetch_object($grabberpage))
	{
	  echo $row->page;
	}
?>
