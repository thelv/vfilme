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



  //$HTMLfilm=preg_split('/<\$>/',file_get_contents('HTMLparts/watch/film.html'),-1,PREG_SPLIT_NO_EMPTY);
if ($film['embed'])
{
   if($film['hd']==0)
   {
       $HTMLfilm = file_get_contents('HTMLparts/watch/film_embed_small.html');
   }
   else
   {
       $HTMLfilm = file_get_contents('HTMLparts/watch/film_embed.html');
   }
}
else
{
  $HTMLfilm = file_get_contents('HTMLparts/watch/film.html');
}
  $HTMLsearch=preg_split('/<\$>/',file_get_contents('HTMLparts/search.txt'),-1,PREG_SPLIT_NO_EMPTY);
//  echo "<html>\r\n<head>\r\n<title>В Фильме | Просмотр \"${_GET['text']}\"</title>\r\n";


 /* header('Location: http://vkontakte.ru/'.$film['watch']);
  mysql_free_result($result);
  mysql_close($mysql);    
  die();*/

  echo "<html>\r\n<head>\r\n<title>В Фильме | Смотреть онлайн \"".$film['name']."\"</title>\r\n";
  echo "<meta http-equiv='keywords' content='".$film['name']." смотреть онлайн' />";

  echo "\r\n<link rel='stylesheet' href='css/main.php' type='text/css' />\r\n";
  echo "\r\n<link rel='stylesheet' href='css/watch.php' type='text/css' />\r\n";
  echo $HTMLsearch[0];
//adv
/*  $f=fopen("HTMLparts/adv.txt", "r");
  $advsource=fgets($f, 4096);
  echo $advsource;
  fclose($f); */


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
  
/* OLD FILM HTML
echo $HTMLfilm[0].downloadlink($film['host'], $film['vtag'], $film['vkid']).$HTMLfilm[1]."http://vkontakte.ru/${film['watch']}".$HTMLfilm[2].$film['host'].$HTMLfilm[3].$film['vtag'].$HTMLfilm[4].$film['vkid'].$HTMLfilm[5].$description.$HTMLfilm[6];
*/

if($film['embed'] && $film['hd']==0){$film['embed']=str_replace('"607"','"480"',$film['embed']);}


$HTMLfilm=str_replace('<$img>', $film['img'], $HTMLfilm);
$HTMLfilm=str_replace('<$name$>', $film['name'], $HTMLfilm);
$HTMLfilm=str_replace('<$watch$>', "http://vkontakte.ru/${film['watch']}", $HTMLfilm);
$HTMLfilm=str_replace('<$img$>', $film['img'], $HTMLfilm);
$HTMLfilm = str_replace('<$download$>', "download.php?film=${film['watch']}", $HTMLfilm);
if($film['description'] === '') { $film['description'] = 'Отсутствует описание.'; }
$HTMLfilm = str_replace('<$description$>', $film['description'], $HTMLfilm);
$HTMLfilm = str_replace('<$embed$>', $film['embed'], $HTMLfilm);

echo $HTMLfilm;

  readfile('HTMLparts/search_end.txt');
  mysql_free_result($result);
  mysql_close($mysql);    

?>