<?php
	if($new['PART']=='title'): 
		echo "В Фильме | Новинки кино / Новые фильмы 2010-2011";
	elseif($new['PART']=='keywords'):
		echo "новинки кино, новые фильмы 2010, новые фильмы 2011, новинки кино смотреть онлайн, новые фильмы смотреть онлайн";
	elseif(! $new['PART']):
?>
		<div id=center_row class=search_films>
			<h1>Новинки мирового кинопроката / Новые фильмы 2010-2011</h1>	
			<?php
				foreach($new['films'] as $search_film)
				{					
						include includeblock('search_film');
				}
			?>								
		</div>
<?php endif; ?>