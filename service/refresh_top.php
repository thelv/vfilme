<?php

	chdir('/var/www/vfilme/service/');
 
	include '../lib/settings.php';


$db_server='localhost';
$db_user='root';
$db_pass='goodrule';

	include '../lib/lib.php';
	db_connect();
	refresh_top();
	db_close();

?>
