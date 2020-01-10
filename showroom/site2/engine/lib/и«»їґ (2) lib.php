<?php
	// <!-- string functions
	function html_line_out($text)
	{
		$text=iconv("cp1251", "UTF-8", $text);
		$text=html_entity_decode($text,ENT_QUOTES,"UTF-8");
		return htmlspecialchars($text,ENT_QUOTES);
	}
	
	function html_block_out($text)
	{
		$text=iconv("cp1251", "UTF-8", $text);
		// <!-- обратна€ совместимость
		$text=str_replace('<br>',"\r\n",$text);
		$text=html_entity_decode($text,ENT_QUOTES);//,"UTF-8");
		// обратна€ совместимость -->
		$text=htmlspecialchars($text,ENT_QUOTES);
		$text=str_replace("\r\n",'<br>',$text);		
		return $text;
	}	
	
	function vk_comment_out($comm)
	{
		$comm=iconv("cp1251", "UTF-8", $comm);
		$comm=str_replace('<br>',"\r\n",$comm);
		$comm=html_entity_decode($comm,ENT_QUOTES,"UTF-8");
		$comm=htmlspecialchars($comm,ENT_QUOTES);
		return str_replace("\r\n","<br>",$comm);						
	}

	function deleteQuotes($str)
	{
		$str=str_replace("'",'',$str);
		$str=str_replace('"','',$str);
		return $str;
	}
	
	// string functions -->

	function db_connect()
	{
		global $db_server;
		global $db_user;
		global $db_pass;
		mysql_connect($db_server,$db_user,$db_pass);
		mysql_query("SET NAMES cp1251");		
		mysql_select_db("vfilme");
	}
	
	function db_close()
	{
		mysql_close();
	}

	function get_popular_films($n0,$n)
	{
		$date=intval(time()/200000)-1;
		//$res=mysql_query("SELECT * FROM (SELECT * FROM top WHERE date=$date GROUP BY img ORDER BY -pop LIMIT $n0, $n) P,film F WHERE P.img=F.img GROUP BY P.img ORDER BY -pop");						
		$res=mysql_query("SELECT * FROM cache_top LIMIT $n0, $n");
		$films=Array();
		while($film=mysql_fetch_assoc($res))
		{
			$film['name']=html_line_out($film['name']);
			$film['description']=html_block_out($film['description']);
			$films[]=$film;
		}		
		mysql_free_result($res);
		return $films;
	}
	
	function get_new_films($n0,$n)
	{
		$res=mysql_query("SELECT * FROM film WHERE flag=10 GROUP BY img ORDER BY -`Id` LIMIT $n0, $n");  
		$films=Array();
		while($film=mysql_fetch_assoc($res))
		{
			$film['name']=html_line_out($film['name']);
			$film['description']=html_block_out($film['description']);
			$films[]=$film;
		}
		mysql_free_result($res);
		return $films;
	}
	
	function get_mult_films($n0,$n)
	{
		$res=mysql_query("SELECT * FROM film WHERE owner='club29991' OR owner='club445750' GROUP BY img ORDER BY -`Id` LIMIT $n0, $n");  
		$films=Array();
		while($film=mysql_fetch_assoc($res))
		{
			$film['name']=html_line_out($film['name']);
			$film['description']=html_block_out($film['description']);
			$films[]=$film;
		}
		mysql_free_result($res);
		return $films;
	}
	
	/*function get_one_film($watch)
	{		
		$res=mysql_query("SELECT * FROM film WHERE watch='$watch'");		
		$film=mysql_fetch_assoc($res);				
		$film['name']=html_line_out($film['name']);		
		$film['description']=html_block_out($film['description']);		
		mysql_free_result($res);
		return $film;
	}*/			
	
	function get_last_comments($n)
	{
		$n=(int)$n;
		$res=mysql_query("SELECT * FROM (SELECT * FROM comment ORDER BY Id DESC LIMIT $n) C, film F WHERE C.film=F.watch ORDER BY C.Id DESC");
		while($comment=mysql_fetch_assoc($res))
		{
			$comment['name']=html_line_out($comment['name']);
			$comment['description']=html_block_out($comment['description']);
			$comment['text']=vk_comment_out($comment['text']);		
			$comments[]=$comment;			
		}
		mysql_free_result($res);
		return $comments;
	}
	
	function get_seasons_number($serial,&$name)
	{
		$res=mysql_query('SELECT seasons_number,name FROM serial WHERE serial.Id=$serial');
		$result=mysql_fetch_assoc($res);
		$name=$result['name'];
		mysql_free_result($res);
		return $result['seasons_number'];
	}
	
	//function get_series_by_film($watch, &$name, &$img, &$description, &$season, &$seasons_number, &$series, &$series_number)
	function get_series_by_film($watch)
	{
		$res=mysql_query('SELECT F.watch as watch, S.name AS name, S.seasons_number AS seasons_number, E.season AS season, E.series_number AS series_number, R.series AS series, F.watch AS watch, F.img AS img, F.description AS description FROM serial S, season E, series R, film F WHERE F.watch=R.watch AND R.season=E.season AND E.serial=S.Id');
		if($film=mysql_fetch_assoc($res))
		{			
			$film['name']=html_line_out($film['name']);		
			$film['description']=html_block_out($film['description']);				
			mysql_free_result($res);
		}
		else
		{			
			mysql_free_result($res);
			$res=mysql_query("SELECT * FROM film WHERE watch='$watch'");		
			$film=mysql_fetch_assoc($res);							
		}
		mysql_free_result($res);		
		return $film;
	}
	
	function get_series($serial,$season);
	{
		$serial=(int)$serial;
		$season=(int)$season;
		$res=mysql_query('SELECT R.series AS series, F.watch AS watch, F.img AS img, F.description AS description FROM season E, series R, film F WHERE E.serial=$serial AND E.season=$season AND R.season=E.Id AND film.watch=R.film');
		while($film=mysql_fetch_assoc($res))
		{
			$film['name']=html_line_out($film['name']);
			$film['description']=html_block_out($film['description']);
			$films[]=$film;
		}
		mysql_free_result($res);
	}
	
	function refresh_top()
	{
		$date=intval(time()/200000)-1;
		// <!-- с созданием таблицы
		// mysql_query("CREATE TABLE cache_top (Id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (Id)) TYPE=MyISAM SELECT F.watch AS watch, F.img AS img, F.name AS name, F.realname AS realname, F.description AS description, F.embed AS embed FROM (SELECT * FROM top WHERE date=$date GROUP BY img ORDER BY -pop LIMIT 0, 130) P,film F WHERE P.img=F.img GROUP BY P.img ORDER BY -pop");
		// с созданием таблицы -->
		mysql_query("TRUNCATE TABLE cache_top");
		mysql_query("INSERT INTO cache_top (watch, img, name, realname, description, embed) SELECT F.watch, F.img, F.name, F.realname, F.description, F.embed FROM (SELECT * FROM top WHERE date=$date GROUP BY img ORDER BY -pop LIMIT 0, 200) P,film F WHERE P.img=F.img GROUP BY P.img ORDER BY -pop");				
	}	
?>