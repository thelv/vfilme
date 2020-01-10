<?php

$t=time();
$ip = ($_SERVER['HTTP_X_FORWARDED_FOR'] == "" ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR']); 
$wt=$_GET['wt'];

//file_put_contents('stat.txt',"$wt $t $ip\r\n",FILE_APPEND);


?>