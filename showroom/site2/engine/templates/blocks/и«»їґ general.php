<?php
	$h1=$general['disable_h1']?'div':'h1';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
		<link rel="shortcut icon" href="img/favicon.png" /> 
		<title><?php 			
			include includeblock($general['block1'],'title');		
		?></title>
		<meta name="keywords" content="<?php			
			include includeblock($general['block1'],'keywords');
		?>"></meta>
		<link rel="stylesheet" href="css/main.css" type="text/css" />		
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/main.js">
		</script>
	</head>
	<body>
		<div id=top>
			<div id=top_left>
				<a href="index.php"><img src="img/label.png" alt="В Фильме.ру"></a>				
				<a class=label_link href="index.php"><<?php echo $h1; ?> class=h1>смотреть фильмы онлайн</<?php echo $h1; ?>></a>
				<a class=label_link href="index.php"><<?php echo $h1; ?> class=h1>скачать фильмы</<?php echo $h1; ?>></a>
			</div>
			<div id=top_right>
				<div class=right_h1>бесплатно</div>
				<div class=right_h1>без регистрации</div>
				<div class=right_h1>без смс</div>
			</div>
			<div id=top_search>				
				<<?php echo $h1; ?> class=h1>поиск фильмов:</<?php echo $h1; ?>>
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
		<?php
			include includeblock($general['block2']);
		?>
	</body>
</html>