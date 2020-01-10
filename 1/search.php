<?php
  function RemoveRuEnd(&$words,$ruGlasn,$ruSogl)
  {
     foreach($words as $key => $word)
     {
       $words[$key]=preg_replace("/(\A.+[$ruGlasn]{1}.*[$ruSogl]{1})(а|и|я|ов|ей|ы|е|ах|ый|ек|ого|ых|ой|ые|ом|их)\z/iU",'$1',$word);
     }
  }

  function MakeSqlQuery($words,$iwords,$wordsfull,$iwordsfull,$owner,$letter,&$cond,&$orderby)
  {
    $cond='TRUE ';
    if(count($words)+count($iwords)>0){
      $orderby=' 1';
      foreach($words as $key => $word)
      {        
        $pos="INSTR(LOWER(name),'$word')";
        $cond.="AND $pos>0 ";
        $orderby.="+6*ORD(MID(nameindex,4*$pos-3,1))+3*(ORD(MID(nameindex,4*$pos-2,1))-LENGTH('$word'))-".(1*strlen($word));
      }   
      if(count($words)>0){$orderby.="+1*LENGTH(realname)";};
      foreach($iwords as $key => $word)
      {        
        $pos="INSTR(LOWER(description),'$word')";
        $cond.="AND $pos>0 ";
        $orderby.="+6*ORD(MID(descindex,4*$pos-3,1))+3*(ORD(MID(descindex,4*$pos-2,1))-LENGTH('$word'))";
      }   
      $orderby.=',';
    }  
    if (! $owner=='')
    {
      $cond.="AND owner='$owner'";
    };
    if (! $letter=='' || $letter=='0')
    {
      $cond.="AND LOWER(LEFT(realname,1))='$letter'";
    }
    $orderby.=' realname,LOWER(name),-LENGTH(description)';
    return(true);
  }

  function gethideddesc(&$desc1,&$desc2,$fulldesc,$iwords)
  {
    $fulldesc=preg_replace('|(_{60})_*|','$1',$fulldesc);
    $fulldesc=preg_replace('|[^\s<>]{60}|','$0<br/>',$fulldesc);
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
    foreach($films as $key => $film)
    {


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
      }
      else
      {
  
        if($opentoo)
        {
            readfile('HTMLparts/search/tooresult_end.txt');
            $opentoo=false;
        };

        if(! $advwas && $key>=1)  
        {
   
          //readfile('HTMLParts/search_adv.txt');
          $advwas=true;   

        }


      }
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

  function getlettern($l)
  {
    $n= ord($l);
    if ($n>=224){$n+=-224+26;}
    elseif ($n>=0x61){$n+=-0x61;}
    elseif ($n>=0x30){$n+=-0x30+58;}
    return $n;
  }

  function parsekeywords($keyex)
  {
    preg_match_all('/([^\W\d_]+|[\d]+)/s',$keyex,$arr);
    $keywords=$arr[0];
    foreach($keywords as $key => $word)
    {
      $keywords[$key]=strtolower($word);
    };
    return $keywords;
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

setlocale(LC_ALL, 'ru_RU.CP1251');
$name=strtolower($_GET['name']);
if ($name=='порно' || $name=='porno' || $name=='порнуха' || $name=='порево' ||$name=='porn' || $name=='лезби'){header('Location: /porn/access.php');die();}

$video_name = trim($_GET['name']);
if (preg_match('|\Ahttp://vkontakte.ru/video-{0,1}[\d]+_[\d]+\Z|', $video_name)) { header("Location: video.php?video=$video_name"); die(); };

  $ruGlasn='аеёиоуыэюя';
  $ruSogl='бвгджзклмнпрстфхцчшщ';
  $definfo='режиссер, актеры, жанр, страна, год и т.д.';
  $name=html_entity_decode($_GET['name']);
  $words=parsekeywords($name);
  $wordsfull=$words;
  if (! ($_GET['info']==$definfo)){$info=html_entity_decode($_GET['info']);}
  $iwords=parsekeywords($info);
  $iwordsfull=$iwords;
  $letter=$_GET['l'];
  $owner=$_GET['owner'];
  RemoveRuEnd($words,$ruGlasn,$ruSogl);
  RemoveRuEnd($iwords,$ruGlasn,$ruSogl);
  $HTMLfilm=preg_split('/<\$>/',file_get_contents('HTMLparts/search/film.html'),-1,PREG_SPLIT_NO_EMPTY);
  $type=$_GET['type'];
  if(((int)$_GET['page'])==0){$page=1;}else{$page=(int)$_GET['page'];};
  $ninpage=20;
  $HTMLsearch=preg_split('/<\$>/',file_get_contents('HTMLparts/search.txt'),-1,PREG_SPLIT_NO_EMPTY);
  $HTMLclaim=preg_split('/<\$>/',file_get_contents('HTMLparts/search/claim.html'),-1,PREG_SPLIT_NO_EMPTY);

  echo "<html>\r\n<head>\r\n<title>В Фильме | Поиск ";
  if (! ($name=='')){echo "\"$name\" ";};
  if (! $info==''){echo "с \"$info\" ";};
  if (! $owner=='')
  {
    if($owner=='club29991')
    {
       echo '"Советские психоделические мультфильмы"'; 
    }
    else if($owner=='club445750')
    {
      echo '"Советские мультики и детские фильмы"'; 
    }
    else if($owner=='club61972')
    {
      echo '"Чёрные фильмы"'; 
    }
    else 
    {
      echo "в группе \"$owner\" ";
    }
    
  };
  if (! $letter=='' || $letter=='0'){echo 'на букву "'.strtoupper($letter).'" ';};
  echo '</title>'."\r\n";
  echo '<meta name="keywords" content="скачать фильмы,смотреть фильмы онлайн, скачать мультфильмы, смотреть мультфильмы"></meta>';
  echo "\r\n<link rel='stylesheet' href='css/main.php' type='text/css' />\r\n";
  echo "\r\n<link rel='stylesheet' href='css/search.php' type='text/css' />\r\n";
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
  if ($type=='quick'){echo "\r\n<script language='JavaScript'>\r\n<!--\r\ndocument.getElementById('quicksearch').className='opensearch';\r\n document.forms[0].elements[0].value='${_GET['name']}';\r\n-->\r\n</script>\r\n";};
  if ($type=='ext'){
    echo "\r\n<script language='JavaScript'>\r\n<!--\r\ndocument.getElementById('extsearch').className='opensearch';\r\n document.forms[1].elements[0].value='${_GET['name']}';\r\ndocument.forms[1].elements[2].value='${_GET['owner']}';\r\n";
    if(! $info==''){echo "document.forms[1].elements[1].value='$info';\r\ndocument.forms[1].elements[1].className='';\r\n";};
    echo "-->\r\n</script>\r\n";
  };
  if ($type=='' && (($letter=='0' || ! $letter==''))){$lettern=getlettern($letter)+1;echo "\r\n<script language='JavaScript'>\r\n<!--\r\ndocument.getElementById('lettersearch').className='opensearch';\r\n document.links[$lettern].id='selectedl';\r\n-->\r\n</script>\r\n";}

  echo '<div class="closesearch" id="lastsearch"><a class="searchlabel" href="index.php">top 100 фильмов</a></div>';

  $mysql=mysql_connect("localhost", "vfilme", "wqGrhc9mDTtnePzt");
  mysql_query("set names cp1251");
  $fb=mysql_select_db("vfilme");

  MakeSqlQuery($words,$iwords,$wordsfull,$iwordsfull,$owner,$letter,$cond,$orderby);
  mysql_query("SELECT id FROM film WHERE $cond AND flag<=10");  
  $nfilm=mysql_affected_rows($mysql);
  $result=mysql_query("SELECT * FROM film WHERE $cond AND flag<=10 GROUP BY img ORDER BY $orderby LIMIT ".($page-1)*$ninpage.", $ninpage");  
  $pagesstr=showpages($page,(int)(($nfilm-1)/$ninpage)+1);
  echo $pagesstr;
  echo "<div class='resultslabel'>\r\n<H2>Результаты поиска: $nfilm ".filmpadeg($nfilm)." </H2></div>\r\n"; 

  if ($nfilm==0 && (!($name==''))){
    echo $HTMLclaim[0];
    echo $name;
    echo $HTMLclaim[1];
  } 
  else
  {
    readfile('HTMLParts/search_adv.txt');
  }

  $films=Array();
  while($film=mysql_fetch_assoc($result))
  {
    $films[]=$film;
  }


  MakeHTML($films,$HTMLfilm,$iwords);
  $nfilmonpage=$nfilm-($page-1)*$ninpage;
  if($nfilmonpage>3)
  {
    echo '<div style="height:15px;width:100%;"></div>';
    echo $pagesstr;
    echo "<div class='resultslabel'>\r\n<a href=#top id='ontoplink'>К началу страницы</a>\r\n</div>\r\n";
  }  
  readfile('HTMLparts/search_end.txt');
  mysql_free_result($result);
  mysql_close($mysql);    
?>