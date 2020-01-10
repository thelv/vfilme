<?php ob_start(); ?>
						
<?php

	if(! $title=$serial['ru_title']) $title=$serial['title']; else $origTitle=$serial['title'];
	$ruTitleClear=mb_strtolower(preg_replace('/(\A | \Z)/', '', preg_replace('/[\,\.\:\-\/\s\;\!\?\"\']+/',' ',$serial['ru_title'])), 'UTF-8');
	$titleClear=mb_strtolower(preg_replace('/(\A | \Z)/', '', preg_replace('/[\,\.\:\-\/\s\;\!\?\"\']+/',' ',$serial['title'])), 'UTF-8');		
	
	if(! $url['season'])
	{
		$_title="В Фильме: \"{$title}\" смотреть онлайн";
		if($serial['ru_title']) $_keywords[]="сериал $ruTitleClear";
		if($serial['title']) $_keywords[]="сериал $titleClear";		
	}
	elseif(! $url['serie'])
	{
		$_title="В Фильме: \"{$title}\" {$url['season']} сезон смотреть онлайн";
		$ruTitleClear.=" {$url['season']} сезон";
		$titleClear.=" {$url['season']} сезон";
		$serieText=" {$url['season']} сезон";
	}
	else
	{
		$_title="В Фильме: \"{$title}\" {$url['season']} сезон {$url['serie']} серия смотреть онлайн";
		$ruTitleClear.=" {$url['season']} сезон";
		$ruTitleClear.=" {$url['serie']} серия";
		$titleClear.=" {$url['season']} сезон";
		$titleClear.=" {$url['serie']} серия";
		$serieText=" {$url['season']} сезон {$url['serie']} серия";
	}
	
	if($serial['ru_title']) $_keywords[]="$ruTitleClear, $ruTitleClear смотреть онлайн";
	if($serial['title']) $_keywords[]="$titleClear, $titleClear смотреть онлайн";
	$_description="На этом сайте можно бесплатно посмотреть сериал \"{$title}\" ".($origTitle ? "({$origTitle})" : '')."{$serieText} в режиме онлайн";
	
	if($serie['season']==1)
	{
		$vkTitle="\"{$title}\" смотреть онлайн на ВФильме.ру";
		$vkDescription="Бесплатно посмотреть все серии сериала \"$title\" ".($origTitle ? "({$origTitle})" : '')." в хорошем качестве";
		$twitterText="\"{$title}\" смотреть онлайн все серии";
		$shareUrl=url('serial', $serial);
		$twitterUrl=url('serialShort', $serial);		
	}
	else
	{
		$vkTitle="\"{$title}\" {$serie['season']} сезон смотреть онлайн на ВФильме.ру";
		$vkDescription="Бесплатно посмотреть все серии {$serie['season']} сезона сериала \"$title\" ".($origTitle ? "({$origTitle})" : '')." в хорошем качестве";
		$twitterText="\"{$title}\" {$serie['season']} сезон все серии смотреть онлайн";
		$shareUrl=url('serial', $serial, $serie['season']);
		$twitterUrl=url('serialShort', $serial, $serie['season']);
	}
	$_ogImage=$shareImage=imgCover($serial);		
	$_ogTitle=$vkTitle;
	$_ogDescription=$vkDescription;
?>

<h1>
	<? // <a href='<?= url('serial', $serial) *>'> ?>
		<?= htmlspecialchars(($serial['ru_title'] ? "{$serial['ru_title']} / " : '').$serial['title']) ?>
	<? //</a> ?>
	<?
		if($url['season'])
		{
			?>
				/ <? //<a href='<?= url('serial', $serial, $serie['season']) *>'> ?> <?= (int)($url['season']) ?> сезон <? //</a> ?>
			<?
		}
		
		if($url['serie'])
		{
			?>
				<? //<a href='<?= url('serial', $serial, $serie['season']) *>'> ?> <?= (int)($url['serie']) ?> серия <? //</a> ?>
			<?
		}
	?>
</h1>

<div id="serialShare">
	<?= render('blocks/share', array('vkTitle'=>$vkTitle, 'vkDescription'=> $vkDescription, 'url'=>$shareUrl, 'twitterUrl'=>$twitterUrl, 'twitterText'=>$twitterText, 'image'=>$shareImage)); ?>
</div>

