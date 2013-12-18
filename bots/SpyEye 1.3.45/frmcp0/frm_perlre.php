<?php

$script .= "<script type=\"text/javascript\" defer>\n";
$script .= "function xxx () {\n";
$script .= "	var pdata = ajax_getInputs(\"frm_perlre\");\n";
$script .= "	ajax_pload('mod_perlre.php', pdata, 'div_result');\n";
$script .= "}\n";
$script .= "</script>\n";

$script .= "<script type=\"text/javascript\">\n";
$script .= "    var GB_ROOT_DIR = \"js/greybox/\";\n";
$script .= "</script>\n";
$script .= "\n";
$script .= "<script type=\"text/javascript\" src=\"js/greybox/AJS.js\"></script>\n";
$script .= "<script type=\"text/javascript\" src=\"js/greybox/AJS_fx.js\"></script>\n";
$script .= "<script type=\"text/javascript\" src=\"js/greybox/gb_scripts.js\"></script>\n";
$script .= "<link href=\"js/greybox/gb_styles.css\" rel=\"stylesheet\" type=\"text/css\" /> \n";

$script .= "<script type=\"text/javascript\"> \n";
$script .= "function onclickBanHost(host) {\n";
$script .= "	host = document.getElementById('re').value;\n";
$script .= "	host = prompt('Do you really want to do it ?', host);\n";
$script .= "	if (!host) return false;\n";
$script .= "	GB_show('Ban host', '../../mod_hostban_add.php?host=' + host, 470, 550);\n";
$script .= "	return false;\n";
$script .= "}\n";
$script .= "</script> \n";

$content .= "$script\n";
$content .= "<h1><a href=\"http://www.linuxshare.ru/docs/devel/languages/perlre.html\" target=\"_blank\">PERLRE</a></h1>\n";
$content .= "<hr size='1' color='#CCC'>\n";
$content .= "<form name='frm_perlre' id='frm_perlre'>\n";
$content .= "<table>";
$content .= "<tr><td align='left'><label>Data: </label></td><td><input id='data' name='data' size=60 value='http://www.google.com/q=tada'></td></tr>\n";
$content .= "<tr><td align='left'><label>Data2: </label></td><td><input id='data2' name='data2' size=60 value='http://mail.google.com/l=fucker'></td></tr>\n";
$content .= "<tr><td align='left'><label>RE: </label></td><td><input id='re' name='re' size=60 value='(?:(?!mail\.).....|^..?)google\.'></td></tr>\n";
$content .= "<tr><td align='center' colspan='2'><input type='button' value='submit' onclick='xxx(); return false;'> | <input type='button' value='add to banlist' onclick='onclickBanHost(); return false;'></td></tr>\n";
$content .= "</table>";
$content .= "</form>\n";
$content .= "<hr size='1' color='#CCC'>\n";
$content .= "<div id='div_result'></div>";

require_once 'frm_skelet.php';
echo get_skelet('PERLRE', $content);

?>