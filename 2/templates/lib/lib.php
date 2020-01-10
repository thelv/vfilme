<?php
	function viewout_line($text)
	{
		return htmlspecialchars($text,ENT_QUOTES);
	}
	
	function viewout_block($text)
	{
		$text=htmlspecialchars($text,ENT_QUOTES);
		$text=str_replace("\n","",$text);
		$text=str_replace("\r",'<br>',$text);
		return $text;
	}

	function includeblock($block,$part='',$options=Array())
	{		 
		global ${$block};
		${$block}['PART']=$part;		
		${$block}['OPTIONS']=$options;
		return "templates/blocks/${block}.php";
	}
	
	function preparevkiframe(&$iframe,$watch,$film)
	{
		//return str_replace('</iframe>',"\r\n<a href='http://vkontakte.ru'>Смотреть \"${film}\"  ВКонтакте</a>\r\n</iframe>",$iframe);
		if(strpos($iframe,'&hd=')===false)
		{
			$iframe=str_replace('"607"','"480"',$iframe);
			return '480';
		}
		else
		{
			return '607';
		}
	}

/*	function gethideddesc2(&$desc1,&$desc2,$fulldesc,$iwords,$maxn,$linelen)
	{
		$fulldesc=str_replace("\r",'',$fulldesc);
		$fulldesc=str_replace("\n",'',$fulldesc);
		$fulldesc=str_replace('<br>',"\r",$fulldesc);
		$fulldesc=html_entity_decode($fulldesc,"ENT_QUOTES");
		$i=0;
		while($linen<$maxn)
		{
			$i
		}
	}
*/

	function get_hided_desc($text,$text1,$text2,$max_line_number,$line_len)
	{
		$len=strlen($text);
		while($pos<$len && $line_number<$max_line_number)
		{
			$rn_pos=strpos($text,"\r\n",$pos);
			if($rn_pos===false || $rn_pos-$pos>$line_len)
			{
				$pos=$pos+$line_len;
				$line_number++;
			}
			else
			{
				$pos=$rn_pos+2;
				$line_number++;
			}
		}
		$text1=substr($text,0,$pos-1);
		$text2=substr($text,$pos);
	}
	
	function gethideddesc(&$desc1,&$desc2,$fulldesc,$iwords,$maxn,$linelen)
	{
		//setlocale(LC_ALL, 'ru_RU.UTF8');
		$fulldesc=preg_replace('|(_{60})_*|','$1',$fulldesc);		
		preg_match_all('/([^<>]{'.$linelen.'}|<br\/>|<br>)/iUs',$fulldesc,$arr,PREG_OFFSET_CAPTURE,$maxn);
		//print_r($arr);
		if(count($iwords)>0)
		{
			foreach($iwords as $iword)
			{
				$iwordsstr.="|$iword";
			}
			$iwordsstr=substr($iwordsstr,1);
			preg_match_all("/($iwordsstr)/iUs",$fulldesc,$arrf,PREG_OFFSET_CAPTURE);
			$findn=count($arrf[0]);
			$maxfind=$arrf[0][$findn-1][1]+strlen($arrf[0][$findn-1][0]);
			$fulldesc=preg_replace("/($iwordsstr)/iUs",'<span class="findtext">$1</span>',$fulldesc);
		}
		if (! $arr[0][$maxn-1]==NULL)
		{
			if($arr[0][$maxn-2][0]=='<br>' || $arr[0][$maxn-2][0]=='<br/>')
			{
				$tab=$arr[0][$maxn-2][1];
			}
			else
			{
				$tab=$arr[0][$maxn-1][1];
			}
			$tab=max($tab,$maxfind)+30*$findn+28*($maxfind>$tab-28);
			$desc1=substr($fulldesc,0,$tab);
			$desc2=substr($fulldesc,$tab,strlen($fulldesc));
		}
		else
		{
			$desc1=$fulldesc;
			$desc2='';
		};
	}
	
	function makehideddesc($description, $searchwords, $maxn, $linelen=70)
	{	
		$description=iconv('UTF-8','cp1251',$description);				
		gethideddesc($desc1,$desc2,$description,$searchwords,$maxn,$linelen);
		$desc1=iconv('cp1251','UTF-8',$desc1);
		$desc2=iconv('cp1251','UTF-8',$desc2);
		if($desc2=='')
		{			
			$description=$desc1;
		}
		else
		{			
			$description="$desc1<span class='hidedesc'><span>$desc2</span> <br> <a class='deschider' onclick='showhidedesc(this);'>далее...</a></span>";
		}
		$description=str_replace("\r\n","\r",$description);
		$description=str_replace("\n","",$description);
		$description=str_replace("\r",'<br>',$description);
		return $description;
	}	
	
	function makeshortdesc($description, $maxn)
	{
		$description=iconv('UTF-8','cp1251',$description);		
		gethideddesc($desc1,$desc2,$description,Array(),$maxn,32);
		$desc1=iconv('cp1251','UTF-8',$desc1);
		$desc2=iconv('cp1251','UTF-8',$desc2);
		if($desc2=='')
		{			
			$description=$desc1;
		}
		else
		{			
			$description="$desc1.....";
		}
		$description=viewout_line($description);		
		$description=str_replace("\n","",$description);
		$description=preg_replace('|[\r][\r\s]*|'," • ",$description);
		return $description;
	}	
	
	function verb_ending($n)
	{
		if (substr((string)$n,-1)=='1')
		{
			return '';
		}
		else
		{
			return 'о';
		}
	}
	
	function noun_ending($n)
	{		
		$n=(int)$n;
		if ($n===1)
		{
			return '';
		}
		elseif ($n>1 && $n<5)
		{
			return 'а';			
		}
		else
		{
			return 'ов';
		}
	}

?>