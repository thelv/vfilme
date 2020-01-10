<?php
  function downloadlink($host,$vtag,$vkid)
  {
    return "http://$host/assets/videos/$vtag$vkid.vk.flv";
  }

  if (!($_COOKIE['porn']==1)){header("Location: access.php?q=${_SERVER['REQUEST_URI']}");die();}
  $HTMLfilm=preg_split('/<\$>/',file_get_contents('HTMLparts/watch/film.html'),-1,PREG_SPLIT_NO_EMPTY);
  $HTMLsearch=preg_split('/<\$>/',file_get_contents('HTMLparts/search.txt'),-1,PREG_SPLIT_NO_EMPTY);
  echo "<html>\r\n<head>\r\n<title>В Фильме | Просмотр \"${_GET['text']}\"</title>\r\n";
  echo "\r\n<link rel='stylesheet' href='/css/main.php' type='text/css' />\r\n";
  echo "\r\n<link rel='stylesheet' href='/css/watch.php' type='text/css' />\r\n";
  echo $HTMLsearch[0];
  echo $HTMLsearch[1];
  echo '<div class="resultslabel">';

  $mysql=mysql_connect("localhost", "dreamsa0_admin", "pi2Jogodi");
  mysql_query("set names cp1251");
  $fb=mysql_select_db("dreamsa0_films");

  $req="SELECT * FROM porn2 WHERE watch='${_GET['film']}'";
  $result=mysql_query($req);  
  $film=mysql_fetch_assoc($result);
//counter
  echo "\r\n<script language='JavaScript'>\r\n<!--\r\ncounterparam='img=${film['img']}';\r\n-->\r\n</script>\r\n";
  $name=preg_replace('|http://[^\s]*|i','',$film['name']);
  echo $name;
  if($film['description']==''){$description='Отсутствует описание';}else{$description=$film['description'];};
  $description=preg_replace('|(_{20})_*|','$1',$description);
  $description=preg_replace('|[^\s<>]{25}|','$0 ',$description);
  $description=preg_replace('|http://[^\s]*|i','',$description);
  echo '</div>';
  echo "\r\n<script language='JavaScript'>\r\n<!--\r\n document.title='В Фильме | ${film['name']}';\r\n-->\r\n</script>\r\n";

  echo $HTMLfilm[0].$film['watch'].$HTMLfilm[1].downloadlink($film['host'],$film['vtag'],$film['vkid']).$HTMLfilm[2]."http://vkontakte.ru/${film['watch']}".$HTMLfilm[3].$film['host'].$HTMLfilm[4].$film['vtag'].$HTMLfilm[5].$film['vkid'].$HTMLfilm[6].$description.$HTMLfilm[7];
  readfile('HTMLparts/search_end_watch.txt');
  mysql_free_result($result);
  mysql_close($mysql);    


///////////////////////////////////////////////
//  echo "<script type='text/javascript'>\r\nwindow.location=\"http://vkontakte.ru/${film['watch']}\"\r\n</script>";
?>

