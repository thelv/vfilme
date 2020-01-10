<?php
	include 'admin/lib.php';
	access();		
	
	if(! $_POST['request_is']){die();}
	
	connect_db();
	if(add_db($id,$name,$desc,$img,$watch,$embed))
	{	
		echo 'OK';
	}
	else
	{
		echo 'error';
	}	
	mysql_close();
?>