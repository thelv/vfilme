<?php		
	$alphabet['Letter']=utfToUpper($alphabet['letter']);
	//$alphabet['letter']=mb_strtolower($alphabet['letter']);
	$alphabet['letter_type']=is_numeric($alphabet['letter']) ? 'цифру' : 'букву';
	$alphabet['letter_encoded']=urlencode($alphabet['letter']);
	$alphabet['last_page']=(int)($alphabet['films_number']/$alphabet['films_on_page'])+1;
	if($alphabet['PART']=='title'): 
		echo "В Фильме | Все фильмы на ${alphabet['letter_type']} \"${alphabet['Letter']}\"";
	elseif($alphabet['PART']=='keywords'):
		echo "фильмы на ${alphabet['letter_type']} ${alphabet['letter']}, фильмы на ${alphabet['letter_type']} ${alphabet['letter']} смотреть онлайн, фильмы начинающиеся на ${alphabet['letter']}, фильмы начинающиеся на ${alphabet['letter']} смотреть онлайн";
	elseif(! $alphabet['PART']):
?>
		<div id=center_row class=search_films>
			<h1>
				Все фильмы, начинающиеся на <?php echo "\"${alphabet['Letter']}\""; ?> 				
			</h1>
			<div class=pages>				
				<?php
					$pages['page']=$page;
					$pages['last_page']=$alphabet['last_page'];
					$pages['url']="?letter=${alphabet['letter_encoded']}&page=";
					include includeblock('pages');  
				?>
			</div>					
			<?php
				foreach($alphabet['films'] as $search_film)
				{
					include includeblock('search_film');
				}
			?>									
			<div class=pages id=bottom_pages>				
				<?php
					$pages['page']=$page;
					$pages['last_page']=$alphabet['last_page'];
					$pages['url']="?letter=${alphabet['letter_encoded']}&page=";
					include includeblock('pages');  
				?>
			</div>
		</div>
<?php endif; ?>