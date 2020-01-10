<?php 
	if($watch['PART']=='title'): 
		if(! $watch['serial_id'])
		{
			echo "В Фильме | \"${watch['name']}\" смотреть онлайн";
		}
		else
		{
			echo "В Фильме | \"${watch['name']}\" - ${watch['season']} сезон ${watch['series']} серия смотреть онлайн";
		}
	elseif($watch['PART']=='keywords'):
		echo "${watch['name']} смотреть онлайн";
	elseif(! $watch['PART']):
?>
		<div id=center_row class=watch_film>			
	<?php
		if(! $watch['serial_id']):
	?>
			<h1><?php echo $watch['name']; ?></h1>
	<?php
		else:	
			echo "
			<h1><a href='serial.php?serial=${watch['serial_id']}'>${watch['name']}</a></h1>
			<h1 id=series_name><b><a href='serial.php?serial=${watch['serial_id']}&season=${watch['season']}'>${watch['season']} сезон</a> ${watch['series']} серия</b></h1>
			";
	?>
	<?php endif; ?>	
			<div class=w_d>смотреть онлайн / <a href=download.php?film=<?php echo $watch['watch']; ?>>скачать</a></div>
			<div class=film_cont>
				<div>
					<?php echo preparevkiframe($watch['embed'],$watch['watch'],$watch['name']); ?>
				</div>

				
								

				
				<script type="text/javascript" src="http://vkontakte.ru/js/api/share.js?9" charset="windows-1251">
				</script>

<div style='padding-left:0px;padding-top:8px;overflow:hidden'>



<div style='float:left'>

<script type="text/javascript">

<!--

document.write(VK.Share.button({

  url: 'http://www.vfilme.ru/watch.php?film=<?php echo $watch['watch']; ?>',

  title: 'Фильм "<?php echo $watch['name']; ?>" онлайн',

  description: '<?php echo $watch['description']; ?>',

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

				
			</div>						
		
			<div class="pages" series=1>
					<b>Сезоны</b> 	
					<span class="page_links">
						<b class="page_link">1</b> <a class="page_link" href="http://localhost/vfilme/site2/engine/watch.php?page=2">2</a> <a class="page_link" href="http://localhost/vfilme/site2/engine/watch.php?page=3">3</a> <a class="page_link" href="http://localhost/vfilme/site2/engine/watch.php?page=4">4</a> <a class="page_link" href="http://localhost/vfilme/site2/engine/watch.php?page=5">5</a> 										
					</span>
					<b>Серии</b>
					<span class="page_links">
						<a class="page_link" href="http://localhost/vfilme/site2/engine/watch.php?page=2">1</a> <a class="page_link" href="http://localhost/vfilme/site2/engine/watch.php?page=2">2</a> <a class="page_link" href="http://localhost/vfilme/site2/engine/watch.php?page=3">3</a> <a class="page_link" href="http://localhost/vfilme/site2/engine/watch.php?page=4">4</a> <b class="page_link">5</b> <a class="page_link" href="http://localhost/vfilme/site2/engine/watch.php?page=5">6</a> <a class="page_link" href="http://localhost/vfilme/site2/engine/watch.php?page=5">7</a> <a class="page_link" href="http://localhost/vfilme/site2/engine/watch.php?page=5">8</a> 													
					</span>
					<div class=prev_next>
						<a class="forw_back" href="http://localhost/vfilme/site2/engine/asd">← предыдущая серия</a>  <a class="forw_back" href="http://localhost/vfilme/site2/engine/watch.php?page=2">следующая серия →</a> 
					</div>
			</div>
				
			<span style='display:block;font-size:2px;height:1px;margin-bottom:-1px;width:200px;overflow:hidden'>
				&nbsp;
			</span>
			<?php echo $watch['description']; ?>			
			
			<!-- Put this script tag to the <head> of your page -->

<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?14"></script>

<script type="text/javascript">

  VK.init({apiId: 2010028, onlyWidgets: true});

</script>

<!-- Put this div tag to the place, where the Comments block will be -->

 <div id="vk_comments" style='margin-left:20px;margin-bottom:25px'> </div> 

<script type="text/javascript">

VK.Widgets.Comments("vk_comments", {limit: 10,autoPublish : 0});

</script>
		</div>
<?php endif; ?>