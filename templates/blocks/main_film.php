<?php
	$main_film['viewout_img']=viewout_line($main_film['img']);
	$main_film['viewout_watch']=viewout_line($main_film['watch']);
	$main_film['viewout_name']=viewout_line($main_film['name']);
	echo "
				<div class=main_film>						
					<a title='смотреть онлайн' class=main_film_link href='watch.php?film=${main_film['viewout_watch']}'>${main_film['viewout_name']}</a>
					<a href='watch.php?film=${main_film['viewout_watch']}'><img alt='\"${main_film['viewout_name']}\" смотреть онлайн' src='${main_film['viewout_img']}'></a>
					".makehideddesc($main_film['description'],Array(),15,46)."
				</div>							
	";
?>