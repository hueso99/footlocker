<?php /* Smarty version Smarty-3.0.6, created on 2011-02-19 18:46:38
         compiled from "/var/www/maincp/client/templates/upload_file.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17885548014d60100e395d42-96569347%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a43fda2358b5fb7d19a42cfe70f886f10cd236c0' => 
    array (
      0 => '/var/www/maincp/client/templates/upload_file.tpl',
      1 => 1296946481,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17885548014d60100e395d42-96569347',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
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

<?php if (isset($_smarty_tpl->getVariable('COUNTRIES',null,true,false)->value)){?>
<a href='javascript:void();' onClick='SelectAll("bots",true);'>Select All</a> 
<a href='javascript:void();' onClick='SelectAll("bots",false);'>Unselect All</a> 
<?php $_template = new Smarty_Internal_Template('get_bots.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<?php }?>

</form>
</div>
<iframe id="hiddenframe" name="hiddenframe" style="width:100%; height:0px; border:0px"></iframe>

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
	