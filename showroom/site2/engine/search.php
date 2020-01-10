<?php	
	include "lib/settings.php";
	include "lib/lib.php";
	include "templates/lib/lib.php";
	include "templates/blocks/lib/lib.php";
ini_set('display_errors',0);

// <!-- обратная совместимость
	if($_GET['type']=='ext')
	{
		if($_GET['owner']=='club29991' || $_GET['owner']=='club445750')
		{
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: multfilms.php');
			die();
		}		
		if($_GET['owner']=='club61972')
		{
			header('HTTP/1.1 301 Moved Permanently');
			//header('Location: black.php');
			header('Location: http://vfilme.ru/extended_search.php?name=&info=&genre=black');
			die();
		}		
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: extended_search.php?name='.urlencode($_GET['name']).'&info='.urlencode($_GET['info']).'&genre=');
		die();
	}
	if($_GET['l'])
	{
		$letter=$_GET['l'];
		$letter=strtolower($letter);
		$letter=toUTF($letter);
		$letter=urlencode($letter);
		header('HTTP/1.1 301 Moved Permanently');
		if($page=$_GET['page'])
		{
			$page_str="&page=${page}";
		}
		header("Location: alphabet.php?letter=${letter}${page_str}");
		die();
	}
// обратная совместимость -->	
	
	
	$FILMS_ON_PAGE=20;
	$page=(int)$_GET['page'];	
	$page=max(1,$page);
	$request=$_GET['request'];
	db_connect();	
	$films=search_films($request,($page-1)*$FILMS_ON_PAGE,$FILMS_ON_PAGE,$films_number);
	include 'left_block.php';
	db_close();
	
	include 'templates/search.php';
?>