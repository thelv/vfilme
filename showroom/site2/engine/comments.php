<?php	
	include "lib/settings.php";
	include "lib/lib.php";
	include "templates/lib/lib.php";
ini_set('display_errors',0);
	
	$FILMS_ON_PAGE=20;
	$page=(int)$_GET['page'];	
	$page=max(1,$page);
	db_connect();	
	$films=get_last_comments(($page-1)*$FILMS_ON_PAGE,$FILMS_ON_PAGE);
	include 'left_block.php';
	db_close();
	
	include 'templates/comments.php';
?>