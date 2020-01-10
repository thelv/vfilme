<?php
//	header('Location: error.php');
//die();
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

	if($watch['serial_id'])
	{
		$watch['all_series']=get_series($watch['serial_id'],$watch['season']);
		$end=end($watch['all_series']);
		$begin=reset($watch['all_series']);		
		$watch['end_series']=$end['series'];
		$watch['begin_series']=$begin['series'];		
		if($watch['series']==$end['series'] && $watch['season']<$watch['seasons_number'])
		{			
			$watch['next_season_series']=get_series($watch['serial_id'],$watch['season']+1);			
		}
		elseif($watch['series']==$begin['series'] && $watch['season']>1)
		{			
			$watch['prev_season_series']=get_series($watch['serial_id'],$watch['season']-1);
		}
	}
	include 'left_block.php';
	db_close();
		
	include 'templates/watch.php';
?>