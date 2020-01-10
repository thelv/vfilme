<?php	
	include "lib/settings.php";
	include "lib/lib.php";
	include "templates/lib/lib.php";
ini_set('display_errors',0);
			
	db_connect();	
	$serials=get_serials(0, 100);
	include 'left_block.php';
	db_close();
	
	include 'templates/serials.php';
?>