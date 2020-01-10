<?php
	$left_comment['viewout_img']=viewout_line($left_comment['img']);
	$left_comment['viewout_watch']=viewout_line($left_comment['watch']);
	$left_comment['viewout_name']=viewout_line($left_comment['name']);
	$left_comment['viewout_text']=viewout_line($left_comment['text']);
	
	echo "			
		<div class=left_film>
			<div class=fast_film>
				<img class=fast_film_arrow src='img/arrow.png'>
				<b>${left_comment['viewout_name']}</b>
				<img class=fast_film_img src='${left_comment['viewout_img']}'>
				".makeshortdesc($left_comment['description'],16)."
			</div>
			<a onmouseover='show_fast_film(this)' onmouseout='hide_fast_film(this)' href='watch.php?film=${left_comment['viewout_watch']}'>${left_comment['viewout_name']}</a>
			-
			${left_comment['viewout_text']}
		</div>
	";
?>