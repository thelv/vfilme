<?php	
	include "lib/settings.php";
	include "lib/lib.php";
	include "templates/lib/lib.php";
ini_set('display_errors',0);
		
	$serial_id=(int)$_GET['serial'];
	$season=(int)$_GET['season'];
	$season=max(1,$season);
	db_connect();
	$seasons_number=get_seasons_number($serial_id,$name);
	$films=get_series($serial_id,$season);		
	include 'left_block.php';
	db_close();	

	include 'templates/serial.php';
?>