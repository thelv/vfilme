<?php
	$search_film['viewout_img']=viewout_line($search_film['img']);
	$search_film['viewout_watch']=viewout_line($search_film['watch']);
	$search_film['viewout_name']=viewout_line($search_film['name']);
	//$search_film['viewout_description']=viewout_block($search_film['description']);		
	echo "
			<div class=search_film>				
				<a href='watch.php?film=${search_film['viewout_watch']}'><img alt='\"${search_film['viewout_name']}\" смотреть онлайн' src='${search_film['viewout_img']}'></a>
				<a title='смотреть онлайн' class=search_film_link href='watch.php?film=${search_film['viewout_watch']}'>${search_film['viewout_name']}</a>				
				<div class=search_film_desc>
					".makehideddesc($search_film['description'],NULL,16)."
				</div>
			</div>		
	";
?>