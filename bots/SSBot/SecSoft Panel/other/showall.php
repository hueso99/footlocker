<style type="text/css">
	body{
		font-size: 11px;
		font-family: Tahoma;
	}
	
	label{
		display: inline-block;
		width: 14em;
	}
</style>

<?php
require_once('../inc/config.php');
	require_once('../other/safe.php');
	require_once('../other/code2country.php');
	
	$id = safe_xss($_GET['id']);
	
	$query1 = mysql_query("SELECT * FROM tasks WHERE id = '".safe_sql($id)."'");
	while($row = mysql_fetch_array($query1))
	{
		 $split = explode(',', safe_xss($row['countries']));
		  
	
		for($i = 0; $i <= count($split)-2; $i++){
			echo '<img src="../img/flags/'.$split[$i].'.gif" />&nbsp;'.$options[strtoupper($split[$i])].'<br />';
		}

	}
?>