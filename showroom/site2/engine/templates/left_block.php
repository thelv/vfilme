		<div id=left_row>	
			<div class=left_item>
				<a class=left_h href="index.php?page=1">
					Популярные фильмы
				</a>
				<span class="fade"></span>
				<?php
					foreach($pop_films as $left_film)
					{						
						include 'templates/left_film.php';
					}
				?>				
			</div>
			<div class=left_item>
				<a class=left_h href="new.php">
					Новинки кинопроката
				</a>
				<span class="fade"></span>
				<?php
					foreach($new_films as $left_film)
					{
						include 'templates/left_film.php';
					}
				?>	
			</div>
			<div class=left_item>
				<a class=left_h href="multfilms.php">
					Советские мультики
				</a>
				<span class="fade"></span>
				<?php
					foreach($mult_films as $left_film)
					{
						include 'templates/left_film.php';
					}
				?>	
			</div>
			<div class=left_item id=left_comments>
				<a class=left_h href=qwe>
					Обсуждение фильмов
				</a>				
				<span class="fade"></span>											
				<?php
					foreach($left_comments as $left_comment)
					{
						include 'templates/left_comment.php';
					}
				?>				
			</div>
		</div>