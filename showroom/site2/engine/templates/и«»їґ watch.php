<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		<link rel="shortcut icon" href="img/favicon.png" /> 
		<link rel="stylesheet" href="css/main.css" type="text/css" /> 
		<script type="text/javascript" src="js/jquery.js"></script>		
		<script type="text/javascript" src="main.js"></script>		
	</head>
	<body>
		<div id=top>
			<div id=top_left>
				<a href="/"><img src="img/label.png" alt="В Фильме.ру"></a>
				<a class=label_link href="/"><h1>смотреть фильмы онлайн</h1></a>
				<a class=label_link href="/"><h1>скачать фильмы</h1></a>
			</div>
			<div id=top_right>
				<div class=right_h1>бесплатно</div>
				<div class=right_h1>без регистрации</div>
				<div class=right_h1>без смс</div>
			</div>
			<div id=top_search>				
				<h1>поиск фильмов:</h1>
				<form>					
					<input type=submit value=искать>
					<div>
						<input type=text>										
						<a href=extended_search.php>расширенный поиск</a>
					</div>
				</form>			
				<a class=alfa href=alfa>1</a>
				<a class=alfa href=alfa>2</a>
				<a class=alfa href=alfa>3</a>
				<a class=alfa href=alfa>4</a>
				<a class=alfa href=alfa>5</a>
				<a class=alfa href=alfa>6</a>
				<a class=alfa href=alfa>7</a>
				<a class=alfa href=alfa>8</a>
				<a class=alfa href=alfa>9</a>
				<a class=alfa href=alfa>0</a>
				<a class=alfa href=alfa>а</a>
				<a class=alfa href=alfa>б</a>
				<a class=alfa href=alfa>в</a>
				<a class=alfa href=alfa>г</a>
				<a class=alfa href=alfa>д</a>
				<a class=alfa href=alfa>е</a>
				<a class=alfa href=alfa>ё</a>
				<a class=alfa href=alfa>ж</a>
				<a class=alfa href=alfa>з</a>
				<a class=alfa href=alfa>б</a>
				<a class=alfa href=alfa>и</a>
				<a class=alfa href=alfa>й</a>
				<a class=alfa href=alfa>к</a>
				<a class=alfa href=alfa>л</a>
				<a class=alfa href=alfa>м</a>
				<a class=alfa href=alfa>н</a>
				<a class=alfa href=alfa>о</a>
				<a class=alfa href=alfa>п</a>
				<a class=alfa href=alfa>р</a>
				<a class=alfa href=alfa>с</a>
				<a class=alfa href=alfa>т</a>
				<a class=alfa href=alfa>у</a>
				<a class=alfa href=alfa>ф</a>
				<a class=alfa href=alfa>х</a>
				<a class=alfa href=alfa>ц</a>
				<a class=alfa href=alfa>ч</a>
				<a class=alfa href=alfa>ш</a>
				<a class=alfa href=alfa>щ</a>
				<a class=alfa href=alfa>ъ</a>
				<a class=alfa href=alfa>ы</a>
				<a class=alfa href=alfa>ь</a>
				<a class=alfa href=alfa>э</a>
				<a class=alfa href=alfa>ю</a>
				<a class=alfa href=alfa>я</a>				
			</div>	
		</div>		
		<?php include 'templates/left_block.php'; ?>
		<div id=right_row>
	<!--	<iframe scrolling=no src="http://teasernet.com/webmaster/editblock/show/index.php?notpl=1&nohtml&thq=1&ipl=0&cw=100&tvk=5&blw=200&blmh=0&blmv=0&blmvt=px&blbgch=%23FFFFFF&blbgc=%23FFFFFF&blbw=0&blbt=solid&blbc=%23e0dce0&tbgc=%23FFFFFF&ism=70&iw=60&tbw=0&tbt=solid&tbgch=%23FFFFFF&tbc=%23CCCCCC&ibt=solid&ibc=%23bdb2bd&ibw=0&ims=6&af=tahoma&as=12&au=px&ac=%23575757&ahf=tahoma&ahs=12&ahu=px&ahc=%23000000&aos=12&aof=tahoma&aou=px&aoc=%230000cc&afun=0&afb=1&atun=0&atb=1&ahb=1&ahun=0" style="width:195px;height:1000px;border:0;margin-left:-8px;overflow:hidden"></iframe> -->
<!--		<script type="text/javascript">
teasernet_blockid = 226169;
teasernet_padid = 72749;
</script>
<script type="text/javascript" src="http://agitazio.com/block.js"></script>
  
		&nbsp;-->
		<script language="JavaScript" type="text/javascript">
var ban_id='1376';
														var size="160x600";	// размер баннера
														var cid="ffbcdb7d98a63749d7b008ffaa4dc8e7";
														var sa="";  // субаккаунт
													</script>
													<script language="JavaScript" type="text/javascript" src="http://t44.gameleads.ru/"></script>
		
		
		</div>
		<div id=center_row class=watch_film>
			<h1><?php echo $film['name']; ?></h1>
			<div class=w_d>смотреть онлайн / <a href=download.php?film=<?php echo $film['watch']; ?>>скачать</a></div>
			<div class=film_cont>
				<div>
					<?php echo $film['embed']; ?>
				</div>

				
								

				
				<script type="text/javascript" src="http://vkontakte.ru/js/api/share.js?9" charset="windows-1251">
				</script>

<div style='padding-left:0px;padding-top:8px;overflow:hidden'>



<div style='float:left'>

<script type="text/javascript">

<!--

document.write(VK.Share.button({

  url: 'http://www.vfilme.ru/watch.php?film=<?php echo $film['watch']; ?>',

  title: 'Фильм "<?php echo $film['name']; ?>" онлайн',

  description: '<?php echo $film['description']; ?>',

  image: 'http://www.vfilme.ru/php/img.php?url=<?php echo $film['img']; ?>',

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

			<?php echo $film['description']; ?>			
			
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
	</body>
</html>