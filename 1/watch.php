<?php
  
  if(count($_GET)>1 || $_SERVER['HTTP_HOST']=='vfilme.ru')
  {
    header("HTTP/1.1 301 Moved Permanently");
    header('Location: http://www.vfilme.ru/watch.php?film='.($_GET['film']));
  }


  function downloadlink($host,$vtag,$vkid)
  {
    return "http://$host/assets/videos/$vtag$vkid.vk.flv";
  }


//bd
  $mysql=mysql_connect("localhost", "vfilme", "wqGrhc9mDTtnePzt");
  mysql_query("set names cp1251");
  $fb=mysql_select_db("vfilme");


//заплатка
/*  if($_GET['film']==='video-1969106_117117319')
  {
    $_GET['film']='video-1792796_35754802';
  }*/
  $req="SELECT * FROM film WHERE watch='${_GET['film']}'";
  $result=mysql_query($req);  
  $film=mysql_fetch_assoc($result);


//достаем коменты
  $watch=htmlspecialchars($_GET['film'],ENT_QUOTES);
  $comm_res=mysql_query("SELECT * FROM comment WHERE film='$watch' ORDER BY -time");
  while($comment=mysql_fetch_assoc($comm_res))
  {
    $comm=$comment['text'];
    $comm=str_replace('&quot;','"',$comm);
    $comm=str_replace('&#39;',"'",$comm);
    $comm=str_replace('<br>',"\r\n",$comm);
    $comm=html_entity_decode($comm);
    $comm=htmlspecialchars($comm,ENT_QUOTES);
    $comm=str_replace("\r\n","<br>",$comm);
    $comms[]=$comm;
  }
  $comms=implode("\r\n<br><br><li>\r\n",$comms);


  //$HTMLfilm=preg_split('/<\$>/',file_get_contents('HTMLparts/watch/film.html'),-1,PREG_SPLIT_NO_EMPTY);
if ($film['watch']=='video-601394_74786758' || $film['watch']=='video-1884027_121897532' || $film['watch']=='video-1969106_70353608' || $film['watch']=='video-1792796_67541181' || $film['watch']=='video-1884027_108192913' || $film['watch']=='video-1969106_128808231' || $film['watch']=='video-1884027_97338049')
{
	$film['hd']=1;
}

if ($film['embed'])
{
   if($film['hd']==0)
   {
       $HTMLfilm = file_get_contents('HTMLparts/watch/film_embed_small_adv_vkb_marketgid.html');
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
//include 'HTMLparts/adv.php';
/*echo '<script src="js/adv.js">
      </script>';*/
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



if($comms)
{
	$film['description_with_comms']=$film['description']."
	<noscript>
		<div id=my_comments>
			<br><br>
			<b>Комментарии к фильму</b>
			<br><br>
			<ul>				<li>
			 $comms
			</ul>
		</div>
	</noscript>
	";
}



$HTMLfilm=str_replace('<$img>', $film['img'], $HTMLfilm);
$HTMLfilm=str_replace('<$name$>', $film['name'], $HTMLfilm);
$HTMLfilm=str_replace('<$watch$>', "http://vkontakte.ru/${film['watch']}", $HTMLfilm);
$HTMLfilm=str_replace('<$img$>', $film['img'], $HTMLfilm);
$HTMLfilm = str_replace('<$download$>', "download.php?film=${film['watch']}", $HTMLfilm);
if($film['description'] === '') { $film['description'] = 'Отсутствует описание.'; }
$HTMLfilm = str_replace('<$description$>', $film['description'], $HTMLfilm);
$HTMLfilm = str_replace('<$description_with_comms$>', $film['description_with_comms'], $HTMLfilm);
$HTMLfilm = str_replace('<$embed$>', $film['embed'], $HTMLfilm);
$HTMLfilm = str_replace('<$url$>', 'http://vfilme.ru'.$_SERVER['REQUEST_URI'], $HTMLfilm);
$HTMLfilm = str_replace('<$description_vkb$>', str_replace("<br>",'/',$film['description']), $HTMLfilm);

echo $HTMLfilm;

  readfile('HTMLparts/search_end.txt');
  mysql_free_result($result);
  mysql_close($mysql);    

?>

<script type='text/javascript'>


  wt=0;

  setInterval('wt=wt+1',1000)

  function sendstat()
  {	
	ajax.open('GET','stat/counter.php?wt='+wt,false);
	ajax.send(null);	
  }

//  document.body.setAttribute('onunload','sendstat();');

</script>