		<div id=left_row>	
			<div class=left_item>
				<a class=left_h href="index.php?page=1">
					Популярные фильмы
				</a>
				<span class="fade"></span>
				<?php
					foreach($left_block['pop_films'] as $left_film)
					{						
						include includeblock('left_film');
					}				
				?>
			</div>
			<div class=left_item>
				<a class=left_h href="new.php">
					Новинки кинопроката
				</a>
				<span class="fade"></span>
				<?php
					foreach($left_block['new_films'] as $left_film)
					{
						include includeblock('left_film');
					}				
				?>
			</div>
			<div class=left_item>
				<a class=left_h href="multfilms.php">
					Советские мультики
				</a>
				<span class="fade"></span>
				<?php
					foreach($left_block['mult_films'] as $left_film)
					{
						include includeblock('left_film');
					}				
				?>
			</div>
			<div class=left_item>
				<a class=left_h href="random.php">
					Случайный фильм
				</a>
				<span class="fade"></span>
				<?php
					foreach($left_block['random_films'] as $left_film)
					{																		
						include includeblock('left_film','',Array('random' => True));
					}				
				?>
				<!-- <a class=else href="random.php" style='display:block;overflow:hidden;clear:left;color:#666'>другой случайный фильм </a> -->
			</div>
			<div class=left_item id=left_comments>
				<a class=left_h href="comments.php">
					Обсуждение фильмов
				</a>				
				<span class="fade"></span>											
				<?php
					foreach($left_block['comments'] as $left_comment)
					{
						include includeblock('left_comment');
					}				
				?>
			</div>
		</div>