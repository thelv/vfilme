<?php 
	if ($pages['last_page']!=1):
?>
				<b>Страницы </b> 
				<?php
					if($pages['page']==1)
					{
						echo ' <span class=forw_back>← предыдущая</span> ';
					}
					else
					{
						echo " <a class=forw_back href='${pages['url']}".($pages['page']-1)."'>← предыдущая</a> ";
					}
					
					if($pages['page']==$pages['last_page'])
					{
						echo ' <span class=forw_back>следующая →</span> ';
					}
					else
					{
						echo " <a class=forw_back href='${pages['url']}".($pages['page']+1)."'>следующая →</a> ";
					}					
				?>
				<div class=page_links>
<?php	
	pages($pages['page'],$pages['last_page'],$pages['url']);
?>
				</div>
<?php endif; ?>