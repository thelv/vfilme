<?php
	$search['request_encoded']=urlencode($search['request']);
	$search['request']=htmlspecialchars($search['request'],ENT_QUOTES);
	$search['last_page']=(int)($search['films_number']/$search['films_on_page'])+1;
	if($search['PART']=='title'): 
		echo "В Фильме | Поиск фильмов \"${search['request']}\"";
	elseif($search['PART']=='keywords'):
		echo "фильм ${search['request']}, фильм ${search['request']} смотреть онлайн";
	elseif($search['PART']=='search_request'):
		echo $search['request'];
	elseif(! $search['PART']):
?>
		<div id=center_row class=search_films>
			<h1><?php echo 'Найден'.verb_ending($search['films_number']).' '.(int)$search['films_number'].' фильм'.noun_ending($search['films_number'])." по запросу \"${search['request']}\""; ?></h1>
			<div class=pages>				
				<?php
					$pages['page']=$page;
					$pages['last_page']=$search['last_page'];
					$pages['url']="?request=${search['request_encoded']}&page=";
					include includeblock('pages');  
				?>
			</div>
			<?php
				foreach($search['films'] as $search_film)
				{
					include includeblock('search_film');
				}
			?>									
			<div class=pages id=bottom_pages>				
				<?php
					$pages['page']=$page;
					$pages['last_page']=$search['last_page'];
					$pages['url']="?request=${search['request_encoded']}&page=";
					include includeblock('pages');  
				?>
			</div>
		</div>
<?php endif; ?>