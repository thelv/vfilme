<?php
//ini_set('display_errors','on');

	header('Content-Type: image/jpeg');
	readfile($_GET['url']);

//	file_put_contents('vkbutton_films.txt',$_GET['url']."\r\n",FILE_APPEND);
?>