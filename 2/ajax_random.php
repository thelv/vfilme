<?php	
	include "lib/settings.php";
	include "lib/lib.php";
	include "templates/lib/lib.php";
	include "templates/blocks/lib/lib.php";
ini_set('display_errors',0);
			
	db_connect();	
	$film=get_random_film();
	db_close();
	
	header('Pragma: no-cache');
	header('Cache-Control: max-age=1');	
	header('Content-Type: text/plain; charset=utf-8');
	
	$search_film=$film;
	include includeblock('search_film');
?>