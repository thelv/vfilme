<?php
	$extended_search['name_encoded']=urlencode($extended_search['name']);
	$extended_search['info_encoded']=urlencode($extended_search['info']);
	$extended_search['genre_encoded']=urlencode($extended_search['genre']);
	$extended_search['last_page']=(int)($extended_search['films_number']/$extended_search['films_on_page'])+1;

	if($extended_search['genre']=='black') 
	{
		$extended_search['genre_black']='selected';
	}
	elseif($extended_search['genre']=='multfilms')
	{
		$extended_search['genre_multfilms']='selected';
	}
	else
	{
		$extended_search['genre_any']='selected';
	}
	
	if($extended_search['PART']=='title'): 
		echo "В Фильме | Поиск фильмов \"${search['request']}\"";
	elseif($extended_search['PART']=='keywords'):
		echo "фильм ${search['request']}, фильм ${search['request']} смотреть онлайн";	
	elseif(! $extended_search['PART']):		
?>
		<div id=center_row class=search_films>
			<form id=extended_search>
				<table cellpadding=0 cellspacing=0>
					<tr>
						<td colspan=2>
							<h1>Расширенный поиск фильмов</h1>
						</td>
					<tr>
						<td>
							Название:
						</td>
						<td>
							<input type=text name="name" value="<?php echo htmlspecialchars($extended_search['name'],ENT_QUOTES);?>"><br>
							<span><b>только</b> название фильма</span>
						</td>
					</tr>
					<tr>
						<td>
							Описание:
						</td>
						<td>
							<input type=text name="info" value="<?php echo htmlspecialchars($extended_search['info'],ENT_QUOTES);?>"><br>
							<span>любая информация о фильме (страна, год, режиссер, актеры и т.п.)</span>
						</td>
					</tr>						
					<tr>
						<td>
							Жанр:
						</td>
						<td>
							<select name="genre">
								<option <?php echo $extended_search['genre_any']; ?> value="">любой</option>
								<option <?php echo $extended_search['genre_multfilms']; ?> value="multfilms">советские и российские мультфильмы</option>
								<option <?php echo $extended_search['genre_black']; ?> value="black">чёрные фильмы</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
						</td>
						<td>
							<input type=submit value="искать фильмы">
						</td>
					</tr>
				</table>
			</form>			
	<?php if(! $extended_search['no_request']): ?>			
			<h1>По вашему запросу найден<?php echo verb_ending($extended_search['films_number']).' '.(int)$extended_search['films_number'].' фильм'.noun_ending($extended_search['films_number']); ?></h1>	
			
			<div class=pages>				
				<?php
					$pages['page']=$page;
					$pages['last_page']=$extended_search['last_page'];
					$pages['url']="?name=${extended_search['name_encoded']}&info=${extended_search['info_encoded']}&genre=${extended_search['genre_encoded']}&page=";
					include includeblock('pages');  
				?>
			</div>			
			<?php			
				foreach($extended_search['films'] as $search_film)
				{
					include includeblock('search_film');
				}
			?>				
			<div class=pages id=bottom_pages>				
				<?php
					$pages['page']=$page;
					$pages['last_page']=$extended_search['last_page'];
					$pages['url']="?name=${extended_search['name_encoded']}&info=${extended_search['info_encoded']}&genre=${extended_search['genre_encoded']}&page=";
					include includeblock('pages');  
				?>
			</div>			
			
		</div>
	<?php endif; ?>
<?php endif; ?>