<?php
	if($index['PART']=='title'): 
		echo "В Фильме | Популярные фильмы";
	elseif($index['PART']=='keywords'):
		echo "популярные фильмы, популярные фильмы смотреть онлайн";
	elseif(! $index['PART']):
?>
		<div id=center_row class=search_films>
			<h1>Популярные фильмы</h1>
			<div class=pages>				
				<b>Страницы </b> 
				<?php
					if($index['page']==1)
					{
						echo ' <span class=forw_back>← предыдущая</span> ';
					}
					else
					{
						echo " <a class=forw_back href='?page=".($index['page']-1)."'>← предыдущая</a> ";
					}
					
					if($index['page']==5)
					{
						echo ' <span class=forw_back>следующая →</span> ';
					}
					else
					{
						echo " <a class=forw_back href='?page=".($index['page']+1)."'>следующая →</a> ";
					}					
				?>
				<div class=page_links>
				<?php
					for($i=1;$i<=5;$i++)
					{
						if ($i==$index['page'])
						{
							echo "<b class=page_link>$i</b> ";							
						}
						elseif($i==$index['page']-1)
						{
							echo "<a class=page_link href='?page=$i' style='padding-right:0'>$i</a> ";
						}
						else
						{
							echo "<a class=page_link href='?page=$i'>$i</a> ";
						}						
					}					  
				?>
				</div>
			</div>
			
			<?php
				foreach($index['films'] as $search_film)
				{
					include includeblock('search_film');
				}
			?>						
			
			<div class=pages id=bottom_pages>				
				<b>Страницы </b> 
				<?php
					if($index['page']==1)
					{
						echo ' <span class=forw_back>← предыдущая</span> ';
					}
					else
					{
						echo " <a class=forw_back href='?page=".($index['page']-1)."'>← предыдущая</a> ";
					}
					
					if($index['page']==5)
					{
						echo ' <span class=forw_back>следующая →</span> ';
					}
					else
					{
						echo " <a class=forw_back href='?page=".($index['page']+1)."'>следующая →</a> ";
					}					
				?>
				<div class=page_links>
				<?php
					for($i=1;$i<=5;$i++)
					{
						if ($i==$index['page'])
						{
							echo "<b class=page_link>$i</b> ";							
						}
						elseif($i==$index['page']-1)
						{
							echo "<a class=page_link href='?page=$i' style='padding-right:0'>$i</a> ";
						}
						else
						{
							echo "<a class=page_link href='?page=$i'>$i</a> ";
						}						
					}					  
				?>
				</div>
			</div>
		</div>
<?php endif; ?>