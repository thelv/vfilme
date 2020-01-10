<?php 
	$watch['viewout_img']=viewout_line($watch['img']);
	$watch['viewout_watch']=viewout_line($watch['watch']);
	$watch['viewout_name']=viewout_line($watch['name']);
	$watch['viewout_description']=viewout_block($watch['description']);			

	if($watch['PART']=='title'): 
		if(! $watch['serial_id'])
		{
			echo "В Фильме | \"${watch['viewout_name']}\" смотреть онлайн";
		}
		else
		{
			$watch['viewout_season']=viewout_line($watch['season']);
			$watch['viewout_series']=viewout_line($watch['series']);
			echo "В Фильме | \"${watch['viewout_name']}\" - ${watch['viewout_season']} сезон ${watch['viewout_series']} серия смотреть онлайн";
		}
	elseif($watch['PART']=='keywords'):
		echo "${watch['viewout_name']} смотреть онлайн";
	elseif(! $watch['PART']):
?>
		<?php 
			$watch['jsout_img']=htmlspecialchars($watch['img'],ENT_QUOTES);			
			echo "\r\n<script type='text/javascript'>\r\n<!--\r\ncounterparam='img=${watch['jsout_img']}';\r\n-->\r\n</script>\r\n"; 
		?>
		<div id=center_row class=watch_film>			
	<?php
		if(! $watch['serial_id']):
	?>
			<h1><?php echo $watch['name']; ?></h1>
	<?php
		else:	
			$watch['viewout_serial_id']=viewout_line($watch['serial_id']);
			echo "
			<h1><a href='serial.php?serial=${watch['viewout_serial_id']}'>${watch['viewout_name']}</a></h1>
			<h1 id=series_name><b><a href='serial.php?serial=${watch['viewout_serial_id']}&season=${watch['viewout_season']}'>${watch['viewout_season']} сезон</a> ${watch['viewout_series']} серия</b></h1>
			";
	?>
	<?php endif; ?>		
			<div class=w_d>смотреть онлайн / <a href=download.php?film=<?php echo $watch['viewout_watch']; ?>>скачать</a></div>
			<div class=film_cont style='width:<?php echo preparevkiframe($watch['embed'],$watch['watch'],$watch['name']); ?>px'>
				<div>
					<?php echo $watch['embed']; ?>
				</div>
									
<!-- SHARE BUTTONS -->								
<script type="text/javascript" src="http://vkontakte.ru/js/api/share.js?9" charset="windows-1251">
</script>
<div style='padding-left:0px;padding-top:8px;overflow:hidden'>
<div style='float:left'>
<script type="text/javascript">
<!--
document.write(VK.Share.button({
  url: 'http://www.vfilme.ru/watch.php?film=<?php echo $watch['watch']; ?>',
  title: 'Фильм "<?php echo $watch['viewout_name']; ?>" онлайн',
  description: '<?php echo $watch['viewout_description']; ?>',
  image: 'http://www.vfilme.ru/php/img.php?url=<?php echo $watch['img']; ?>',
  noparse: true
}));
-->
</script>
</div>
<div style='float:left;padding-left:5px;padding-top:1px'>
<style>
/*	#at16p{margin-left:130px !important}
	#at15s{top:565px !important;}*/
</style>
<!-- AddThis Button BEGIN --> 
<div class="addthis_toolbox addthis_default_style">
<!-- <a class="addthis_counter addthis_pill_style"></a> -->
<a class="addthis_button_memori" style='padding-left:2px;padding-top:3px;color:gray;text-indent:2px;'>Memori</a>  
<a class="addthis_button_bobrdobr" style='padding-left:7px;padding-top:3px;color:gray;text-indent:2px;'>БобрДобр</a>  
<a class="addthis_button_misterwong" style='padding-left:7px;padding-top:3px;color:gray;text-indent:2px;'>Mister-Wong</a>  
<a class="addthis_button_compact" style='padding-left:7px;padding-top:3px;color:gray;text-indent:0px;text-decoration:underline' title='кликните, чтобы увидеть все сервисы'>Еще...</a>  
</div>
<script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script> 
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=thelv"></script>
<!-- AddThis Button END --> 
</div>
</div>
<!-- SHARE BUTTONS END -->
		
			</div>								
				
			<span style='display:block;font-size:2px;height:1px;margin-bottom:-1px;width:200px;overflow:hidden'>
				&nbsp;
			</span>

			<?php echo $watch['viewout_description']; ?>			
			
			<!-- Put this script tag to the <head> of your page -->

<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?14"></script>

<script type="text/javascript">

  VK.init({apiId: 2010028, onlyWidgets: true});

</script>

<!-- Put this div tag to the place, where the Comments block will be -->

 <div id="vk_comments" style='clear:both;margin-left:20px;margin-bottom:25px'> </div> 

<script type="text/javascript">

VK.Widgets.Comments("vk_comments", {limit: 10, autoPublish : 0, onChange : vk_comment_callback});

</script>
<noscript>
	<b>Комментарии к фильму.</b>
	<ul>		
		<?php
			foreach($watch['comments'] as $watch_comment)
			{
				$viewout_watch_comment=viewout_block($watch_comment);
				echo "<li>$viewout_watch_comment<br><br>\r\n";
			}
		?>		
	</ul>
</noscript>
		</div>
<?php endif; ?>