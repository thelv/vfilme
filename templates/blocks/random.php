<?php
	if($random['PART']=='title'):
		echo "В Фильме | Случайный фильм (если не знаете что смотреть)";
	elseif($random['PART']=='keywords'):
		echo "случайный фильм, подобрать фильм, случайный фильм смотреть онлайн";	
	elseif(! $random['PART']):
?>
		<div id=center_row class=search_films>
			<h1>Случайный фильм</h1>		
			<form id=random onsubmit="get_random_film();return false;">
				<!-- <input type=hidden name=film value="<?php $random['next_film']; ?>"> -->
				<input type=submit value="показать другой">
			</form>
			<div id=random_film>
			<?php			
				$search_film=$random['film'];
				include includeblock('search_film');			
			?>				
			</div>
		</div>
<?php endif; ?>