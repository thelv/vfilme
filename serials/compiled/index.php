<?php

	include 'settings.php';
	
	if($_SERVER['HTTP_HOST']!=$domen)
	{
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: http://'.$domen.$_SERVER['REQUEST_URI']);
	}
	
	session_start();
	include 'auth.php';
	
	include 'lib/dbGeneral.php';
	include 'lib/dbSelect.php';	
	include 'lib/dbChange.php';	
	include compile("db.php");	
	mysql_connect('localhost', $dbLogin, $dbPass);
	mysql_query('set names utf8');
	mysql_select_db($dbName);
	
	$rawTables=$tables;
	tablesConvert($tables, $relations);
	accessConvert($access, $ses['level']);	
	
    if(strpos($_SERVER['REQUEST_URI'], '/request')===0)
	{
		include 'request.php';
	}
	elseif(strpos($_SERVER['REQUEST_URI'], '/serials/admin')===0)
	{		
		include 'admin.php';
	}
	else
	{
		include compile("url.php");
		include compile("pages.php");
	}
	
?>