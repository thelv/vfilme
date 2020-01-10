<?php
	echo "			
		<div class=left_film>
			<div class=fast_film>
				<img class=fast_film_arrow src='img/arrow.png'>
				<b>${left_comment['name']}</b>
				<img class=fast_film_img src='${left_comment['img']}'>
				".makeshortdesc($left_comment['description'],16)."
			</div>
			<a onmouseover='show_fast_film(this)' onmouseout='hide_fast_film(this)' href='watch.php?film=${left_comment['watch']}'>${left_comment['name']}</a>
			-
			${left_comment['text']}
		</div>
	";
?>