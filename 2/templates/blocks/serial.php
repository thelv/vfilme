<?php
	if($serial['PART']=='title'): 
		echo "В Фильме | \"${serial['name']}\" - ${serial['season']} сезон смотреть онлайн";
	elseif($serial['PART']=='keywords'):
		echo "${serial['name']}, ${serial['name']} смотреть онлайн, ${serial['name']} сериал, сериал ${serial['name']} смотреть онлайн";
	else:	
?>
		<div id=center_row class=search_films>
			<h1><?php echo $serial['name']; ?><span> (сериал)</span></h1>
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
			
			<?php				
				foreach($serial['films'] as $search_film)
				{
					$search_film['name']="${serial['season']} сезон ${search_film['series']} серия";
					include includeblock('search_film');
				}
			?>						
			
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
		</div>
<?php endif; ?>