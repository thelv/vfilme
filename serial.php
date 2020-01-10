<?php	
	include "lib/settings.php";
	include "lib/lib.php";
	include "templates/lib/lib.php";
ini_set('display_errors',0);
		
	//$serial_id=(int)$_GET['serial'];
	$serial_alias=$_GET['serial'];
	$season=(int)$_GET['season'];	
	$season=max(1,$season);
	db_connect();
	$serial=get_serial_by_alias($serial_alias);
	if (! $serial['Id'])
	{
		$serial=get_serial_by_id((int)$serial_alias);
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: /serial.php?serial='.$serial['alias'].($_GET['season']  ? '&season='.$_GET['season'] : ''));
		die();
	}
	if(! isset($_GET['season'])){$serial['no_season']=true;}
	$films=get_series($serial['Id'],$season);		
	include 'left_block.php';
	db_close();	

	include 'templates/serial.php';
?>