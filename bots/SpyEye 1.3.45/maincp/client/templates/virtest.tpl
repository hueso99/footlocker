<form name="frm_checkbot" id="frm_checkbot" >
<table>
<tr align="left">
	<td align='left'><label>File to check (<b>*.exe</b>):</label></td>
	<td align='left'>
		<select name="file" style="width:500px;font-size:10px;">
{foreach from=$DBPATH item=PATH}
	<option value='{$PATH}'>{$PATH}</option>
{foreachelse}
<option>There are no uploaded files for testing</option>
{/foreach}
		</select>
	
<!--	<input name="file" value="{$DBPATH}" style="width:500px;"></td> -->
</tr>
<tr>
	<td colspan='2' align='center'><input type='submit' value='submit'  style="width:140px;"></td>
</tr>
</table>

<hr size='1' color='#CCC'><div name='ajax_checkbot' id='ajax_checkbot'></div>
</form>

{literal}
<script>
$(document).ready(function()
{
	$("#frm_checkbot").submit(function()
	{
		SetLoading('ajax_checkbot');
		pdata = $('#frm_checkbot').serialize(true);
		$.post('./mod/virtestrun.php', pdata, function(data) { $("#ajax_checkbot").html(data); });
		return false;
	});
});
</script>
{/literal}
