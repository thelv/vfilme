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
				<div class=left_comment>
					<!-- <div class=left_film>					
						<div class=fast_film>				
							<img class=fast_film_arrow src='img/arrow.png'>
							<b>Социальная сеть / The Social Newtwork (2010)</b>
							<img class=fast_film_img src='http://cs12921.vkontakte.ru/u46868774/video/l_997d042c.jpg'>
							История создания социальной сети facebook.<br>Жанр: Драма.<br>Один из главных претендентов на Главный Оскар<br><br>В фильме рассказывается история создания одной из самых популярных в Интернете социальных сетей — Facebook. Оглушительный успех этой сети среди пользователей по всему миру навсегда изменил жизнь студентов-однокурсников гарвардского университета, которые основали ее в 2004 году и за несколько лет стали самыми молодыми мультимиллионерами в США......
						</div>			-->
						<a onmouseover="show_fast_film(this)" onmouseout="hide_fast_film(this)" href=film>Социальная сеть / The Social Newtwork (2010)</a> - очень хороший сериал!!! Я сама хочу быть хирургом <br>
					<!-- </div> -->
				</div>
				<div class=left_comment>
					<a href=film><nobr>Ловушка для бамбра </nobr></a> - интересно, девчонки не на сценарий работали?
				</div>				
			</div>
		</div>