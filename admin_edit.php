<?php
	include 'admin/lib.php';
	access();	
	connect_db();
	$id=(int)$_GET['id'];			
	$watch=$_GET['film'];
	read_db($id,$name,$desc,$img,$watch,$embed,$flag);
	mysql_close();	
?>
<style>
	textarea{width:700px;height:200px;}
	input{width:700px}	
</style>

<form method=post action=admin_edit_engine.php target='_blank'>
	name: <input name=name value='<?php echo htmlspecialchars($name,ENT_QUOTES); ?>'><br>
	desc: <textarea name=desc><?php echo htmlspecialchars(str_replace('<br>',"\r\n",$desc),ENT_QUOTES); ?></textarea> <br>
	img: <input name=img value='<?php echo htmlspecialchars($img,ENT_QUOTES); ?>'> <br>
	watch: <input name=watch value='<?php echo htmlspecialchars($watch,ENT_QUOTES); ?>'> <br>
	embed: <input name=embed value='<?php echo htmlspecialchars($embed,ENT_QUOTES); ?>'> <br>
	flag: <input name=flag value='<?php echo htmlspecialchars($flag,ENT_QUOTES); ?>'> <br>
	<input type=hidden name=request_is value=1>
	<input type=hidden name=id value='<?php echo $id; ?>'>
	<input type=submit>
</form>