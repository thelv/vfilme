<?php

	
	foreach($myshows_serials as $serial)
	{
		?>
		
			<div style='clear:both;padding-top:15px'><b>$$serial[title]</b></div>
			
			<div>
		
			<?
				$season=0;
				
				foreach($serial['myshows_series'] as $serie)
				{					
					$background='';
					$v=$serie['vk_video'];
					if($v['m1'])
					{
						$color='#0f0';
					}
					elseif($v['m2'])
					{
						$color='blue';
					}
					elseif($v['m3'])
					{
						$color='#ee0';
					}
					elseif($v['m4'])
					{
						$color='red';
					}
					else
					{
						if($v['f1']+$v['f2']+$v['f3']+$v['f4']!=0)
						{
							$color='#bbb';
						}
						else
						{
							$color='#555';
						}
						$background='#444';
					}
															
					if(! $serie['episodeNumber'])
					{
						$background='#f7f7f7';
					}					
				
					if($season!=$serie['seasonNumber'])
					{
						$season=$serie['seasonNumber'];						
						?>
							<div style="clear:both"></div>
							<b>$$season</b>						
						<?
					}
					
					?>
					
						<a href='admin_serie?id=$0serie[id]' target=_blank>
							<div style='float:left;margin-bottom:5px;margin-right:5px;border-bottom:1px solid #eee;padding:5px 2px;color:$$color;background:$$background'>
						
								$0serie[vk_video][m1]($0serie[vk_video][f1])<br>
								$0serie[vk_video][m2]($0serie[vk_video][f2])<br>
								$0serie[vk_video][m3]($0serie[vk_video][f3])<br>
								$0serie[vk_video][m4]($0serie[vk_video][f4])<br>
															
								<!-- <span style='color:<?= ($serie['vk_video']['f1'] && $color=='#aaa') ? '#777;font-weight:bold' : '' ?>'>$$serie[vk_video][m1]($$serie[vk_video][f1])</span><br>
								$$serie[vk_video][m2](<span style='color:<?= ($serie['vk_video']['f2'] && $color=='#aaa') ? '#777;font-weight:bold' : '' ?>'>$$serie[vk_video][f2]</span>)<br>
								$$serie[vk_video][m3](<span style='color:<?= ($serie['vk_video']['f3'] && $color=='#aaa') ? '#777;font-weight:bold' : '' ?>'>$$serie[vk_video][f3]</span>)<br>
								$$serie[vk_video][m4](<span style='color:<?= ($serie['vk_video']['f4'] && $color=='#aaa') ? '#777;font-weight:bold' : '' ?>'>$$serie[vk_video][f4]</span>)<br> -->
							
							</div>
						</a>
					
					<?
				}
				
			?>
			
			</div>
		
		<?
	}

?>