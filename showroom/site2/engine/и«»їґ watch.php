<?php
	$root_dir='.';
	include "lib/settings.php";
	include "lib/lib.php";
	include "templates/lib/lib.php";
ini_set('display_errors','0');
	
	$watch=deleteQuotes($_GET['film']);
	db_connect();	
	$watch=get_one_film($watch);
	include 'left_block.php';
	db_close();
		
	include 'templates/watch.php';	
?>