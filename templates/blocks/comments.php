<?php		
	$comments['last_page']=(int)($comments['films_number']/$comments['films_on_page'])+1;
	if($comments['PART']=='title'): 
		echo "В Фильме | Обсуждение фильмов ";
	elseif($comments['PART']=='keywords'):
		echo "комментарии к фильмам, обсуждение фильмов";
	elseif($comments['PART']=='search_request'):
		echo $comments['request'];
	elseif(! $comments['PART']):
?>
		<div id=center_row class=search_films>
			<h1>Обсуждение фильмов</h1>
			
			<div style='padding:100px 0;color:#394;font-size:40px'>
				Этот раздел сайта еще не готов, заходите попозже!
			</div>
			
			<div class=pages>				
				<?php
					$pages['page']=$page;
					$pages['last_page']=$comments['last_page'];
					$pages['url']="?request=${search['request_encoded']}&page=";
					include includeblock('pages');  
				?>
			</div>			
			<?php
				foreach($comments['films'] as $search_film)
				{
					include includeblock('search_film');
				}
			?>						
			
			<div class=pages id=bottom_pages>				
				<?php
					$pages['page']=$page;
					$pages['last_page']=$comments['last_page'];
					$pages['url']="?request=${search['request_encoded']}&page=";
					include includeblock('pages');  
				?>
			</div>
		</div>
<?php endif; ?>