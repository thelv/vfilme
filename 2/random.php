<?php	
	include "lib/settings.php";
	include "lib/lib.php";
	include "templates/lib/lib.php";
	include "templates/blocks/lib/lib.php";
ini_set('display_errors',0);
		

	$watch=$_GET['film'];	
	db_connect();	
	if($watch)
	{	
		$film=get_one_film($watch);
	}
	else
	{
		$film=get_random_film();
	}
	include 'left_block.php';
	db_close();
	
	/*if(! $watch)
	{
		header('Location: ?film='.urlencode($next_film['watch']));
		die();
	}*/	
	
	header('Pragma: no-cache');
	header('Cache-Control: max-age=1');
	
	include 'templates/random.php';
?>