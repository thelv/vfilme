<?php
	$serial['viewout_name']=viewout_line($serial['name']);	
	if($serial['options'] & 2 > 0)
	{
		$serial__serial_word='телепередача';
		$serial__series_word='выпуск';
		$serial__series_word_many='выпуски';		
	}
	else
	{
		$serial__serial_word='сериал';
		$serial__series_word='серия';
		$serial__series_word_many='серии';		
	}
	if($serial['options'] & 1 > 0)
	{
		$serial__show_season=false;
	}
	else
	{
		$serial__show_season=true;
	}

	if($serial['PART']=='title'): 
		$serial__season_str=$serial['no_season'] ? "" : " - ${serial['season']} сезон";
		echo "В Фильме | \"${serial['viewout_name']}\"$serial__season_str смотреть онлайн";
	elseif($serial['PART']=='keywords'):
		$serial__season_str=$serial['no_season'] ? "" : " ${serial['season']} сезон";
		echo "${serial['viewout_name']}$serial__season_str, ${serial['viewout_name']}$serial__season_str смотреть онлайн, ${serial['viewout_name']} $serial__serial_word$serial__season_str, $serial__serial_word ${serial['viewout_name']}$serial__season_str смотреть онлайн";
	elseif(! $serial['PART']):
?>
		<div id=center_row class=search_films>
			<h1><?php echo $serial['viewout_name']; ?><span> (<?php echo $serial__serial_word; ?>)</span></h1>
	<?php if($serial__show_season): ?>

			<div class=pages>				
				<b>Сезоны </b> 
				<?php
					if($serial['season']==1)
					{
						echo ' <span class=forw_back>← предыдущий</span> ';
					}
					else
					{
						echo " <a class=forw_back href='?serial=${serial['serial_id']}&season=".($serial['season']-1)."'>← предыдущий</a> ";
					}
					
					if($serial['season']>=$serial['seasons_number'])
					{
						echo ' <span class=forw_back>следующий →</span> ';
					}
					else
					{
						echo " <a class=forw_back href='?serial=${serial['serial_id']}&season=".($serial['season']+1)."'>следующий →</a> ";
					}					
				?>
				<div class=page_links>
				<?php
					for($i=1;$i<=$serial['seasons_number'];$i++)
					{
						if ($i==$serial['season'])
						{
							echo "<b class=page_link>$i</b> ";							
						}
						elseif($i==$serial['season']-1)
						{
							echo "<a class=page_link href='?serial=${serial['serial_id']}&season=$i' style='padding-right:0'>$i</a> ";
						}
						else
						{
							echo "<a class=page_link href='?serial=${serial['serial_id']}&season=$i'>$i</a> ";
						}						
					}					  
				?>
				</div>
			</div>
			
	<?php endif; ?>
			
			<?php				
				foreach($serial['films'] as $search_film)
				{
					$search_film['name']="${serial['viewout_name']} - ".($serial__show_season ? "${serial['season']} сезон " : "")."${search_film['series']} $serial__series_word";
					include includeblock('search_film');
				}
			?>						
			
			
	<?php if($serial__show_season): ?>
	
			<div class=pages>				
				<b>Сезоны </b> 
				<?php
					if($serial['season']==1)
					{
						echo ' <span class=forw_back>← предыдущий</span> ';
					}
					else
					{
						echo " <a class=forw_back href='?serial=${serial['serial_id']}&season=".($serial['season']-1)."'>← предыдущий</a> ";
					}
					
					if($serial['season']>=$serial['seasons_number'])
					{
						echo ' <span class=forw_back>следующий →</span> ';
					}
					else
					{
						echo " <a class=forw_back href='?serial=${serial['serial_id']}&season=".($serial['season']+1)."'>следующий →</a> ";
					}					
				?>
				<div class=page_links>
				<?php
					for($i=1;$i<=$serial['seasons_number'];$i++)
					{
						if ($i==$serial['season'])
						{
							echo "<b class=page_link>$i</b> ";							
						}
						elseif($i==$serial['season']-1)
						{
							echo "<a class=page_link href='?serial=${serial['serial_id']}&season=$i' style='padding-right:0'>$i</a> ";
						}
						else
						{
							echo "<a class=page_link href='?serial=${serial['serial_id']}&season=$i'>$i</a> ";
						}						
					}					  
				?>
				</div>
			</div>
	
	<?php endif; ?>
	
		</div>
<?php endif; ?>