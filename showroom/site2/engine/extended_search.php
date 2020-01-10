<?php	
	include "lib/settings.php";
	include "lib/lib.php";
	include "templates/lib/lib.php";
	include "templates/blocks/lib/lib.php";
ini_set('display_errors',0);
	
	$FILMS_ON_PAGE=20;
	$page=(int)$_GET['page'];	
	$page=max(1,$page);
	$name=$_GET['name'];
	$info=$_GET['info'];
	$genre=$_GET['genre'];
	db_connect();		
	if(! count($_GET))
	{
		$no_request=true;
	}
	else
	{
		$no_request=false;
		$films=search_films($name,($page-1)*$FILMS_ON_PAGE,$FILMS_ON_PAGE,$films_number,$info,$genre);
	}
	include 'left_block.php';
	db_close();
	
	
	include 'templates/extended_search.php';
?>