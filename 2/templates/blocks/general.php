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
		<script type="text/javascript" src="js/jquery.js">
		</script>
		<script type="text/javascript" src="js/main.js">		
		</script>
		<script type="text/javascript" src="js/counter.js">
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
				<form action="search.php">					
					<input type=submit value=искать>
					<div>
						<input type=text name="request" value="<?php include includeblock($general['block1'],'search_request'); ?>">
						<a href=extended_search.php>расширенный поиск</a>
					</div>
				</form>			
				<?php
					for($i=1;$i<>9;$i++)
					{
						echo "<a class=alfa href='alphabet.php?letter=$i'>$i</a>\r\n";
					}
					echo "<a class=alfa href='alphabet.php?letter=0'>0</a>\r\n";					
					for($i=$i0=ord(toCP1251('а'));$i<$i0+32;$i++)
					{															
						echo "<a class=alfa href='alphabet.php?letter=".urlencode($s=toUTF(chr($i)))."'>".$s."</a>\r\n";
						if($i==$i0+5){echo "<a class=alfa href='alphabet.php?letter=".urlencode('ё')."'>ё</a>\r\n";}
					}					
				?>							
			</div>	
		</div>		
		<?php
			include includeblock($general['block2']);
		?>
	 <!--LiveInternet counter--><script type="text/javascript">document.write('<img src="http://counter.yadro.ru/hit?r' + escape(document.referrer) + ((typeof(screen)=='undefined')?'':';s'+screen.width+'*'+screen.height+'*'+(screen.colorDepth?screen.colorDepth:screen.pixelDepth)) + ';u' + escape(document.URL) + ';' + Math.random() + '" width=1 height=1 alt="">')</script><!--/LiveInternet-->
	</body>
</html>