<?php

	$globals['serialsOnPage']=$serialsOnPage=30;

	function block($type, $params){
	
		compile_globals;
			
		switch($type):

			//serials
			
				case 'serials':
				
					sel($dat, 'serial limit='.($url['p']*$serialsOnPage).','.($serialsOnPage+1).'');
					$template='serials';
					break;
				
			//search	
			
				case 'search':
				
					$ids=search($url['q'], $url['p']*$serialsOnPage, $serialsOnPage+1);
					foreach($ids as $id) sel($dat, 'serial where=<`id`=$0id>');
					$template='serials';
					break;
					
			//pages
			
				case 'pages':
				
					sel($dat,'serial (count(*) count) limit=1');
					$template='pages';
					break;
					
			//autocompleteSerials
			
				case 'autocompleteSerials':
				
					sel($dat, 'serial (SQL_CACHE 1 1, *) order_by=<ru_title, title>');
					foreach($dat['serials'] as $serial)
					{
						$serials[]=array('value'=>($serial['ru_title'] ? $serial['ru_title'].' / ' : '').$serial['title'], 'data'=> $serial['alias']);
					}
					return json_encode($serials);
					
			default:
				
				$template='empty';
				
		endswitch;
		
		return render('blocks/'.$template, $dat);
		
	}

	switch($url['page']){		
						
		//ajax
		
			//serials
			
				case 'ajax/serials':
				
					echo block('serials');
					break;
					
			//search		
			
				case 'ajax/search':
					
					echo block('search');
					break;
			
		//! ajax
		
		//pages
		
			//serials
			
				case 'serials':
				
					$dat['blocks']['serials']=block('serials');
					$dat['blocks']['pages']=block('pages');
					$template='serials';
					break;
					
			//search		
			
				case 'search':
					
					$dat['blocks']['serials']=block('search');
					$template='search';
					break;
					
			//mySerials
			
				case 'mySerials':
				
					$ids=mySerials();
					foreach($ids as $id) sel($dat, 'serial where=<`id`=$0id>');
					$template='mySerials';
					break;
					
			//serial
			
				case 'serial':
				
					if($url['id'])
					{
						sel($dat, 'serial id=$0url[id]');
						header('HTTP/1.1 301 Moved Permanently');
						header('Location: '.url('serial', $dat['serial'], $url['season'], $url['serie'], $url['video']));
						die();
					}												
				
					if(! $season=$url['season']) $season=1;
					if(! $serie=$url['serie']) $serie=1;										
					
					sel($dat, '
						serial where=<`alias`=$"url[title]> limit=1
							serie order_by=<season, serie> where=<serie<>0> video limit=1!!
							serie where=<season=$0season and serie=$0serie> limit=1 video
					
					');
					
					$id=$dat['serial']['id'];
					
					if(! $url['season']) if($_COOKIE["m{$id}"]){
						
						list($season, $serie, $video)=explode('_', $_COOKIE["m{$id}"]);
						header('Location: '.url('serial', $dat['serial'], $season, $serie, $video)); 
						die();
					
					}

					if($url['season']){
						
						setcookie("m{$id}", "{$url['season']}_{$url['serie']}_{$url['video']}", time()+3600*24*1000, '/');
						
					}
					
					/*if(urlTitle($dat['serial'])!=$url['title']){

						header('HTTP/1.1 301 Moved Permanently');
						header('Location: '.url('serial', $dat['serial'], $url['season'], $url['serie'], $url['video']));
						die();
						
					}*/
					
					$template='serial';
					break;
		
		//! pages
		
		default;
			$template='error';
			$dat='404';
	
	}		
	
	if(! $template)
	{
		$template='empty';
	}
	echo render('pages/'.$template, $dat);

?>