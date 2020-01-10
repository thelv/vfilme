<?php

	//конвертаци€ структуры доступа к бд из внешнего формата во внутренний
	
	function accessConvertRecursion(&$accessExt, $parentTable, $parentTables)
	{
		global $tables;
		global $accessAliases;
		static $fullEnding;
		
		if($parentTable===null)
		{
			$accessInn['table_name']='';
		}
		
		while(true)
		{
			preg_match('/(?:
				([\w\.]+)(?:\/(\w*)|)| #1,2
				\?(\w+\.)(?:\/(\w*)|)| #3,4
				([\w\.]+)\?| #5
				([\w\.]+)-(\w+(?:\.|))(?:\/(\w*)|)| #6,7,8
				\(([^)]*)\)| #9
				(\w+)=(?U:<((?:\\\\\\\\|\\\\>|.)*)>|([^\s]*))| #10,11,12
				<((?U:(?:\\\\\\\\|\\\\>|.)*))>| #13
				(!\.)| #14
				(!) #15
			)(?:\s|\Z|(?=!))/x', $accessExt, $match, PREG_OFFSET_CAPTURE);
			if(! $match) break;

			$accessExt=substr($accessExt, $match[0][1]+strlen($match[0][0]));
			foreach($match as &$val) $val=$val[0];
			if($match[1])
			{
				if(! isset($accessInn['table_name']))
				{									
					$relationName=$match[1];					
					$absoluteAlias=$match[2];
				}
				else
				{			
					$accessExt="{$match[0]} {$accessExt}";
					$child=true;			
				}
			}
			elseif($match[3])
			{
				$alias=$match[3];
				$absoluteAlias=$match[4];
			}
			elseif($match[5])
			{
				$relationName=$match[5];
			}
			elseif($match[6])
			{
				if(! isset($accessInn['table_name']))
				{
					$relationName=$match[6];
					$alias=$match[7];
					$absoluteAlias=$match[8];
				}
				else
				{
					$accessExt="{$match[0]} {$accessExt}";
					$child=true;
				}
			}
			elseif(count($match)==10) //$match[9]
			{				
				preg_match_all('/(\w+)\s*(?:\[([^\]]*)\]|)/', $match[9], $commandMatches, PREG_SET_ORDER);
				foreach($commandMatches as $commandMatch)
				{		
					$command=&$commands[$commandMatch[1]];
					$command['exists']=1;
					$fieldMatches=explode(',', $commandMatch[2]);
					foreach($fieldMatches as $fieldMatch)
					{
						preg_match('/(\w+)(?:\=([^\s]+)|)/' ,$fieldMatch, $fieldMatch);
						$fieldName=$fieldMatch[1];
						if($fieldName)
						{
							$fieldValue=$fieldMatch[2];
							$field=&$command['fields'][$fieldName];
							if($fieldValue=='#time')
							{
								$field['time']=true;
								$fieldValue=null;
							}
							$field['value']=$fieldValue;
						}
					}
				}

				$accessInn['commands']=$commands;
				
			}
			elseif($match[10])
			{
				switch($match[10])
				{
					case 'id':
						$accessInn['predefined_id']=$match[12];
						break;
					case 'check':
						$accessInn['check']=(int)$match[12];
						break;
				}
			}
			elseif($match[13])
			{
				//$accessInn['custom'].=$match[13];
			}
			elseif($match[14] || $match[15])
			{
				if($match[14]) $fullEnding=true;
				break;
			}

			if($child)
			{
				$childAccessInn=accessConvertRecursion($accessExt, $accessInn['table_name'], $childParentTables);
				$accessInn['childs'][$childAccessInn['table_alias']]=$childAccessInn;
				if($fullEnding)
				{
					if($parentTable===null)
					{
						$fullEnding=false;
					}
					else
					{
						break;
					}
				}
				$child=false;
			}
			
			if($alias)
			{
				if(substr($alias, -1)=='.')
				{
					$accessInn['individual_var']=true;
					$alias=substr($alias, 0, -1);				
				}
				$accessInn['table_alias']=$alias;
				$alias=false;
			}					
			
			if($relationName)
			{	
				if(substr($relationName, -1)=='.')
				{
					$accessInn['individual_var']=true;
					$relationName=substr($relationName, 0, -1);
				}								
				
				$relationParts=explode('.', $relationName);
				
				if(count($relationParts)==1) //обычна€ св€зь, avatar_image из user
				{
					$relationParent=$parentTable;
					$relationName=$relationParts[0];
					$relationInvert=false;
					if(! $accessInn['table_alias']) $accessInn['table_alias']=$relationName;
				}
				else //обратна€ св€зь, вида "avatar_image.user"
				{
					$relationParent=$relationParts[1];
					$relationName=$relationParts[0];
					$relationInvert=true;
					if(! $accessInn['table_alias']) $accessInn['table_alias']=$relationParent;
				}

				if($parentTable)
				{
					if(! $relationInvert)
					{					
						if($relation=$tables[$relationParent]['childs'][$relationName])
						{
							$accessInn['table_name']=$relation['table_name'];
							$accessInn['relation_type']=$relation['relation_type'];
						}
						else
						{
							swap($relationName, $relationParent);
							$relationInvert=true;
						}						
					}
					if($relationInvert)
					{
						if($relation=$tables[$relationParent]['childs'][$relationName])						
						{
							$accessInn['table_name']=$relationParent;
							$accessInn['relation_type']=($relation['relation_type']=='parent_to_child' ? 'child_to_parent' : 'parent_to_child');
						}
					}
					$accessInn['relation_field']=$relation['relation_field'];
				}
				else
				{
					$accessInn['table_name']=$relationName;
				}
				
				$table=$tables[$accessInn['table_name']];
				if($accessInn['relation_type']=='parent_to_child' || ! $table['id'][1] || ($idNumber=array_search($accessInn['relation_field'], $table['id']))===false)
				{
					$accessInn['id']=$table['id'][0];
				}
				else
				{								
					$accessInn['id']=$table['id'][(int)(! $idNumber)]; //little hack

				}
				if(! $accessInn['id']) $accessInn['id']='id';
				
				$childParentTables=$parentTables;
				$childParentTables[]=$accessInn['table_alias'];
				
				if(isset($absoluteAlias))
				{					
					if(! $absoluteAlias) $absoluteAlias=$accessInn['table_alias'];
					$accessInn['absolute_alias']=$absoluteAlias;
					$accessAliases[$absoluteAlias]=$childParentTables;
				}
				
				$relationName=false;																
			}						
		}
				
		if($parentTable===null)
		{
			return $accessInn['childs'];
		}
		else
		{
			if(! $accessInn['table_name']) return false;					
			return $accessInn;
		}		
	}

	function accessConvert($accessExt, $level)
	{		
		global $access;
		$access=accessConvertRecursion($accessExt[$level], null, array());
	}

	//! конвертаци€ структуры доступа к бд из внешнего формата во внутренний
	
	//ковертаци€ запроса из формата формы во внутренний
	
	function requestConvert($formReq, $files)
	{		
		global $accessAliases;
	
		foreach($files as $key=>$value)
		{
			$formReq[$key]=$value;			
		}

		$aliases=array();
		foreach($formReq as $key=>$val)
		{			
			unset($formReq[$key]);
			
			$key=str_replace('/', '.', $key);
			$key=str_replace('^', ' ', $key);
			$key=str_replace('(', '[', $key);
			$key=str_replace(')', ']', $key);
			
			if($key{0}!='@')
			{
				if(strpos($key, 'alias ')===0)
				{
					if($val!=='')
					{
						$m=explode(' ', $key, 2);
						parse_str($m[1].$val, $m);		
						if($m) $aliases=array_merge($aliases, $m);
					}
				}
				else
				{
					$formReq[$key]=$val;
				}
			}
			else
			{
				unset($formReq[$key]);
			}
		}
		
		foreach($formReq as $key=>$val)
		{
			unset($formReq[$key]);
			foreach($aliases as $aliasKey=>$aliasVal)
			{
				$key=preg_replace("/\b{$aliasKey}\b/", $aliasVal, $key);
			}
			if(! preg_match('/[A-Z]/', $key)) $formReq[$key]=$val;
		}			
	
		foreach($formReq as $key=>$val)
		{
			unset($formReq[$key]);					
			if(strpos($key, '='))
			{
				if($val)
				{
					list($newKey, $newVal)=explode('=', $key, 2);	
					$formReq[]=array('key'=>$newKey, 'val'=>$newVal);
				}				
			}
			else
			{				
				$formReq[]=array('key'=>$key,'val'=>$val);
			}
		}
		
		$req=Array();
		
		do
		{
			foreach($formReq as $val)
			{					
				$key=$val['key'];
				$val=$val['val'];
			
				list($command, $field)=explode(' ', $key, 2);
				if(! $field)
				{
					$field=$command;
					$command=false;
				}
				
				//$table=explode('.', $field);
				$table=preg_split('/(\.|(?<=-)(?=\w))/', $field);
				
				$field=$table[count($table)-1];
				if($field=='id')
				{
					$fieldName=null;
					$id=$val;				
				}
				else
				{			
					$id=null;
					$fieldName=$field;
					$fieldValue=$val;
				}			
				unset($table[count($table)-1]);												
				
				$addTablePath=array();
				if($table[0]{0}=='-')
				{
					for($j=0;$table[0]{$j}=='-';$j++)
					{
						$addTablePath[]=$lastTablePath[$j];
					}
					unset($table[0]);
					$table=array_values($table);
				}	

				$tablePath=array();
				$lastIndex='';				
				
				for($i=count($table)-1;$i>=0;$i--)
				{				
					if($table[$i]{0}=='-')
					{
						$tablePath[]=$table[$i];
					}
					else
					{
						preg_match('/(\w+)(?:\[(.*)\]|)/', $table[$i], $m);
						if($m[2]=='-') $m[2]=$lastIndex; elseif($m[2]=='+') $m[2]=(int)$autoInc++;
						$lastIndex=$m[2];				
						$tablePath[]=Array('table' => $m[1], 'index' => $m[2]);				
						if(preg_match('/[a-zA-Z]/', $m[2]))
						{
							continue 2;
						}
					}
				}
				$tablePath=array_reverse($tablePath);
				$tablePath=array_merge($addTablePath, $tablePath);
				$lastTablePath=$tablePath;
				
				if($aliasTables=$accessAliases[$tablePath[0]['table']])
				{
					$newTablePath0=array();
					foreach($aliasTables as $aliasTable)
					{
						$newTablePath0[]=array('table'=>$aliasTable, 'index'=>'');
					}
					$newTablePath0[count($aliasTables)-1]['index']=$tablePath[0]['index'];
					unset($tablePath[0]);
					$tablePath=array_merge($newTablePath0, $tablePath);
				}
				
								
				
				$currentBranch=&$req;
				foreach($tablePath as $key => $val)
				{			
					if(strpos($val['index'], '*')!==false)
					{				
						$index=str_replace('*', '\d+', "{$val['table']}\\[{$val['index']}\\]");
						foreach($currentBranch as $childIndex => $child)
						{					
							if(preg_match("/^{$index}$/", $childIndex))
							{												
								$table[$key]=$childIndex;							
								$addFormReq[$command.' '.implode('.', $table).".{$fieldName}"]=$fieldValue;															
							}
						}
						continue 2;
					}
					else
					{
						if(! $newBranch=&$currentBranch[$val['table']."[{$val['index']}]"])
						{
							$newBranch=Array
							(						
								'command' => 'empty',
								'table' => $val['table'],
								'childs' => Array()			
							);
						}
						$currentBranch=&$newBranch['childs'];
					}
				}
				
				if($command) $newBranch['command']=$command;
				if($id) 
				{
					$newBranch['id']=$id;
				}
				elseif($fieldName)
				{									
					$newBranch['fields'][$fieldName]=$fieldValue;
				}
			}
			$formReq=$addFormReq;
			$addFormReq=null;
		}
		while($formReq);

		return $req;
	}
	
	//! ковертаци€ запроса из формата формы во внутренний
	
	//функци€, выполн€юща€ запрос
	
	function requestDoWhere($parents, $command)
	{								
		for($i=count($parents)-1;$i>=0;$i--)
		{
			if($parents[$i]['id'])
			{
				break;
			}
			else
			{
				unset($parents[$i]);
			}
		}
						
		$table=$parents[0]['table'];
		if($id=$parents[0]['id'])
		{
			$where.="`{$table['id']}` = '".mysql_real_escape_string($id)."'";
		}
		else
		{
			$where='true';
		}

		if(($command=='insert' && (! $parents[1]['id'])) || count($parents)==1)
		{
			//nothing
		}
		else
		{
			if($command=='insert')
			{				
				$where.=' and (select 1 from ';
			}
			else
			{
				$parentTable=$parents[1]['table'];
				if($table['relation_type']=='child_to_parent')
				{
					$where.=" and `{$table['relation_field']}` in (select `.{$parentTable['table_name']}`.`{$parentTable['id']}` from ";
				}
				else
				{
					$where.=" and `{$table['id']}` in (select `.{$parentTable['table_name']}`.`{$table['relation_field']}` from ";
				}
			}
			
			unset($parents[0]);
			$parents=array_values($parents);
						
			if(count($parents))
			{					
				$innerWhere='true';
				for($i=0; $i<count($parents); $i++)
				{					
					$prevTable=$table;
					$table=$parents[$i]['table'];
					$prevAlias=$alias;
					$alias.='.'.$table['table_name'];
					$id=$parents[$i]['id'];
					if($i==0)
					{						
						$where.=" `{$table['table_name']}` `{$alias}` ";						
					}
					else
					{
						$where.=
							" 
								join `{$table['table_name']}` `{$alias}` 
								on  
								".
								(
									(
										$prevTable['relation_type']=='child_to_parent'
									)
									? 
									(
										"`{$prevAlias}`.`{$prevTable['relation_field']}`=`{$alias}`.`{$table['id']}`"	
									)
									:
									(										
										"`{$prevAlias}`.`{$prevTable['id']}`=`{$alias}`.`{$prevTable['relation_field']}`"
									)
								)
								."
							"
						;										
					}
					if($id) $innerWhere.=" and `{$alias}`.`{$table['id']}` = '".mysql_real_escape_string($id)."'";											
				}
				$where.=" where {$innerWhere})";
			}
		}

		return $where;
	}
	
	function requestDoRecursion($parents, $request, &$table)
	{				
		if($request['command']=='empty')
		{
			if($table['id']==$table['relation_field'] && $table['relation_type']=='child_to_parent')
			{
				$request['command']='update';
				echo $request['id']=$parents[0]['id'];
			}
			else
			{
				if($request['id'])
				{
					$request['command']='update';
				}
				else
				{
					$request['command']='insert';
				}
			}
		}
	
		if($table['predefined_id'])
		{
			$request['id']=$table['predefined_id'];
			if($request['command']=='insert') $request['command']='update';
		}
		
		if($request['command']=='delete' && ! $request['id']) $request['id']=$request['fields'][$table['id']]; //little hack
		$parentsWithChild=$parents;
		array_unshift($parentsWithChild, Array('table' => &$table, 'id' => $request['id']));			
		if(! $table['commands'][$request['command']]) return 'access denied';
		if($request['command']=='insert' && count($parents) && ! $parents[0]['id']) return 'insert in nowhere';		
		
		//image

			if($table['table_name']=='image' && $request['command']=='insert')
			{	
				$file=$request['fields']['location'];
				if(! $file['tmp_name']) return;
				$request['fields']['name']='name';
			}
		
		//! image			
		
		$fields=$table['commands'][$request['command']]['fields'];
		if(! is_array($fields)) $fields=array();
		foreach($fields as $name=>$value)
		{
			if($value['value']!==null)
			{
				$request['fields'][$name]=$value['value'];
			}
			elseif($value['time'])
			{
				$request['fields'][$name]=time();
			}
		}
		foreach($request['fields'] as $name => $value)
		{
			if(! $fields[$name])
			{
				unset($request['fields'][$name]);
			}
		}
		
		if($check=$table['check'])
		{
			$check=functionGet($check);
			$check($request['table_name'], $request['fields'], $request['where']);
		}
		
		foreach($request['fields'] as $name => $value)
		{
			switch($request['command'])
			{
				case 'update':
					$set[]="`$name`='".mysql_real_escape_string($value)."'";
					break;
				case 'insert':
					$names[]="`$name`";
					$values[]="'".mysql_real_escape_string($value)."'";
					break;
			}
		}
		
		if((count($set) || $request['command']!=='update') && $request['command']!=='none' )
		{					
			$where=requestDoWhere($parentsWithChild, $request['command']);
		
			switch($request['command'])
			{
				case 'update':				
					$query="update `{$table['table_name']}` set ".implode(', ', $set)." where {$where} /*returning `{$table['id']}` id*/";
					break;
				case 'insert':	
					if($table['relation_type']=='child_to_parent')
					{
						$names[]="`{$table['relation_field']}`";
						$values[]="'".mysql_real_escape_string($parents[0]['id'])."'";
					}										
					
					$query="insert into `{$table['table_name']}` (".implode(', ', $names).") select ".implode(', ', $values)." from dual where {$where} /*returning `{$table['id']}` id*/";
					break;
				case 'delete':
					$query="delete from `{$table['table_name']}` where {$where} /*returning `{$table['id']}` id*/";
					break;
			}
			
			echo $query;
			
			if(mysql_query($query))
			{
				if($request['command']=='insert')
				{
					if($table['relation_type']=='child_to_parent' && $table['relation_field']==$table['id'])
					{
						$id=$parents[0]['id'];
					}
					else
					{
						$id=mysql_insert_id();
					}
					$parentsWithChild=$parents;
					array_unshift($parentsWithChild, Array('table' => &$table, 'id' => $id));
					
					//image
						
						if($table['table_name']=='image')
						{
							move_uploaded_file($request['fields']['location']['tmp_name'], 'upload/img/'.imgCreate($id).'.jpg');
						}
						
					//image
				}
			}
			else
			{
				echo mysql_error();
				return 'error on mysql query';
			}
			
			if($request['command']=='insert' && $table['relation_type']=='parent_to_child')
			{			
				mysql_query
				(
					$q="
						update 
							`{$parents[0]['table']['table_name']}`
						set 
							`{$table['relation_field']}`='".mysql_real_escape_string($id)."' 
						where 
							`{$parents[0]['table']['id']}`="."'".mysql_real_escape_string($parents[0]['id'])."'
					"
				);
				echo $q;
			}			
		}
				
		foreach($request['childs'] as $childRequest)
		{
			if($error=requestDoRecursion($parentsWithChild, $childRequest, $table['childs'][$childRequest['table']])) return $error;
		}
	}
	
	function requestDo(&$tableTree, $requestTrees)
	{
		mysql_query('start transaction');		
		foreach($requestTrees as $requestTree)
		{			
			if($error=requestDoRecursion(Array(), $requestTree, $tableTree[$requestTree['table']]))
			{
				mysql_query('rollback');
				echo $error;
				return false;
			}
		}
		mysql_query('commit');	
		return true;
	}	
	
	function req($request, $files)
	{
		global $access;
		return requestDo($access, requestConvert($request, $files));
	}
	
	//! функци€, выполн€юща€ запрос

?>