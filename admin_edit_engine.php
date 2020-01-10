<?php
	include 'admin/lib.php';
	access();	
	echo $id.'!';
	echo $watch.'!';
	$id=(int)$_POST['id'];	
	$name=$_POST['name'];
	$desc=$_POST['desc'];
	$img=$_POST['img'];
	$watch=$_POST['watch'];
	$embed=$_POST['embed'];
	$flag=$_POST['flag'];
	
	if(! $_POST['request_is']){die();}
	
	connect_db();
	if(edit_db($id,$name,$desc,$img,$watch,$embed,$flag))
	{	
		echo 'OK';
	}
	else
	{
		echo 'error';
	}	
	mysql_close();
?>