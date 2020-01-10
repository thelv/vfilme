?parent_template=pages/outer

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