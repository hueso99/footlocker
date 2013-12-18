<?php

session_start(  );

if ($_SESSION['login'] == true) {
	header( 'Location: statistics.php' );
	exit(  );
	return 1;
}

header( 'Location: login.php' );
exit(  );
?>
