<?php

require_once("../config.php");
require_once("../include/mysql.php");



	$r=mysql_query("SELECT * FROM `bots` WHERE ``bot_id	bot_ip	country	system	username	table	small_blind	big_blind	hand	screen_width	screen_height	lost_time	first_time	last_time");
	if (mysql_num_rows($r)>0) {
		echo "<table>";
		while($v=mysql_fetch_assoc($r)){
			echo '<tr>';
			echo '<td><img align="top" style="margin-top:0px;margin-right:5px;margin-left:5px;" src="images/task.png">'.$v['id'].'</td>';
			echo '<td id="url'.$v['id'].'">'.$v['url'].'</td>';
			echo '<td>';
			echo $v['command']=='' ? "" : $v['command'];
			echo '</td>';
			echo '<td>';
			echo $v['flags']=='' ? "" : $v['flags'];
			echo '</td>';
			echo '<td>';
			echo $v['functionName']=='' ? "" : $v['functionName'];
			echo '</td>';
			echo '<td>';
			echo $v['limit']==0 ? "unlimited" : $v['limit'];
			echo '</td>';
			echo '<td>';
			echo $v['count'];
			echo '</td>';
			echo '<td><span class="delBtn" onClick="doDel('.$v['id'].',this);">'.$lang[$l][6].'</span> | <span class="delBtn" onClick="doEdit('.$v['id'].',this);">'.$lang[$l][7].'</span> | ';
			if ($v['stop']==0) echo '<span class="delBtn stopBtn" onClick="doStopTask('.$v['id'].',this);">'.$lang[$l][8].'</span></td>';
			if ($v['stop']==1) echo '<span class="delBtn stopBtn" onClick="doStopTask('.$v['id'].',this);">'.$lang[$l][9].'</span></td>';
			
			echo "</tr>";
		}
		echo "</table>";
	}
}