<div id="addToFavorites"
	onclick="					
		profile.addToFavorites(<?= (int)($serial['id']) ?>, ! profile.isFavorite(<?= (int)($serial['id']) ?>));
		$('#addToFavoritesImage').attr('src', profile.isFavorite(<?= (int)($serial['id']) ?>) ? '/serials/img/fav.png' : '/serials/img/fav_hide.png');
	"
>				
	<script>
		if(profile.isFavorite(<?= (int)($serial['id']) ?>))
		{
			document.write("<img id='addToFavoritesImage' src='/serials/img/fav.png'/>");
		}
		else
		{
			document.write("<img id='addToFavoritesImage' src='/serials/img/fav_hide.png'/>");
		}
	</script>
	в мои сериалы 
</div>

<?php 
	if(! $video=$videos[$url['video']]) $video=current($videos);

	foreach($series as $serie_)
	{
		$seasons[$serie_['season']][$serie_['serie']]=$serie_;			
	}		

	if($video)
	{
		?>
			<iframe src='<?= htmlspecialchars($video['player']) ?>'>
			</iframe>
		<?
	}
	else
	{
		?>
			<div id="noPlayer">
				Видео для этой серии у нас, к сожалению, нету (пока нету)
			</div>
		<?
	}

?>	

<table id="seriesLinks" cellpadding=0 cellspacing=0>
	<tr>
		<td>
			Сезоны: 
		</td>
		<td> 

			<?
				
				foreach($seasons as $season_=>$series_)
				{	
					if($season_==$serie['season']){	
						?>
							<a class='seriesLink' id='activeSeriesLink' href='<?= url('serial', $serial, $season_) ?>' onclick='return false;'><?= htmlspecialchars($season_) ?></a>
						<?
					}else{				
						?>
							<a class='seriesLink' href='<?= url('serial', $serial, $season_) ?>'><?= htmlspecialchars($season_) ?></a>
						<?				
					}
				}
					
			?>

		</td>
	</tr>
	<tr>
		<td>
			Серии: 
		</td>
		<td> 
			<?				
				
				foreach($seasons[$serie['season']] as $serie_=>$videos_)
				{
					$classes=(! $videos_['video'] ? ' seriesLinkNoVideo' : '');
					
					if($serie['serie']==$serie_){
						?>
							<a class='seriesLink <?= htmlspecialchars($classes) ?>' id='activeSeriesLink' href='<?= url('serial', $serial, $serie['season'], $serie_) ?>' onclick='return false;'><?= htmlspecialchars($serie_) ?></a>
						<?
					}else{
						?>
							<a class='seriesLink <?= htmlspecialchars($classes) ?>' href='<?= url('serial', $serial, $serie['season'], $serie_) ?>'><?= htmlspecialchars($serie_) ?></a>
						<?	
					}
				}
				
			?>

		</td>
	</tr>
</table>

<table id="videoVersions" cellpadding=0 cellspacing=0>
	<tr>
		<td>
			Другие версии видео:
		</td>
		<td>
			<?php
				if(count($videos)<=1)
				{
					?>
					    <span style='color:#777;margin-left:2px'>нету</span>
					<?
				}
				else
				{
					$i=1;
					foreach($videos as $video_)
					{		
						if($video_['id']==$video['id']){
							?>
								<a class="seriesLink" id="activeSeriesLink" href='<?= url('serial', $serial, $serie['season'], $serie['serie'], $video_['id']) ?>' onclick='return false;'><?= htmlspecialchars($i) ?></a>
							<?
						}else{
							?>
								<a class="seriesLink" href='<?= url('serial', $serial, $serie['season'], $serie['serie'], $video_['id']) ?>'><?= htmlspecialchars($i) ?></a>
							<?	
						}
						$i++;
					}
				}
				
			?>
		</td>				
	</tr>	
<!--	<tr>
		<td>
			Оценить эту версию:
		</td>
		<td>
			<span style='color:green;text-decoration:underline;cursor:pointer'>+</span> <span style='color:red;text-decoration:underline;cursor:pointer'>–</span> <span style='font-size:12px'><span style='color:green'>430</span>/<span style='color:red'>120</span></span>
		</td>
	</tr> -->
</table>

<div id="comments">
	<div id="vk_comments"></div> 	
</div>

<script type="text/javascript">
	VK.Widgets.Comments("vk_comments", {limit: 10, autoPublish : 0, pageUrl: '<?= url('serial') ?>'}, '<? echo md5("serial={$serial['id']}")?>');
</script>


						<?php
							$content=ob_get_clean(); 
							templateCompile('pages/outer');
							include 'compiled/templates/pages/outer.php';
						?>
					