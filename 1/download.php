<?php
  function downloadlink($host,$vtag,$vkid)
  {
    return "http://$host/assets/videos/$vtag$vkid.vk.flv";
  }

//bd
  $mysql=mysql_connect("localhost", "vfilme", "wqGrhc9mDTtnePzt");
  mysql_query("set names cp1251");
  $fb=mysql_select_db("vfilme");

  $req="SELECT * FROM film WHERE watch='${_GET['film']}'";
  $result=mysql_query($req);  
  $film=mysql_fetch_assoc($result);

//html

  $HTMLfilm = file_get_contents('HTMLparts/download/film.html');
  $HTMLsearch=preg_split('/<\$>/',file_get_contents('HTMLparts/search.txt'),-1,PREG_SPLIT_NO_EMPTY);
  echo "<html>\r\n<head>\r\n<title>В Фильме | Скачать \"".$film['name']."\"</title>\r\n";
  echo "<meta http-equiv='keywords' content=' ".$film['name']." скачать' />";
  echo "\r\n<link rel='stylesheet' href='css/main.php' type='text/css' />\r\n";
  echo "\r\n<link rel='stylesheet' href='css/watch.php' type='text/css' />\r\n";
  echo $HTMLsearch[0];

//adv
/*
 $advn=6;//rand(1,7);
 $f=fopen("HTMLparts/adv.txt", "r");
 while(!feof($f) && $i<$advn){
    $advsource=fgets($f, 4096);
    $i+=1;
 }
 echo $advsource;
 fclose($f);
*/
include 'HTMLparts/adv.php';
//!adv

  echo $HTMLsearch[1];
  echo '<H1 class="resultslabel">';

//counter
  echo "\r\n<script language='JavaScript'>\r\n<!--\r\ncounterparam='img=${film['img']}';\r\n-->\r\n</script>\r\n";
  echo $film['name'];
  if($film['description']==''){$description='Отсутствует описание';}else{$description=$film['description'];};
  $description=preg_replace('|(_{20})_*|','$1',$description);
  $description=preg_replace('|[^\s<>]{25}|','$0 ',$description);
  echo '</H1>';
//  echo "\r\n<script language='JavaScript'>\r\n<!--\r\n document.title='В Фильме | ${film['name']}';\r\n-->\r\n</script>\r\n";
  
$HTMLfilm=str_replace('<$img>', $film['img'], $HTMLfilm);
$HTMLfilm=str_replace('<$watch$>', "http://vkontakte.ru/${film['watch']}", $HTMLfilm);
$HTMLfilm=str_replace('<$img$>', $film['img'], $HTMLfilm);
$HTMLfilm = str_replace('<$download$>', "download.php?film=${film['watch']}", $HTMLfilm);
if($film['description'] === '') { $film['description'] = 'Отсутствует описание.'; }
$HTMLfilm = str_replace('<$description$>', $film['description'], $HTMLfilm);
$HTMLfilm = str_replace('<$name$>', $film['name'], $HTMLfilm);
if($film['embed'])
{
    $HTMLfilm = str_replace('<$watch_vfilme$>', "watch.php?film=".$film['watch'], $HTMLfilm);
}
else
{
    $HTMLfilm = str_replace('<$watch_vfilme$>', "http://vkontakte.ru/${film['watch']}", $HTMLfilm);
}

echo $HTMLfilm;


  readfile('HTMLparts/search_end.txt');
  mysql_free_result($result);
  mysql_close($mysql);    
?>