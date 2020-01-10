<?php
	echo "
				<div class=main_film>						
					<a class=main_film_link href='watch.php?film=${main_film['watch']}'>${main_film['name']}</a>
					<img src='${main_film['img']}'>
					".makehideddesc($main_film['description'],Array(),15,46)."
				</div>							
	";
?>