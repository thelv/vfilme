<?php

ini_set('display_errors', 1);

	$SERIAL_ID=5;
	$SEASON=7;

	include 'lib.php';
	include 'serial_parser.php';

	connect_db();
	echo "<br>1:".mysql_error();

	$text=file_get_contents('md/house7.html');
	$films=parse_all_series_page_club_allfilms_v3($text);


	foreach($films as $film)
	{
		add_one_series_to_season($SERIAL_ID, $SEASON, $film['series'], $film['watch']);
		print_r($film);
		echo "<br>error:".mysql_error();
	}


	mysql_close();
?>