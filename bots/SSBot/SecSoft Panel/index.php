<?php 
require_once('inc/session.php');

if(isset($_GET['ausloggen'])){
  session_start();
  session_destroy();
  header('Location: login.php');
}

require_once('inc/body.php'); require_once('inc/config.php'); require_once('other/safe.php'); ?>

<img src="other/week.php" />
<img src="other/monthly.php" />

<?php $today = date('Y-m-d'); $yesterday = date('Y-m-d', time()-86400); ?>
			
<div id="mainBox">
	<div id="innerBox">
		<div id="leftBox">
			 <?php require_once('other/top20countries.php'); ?>
		</div>
		<div id="centerBox">
			 <?php require_once('other/top10today.php'); ?>
		</div>
		<div id="rightBox">
			 <?php //require_once('other/top10yesterday.php'); ?>
		</div>
			
		<div class="clear"></div>
	</div>
</div>
	
<?php  require_once('inc/footer.php'); ?>