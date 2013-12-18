<?php
if (!@$pageIncluded) { 
	header ("Content-type: text/html; charset=utf-8");
	chdir('..');
}


require_once("config.php");
require_once("ln/ln.php");
require_once("includes/mysql.php");

$db=new odbcClass();

require_once("includes/functions.php");

$config["language"] == "ru" ? $l = "ru" : $l = "en";

?>

<table cellpadding="0" cellspacing="0" style="padding:0;">
	<tr><td style="background:#fff;" align="center"><h1 style="margin-top:20px;margin-bottom:20px;">Статистика</h1></td><td style="background:#fff;" align="center"><h1 style="margin-top:20px;margin-bottom:20px;"><?=$lang[$l][36];?></h1></td></tr>
    <tr>
    	<td style="padding:0;width:350px;background:#fff;">
        	<table cellspacing="0">
        		<tr><th><?=$lang[$l][37];?></th><th><?=$lang[$l][38];?></th></tr>
            	<tr><td><img align="top" style="margin-top:0px;margin-right:5px;margin-left:5px;" src="images/icons/infected.png"><?=$lang[$l][39];?>:</td><td><?=get_total(); ?></td></tr>
            	<tr><td><img align="top" style="margin-top:0px;margin-right:5px;margin-left:5px;" src="images/icons/online.png"><?=$lang[$l][61];?>:</td><td><?=get_online(); ?></td></tr>
            	<tr><td><img align="top" style="margin-top:0px;margin-right:5px;margin-left:5px;" src="images/icons/offline.png"><?=$lang[$l][62];?>:</td><td><?=get_offline(); ?></td></tr>
			<tr><td><img align="top" style="margin-top:0px;margin-right:5px;margin-left:5px;" src="images/icons/tasks.png"><?=$lang[$l][40];?>:</td><td><?=get_tasks(); ?></td></tr>
			<tr><td><img align="top" style="margin-top:0px;margin-right:5px;margin-left:5px;" src="images/icons/downloads.png"><?=$lang[$l][41];?>:</td><td><?=get_loaded(); ?></td></tr>
			</table>
		</td>
		<td style="background:#fff;" align="center">
			<?=get_chart_data();?>
		</td>
	</tr>
</table>

<h1 style="margin-top:20px;margin-bottom:20px;text-align:center;"><?=$lang[$l][43];?></h1>
<table cellspacing="0">
<tr><th style="width:20%;">IP</th><th>BID</th></th><th style="width:30%;"><?=$lang[$l][44];?></th><th>Система</th></th><th><?=$lang[$l][45];?></th></tr>
<?=get_top_5();?>
</table>

<h1 style="margin-top:20px;margin-bottom:20px;text-align:center;"><?=$lang[$l][46];?></h1>
<table cellspacing="0">
<tr><th style="width:30%;"><?=$lang[$l][47];?></th><th><?=$lang[$l][48];?></th></tr>
<?=get_top_os();?>
</table>

<h1 style="margin-top:20px;margin-bottom:20px;text-align:center;"><?=$lang[$l][49];?></h1>
<table cellspacing="0">
<tr><th style="width:30%;"><?=$lang[$l][44];?></th><th><?=$lang[$l][48];?></th></tr>
<?=get_cc_stat();?>
</table>


