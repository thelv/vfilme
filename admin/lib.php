<?php

function access()
{
	session_start();
	global $_SESSION;
	if ($_SESSION['admin']===true)
	{
		return true; 
	}
	else
	{
		if ($_POST['pass']==='goodrule')
		{
			$_SESSION['admin']=true;
			return true;
		};
		die('<form method=post><input type=password name=pass></form>');
		return false;
	}
}

function realname($name)
{
    $name=preg_replace('|\A[\W]*фильм[\s]*[^\w\s]+|i','',$name,1);
    $name=preg_replace('|\A[\W]|','',$name,1);
    $name=preg_replace('|[\[\(/].*|','',$name);
    $name=preg_replace('/([^\w\d]|_)/','',$name);
    $name=preg_replace('|Є|','е',$name);
    $name=strtolower($name);
    $name=preg_replace('/(целыйфильм|фильмцеликом|смотретьвсем|полныйфильм)/','',$name);
    return $name;
}

function RemoveRuEnd($word,$ruGlasn,$ruSogl)
{
       $newword=preg_replace("/(\A.+[$ruGlasn]{1}.*[$ruSogl]{1})(а|и|€|ов|ей|ы|е|ах|ый|ек|ого|ых|ой|ые|ом|их)\z/iU",'$1',$word);
       return $newword;
}

function makeindex($str)
{
  $strindex=' ';
  $ruGlasn='аеЄиоуыэю€';
  $ruSogl='бвгджзклмнпрстфхцчшщ';
  preg_match_all('/([^\W\d_]+|[\d]+)/s',$str,$words,PREG_OFFSET_CAPTURE);
  foreach($words[0] as $word)
  {
    $len=strlen($word[0]); 
    $pos=$word[1];
    $i=0;
    while($i<$len){
      $strindex{4*($pos+$i)}=chr($i);
      $strindex{4*($pos+$i)+1}=chr($len-$i);
      $i+=1;
    }
    $newword=RemoveRuEnd($word[0],$ruGlasn,$ruSogl);
    $len=strlen($newword);
    $i=0;
    while($i<$len){
      $strindex{4*($pos+$i)+2}=chr($i);
      $strindex{4*($pos+$i)+3}=chr($len-$i);
      $i+=1;
    }
  }
  $i=0;
/*  while($i<40)
  {  echo '<font color=red> | </font>';
    echo " $i: <b>".ord($strindex{$i})." </b>; ";
    $i+=1;
    echo " $i: <b>".ord($strindex{$i})." </b>; ";
    $i+=1;
    echo " $i: <b>".ord($strindex{$i})." </b>; ";
    $i+=1;
    echo " $i: <b>".ord($strindex{$i})." </b>; ";
    $i+=1;
  }
  echo ' !!!!! ';
  echo strlen($strindex);*/
  return $strindex;
}


function connect_db()
{
	$mysql=mysql_connect("localhost", "vfilme", "wqGrhc9mDTtnePzt");
	mysql_select_db("vfilme");
	mysql_query("set names cp1251");
}

function add_db()
{
	$query_str = "INSERT INTO film (`Id`,`name`,`owner`,`description`,`img`,`watch`,`long`,`host`,`vtag`,`vkid`,`realname`,`weight`,`nameindex`,`descindex`,`flag`,`timeflag`) VALUES(NULL,'','','','','',0,'','','','',NULL,'','',2000,5);";
	mysql_query($query_str);
	$id=mysql_insert_id();
	return $id;
}

function read_db(&$id,&$name,&$desc,&$img,&$watch,&$embed,&$flag)
{
	if($id=(int)$id)
	{
		$query_str = "SELECT * FROM film WHERE Id=$id";
	}
	else
	{
		$watch = mysql_real_escape_string($watch);
		$query_str = "SELECT * FROM film WHERE watch='$watch'";

	}
	$res=mysql_query($query_str);
	if(! $film=mysql_fetch_assoc($res)){return false;}
	$id=$film['Id'];
	$name=$film['name'];
	$desc=$film['description'];
	$img=$film['img'];	
	$watch=$film['watch'];
	$embed=$film['embed'];
	$flag=$film['flag'];
}

function edit_db($id,$name,$desc,$img,$watch,$embed,$flag)
{
	if(! $id){return false;}
	if(! $name){$name='(NONAME)';}	
	$flag=(int)$flag;
	if(! $flag){$flag=10;}
	$realname=realname($name);
	$nameindex=makeindex($name);
	$desc=str_replace("\r\n",'<br>',$desc);
	echo $desc;
	$descindex=makeindex($desc);
	$name=mysql_real_escape_string($name);
	$desc=mysql_real_escape_string($desc);
	$realname=mysql_real_escape_string($realname);
	$nameindex=mysql_real_escape_string($nameindex);
	$descindex=mysql_real_escape_string($descindex);
	$img=mysql_real_escape_string($img);
	$embed=mysql_real_escape_string($embed);
	$watch=mysql_real_escape_string($watch);	
	$query_str = "UPDATE film SET name='$name',description='$desc',hd=1,img='$img',watch='$watch',realname='$realname',nameindex='$nameindex',descindex='$descindex',embed='$embed',flag=$flag WHERE Id=$id";			
	mysql_query($query_str);	
}


function get_season_id($serial_id, $season)
{
	$dbquery_serial_id=(int)$serial_id;
	$dbquery_season=(int)$season;
	$res=mysql_query("SELECT id FROM `season` WHERE `serial`=$dbquery_serial_id AND season=$dbquery_season");
	if($finded_season=mysql_fetch_assoc($res))
	{
		return $finded_season['id'];
	}
	else
	{
		return 0;
	}
}

function add_season($serial_id,$season)
{
	$dbquery_serial_id=(int)$serial_id;
	$dbquery_season=(int)$season;

	mysql_query("INSERT INTO season (`serial`, `season`, `series_number`) VALUES ($dbquery_serial_id, $dbquery_season, 2)");
	return mysql_insert_id();
}

function add_season_if_not_exists($serial_id, $season)
{	
	if($id=get_season_id($serial_id, $season))
	{
		return $id;
	}
	else
	{
		return add_season($serial_id, $season);
	}
}

function add_one_series_to_season($serial_id, $season, $series, $watch)
{
	$season_id=add_season_if_not_exists($serial_id, $season);
	return add_one_series($season_id, $series, $watch);
}

function add_one_series($season_id,$series,$watch)
{
	$dbquery_watch=mysql_real_escape_string($watch);
	$dbquery_season_id=(int)$season_id;
	$dbquery_series=(int)$series;
	
	mysql_query("INSERT INTO series (`season`, `series`, `film`) VALUES ($dbquery_season_id, $dbquery_series, '$dbquery_watch')");
	return mysql_insert_id();
}



?>