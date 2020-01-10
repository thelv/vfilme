<?php
	function gethideddesc(&$desc1,&$desc2,$fulldesc,$iwords,$maxn,$linelen)
	{
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
	
	function makehideddesc($description, $searchwords, $maxn)
	{
		$description=iconv('UTF-8','cp1251',$description);		
		gethideddesc($desc1,$desc2,$description,$searchwords,$maxn,70);
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
		return $description;
	}	
	
?>