<?php
	if($serials['PART']=='title'):
		echo "В Фильме | Сериалы — смотреть онлайн";
	elseif($serials['PART']=='keywords'):
		echo "сериалы, сериалы онлайн, сериалы смотреть онлайн";
	elseif(! $serials['PART']):
?>
		<div id=center_row class=search_films>
			<h1>Сериалы</h1>
			<?php
				foreach($serials['serials'] as $serials_serial)
				{					
                                        echo
                                        "
                                            <a href='serial.php?serial=".urlencode($serials_serial['alias'])."' class=search_serial title='смотреть онлайн'>
                                                ".htmlspecialchars($serials_serial['name'])."
                                            </a>

                                        ";
				}
			?>								
		</div>
<?php endif; ?>