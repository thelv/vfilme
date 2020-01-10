<?php
  function gethideddesc(&$desc1,&$desc2,$fulldesc,$iwords)
  {
    $fulldesc=preg_replace('|(_{60})_*|','$1',$fulldesc);
    $maxn=7;
    preg_match_all('/([^<>]{70}|<br\/>|<br>)/iUs',$fulldesc,$arr,PREG_OFFSET_CAPTURE,$maxn);
    //print_r($arr);
    if(count($iwords)>0)
    {
      foreach($iwords as $iword){
        $iwordsstr.="|$iword";
      };
      $iwordsstr=substr($iwordsstr,1);
      preg_match_all("/($iwordsstr)/iUs",$fulldesc,$arrf,PREG_OFFSET_CAPTURE);
      $findn=count($arrf[0]);
      $maxfind=$arrf[0][$findn-1][1]+strlen($arrf[0][$findn-1][0]);
      $fulldesc=preg_replace("/($iwordsstr)/iUs",'<span class="findtext">$1</span>',$fulldesc);
    };
    if (! $arr[0][$maxn-1]==NULL)
    {
      if($arr[0][$maxn-2][0]=='<br>' || $arr[0][$maxn-2][0]=='<br/>')
      {$tab=$arr[0][$maxn-2][1];}else{$tab=$arr[0][$maxn-1][1];};
      $tab=max($tab,$maxfind)+30*$findn+28*($maxfind>$tab-28);
      $desc1=substr($fulldesc,0,$tab);$desc2=substr($fulldesc,$tab,strlen($fulldesc));
    }
    else{$desc1=$fulldesc;$desc2='';};
  }

  function MakeHTML($films,$HTMLfilm,$iwords)
  {
    $opentoo=false;
    $HTMLtoorestab='<a class="toorestab" onclick="closetoores(this)"></a>';
    $lastrealname='([$//specsimbol';
    foreach($films as $key=>$film)
    {

   
//     if ($key==1){readfile('HTMLParts/search_adv.txt');};

     if ((! ($film['img']==$lastimg)) || (strlen($lastdesc) < strlen($film['description'])))
     { 
      if ($lastrealname==$film['realname'] || $film['img']==$lastimg)
      {
        if(! $opentoo)
        {
          readfile('HTMLparts/search/tooresult.txt');
          $opentoo=true;
        }
        echo $HTMLtoorestab;
      }elseif($opentoo)
      {
          readfile('HTMLparts/search/tooresult_end.txt');
          $opentoo=false;
      };
      gethideddesc($desc1,$desc2,$film['description'],$iwords);
      if($desc2==''){$description=$desc1;}
      else{$description="$desc1<span class='hidedesc'><span>$desc2</span> <a class='deschider' onclick='showhidedesc(this);'>далее...</a></span>";};
      $altfilmname=preg_replace('|[\'<>"]|iU','',$film['name']);
      echo "${HTMLfilm[0]}watch.php?film=${film['watch']}${HTMLfilm[1]}${film['img']}\" alt=\"смотреть онлайн, скачать $altfilmname${HTMLfilm[2]}${film['name']}${HTMLfilm[3]}${description}${HTMLfilm[4]}watch.php?film=${film['watch']}${HTMLfilm[5]}".downloadlink($film['watch']/*$film['host']*/,$film['vtag'],$film['vkid'])."${HTMLfilm[6]}img=${film['img']}${HTMLfilm[7]}";
      $lastrealname=$film['realname'];
      $lastimg=$film['img'];
      $lastdesc=$film['description'];
     }
    } 
    if($opentoo){readfile('HTMLparts/search/tooresult_end.txt');}
  }

  function makequery($arr)
  {
    foreach($_GET as $key => $value){
      if($arr[$key]===''){}elseif($arr[$key]==''){$res.="&$key=$value";}
    }
    foreach($arr as $key => $value){
      if($arr[$key]===''){}else{$res.="&$key=$value";};
    }
    return $res;
  }

  function pagelink($page)
  {
    return '?'.makequery(array('page' => $page));
  }
  function pageform()
  {
    foreach($_GET as $key => $value){
      if($key!=='page'){$res.="<input type=hidden name='$key' value='$value'>";}
    }
    return $res;
  }
  function showpages($page, $last)
  {
   if($last<=1){return '';}else{
     $res="<div class='pages'>\r\nстр. "; 
     $min=max(1,$page-2);
     $max=min($last,$min+4);
     $min=min($min,max(1,$max-4));
     $i=$min+1;
     if ($min==1){$i=$min;}else{$res.="<a href='".pagelink(1)."'>..</a><span></span>";}
     if($max==$last){$maxi=$max;}else{$maxi=$max-1;};
     while($i<=$maxi){
       if ($i==$page)
       {if(!($page==1)){$res.='&nbsp;';};$res.="<form method=get action=''>".pageform()."<input style='width:".((strlen($page)*8+5)+2*($page<10)).";' type=text name=page value=$page></form>";if(!($page==$last)){$res.='&nbsp;';};}else
       {$res.="<a href='".pagelink($i)."'>$i</a>";if(!($i==$page-1) && !($i==$max)){$res.='<span></span>';};};
       $i+=1;
     }
     if(!($max==$last)){$res.="<a href='".pagelink($last)."'>..</a>";};
     $res.="\r\n</div>\r\n";
   //  if($page>=10){$res.="<script language=JavaScript>\r\n<!--\r\ndocument.getElementById('pageform').style.width=".(strlen($page)*8+5).";\r\n-->\r\n</script>\r\n";}
     return $res;
   }
  }

  function downloadlink($host,$vtag,$vkid)
  {
    //return "http://$host/assets/videos/$vtag$vkid.vk.flv";

    return "download.php?film=$host";
  }

  function filmpadeg($n)
  {
    $n=strval($n);
    $len=strlen($n);
    if($n>10){$n2=$n{$len-2};};
    if($n2==1){return 'фильмов';}else
    {
      $n1=$n{$len-1};
      if($n1==0 || $n1>=5){return 'фильмов';}elseif($n1==1){return 'фильм';}else{return 'фильма';};
    }
  }

  $definfo='режиссер, актеры, жанр, страна, год и т.д.';
  $owner=$_GET['owner'];
  $HTMLfilm=preg_split('/<\$>/',file_get_contents('HTMLparts/index/film.html'),-1,PREG_SPLIT_NO_EMPTY);
  $type=$_GET['type'];
  if(!($type)){$type='quick';};
  if(((int)$_GET['page'])==0){$page=1;}else{$page=(int)$_GET['page'];};
  $ninpage=20;
  $HTMLsearch=preg_split('/<\$>/',file_get_contents('HTMLparts/search.txt'),-1,PREG_SPLIT_NO_EMPTY);
  $npageontop=100;

  echo "<html>\r\n<head>\r\n<title>В Фильме | Скачать фильмы, Смотреть фильмы онлайн, Поиск фильмов ВКонтакте ";
  if (! $owner==''){echo "в группе \"$owner\" ";};
  if (! $letter=='' || $letter=='0'){echo 'на букву "'.strtoupper($letter).'" ';};
  echo '</title>'."\r\n";
  echo '<meta name="keywords" content="скачать фильмы,смотреть фильмы онлайн, скачать мультфильмы, смотреть мультфильмы"></meta>';
  echo "\r\n<link rel='stylesheet' href='css/main.php' type='text/css' />\r\n";
  echo "\r\n<link rel='stylesheet' href='css/search.php' type='text/css' />\r\n";
  echo "\r\n<link rel='stylesheet' href='css/index.php' type='text/css' />\r\n";
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
//include 'HTMLparts/adv.php';
//!adv
  echo $HTMLsearch[1];
  if ($type=='quick'){echo "\r\n<script language='JavaScript'>\r\n<!--\r\ndocument.getElementById('quicksearch').className='opensearch';\r\n-->\r\n</script>\r\n";};
  if ($type=='ext'){
    echo "\r\n<script language='JavaScript'>\r\n<!--\r\ndocument.getElementById('extsearch').className='opensearch';\r\n document.forms[1].elements[0].value='${_GET['name']}';\r\ndocument.forms[1].elements[2].value='${_GET['owner']}';\r\n";
    echo "-->\r\n</script>\r\n";
  };
  if ($type=='l'){echo "\r\n<script language='JavaScript'>\r\n<!--\r\ndocument.getElementById('lettersearch').className='opensearch';\r\n-->\r\n</script>\r\n";}

