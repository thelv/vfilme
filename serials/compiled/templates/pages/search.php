<?php ob_start(); ?>
						
<script>
	loadPages.init(<?= (int)($url['p']) ?>);
</script>

<div id="serials">
	<?= ($blocks['serials']) ?>
</div>

<script>
	document.write('<style>#pages{display:none}</style>');
</script>

<?= ($blocks['pages']) ?>

<script>
	document.write(loadPages.html);
</script>
						<?php
							$content=ob_get_clean(); 
							templateCompile('pages/outer');
							include 'compiled/templates/pages/outer.php';
						?>
					