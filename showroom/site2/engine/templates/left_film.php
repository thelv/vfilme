<?php
	echo "			
		<div class=left_film>
			<div class=fast_film>				
				<img class=fast_film_arrow src='img/arrow.png'>
				<b>${left_film['name']}</b>
				<img class=fast_film_img src='${left_film['img']}'>
				".makeshortdesc($left_film['description'],16)."
			</div>
			<a onmouseover='show_fast_film(this)' onmouseout='hide_fast_film(this)' href='watch.php?film=${left_film['watch']}'><nobr>${left_film['name']}</nobr></a>
		</div>
	";
?>