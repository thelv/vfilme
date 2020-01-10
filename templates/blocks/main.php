<?php
	if($main['PART']=='title'): 
		echo "В Фильме - смотреть фильмы онлайн, скачать фильмы, поиск фильмов ВКонтакте.";
	elseif($main['PART']=='keywords'):
		echo "смотреть фильмы онлайн, смотреть фильмы, фильмы онлайн, скачать фильмы, фильмы, фильмы вконтакте, смотреть фильмы вконтакте";
	elseif(! $main['PART']):
?>
		<div class=big_row type=films>
			<div>
				<a class=big_link href="index.php?page=1">Популярные фильмы</a>
				<?php 
					foreach($main['pop_films'] as $main_film)
					{
						include includeblock('main_film');
					}
				?>				
				<a href="index.php?page=1" class=else>Все пуполярные →</a>
			</div>
		</div>
		<div class=big_row type=films>
			<div>
				<a class=big_link href="new.php">Новинки кинопроката</a>				
				<?php 
					foreach($main['new_films'] as $main_film)
					{
						include includeblock('main_film');
					}
				?>			
				<a href="new.php" class=else>Все новинки →</a>
			</div>			
		</div>
		<div class=big_row id=last_row type=comments>
			<div>
				<a class=big_link href="comments.php">Обсуждение фильмов</a>				
				<?php
					foreach($main['comments'] as $main_comment)
					{
						$main_comment['viewout_watch']=viewout_line($main_comment['watch']);
						$main_comment['viewout_name']=viewout_line($main_comment['name']);
						$main_comment['viewout_text']=viewout_block($main_comment['text']);
						echo "
				<div>
					<a title='смотреть онлайн' href='watch.php?film=${main_comment['viewout_watch']}'>${main_comment['viewout_name']}</a> - ${main_comment['viewout_text']}
				</div>
						";
					}
				?>
				<a href="comments.php" class=else>Все обсуждения →</a>
			</div>
		</div>	
<?php endif; ?>