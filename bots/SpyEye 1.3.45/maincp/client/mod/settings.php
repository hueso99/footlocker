<?
	include_once "../common.php";
	if( !$user->Check() ) exit;
	
	$stat = 0;
	if ((@$_POST) && $_POST['isIni']) 
	{
		$ini = array();
		foreach ($_POST as $key => $value) 
		{
			$pos = strpos($key, '|');
			$key1 = substr($key, 0, $pos);
			$key2 = substr($key, $pos + 1);
			if (strlen($key1)) $ini[$key2] = $value;
			
		}
		if( (int)$ini['del_period_days'] <= 0 ) $ini['del_period_days'] = 1000;
		if( count($ini) ) $stat = $db->UpdateConfigs($ini);
	}

	$ini = $db->GetConfigs();
	$smarty->assign('CONT_ARR', $ini);
	
	if ($stat) $msg = "<span><font class='ok'>OK</font></span> changes are saved [ $stat ]</small></font>";
	//else $msg = "<span><font class='error'>No data changes</font></span></small></font>";

	$smarty->assign('MSG', $msg);
	$smarty->display('settings.tpl');
?>