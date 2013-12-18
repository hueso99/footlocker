<?php /* Smarty version Smarty-3.0.6, created on 2011-02-19 18:46:36
         compiled from "/var/www/maincp/client/templates/progress.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14204055174d60100c695db0-64545801%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b2ff3cd396d547059331b0d283c72d59c1787ee4' => 
    array (
      0 => '/var/www/maincp/client/templates/progress.tpl',
      1 => 1296946253,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14204055174d60100c695db0-64545801',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<style>body { font-family: Verdana; font-size: 10px; background-color: #F7F7F7; }</style>
<div style='text-align:center;'>Complete : <span><img id='ref_to' src='./progress.php' style='vertical-align:middle;'></span></div>
<div id='progress' style='visibility:hidden;'><img src='1' id='ref_from'></div>
<script type="text/javascript" src="../scripts/jquery.js"></script>
<script>
function r(per)
{
	$("#progress").html("<img id='ref_from' src='./progress.php?per="+per+"' style='vertical-align:middle;'>");
	var x = $("#ref_from").attr('src');
	$("#ref_to").attr('src', x);
}
function SetResult(text)
{
	x = parent.document.getElementById('uploadResult');
	x.innerHTML = text;
	// show create task link/button
	t = parent.document.getElementById('task_div');
	t.style.visibility = 'visible';
}
ifrm = parent.document.getElementById('hiddenframe');
ifrm.style.height = 30;
</script>