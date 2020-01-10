<?php
  function downloadlink($host,$vtag,$vkid)
  {
    return "http://$host/assets/videos/$vtag$vkid.vk.flv";
  }

  $video_name = trim($_GET['video']);
  if (! preg_match('|\Ahttp://vkontakte.ru/video-{0,1}[\d]+_[\d]+\Z|', $video_name)) { header("Location: search.php?type=quick&name=".urlencode($video_name)); die(); };
  
//bd
  $mysql=mysql_connect("mediasaver.ru", "mediasav_vfilme", "tae6Tack");
  $fb=mysql_select_db("wwwmediasaverru_vfilme");
  mysql_query("set names cp1251");
  //$fb=mysql_select_db("dreamsa0_films");

  $req="SELECT * FROM film WHERE watch='${_GET['film']}'";
  $result=mysql_query($req);  
  $film=mysql_fetch_assoc($result);

//html

  $HTMLfilm = file_get_contents('HTMLparts/video/film.html');
  $HTMLsearch=preg_split('/<\$>/',file_get_contents('HTMLparts/search.txt'),-1,PREG_SPLIT_NO_EMPTY);
  echo "<html>\r\n<head>\r\n<title>В Фильме | Смотреть онлайн, скачать \"".$film['name']."\"</title>\r\n";
  echo "<meta http-equiv='keywords' content='".$film['name']." смотреть онлайн, ".$film['name']." скачать' />";
  echo "\r\n<link rel='stylesheet' href='css/main.php' type='text/css' />\r\n";
  echo "\r\n<link rel='stylesheet' href='css/watch.php' type='text/css' />\r\n";
  echo $HTMLsearch[0];

//adv
/*
  $f=fopen("HTMLparts/adv.txt", "r");
  $advsource=fgets($f, 4096);
  echo $advsource;
  fclose($f);
*/
  include 'HTMLparts/adv.php';

  echo $HTMLsearch[1];
  echo '<H1 class="resultslabel">';

//counter
  echo "\r\n<script language='JavaScript'>\r\n<!--\r\ncounterparam='img=${film['img']}';\r\n-->\r\n</script>\r\n";
  echo 'Скачать видео ВКонтакте';
  if($film['description']==''){$description='Отсутствует описание';}else{$description=$film['description'];};
  $description=preg_replace('|(_{20})_*|','$1',$description);
  $description=preg_replace('|[^\s<>]{25}|','$0 ',$description);
  echo '</H1>';
//  echo "\r\n<script language='JavaScript'>\r\n<!--\r\n document.title='В Фильме | ${film['name']}';\r\n-->\r\n</script>\r\n";
  
$watch = htmlspecialchars($_GET['video']);

$HTMLfilm=str_replace('<$watch$>', $watch, $HTMLfilm);

echo $HTMLfilm;


  readfile('HTMLparts/search_end.txt');
  mysql_free_result($result);
  mysql_close($mysql);    
?>