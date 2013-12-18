<h1>Create Task</h1>
<form id='frm_addtask' method='post'>
<table style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240); width:700px;" border="1" cellpadding="3" cellspacing="0">
<tr><td align="left" width="80px"><b>File: </b>
</td><td colspan='4'>
	<select name='file' style="width: 100%; font-size: 10px;" id='file'>
	<option value='0'>Plz, select file ..</option>
	{foreach from=$FILES item=FILE}
	<option value='{$FILE.FID}' onClick='SetType("{$FILE.FTYPE}");'>{$FILE.FNAME}</option>
	{/foreach}
	</select>
</td></tr>
<tr><td align="left"><b>Type: </b></td>
<td width='120' valign='top'><input type='radio' value='bot' id='rb' onClick='SetType("b")' disabled > <b>Update bot body &nbsp;</b></td>
<td width='120' valign='top'><input type='radio' value='config' id='rc' onClick='SetType("c");' disabled > <b>Update bot config &nbsp;</b></td>
<td width='120' valign='top'><input type='radio' value='exe' id='re' onClick='SetType("e");' disabled > <b>Load exe &nbsp;</b></td>
<input type='hidden' name='type' id='div_type'>
<td> </td>
</td>
<tr id='bot_ext'></tr>
</tr>
<tr>
    <td>Unlimited</td>
    <td colspan="4"><input name="isUnlimit" type="checkbox" value="1" /></td>
</tr>
<tr><td><b>Note:</b></td><td colspan='4'><textarea name="note" style='width:100%;' rows="3" wrap="off"></textarea></td></tr>


<tr><td colspan='5' align='center'><input type='submit' value='Next'></td></tr>
</table>
</form>

{literal}
<script>
function showCountries()
{
	var myDiv = document.getElementById('countries');
	var myExtDiv = document.getElementById('ext_countries');
	if(myDiv.style.display == 'none')
	{
		myDiv.style.display = 'block';
		myExtDiv.style.display = 'none';
	} else 
	{
		myDiv.style.display = 'none';
		myExtDiv.style.display = 'block';
	}
	return false;
}
function DisableAll()
{
	radio = document.getElementById('rb');
	if(radio) radio.checked = false;
	radio = document.getElementById('rc');
	if(radio) radio.checked = false;
	radio = document.getElementById('re');
	if(radio) radio.checked = false;	
}
function SetType(type)
{
	DisableAll();	
	radio = document.getElementById('r'+type);
	if(radio) radio.checked = true;
	
	div_type = document.getElementById('div_type');
	if(div_type) div_type.value = type;
	bot_ext = document.getElementById('bot_ext');
	if(!type || !bot_ext) alert('Javs Error');
	
	if(type == 'b')
	{
		in_html = "<td></td><td colspan='4'>" +
			"<input type='checkbox' name='pe_loader' id='pe_loader' onClick='SetPeLoader()'> use build-in pe loader<br>" +
			"<input type='checkbox' name='repl_exe' id='repl_exe' onClick=''> replace exe</td>";
		if(bot_ext) bot_ext.innerHTML = in_html;
	}
	if(type == 'e')
	{
		in_html = "<td></td><td colspan='4'>" +
			"<input type='checkbox' name='pe_loader' id='pe_loader'> use build-in pe loader</td>";
		if(bot_ext) bot_ext.innerHTML = in_html;
	}
	if(type == 'c' && bot_ext) bot_ext.innerHTML = '';
}
function SetPeLoader()
{
	//repl = document.getElementById('repl_exe');
	//peload = document.getElementById('pe_loader');
	//if( repl && peload && peload.checked ) repl.checked = true;
}
$("#frm_addtask").submit(function() 
{
	if( $("#file").val() == 0 ) { alert('Plz, select file!'); return false; }
	pdata = $('#frm_addtask').serialize(true); 
	$.post('./mod/create_task.php', pdata, function(data) { $("#page_content").html(data); });
	return false;
});
</script>
{/literal}