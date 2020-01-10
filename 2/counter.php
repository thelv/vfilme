<?php
  session_start();
  if($_GET['img']){}else{$_SESSION['start']=1;die();};
  $img=$_GET['img'];  
  $film=$img;
  $date=intval(time()/200000);
  echo 'OK';
  if(count($_SESSION['counts'])==0){$_SESSION['counts']=Array();};
  if($_SESSION['start'] && !(in_array($film,$_SESSION['counts'])) && (time()-$_SESSION['lasttime']>30)){}else{die();}
  $_SESSION['counts'][]=$film;

  $mysql=mysql_connect("localhost", "vfilme", "wqGrhc9mDTtnePzt");
  mysql_query("set names cp1251");
  $fb=mysql_select_db("vfilme");
  $img=mysql_real_escape_string($img);
  mysql_query("SELECT NULL FROM top WHERE img='$img' AND date=$date");
  echo 'OK';
 if(mysql_affected_rows($mysql)==1)
  {
    $req="UPDATE top SET pop=pop+1 WHERE img='$img' AND date=$date";
    mysql_query($req);
  }
  else{
    $req="INSERT INTO top VALUES('$img',1,$date)";    
    mysql_query($req);    
  }
  mysql_close($mysql);  
  echo 'OK';
?>