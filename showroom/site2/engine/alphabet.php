<?php	
	include "lib/settings.php";
	include "lib/lib.php";
	include "templates/lib/lib.php";
	include "templates/blocks/lib/lib.php";
ini_set('display_errors',0);
	
	$FILMS_ON_PAGE=20;
	$page=(int)$_GET['page'];		
	$page=max(1,$page);
	$letter=deleteQuotes($_GET['letter']);
	db_connect();	
	$films=films_on_letter($letter,($page-1)*$FILMS_ON_PAGE,$FILMS_ON_PAGE,$films_number);
	include 'left_block.php';
	db_close();
	
	include 'templates/alphabet.php';
?>