//  echo '<div class="closesearch" id="lastsearch"><a class="searchlabel" href="claims.php">фильмы по заявкам</a></div>';
//  echo '<div id="lastsearch"></div>';
  $mysql=mysql_connect("localhost", "vfilme", "wqGrhc9mDTtnePzt");
  mysql_query("set names cp1251");
  $fb=mysql_select_db("vfilme");
  //$result=mysql_query("SELECT * FROM film F,count_ C WHERE F.host=C.host AND F.vtag=C.vtag AND F.vkid=C.vkid GROUP BY img");  
  $nfilm=$npageontop;
  //$result=mysql_query("SELECT * FROM (SELECT *,count(*) as pop FROM film F,count_ C WHERE F.host=C.host AND F.vtag=C.vtag AND F.vkid=C.vkid GROUP BY img) as NT ORDER BY NT.pop DESC LIMIT ".($page-1)*$ninpage.", $ninpage");  
  //$result=mysql_query("SELECT * FROM popular2 P,film F WHERE P.film_Id=F.Id  LIMIT ".($page-1)*$ninpage.", $ninpage");  
  $date=intval(time()/200000)-1;
//  $result=mysql_query("SELECT * FROM top P,film F WHERE P.img=F.img AND date=$date AND F.watch<>'video-601394_74786758' AND F.watch<>'video-1884027_121897532' AND F.watch<>'video-1969106_70353608' AND F.watch<>'video-1792796_67541181' AND F.watch<>'video-1884027_108192913' AND F.watch<>'video-1969106_128808231' AND F.watch<>'video-1884027_97338049' GROUP BY P.img ORDER BY -P.pop LIMIT ".($page-1)*$ninpage.", $ninpage");  
//  $result=mysql_query("SELECT * FROM (SELECT * FROM top WHERE date=$date GROUP BY img ORDER BY -pop LIMIT ".($page-1)*$ninpage.", $ninpage) P, film F WHERE P.img=F.img AND F.watch<>'video-601394_74786758' AND F.watch<>'video-1884027_121897532' AND F.watch<>'video-1969106_70353608' AND F.watch<>'video-1792796_67541181' AND F.watch<>'video-1884027_108192913' AND F.watch<>'video-1969106_128808231' AND F.watch<>'video-1884027_97338049' GROUP BY P.img ORDER BY -P.pop");  
  $result=mysql_query("SELECT * FROM cache_top F WHERE F.watch<>'video-601394_74786758' AND F.watch<>'video-1884027_121897532' AND F.watch<>'video-1969106_70353608' AND F.watch<>'video-1792796_67541181' AND F.watch<>'video-1884027_108192913' AND F.watch<>'video-1969106_128808231' AND F.watch<>'video-1884027_97338049' LIMIT ".($page-1)*$ninpage.", $ninpage");  
  $pagesstr=showpages($page,(int)(($nfilm-1)/$ninpage)+1);
  echo $pagesstr;
  echo "<div class='resultslabel'>\r\n<H2>Top 100 ".filmpadeg(100)." </H2></div>\r\n"; 
  $films=Array();
  while($film=mysql_fetch_assoc($result))
  {
    $films[]=$film;
  }

  readfile('HTMLParts/search_adv.txt');

  
  MakeHTML($films,$HTMLfilm,$iwords);
  $nfilmonpage=$nfilm-($page-1)*$ninpage;
  if($nfilmonpage>3)
  {
    echo '<div style="height:15px;width:100%;"></div>';
    echo $pagesstr;
    echo "<div class='resultslabel'>\r\n<a href=#top>К началу страницы</a>\r\n</div>\r\n";
  }  
  readfile('HTMLparts/search_end.txt');

  mysql_free_result($result);
  mysql_close($mysql);    
?>

<script type="text/javascript">
  document.forms[0].name.focus();
</script>