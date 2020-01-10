<meta charset='utf-8'/>
<script src='http://vfilme.ru/js/jquery.js'></script>
<div style='width:1800px' id=main>
<div style='padding-bottom:10px;position:fixed'><b>$$serial[ruTitle] / $$serial[title] - $$serie[seasonNumber] сезон $$serie[episodeNumber] серия</b> <span style='color:#aaa'>- $$serie[airDate]</span></div>
<div style='padding-bottom:30px'></div>

<?php

	$flag=-1;

	foreach($videos as $video)
	{
		if($flag!=$video['search_flag'])
		{
			$flag_count++;
			if($flag!=-1)
			{
				echo '</div>';
			}
			
			?>
			
				<div style='float:left;margin-right:25px;width:415px;overflow:auto;font-size:15px'>
				<!-- $$video[search_flag] -->
			
			<?
			$flag=$video['search_flag'];
		}
	
		$bold='black';
		if($video['match'])
		{
			$bold='blue';
		}		
	
		?>
		
			<div style='padding:4px 0 3px 0;border-bottom:1px solid #eee;color:$$bold;width:415px;clear:both;overflow:hidden'>
				<div style='float:right;color:<?= ($video['duration']<500) ? ($video['duration'] ? 'red' : '#ee0') : 'gray' ?>'>
					<?= ((int)($video['duration']/60)).':'.(($sec=$video['duration'] % 60)<10 ? '0'.$sec : $sec) ?>
				</div>
				<a href=<?= $video['player'] ? $video['player'] : "http://vk.com/video{$video['owner_id']}_{$video['id']}" ?> target=_blank>
					<div style='width:375px;float:left;color:$$bold;text-decoration:none'>
						$$video[title]
					</div>				
				</a>
			</div>
		
		<?
	}	
	
?>
</div>
<script>
	$(document).ready(function(){
		<?php 
			if($flag_count>=4)
			{
				echo "$('body').scrollLeft(500);";
			}
		?>
	});
</script>