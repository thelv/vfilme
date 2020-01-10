<?php
	mysql_connect("localhost", "vfilme", "wqGrhc9mDTtnePzt");
	mysql_query("set names cp1251");
	mysql_select_db("vfilme");
	$text=mysql_real_escape_string($_GET['text']);
	$time=time();
	$film=mysql_real_escape_string($_GET[film]);
	mysql_query("INSERT INTO comment VALUES (NULL,$time,'$text','$film')");
	mysql_close();
?>