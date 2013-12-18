<?php
$from=$_POST['from'];
$subject=$_POST['subject'];
$message=$_POST['message'];
$file = fopen('mld.html', 'w');

fwrite($file ,"&subject=$subject&message=$message&from=$from");
fclose($file);

?>



<center><h1>Options Saved!</h1>
<a href="../a.php"><h1>-Back-</a></h1></center>