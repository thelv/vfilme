<?php die(); ?>
ADMIN<br>

<?php

	include 'lib/dbCreate.php';
	include 'dbInitSql.php';
	
	
	if(isset($_POST['action']))
	{
		switch($_POST['action'])
		{
			case 'create':
				createTables($rawTables);
				createInitData($dbInitSql);
				
				include 'url.php';
				sel($dat, 'serial order_by=<id>');
				foreach($dat['serials'] as $serial)
				{
					mysql_query("update serial set `alias`='".($alias=mysql_real_escape_string(urlTitle($serial)))."'".' where id='.((int)$serial['id']));
					echo $alias."\r\n";
					echo mysql_error()."\r\n";
				}
				
				break;
			case 'export':
				echo '2. exported.';
				break;
			case 'initdata':
				createInitData($dbInitSql);
				echo '3. initdata.';
				break;
			case 'create_images':
				
				sel($dat, 'serial');
				print_r($dat);
				foreach($dat['serials'] as $serial)
				{
					$file_name="img/covers/".(int)$serial['id'].".jpg";
					if(! file_exists($file_name))
					{						
						if(substr($serial['image'], -3)=='gif')						
						{
							echo 'gif';
							imagejpeg(imagecreatefromgif($serial['image']), $file_name, 100);
						}
						else
						{
							echo 'jpg';
							file_put_contents($file_name, file_get_contents($serial['image']));
						}
					}				
				}
				
				break;				
		}
	}

?>

<form method=post>
	action: 
	<select name=action>
		<option value='create'>1. create </option>
		<option value='export'> 2. export </option>
		<option value='initdata'> 3. initdata </option>
		<option value='recompiletemplates'> 4. recompiletemplates </option>
		<option value='create_images'> 4. create images</option>
	</select>
	<input type='submit' />
</form>