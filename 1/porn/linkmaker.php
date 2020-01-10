<?php

 function RemoveRuEnd($word,$ruGlasn,$ruSogl)
{
       $newword=preg_replace("/(\A.+[$ruGlasn]{1}.*[$ruSogl]{1})(а|и|я|ов|ей|ы|е|ах|ый|ек|ого|ых|ой|ые|ом|их)\z/iU",'$1',$word);
       return $newword;
}

  function HTTPAnswer($domen,$headers,$postquery)
  {

    $IPAdress=gethostbyname('vkadre.ru');
    $port=80;
    $s=socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    $a=socket_connect($s,$IPAdress,$port);
    if ($a==True) {
      socket_write($s,$headers);
      if ($postquery<>''){socket_write($s,'Content-Length: '.strlen($postquery)."\r\n\r\n$postquery");}
      else{socket_write($s,"\r\n");}       
      $res='';
      while ($resadd=socket_read($s,2048))
      {$res.=$resadd;}
      socket_shutdown($s);    
      socket_close($s);   
      return $res;
    }else{return '!cant_connect!';} 
  }
  
  function getsourse($img)
  {
    $host='vkadre.ru';
    $img=substr($img,16,1000);
   echo $img;
    $hdrs="GET $img HTTP/1.1\r\n".
"Host: $host\r\n".
'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.1.15) Gecko/20080623 AdCentriaIM/1.7 Firefox/2.0.0.15
Connection: close
Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5
Accept-Language: ru-ru,ru;q=0.8,en-us;q=0.5,en;q=0.3
Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7
Connection: Close
Referer: http://vkontakte.ru/video.php
';
    $res=HTTPAnswer('vkontakte.ru',$hdrs,'');
echo $hdrs;
    return $res;
  }  


function getvparam($img,&$host,&$vkid,&$vtag){
  if ($img{7}==v){
  $src=getsourse($img);  
  echo $src;
  preg_match('|Location: (.*)\r\n|iU',$src,$arr);
  $link=$arr[1];
  preg_match('|http://(.*)/assets/thumbnails/(.{8})(.*)\.|iU',$link,$arr);
  $host=$arr[1];$vtag=$arr[2];$vkid=$arr[3];
  echo '1';
  }
  else
  {
   preg_match('|http://(.*)/assets/thumbnails/(.{8})(.*)\.|U',$img,$vdprms);
   $host=$vdprms[1];
   $vtag=$vdprms[2];
   $vkid=$vdprms[3];
  }
}


if($_GET['p']!=='mkjhfggfhjkm'){die();}

setlocale(LC_ALL, 'ru_RU.CP1251');
  $q="SELECT * FROM porn2 WHERE host='' LIMIT 100 ;";
 
  $mysql=mysql_connect("localhost", "dreamsa0_admin", "pi2Jogodi");
  mysql_query("set names cp1251");
  $fb=mysql_select_db("dreamsa0_films");
  $result=mysql_query($q);
  while($film=mysql_fetch_assoc($result))
  {
print_r($film);
    if (! ($film['host'])){getvparam($film['img'],$host,$vkid,$vtag);};
      
//    echo $strindex;
    $q="UPDATE porn2 SET flag=2000,host='$host',vkid='$vkid',vtag='$vtag' WHERE id=${film['Id']}";
    echo $q;
    if (! ($film['host'])){$fb=mysql_query($q);};
    echo $fb;
  };
  mysql_free_result($result);
  mysql_close($mysql);    
echo '123';

?>