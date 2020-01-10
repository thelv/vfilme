<?php
	// <!-- string functions
	function toUTF($str)
	{
		return iconv("cp1251", "UTF-8", $str);
	}
	
	function toCP1251($str)
	{
		return iconv("UTF-8", "cp1251", $str);
	}
	
	function utfToLower($str)
	{
		return toUTF(strtolower(toCP1251($str)));
	}
	
	function utfToUpper($str)
	{
		return toUTF(strtoupper(toCP1251($str)));
	}
	
	function html_line_out($text)
	{
		// <!-- обратна€ совместимость
		$text=iconv("cp1251", "UTF-8", $text);		
		$text=html_entity_decode($text,ENT_QUOTES,"UTF-8");			
		// обратна€ совместимость -->
		return $text;
	}
	
	function html_block_out($text)
	{
		// <!-- обратна€ совместимость
		$text=iconv("cp1251", "UTF-8", $text);		
		$text=str_replace('<br>',"\r\n",$text);
		$text=html_entity_decode($text,ENT_QUOTES);//,"UTF-8");
		// обратна€ совместимость -->			
		return $text;
	}	
	
	function vk_comment_out($comm)
	{
		$comm=iconv("cp1251", "UTF-8", $comm);
		$comm=str_replace('<br>',"\r\n",$comm);
		$comm=html_entity_decode($comm,ENT_QUOTES,"UTF-8");		
		return $comm;
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
		$dbquery_n0=(int)$n0;
		$dbquery_n=(int)$n;
		$date=intval(time()/200000)-1;
		//$res=mysql_query("SELECT * FROM (SELECT * FROM top WHERE date=$date GROUP BY img ORDER BY -pop LIMIT $n0, $n) P,film F WHERE P.img=F.img GROUP BY P.img ORDER BY -pop");
		$res=mysql_query("SELECT * FROM cache_top F WHERE F.watch<>'video-601394_74786758' AND F.watch<>'video-1884027_121897532' AND F.watch<>'video-1969106_70353608' AND F.watch<>'video-1792796_67541181' AND F.watch<>'video-1884027_108192913' AND F.watch<>'video-1969106_128808231' AND F.watch<>'video-1884027_97338049' LIMIT $dbquery_n0, $dbquery_n");
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
		$dbquery_n0=(int)$n0;
		$dbquery_n=(int)$n;
		$res=mysql_query("SELECT * FROM film WHERE flag=10 GROUP BY img ORDER BY -`Id` LIMIT $dbquery_n0, $dbquery_n");  
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
	
	function mult_films_count()
	{
		$res=mysql_query("SELECT SQL_CACHE count(*) AS count FROM (SELECT * FROM film WHERE owner='club29991' OR owner='club445750' GROUP BY img) temp");
		$result=mysql_fetch_assoc($res);
		mysql_free_result($res);
		return $result['count'];
	}
	
	function get_mult_films($n0,$n)
	{		
		$dbquery_n0=(int)$n0;
		$dbquery_n=(int)$n;
		$res=mysql_query("SELECT * FROM film WHERE owner='club29991' OR owner='club445750' GROUP BY img ORDER BY -`Id` LIMIT $dbquery_n0, $dbquery_n");
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
	
	function films_on_letter($letter,$n0,$n,&$films_number)
	{
		$letter=toCP1251(deleteQuotes($letter));
		$letter=strtoupper($letter{0});
		$dbquery_letter=mysql_real_escape_string($letter);
		$dbquery_n0=(int)$n0;
		$dbquery_n=(int)$n;
		if(! $letter) return;
		$n0=(int)$n0;
		$n=(int)$n;	

		$res=mysql_query("SELECT SQL_CACHE count(*) AS count FROM film WHERE UPPER(LEFT(name,1))='${dbquery_letter}'");
		$result=mysql_fetch_assoc($res);
		mysql_free_result($res);
		$films_number=$result['count'];
		
		$res=mysql_query("SELECT * FROM film WHERE UPPER(LEFT(name,1))='${dbquery_letter}' ORDER BY realname, LOWER(name), -LENGTH(description) LIMIT $dbquery_n0,$dbquery_n");		
		while($film=mysql_fetch_assoc($res))
		{
			$film['name']=html_line_out($film['name']);
			$film['description']=html_block_out($film['description']);
			$films[]=$film;
		}
		mysql_free_result($res);
		return $films;
	}
	
	function search_films($request,$n0,$n,&$films_number,$info='',$genre='')
	{
		function parsekeywords($keyex)
		{
			preg_match_all('/([^\W\d_]+|[\d]+)/s',$keyex,$arr);
			$keywords=$arr[0];
			foreach($keywords as $key => $word)
			{
				$keywords[$key]=strtolower($word);
			}
			return $keywords;
		}	
		
		function RemoveRuEnd(&$words,$ruGlasn,$ruSogl)
		{
			foreach($words as $key => $word)
			{
				$words[$key]=preg_replace("/(\A.+[$ruGlasn]{1}.*[$ruSogl]{1})(а|и|€|ов|ей|ы|е|ах|ый|ек|ого|ых|ой|ые|ом|их)\z/iU",'$1',$word);
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
				if(count($words)>0){$orderby.="+1*LENGTH(realname)";}
				foreach($iwords as $key => $word)
				{        
					$pos="INSTR(LOWER(description),'$word')";
					$cond.="AND $pos>0 ";
					$orderby.="+6*ORD(MID(descindex,4*$pos-3,1))+3*(ORD(MID(descindex,4*$pos-2,1))-LENGTH('$word'))";
				}   
				$orderby.=',';
			}  
			if ($owner=='black')
			{
				$cond.="AND owner='club61972'";
			}
			elseif ($owner=='multfilms')
			{
				$cond.="AND (owner='club29991' OR owner='club445750')";
			}
			if (! $letter=='' || $letter=='0')
			{
				$cond.="AND LOWER(LEFT(realname,1))='$letter'";
			}
			$orderby.=' realname,LOWER(name),-LENGTH(description)';
			return(true);
		}
							
		$n0=(int)$n0;
		$n=(int)$n;
		$films_number=(int)$films_number;
		$genre=deleteQuotes($genre);
		$request=toCP1251($request);			
		$request=deleteQuotes($request);
		$keywords=parsekeywords($request);	
		$info=toCP1251($info);
		$info=deleteQuotes($info);
		$infokeywords=parsekeywords($info);
		$ruGlasn='аеЄиоуыэю€';
		$ruSogl='бвгджзклмнпрстфхцчшщ';  
		RemoveRuEnd($keywords,$ruGlasn,$ruSogl);		
		RemoveRuEnd($infokeywords,$ruGlasn,$ruSogl);		
		MakeSqlQuery($keywords,$infokeywords,$wordsfull,$iwordsfull,$genre,$letter,$cond,$orderby);		
		mysql_query("SELECT id FROM film WHERE $cond AND flag<=10 GROUP BY img");  				
		$films_number=(int)mysql_affected_rows();
		$res=mysql_query("SELECT * FROM film WHERE $cond AND flag<=10 GROUP BY img ORDER BY $orderby LIMIT $n0, $n");				
		while($film=mysql_fetch_assoc($res))
		{
			$film['name']=html_line_out($film['name']);
			$film['description']=html_block_out($film['description']);
			$films[]=$film;
		}
		mysql_free_result($res);			

		return $films;
		
	}
	
	function get_last_comments($n)
	{
		$dbquery_n=(int)$n;
		$res=mysql_query("SELECT * FROM (SELECT * FROM comment ORDER BY Id DESC LIMIT $dbquery_n) C, film F WHERE C.film=F.watch ORDER BY C.Id DESC");
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
		
	function get_one_film($watch)
	{
		$dbquery_watch=mysql_real_escape_string($watch);
		$res=mysql_query("SELECT S.Id AS serial_id, S.options AS serial_options, S.name, S.seasons_number, E.season , E.series_number, R.series, F.watch, F.img, F.embed, F.description, F.name AS series_vk_name FROM serial S, season E, series R, film F WHERE R.film='$dbquery_watch' AND F.watch=R.film AND R.season=E.Id AND E.serial=S.Id");
		if($film=mysql_fetch_assoc($res))
		{					
			$film['serial_id']=(int)$film['serial_id'];
			$film['name']=html_line_out($film['name']);
			$film['series_vk_name']=html_line_out($film['series_vk_name']);
			$film['description']=html_block_out($film['description']);				
			mysql_free_result($res);
		}
		else
		{			
			mysql_free_result($res);
			$res=mysql_query("SELECT * FROM film WHERE watch='$dbquery_watch'");					
			$film=mysql_fetch_assoc($res);							
			$film['name']=html_line_out($film['name']);		
			$film['description']=html_block_out($film['description']);
		}
		mysql_free_result($res);		
		return $film;
	}
	
	function get_serial_by_id($serial_id)
	{
		$dbquery_serial_id=(int)$serial_id;
		$res=mysql_query("SELECT * FROM serial WHERE serial.Id=$dbquery_serial_id");
		$serial=mysql_fetch_assoc($res);
		$serial['name']=html_block_out($serial['name']);		
		mysql_free_result($res);
		return $serial;
	}
	
	function get_series($serial,$season)
	{
		$dbquery_serial=(int)$serial;
		$dbquery_season=(int)$season;
		$res=mysql_query("SELECT R.series AS series, F.watch AS watch, F.img AS img, F.description AS description FROM season E, series R, film F WHERE E.serial=$dbquery_serial AND E.season=$dbquery_season AND R.season=E.Id AND F.watch=R.film");
		while($film=mysql_fetch_assoc($res))
		{		
			$film['name']=html_line_out($film['name']);
			$film['description']=html_block_out($film['description']);
			$films[$film['series']]=$film;
		}
		mysql_free_result($res);		
		return $films;
	}		
	
	function get_random_film()
	{
		$res=mysql_query('SELECT SQL_CACHE MIN(Id) AS mn, MAX(Id) AS mx FROM film');
		$result=mysql_fetch_assoc($res);
		$min=$result['mn'];
		$max=$result['mx'];		
		$id=rand($min,$max);			
		mysql_free_result($res);
		$res=mysql_query("SELECT * FROM film WHERE Id=${id} LIMIT 1");
		$film=mysql_fetch_assoc($res);
		$film['name']=html_line_out($film['name']);		
		$film['description']=html_block_out($film['description']);
		mysql_free_result($res);
		return $film;
	}
	
	function get_film_comments($watch)
	{	
		$dbquery_watch=mysql_real_escape_string($watch);
		$res=mysql_query("SELECT * FROM comment WHERE film='$dbquery_watch' ORDER BY -time");
		$comms=Array();
		while($comment=mysql_fetch_assoc($res))
		{
			$comm=$comment['text'];
			$comm=str_replace('&quot;','"',$comm);
			$comm=str_replace('&#39;',"'",$comm);
			$comm=str_replace('<br>',"\r\n",$comm);
			$comm=html_entity_decode($comm);			
			$comm=toUTF($comm);
			$comms[]=$comm;
		}	
		return $comms;
	}
	
	function get_last_films_comments()
	{
		
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