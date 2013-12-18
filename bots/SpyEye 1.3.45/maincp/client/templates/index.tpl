<table cellspacing="0" cellpadding="0" border="0" width='100%' height="50px">
	<tr><td align='left'>
	<table cellspacing="0" cellpadding="0" border="0">
		<tr>
		<td>{include file='clock.tpl'}<td>
		</tr>
		<tr height="19px">
		<td align="right">
		<!-- just nothing -->
		</tr>
	</table>
	<td width='540px' align='center'>
		<a id='frm_botsmon_country' title='Bots Monitoring'><img src='img/b-bots.png' alt='bots'></a>
		<a id='frm_botstat' title='Bots Statistic'><img src='img/b-fullstat.png' alt='Bots statistics'></a>
		<a id='frm_createtask' title='Create Task'><img src='img/b-createtask.png' alt='createloadertask'></a>
		<a id='frm_stat' title='Tasks Statistic'><img src='img/b-statistics.png' alt='statistics'></a>		
		<a id='frm_virtest' title="Check latest bot's build on Virtest.com"><img src='img/b-virtest.png' alt='virtest'></a>
		<a id='frm_plugins' title='Plugins'><img src='img/b-plugins.png' alt='plugins'></a>
		<a id='frm_ftpbackconnect' title='FTP backconnect'><img src='img/b-ftpbackconnect.png' alt='ftp backconnect'></a>
		<a id='frm_socks5' title='SOCKS5'><img src='img/b-socks5.png' alt='socks5'></a>
		<a id='frm_rdp' title='Remote Desktop'><img src='img/b-rdp.png' alt='rdp'></a>
		<br><hr color="#dddddd" size="1">
		<a id='frm_viewlogs' title='Logs (error.log, debug.log, tasks.log)' href='javascript:void();'><img src='img/b-logs.png' alt='logs' border="0"></a>
		<a id='frm_showfiles' href='javascript:void();'><img src='img/b-files.png' alt='files' border="0"></a>
		<a id='frm_settings' title='Settings'><img src='img/b-settings.png' alt='settings'></a>		
	</td>
	<td align='right'>
	<table cellspacing="0" cellpadding="0" border="0">
		<tr>
		<td>{include file='bots-qview.tpl'}<td>
		</tr>
		<tr height="19px">
		<td align="right">
			<a title="Log out" id="logout" style="margin-right: 2px;" href="javascript:void();"><img alt="logout" src="img/icos/logout-ico.png" border="0"></a>
		</tr>
	</table>
	</table>
<hr color="#cccccc" size="1">
<div id='page_content' align='center'>
	<br><img src='img/logomain.png'>
</div>
<div id='bottom'></div>
{literal}<script src='./scripts/jquery.js'></script><script src='./scripts/main.js'></script>
<script>
$(document).ready(function()
{
	$("#frm_stat").click(function() { load('./mod/show_tasks.php','page_content'); });
	$("#frm_createtask").click(function() { load('./mod/create_task.php','page_content'); });
	$("#close").click(function() { 	$("#popup_wnd").css("visibility", "hidden"); $("#popup_cont").css("visibility", "hidden"); });
	$("#logout").click(function() { load('./mod/logout.php','content'); });	
	$("#frm_botsmon_country").click(function() { load('./mod/botsmon_country.php','page_content'); });
	$("#frm_botstat").click(function() { load('./mod/botstat.php','page_content'); });
	$("#frm_virtest").click(function() { load('./mod/virtest.php','page_content'); });
	$("#frm_plugins").click(function() { load('./mod/plugins.php','page_content'); });
	$("#frm_ftpbackconnect").click(function() { load('./mod/ftpbackconnect.php','page_content'); });
	$("#frm_socks5").click(function() { load('./mod/socks5.php','page_content'); });
	$("#frm_rdp").click(function() { load('./mod/rdp.php','page_content'); });
	$("#frm_settings").click(function() { load('./mod/settings.php','page_content'); });
	$("#frm_viewlogs").click(function() { load('./mod/view_logs.php','page_content'); });
	$("#frm_showfiles").click(function() { load('./mod/show_files.php','page_content'); });
});
function ReloadTime()
{
	$('#clock').load('./mod/clock.php');
{/literal}	
	{if isset($RELOAD_PANEL)}setTimeout("ReloadTime()",5000); {/if}
{literal}
}
ReloadTime();
</script>{/literal}