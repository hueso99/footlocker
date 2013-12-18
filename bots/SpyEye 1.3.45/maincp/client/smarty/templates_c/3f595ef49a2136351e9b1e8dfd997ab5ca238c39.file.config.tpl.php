<?php /* Smarty version Smarty-3.0.6, created on 2011-03-26 03:56:24
         compiled from "Z:/home/gate/www/client/templates\config.tpl" */ ?>
<?php /*%%SmartyHeaderCode:270704d8d39b8e92759-24359140%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3f595ef49a2136351e9b1e8dfd997ab5ca238c39' => 
    array (
      0 => 'Z:/home/gate/www/client/templates\\config.tpl',
      1 => 1295720754,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '270704d8d39b8e92759-24359140',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<<?php ?>?
	# Server DB configuration
	$db_host = "<?php echo $_smarty_tpl->getVariable('DB_HOST')->value;?>
";
	$db_user = "<?php echo $_smarty_tpl->getVariable('DB_USER')->value;?>
";
	$db_pswd = "<?php echo $_smarty_tpl->getVariable('DB_PASS')->value;?>
";
	$db_database = "<?php echo $_smarty_tpl->getVariable('DB_DATABASE')->value;?>
";
	
	# system
	$root_path = "<?php echo $_smarty_tpl->getVariable('ROOT_PATH')->value;?>
";
?<?php ?>>