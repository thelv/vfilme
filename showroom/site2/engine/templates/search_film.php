<?php
	echo "
			<div class=search_film>				
				<a alt='скачать, смотреть онлайн ${film['name']}' href='watch.php?film=${film['watch']}'><img src='${film['img']}'></a>
				<a class=search_film_link href='watch.php?film=${film['watch']}'>${film['name']}</a>				
				<div class=search_film_desc>
					".makehideddesc($film['description'],NULL,16)."
				</div>
			</div>		
	";
?>