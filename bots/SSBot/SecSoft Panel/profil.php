<?php require_once('inc/session.php'); require_once('inc/body.php'); require_once('inc/config.php'); require_once('other/safe.php'); require_once('other/rechte.php'); ?>

<b>Benutzername:</b> <?php echo $_SESSION['secuser']; ?> <br />
<b>Einschr&auml;nkungen:</b>

<?php 
if(isset($_SESSION['admin'])){
  echo 'Nein (Admin)';
}else{
	echo 'Ja (Benutzer) <br /> <br /><b>Freigeschaltet ist:</b> <ul>';
	
	if(profil_rechte('http')){
		echo '<li>HTTP Flood</li>';
	}
	
	if(profil_rechte('tcp')){
		echo '<li>TCP Flood</li>';
	}
	
	if(profil_rechte('udp')){
		echo '<li>UDP Flood</li>';
	}
	
	if(profil_rechte('dlex')){
		echo '<li>DLEX</li>';
	}

	if(profil_rechte('visit')){
		echo '<li>Visit Page</li>';
	}
}
?>

<?php require_once('inc/footer.php'); ?>