<?php		
	
	function parse_all_series_page_club_allfilms($text)
	{
		preg_match_all('|<a class="wikiVideo" href="(.*)"><img alt="(.*)"|iU',$text,$matches,PREG_SET_ORDER);	
		foreach($matches as $match)
		{
			if (strpos($match[2],'англ')===false)
			{
				preg_match('/([\d]+) (?:серия|Серия)/',$match[2],$m);
				//print_r($m);
				$series=$m[1];
				$watch=strstr($match[1],'vid');
				//$watch=$match[1];
				$films[]=Array('series' => $series, 'watch' => $watch);
			}
		}
		return $films;
	}		
	
	function parse_all_series_page_club_allfilms_v2($text)
	{
		preg_match_all('|<a class="wikiVideo" href="(.*)"><img alt="([^"]*)"|iU',$text,$matches,PREG_SET_ORDER);	
		foreach($matches as $match)
		{
			if (strpos($match[2],'англ')===false)
			{
				preg_match('|серия ([\d]+)|',$match[2],$m);
				//print_r($m);
				$series=$m[1];
				$watch=strstr($match[1],'vid');
				$films[]=Array('series' => $series, 'watch' => $watch);
			}
		}
		return $films;
	}	

	function parse_all_series_page_club_allfilms_v3($text)
	{
		preg_match_all('|<a class="wk_video" href="([^"]*)"[^>]*><img alt="([^"]*)"|iU',$text,$matches,PREG_SET_ORDER);	

		foreach($matches as $match)
		{
			if (strpos($match[2],'англ')===false)
			{
				preg_match('|([\d]+) серия|',$match[2],$m);
				//print_r($m);
				$series=$m[1];
				$watch=strstr($match[1],'vid');
				//$watch=$match[1];
				$films[]=Array('series' => $series, 'watch' => $watch);
			}
		}

		return $films;
	}

	function parse_all_series_page_club_allfilms_v4($text)
	{
		preg_match_all('|<a class="wikivideo" href="([^"]*)"[^>]*><img alt="([^"]*)"|iU',$text,$matches,PREG_SET_ORDER);	

		foreach($matches as $match)
		{
			if (strpos($match[2],'англ')===false)
			{
				preg_match('/(?:X|x|х|Х)([\d]+)/',$match[2],$m);
				//print_r($m);
				$series=(int)$m[1];
				$watch=strstr($match[1],'vid');
				//$watch=$match[1];
				$films[]=Array('series' => $series, 'watch' => $watch);
			}
		}

		return $films;
	}
?>