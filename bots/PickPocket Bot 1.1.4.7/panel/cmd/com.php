<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen">
  <link rel="stylesheet" href="../css/buttons.css" type="text/css" media="screen">
<?php 
include('../sys/auth.php');

$to = $_POST['to'];
$nr = $_POST['nr'];
$value = $_POST['value'];

$file = fopen('../nr.html', 'w');

fwrite($file ,"<title>$to$nr</title>$value");

Echo'<center><h2> Command Send !  </h2></center>';
echo "<center><h3> $to  $value</h3></center>";

?>


<center>

<a  href="../a.php"><button class="download-itunes" value='Send CMD'>Back</button><a></center>