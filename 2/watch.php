<?php
	if(count($_GET)>1 || $_SERVER['HTTP_HOST']=='vfilme.ru')
	{
		header("HTTP/1.1 301 Moved Permanently");
		header('Location: http://www.vfilme.ru/watch.php?film='.($_GET['film']));
	}
	
	include "lib/settings.php";
	include "lib/lib.php";
	include "templates/lib/lib.php";
ini_set('display_errors','0');
	
	$watch=deleteQuotes($_GET['film']);
	db_connect();	
	$comments=get_film_comments($watch);	
	$watch=get_one_film($watch);		
	include 'left_block.php';
	db_close();
		
	include 'templates/watch.php';
?>