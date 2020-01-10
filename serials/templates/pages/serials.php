?parent_template=pages/outer

<?php

	$_title='ВФильме: все сериалы смотреть онлайн (бесплатно)';
	$_keywords[]='сериалы, сериалы онлайн, сериалы смотреть, сериалы смотреть онлайн, сериалы на русском, сериалы в хорошем качестве';
	$_description='Посмотреть любые сериалы онлайн в хорошем качестве, бесплатно и без регистрации.';
	
	$vkTitle='Все сериалы онлайн на ВФильме.ру';	
	$vkDescription='Посмотреть любые сериалы онлайн в хорошем качестве, бесплатно и без регистрации.';
	$twitterText='Посмотреть сериалы онлайн можно на ';
	$shareUrl=url('serials');
	$twitterUrl=url('serialsShort');
	$shareImage='/serials/img/favicon.png';
	
	$_ogTitle=$vkTitle;
	$_ogDescription=$vkDescription;
	$_ogImage=$shareImage;

?>

<script>
	loadPages.init($0url[p]);
</script>

<div id="serialsShare">
	<?= render('blocks/share', array('vkTitle'=>$vkTitle, 'vkDescription'=> $vkDescription, 'url'=>$shareUrl, 'twitterUrl'=>$twitterUrl, 'twitterText'=>$twitterText, 'image'=>$shareImage)); ?>
</div>

<div id="serials">
	$=blocks[serials]
</div>

<script>
	document.write('<style>#pages{display:none}</style>');
</script>

$=blocks[pages]

<script>
	document.write(loadPages.html);
</script>