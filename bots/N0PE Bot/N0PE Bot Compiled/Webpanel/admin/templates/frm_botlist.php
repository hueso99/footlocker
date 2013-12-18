<?php
	class template_Bots
	{
		private $Content = NULL;
		private $Title = 'Bot List';
		
		public function __construct()
		{
			global $FNC;
			global $DB;
			$rTime = time();
			
			if(!isset($_GET['all']))
			{
				$iCount = $DB->numRows($DB->Query("SELECT ID FROM bots " . (isset($_GET['online']) ? " WHERE Request > '" . ($rTime - BOT_TIME_ON) . "'" : "")));
				if(isset($_GET['page']) && (intval($_GET['page']) - 1) * SHOW_COUNT < $iCount && intval($_GET['page']) >= 1)
				{
					$rPage = intval($_GET['page']);
					$iLimit = ($rPage - 1) * SHOW_COUNT . ',' . SHOW_COUNT;
				} else {
					$rPage = 1;
					$iLimit = '0,' . SHOW_COUNT;
				}
			}
			
			$Table = '<div style="text-align:right;padding-right:10px">';
			
			if(!isset($_GET['online'])) { $Table .= '<a href="?q=bots&online' . (isset($_GET['all']) ? '&all' : '') . '" class="button"><span>Only Online Bots</span></a>'; }
			else { $Table .= '<a href="?q=bots' . (isset($_GET['all']) ? '&all' : '') . '" class="button"><span>All Bots</span></a>'; }
			if(!isset($_GET['all'])) { $Table .= '<a href="?q=bots' . (isset($_GET['online']) ? '&online' : '') . '&all" class="button"><span>No Pages</span></a>'; }
			else { $Table .= '<a href="?q=bots' . (isset($_GET['online']) ? '&online' : '') . '" class="button"><span>Show Pages</span></a>'; }

			$Table .= '</div><br /><table><tr class="tr_title">
				<td>ID</td>
				<td>Country</td>
				<td>PC Name</td>
				<td>Operating System</td>
				<td>Version</td>
				<td>IP</td>
				<td>Status</td>
				</tr>';

			$Query = $DB->Query("SELECT * FROM bots" . (isset($_GET['online']) ? " WHERE Request > '" . ($rTime - BOT_TIME_ON) . "'" : "") . (!isset($_GET['all']) ? ' LIMIT ' . $iLimit : ''));
			while($sData = $DB->getRowArray($Query))
			{
				$Status = ($sData['Request'] > ($rTime - BOT_TIME_ON) ? '<span class="green">Online</span>' : '<span class="red">Offline</span>');
				$Table .= '<tr><td>#' . $sData['ID'] . '</td><td><img src="resources/images/flags/' . $sData['Flag'] . '.gif" />&nbsp;' . $sData['Country'] . '</td><td>' . $sData['PCName'] . '</td><td>' . $sData['System'] . '</td><td>' . $sData['Version'] . '</td><td>' . $sData['IP'] . '</td><td>' . $Status . '</td></tr>';
			}
			
			$Table .= '</table>';
			if($iCount > SHOW_COUNT && !isset($_GET['all']))
			{
				$Table .= '<div style="text-align:right;padding-right:10px;padding-top:10px;">';
				if($rPage != 1) { $Table .= '<a href="?q=bots' . (isset($_GET['online']) ? '&online' : '') . '&page=' . ($rPage - 1) . '" class="button"><span>&laquo; Back</span></a>'; }
				if($rPage != ceil($iCount / SHOW_COUNT)) { $Table .= '<a href="?q=bots' . (isset($_GET['online']) ? '&online' : '') . '&page=' . ($rPage + 1) . '" class="button"><span>Next &raquo;</span></a>'; }
				$Table .= '</div>';
			}
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