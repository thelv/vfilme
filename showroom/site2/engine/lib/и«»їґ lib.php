<?php
	function deleteQuotes($str)
	{
		$str=str_replace("'",'',$str);
		$str=str_replace('"','',$str);
		return $str;
	}

	function db_connect()
	{
		global $db_server;
		global $db_user;
		global $db_pass;
		mysql_connect($db_server,$db_user,$db_pass);
		mysql_query("SET NAMES cp1251");		
		mysql_select_db("vfilme");
	}

	function get_popular_films($n0,$n)
	{
		$date=intval(time()/200000)-1;
		$res=mysql_query("SELECT * FROM top P,film F WHERE P.img=F.img AND date=$date AND F.watch<>'video-601394_74786758' AND F.watch<>'video-1884027_121897532' AND F.watch<>'video-1969106_70353608' AND F.watch<>'video-1792796_67541181' AND F.watch<>'video-1884027_108192913' AND F.watch<>'video-1969106_128808231' AND F.watch<>'video-1884027_97338049' GROUP BY P.img ORDER BY -P.pop LIMIT $n0, $n");
		$films=Array();
		while($film=mysql_fetch_assoc($res))
		{
			$film['name']=htmlspecialchars(iconv("cp1251", "UTF-8", $film['name']),ENT_QUOTES);
			$film['description']=iconv("cp1251", "UTF-8", $film['description']);
			$films[]=$film;
		}
		return $films;
	}
	
	function get_new_films($n0,$n)
	{
		$res=mysql_query("SELECT * FROM film WHERE flag=10 GROUP BY img ORDER BY -`Id` LIMIT $n0, $n");  
		$films=Array();
		while($film=mysql_fetch_assoc($res))
		{
			$film['name']=htmlspecialchars(iconv("cp1251", "UTF-8", $film['name']),ENT_QUOTES);
			$film['description']=iconv("cp1251", "UTF-8", $film['description']);
			$films[]=$film;
		}
		return $films;
	}
	
	function get_mult_films($n0,$n)
	{
		$res=mysql_query("SELECT * FROM film WHERE owner='club29991' OR owner='club445750' GROUP BY img ORDER BY -`Id` LIMIT $n0, $n");  
		$films=Array();
		while($film=mysql_fetch_assoc($res))
		{
			$film['name']=htmlspecialchars(iconv("cp1251", "UTF-8", $film['name']),ENT_QUOTES);
			$film['description']=iconv("cp1251", "UTF-8", $film['description']);
			$films[]=$film;
		}
		return $films;
	}
	
	function get_one_film($watch)
	{		
		$res=mysql_query("SELECT * FROM film WHERE watch='$watch'");		
		$film=mysql_fetch_assoc($res);		
		$film['name']=htmlspecialchars(iconv("cp1251", "UTF-8", $film['name']),ENT_QUOTES);
		$film['description']=iconv("cp1251", "UTF-8", $film['description']);
		return $film;
	}			
?>