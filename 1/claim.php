<?php
  setlocale(LC_ALL, 'ru_RU.CP1251');

  session_start();
  if($_SESSION['start']==1 && (time()-$_SESSION['lastclaim']>1)){}else{$_SESSION['start']=1;$_SESSION['lastclaim']=time();die();}
  $_SESSION['lastclaim']=time();
  $mysql=mysql_connect("localhost", "dreamsa0_admin", "pi2Jogodi");
  mysql_query("set names cp1251");
  $fb=mysql_select_db("dreamsa0_films");
  $claimfilm=urldecode($_SERVER['QUERY_STRING']);
  mysql_query("INSERT INTO claim VALUES(NULL,'${claimfilm}',".time().",NULL)");  
  mysql_close($mysql);    
  echo 'OK';
?>