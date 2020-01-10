<?php ob_start(); ?>
						
<b>Мои сериалы</b>

<div id="serials">
	<?
		foreach($serials as $serial){
					
			echo render('blocks/serial', $serial, array('my'=>true));
		
		}
		
		if(! $serials)
		{
			?>
				<div id='emptySerials'>
					Вы еще не добавили ни одного сериала в "Мои сериалы".
				</div>
			<?
		}
	?>
</div>
						<?php
							$content=ob_get_clean(); 
							templateCompile('pages/outer');
							include 'compiled/templates/pages/outer.php';
						?>
					