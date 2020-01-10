<?php	
	include "lib/settings.php";
	include "lib/lib.php";
	include "templates/lib/lib.php";
ini_set('display_errors',0);
		
	db_connect();		
	$pop_films=get_popular_films(0,10);
	$new_films=get_new_films(0,7);
	$comments=get_last_comments(20);
	db_close();	
	
	include 'templates/main.php';
?>