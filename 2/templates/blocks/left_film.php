<?php
	$left_film['viewout_img']=viewout_line($left_film['img']);	
	$left_film['viewout_name']=viewout_line($left_film['name']);	
	$left_film['watch']=urlencode($left_film['watch']);		
	if($left_film['OPTIONS']['random'])
	{		
		$left_film['watch']="random.php?film=${left_film['watch']}";
	}	
	else
	{
		$left_film['watch']="watch.php?film=${left_film['watch']}";
	}
	$left_film['viewout_watch']=viewout_line($left_film['watch']);
	echo "			
		<div class=left_film>
			<div class=fast_film>				
				<img class=fast_film_arrow src='img/arrow.png'>
				<b>${left_film['viewout_name']}</b>
				<img class=fast_film_img src='${left_film['viewout_img']}'>
				".makeshortdesc($left_film['description'],16)."
			</div>
			<a onmouseover='show_fast_film(this)' onmouseout='hide_fast_film(this)' href='${left_film['viewout_watch']}'><nobr>${left_film['viewout_name']}</nobr></a>
		</div>
	";
?>