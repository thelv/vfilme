<?php
	
	$globals['SERIALI']=$SERIALI=urlencode('сериалы');
	$globals['SEZON']=$SEZON=urlencode('сезон');
	$globals['SERIA']=$SERIA=urlencode('серия');
	$globals['MOI_SERIALI']=$MOI_SERIALI=urlencode('мои_сериалы');
	
	$globals['url']=&$url;

	$url_parts=parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	$url_parts=explode('/', $url_parts);
	
	if($url_parts[1]==$SERIALI && ! $url_parts[2])
	{
		if($_GET['q']=='')
		{
			$url['page']='serials';
		}
		else
		{
			$url['q']=$_GET['q'];
			$url['page']='search';
		}
		$url['p']=$_GET['p'];
	}
	elseif($url_parts[1]==$SERIALI)// && (int)($url_parts[2]))
	{
		$url['page']='serial';
		//$url['id']=(int)$url_parts[2];
		//$url['title']=urldecode(substr(strstr($url_parts[2], '_'), 1));
		$url['title']=urldecode($url_parts[2]);
		preg_match("/(\d+)_{$SEZON}(?:_(\d+)_{$SERIA}|)/iUs", $url_parts[3], $match);
		$url['season']=$match[1];
		$url['serie']=$match[2];
		$url['video']=$_GET['v'];
	}
	elseif($url_parts[1]==$MOI_SERIALI)
	{
		$url['page']='mySerials';
	}
	elseif($url_parts[1]=='serials')
	{
		if($url_parts[2]=='ajax')
		{
			if($url_parts[3]=='serials')
			{
				if($_GET['q']=='')
				{
					$url['page']='ajax/serials';
				}
				else
				{
					$url['page']='ajax/search';
					$url['q']=$_GET['q'];
				}
			}
			$url['p']=$_GET['p'];
		}
		elseif((int)$url_parts[2])
		{
			$url['page']='serial';
			$url['id']=(int)$url_parts[2];
			preg_match("/(\d+)_season(?:_(\d+)_episode|)/iUs", $url_parts[3], $match);
			$url['season']=$match[1];
			$url['serie']=$match[2];
			$url['video']=$_GET['v'];
		}
		elseif(! $url_parts[2])
		{
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: '.url('serials'));
			die();
		}
	
	}
	
	function urlTitle($serial){
	
		if(! $alias=$serial['ru_title']) $alias=$serial['title'];
		$alias=preg_replace('/[\,\.\:\-\/\s\;\!\?\"\']+/','_',$alias);
		$alias=mb_strtolower(preg_replace('/(\A_|_\Z)/','',$alias), 'UTF-8');		
		return $alias;
		
	}
	
	function url($page, $p1, $p2, $p3, $p4, $p5){
	
		compile_globals;

		switch($page){
					
			case 'serials':
			
				return "/{$SERIALI}".($p1 ? '?p=$0p1' : '');
				
			case 'serial':
			
				$id=$p1['id'];
				//$alias=str_replace(' ', '_', strtolower($p1['ru_title']));
				//$alias=preg_replace('/[^a-aA-Zа-яА-Я]+/','_',$p1['ru_title']);
				$alias=$p1['alias'];//urlTitle($p1);			
				$season=$p2;
				$serie=$p3;
				$video=$p4;
				return '/$=SERIALI/$?alias'.($season ? '/$0season._$=SEZON'.($serie ? '_$0serie._$=SERIA' : '') : '').($video ? '?v=$0video' : '');
				
			case 'mySerials':
			
				return "/{$MOI_SERIALI}";
				
			case 'search':
				
				return '/$=SERIALI?q=$?p2'.($p1 ? '&p=$0p1' : '');
					
			case 'ajax/serials':
			
				return '/serials/ajax/serials?q=$?p1&p=$0p2';
				
			case 'serialShort':
			
				$id=$p1['id'];
				$season=$p2;
				$serie=$p3;
				$video=$p4;
				return '/serials/$0id'.($season ? '/$0season._season'.($serie ? '_$0serie._episode' : '') : '').($video ? '?v=$0video' : '');
				
			case 'serialsShort':
				
				return '/serials';
				
			default:
			
				return 'error';			
		}
	}
	
?>