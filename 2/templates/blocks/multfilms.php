<?php
	if($multfilms['PART']=='title'): 
		echo "В Фильме | Советские и российские мультфильмы";
	elseif($multfilms['PART']=='keywords'):
		echo "советские мультфильмы, российские мультфильмы";
	elseif(! $multfilms['PART']):
?>
		<div id=center_row class=search_films>
			<h1>Советские мультфильмы</h1>
			<div class=pages>	
				<?php
					$pages['page']=$page;
					$pages['last_page']=(int)($multfilms['films_number']/$multfilms['films_on_page'])+1;
					$pages['url']='?page=';
					include includeblock('pages');
				?>
			</div>
			<?php
				foreach($multfilms['films'] as $search_film)
				{
					include includeblock('search_film');
				}
			?>				
			<div class=pages id=bottom_pages>	
				<?php
					$pages['bottom']=true;
					include includeblock('pages');					
				?>			
			</div>
		</div>
<?php endif; ?>