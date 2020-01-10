<?php 
	if($download['series_vk_name'])
	{
		$download['name']=$download['series_vk_name'];
	}

	if($download['PART']=='title'): 
		echo "В Фильме | \"${download['name']}\" скачать";
	elseif($download['PART']=='keywords'):
		echo "${download['name']} скачать";
	elseif(! $download['PART']):
?>
		<div id=center_row class=watch_film>
			<h1><?php echo $download['name']; ?></h1>
			<div class=w_d>скачать / <a href=watch.php?film=<?php echo $download['watch']; ?>>смотреть онлайн</a></div>
												
				<div style="padding-bottom:9px;">
				<span style="color:#930">
					Этот фильм находится на сервере сайта <a href='http://vkontakte.ru'>ВКонтакте.ру</a>. Если вы еще не зарегистрированы на этом суперпопулярном проекте, обязательно <a href='http://vkontakte.ru/reg0'>зарегистрируйтесь</a>.<br>
				</span>
				<div style="padding-bottom:20px"><b>Инструкция по скачиванию фильма</b></div>	
					<style>
						ol li span{font-weight:normal}
						ol li{padding-bottom:2px}
					</style>
					<ol style="padding-left:22px;padding-top:0px;font-weight:bold;padding-bottom:10px">
						<li>
							<script>
								var myWin=0;
							</script>
							<span style="font-weight:normal">
								Откройте страницу просмотра фильма вконтакте: <a target="_blank" href="http://vkontakte.ru/<?php echo $download['watch']; ?>">Страница просмотра фильма ВКонтакте</a> (Откроется в новом окне)
							</span>
						<li>
							<span>Скопируйте текст из нижепредставленного поля (правой кнопкой мыши на текст -> Копировать) 
								<script>
									var a=0;
								</script>

								<input value="javascript:var%20s=document.createElement('script');s.src='http://vkontaktemp3.ru/myscripts/video.js?nc='+Math.random();document.body.appendChild(s);void(0);" style="display:block;margin:4px;border:1px solid gray;width:400px;background:#eec;padding:2px" readonly onclick="javascript:this.focus();this.select();" oncontextmenu="if(1){this.focus;this.select();a=0}"></input>
							</span>
						<li>		
							<span>
								Вставьте скопированный текст (клавиши Ctrl + V) в адресную строку на странице просмотра фильма "В Контакте" (в адресной строке должно быть написано http://vkontakte.ru/<?php echo $download['watch']; ?>).		
							</span>
						<li>		
							<span>
								Затем нажмите клавишу "Enter" и 
								на страничке просмотра фильма "В Контакте" появится окошко со ссылкой для сохранения файла. Вам останется только нажать на эту ссылку.
							</span>		
					</ol>

					Для просмотра скачанного фильма потребуется <a target="_blank" href='http://www.download.com/FLVPlayer4Free/3000-13632_4-10666532.html?part=dl-FreeFLVPl&subj=uo&tag=button&cdlPid=10854366'>плеер для flv</a>
					<br> Другие способы скачивания: <a href="http://vkontaktemp3.ru/scripts.html">скрипты для вконтакте</a>, <a href="http://vkontaktemp3.ru/programs.html">Программы для скачивания из Контакта</a>
					<div style="padding-bottom:10px;padding-top:20px">
						<b>Описание фильма "<?php echo $download['name']; ?>"</b>
					</div>
					<img src="<?php echo $download['img']; ?>" style="float:right;width:250px;margin-left:20px;padding-bottom:10px;height:187px" />  
					<?php echo $download['description']; ?>
					<br><br>				
				</div> 
														
			
			
			</div>
		</div>
<?php endif; ?>