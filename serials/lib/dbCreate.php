<?php

	function createTables($tables)
	{
		foreach($tables as $tableName=>$table)
		{							
			mysql_query("drop table `$tableName`");
			echo mysql_error();
			$fields=preg_replace('/(\A|\,)\s*(\w+)\s/U', '$1 `$2` ', $table[0]);
			mysql_query($q="create table `{$tableName}` ({$fields})");
			echo $q;
			echo mysql_error();
			echo "\r\n\r\n";
		}
	}
	
	function createInitData($sql)
	{
		$reqs=explode(';', $sql);
		foreach($reqs as $req)
		{
			echo $req;
			echo '
			
			';
			mysql_query($req);
			echo mysql_error();
		}
	}
	
?>