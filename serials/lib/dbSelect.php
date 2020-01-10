<?php

	//конвертация селект запроса из внешнего формата во внутренний
	
	function selectConvert(&$selectExt, $parentTable)
	{
		global $tables;
		static $fullEnding;
	
		if($parentTable===null)
		{
			$selectInn['table_name']='';
		}
		
		while(true)
		{
			preg_match('/(?:
				([\w\.,]+)| #1
				\?(\w+\.)| #2
				([\w\.]+)\?| #3
				([\w\.]+)-(\w+(?:\.|))| #4,5
				\(((?: \([^)]*\) | [^)] )*)\)| #6
				(\w+)=(?U:<((?:\\\\\\\\|\\\\>|.)*)>|([^\s]*))| #7,8,9
				<((?U:(?:\\\\\\\\|\\\\>|.)*))>| #10
				(!\.)| #11
				(!) #12
			)(?:\s|\Z|(?=!))/x', $selectExt, $match, PREG_OFFSET_CAPTURE);
			if(! $match) break;

			$selectExt=substr($selectExt, $match[0][1]+strlen($match[0][0]));
			foreach($match as &$val) $val=$val[0];
			if($match[1])
			{
				if(! isset($selectInn['table_name']))
				{									
					$relationName=$match[1];					
				}
				else
				{			
					$selectExt="{$match[1]} {$selectExt}";
					$child=true;									
				}
			}
			elseif($match[2])
			{
				$alias=$match[2];
			}
			elseif($match[3])
			{
				$relationName=$match[3];
			}
			elseif($match[4])
			{
				if(! isset($selectInn['table_name']))
				{
					$relationName=$match[4];
					$alias=$match[5];
				}
				else
				{
					$selectExt="{$match[4]}-{$match[5]} {$selectExt}";
					$child=true;
				}
			}
			elseif(count($match)==7) //$match[6]
			{				
				preg_match_all('/(?=[^\s])((?:\(.*\)|.)+)(?:\s+(\w+)|)\s*(?:,|\Z)/U', $match[6], $fieldMatches, PREG_SET_ORDER);
				if(count($fieldMatches))
				{				
					foreach($fieldMatches as $fieldMatch)
					{
						if($fieldMatch[1]=='*')
						{
							foreach($tables[$selectInn['table_name']]['fields'] as $field) $selectInn['fields'][$field]="`$field`";
						}
						else
						{
							if(! $fieldMatch[2]) $fieldMatch[2]=$fieldMatch[1];
							if(preg_match('/\A\w+\Z/', $fieldMatch[1])) $fieldMatch[1]="`{$fieldMatch[1]}`";
							$selectInn['fields'][$fieldMatch[2]]=$fieldMatch[1];
						}
					}
				}
				else
				{
					$selectInn['fields']=array();
				}
			}
			elseif($match[7])
			{
				switch($match[7])
				{
					case 'where':
					case 'having':						
						$selectInn[$match[7]][]="({$match[8]})";
						break;
					case 'order_by':
					case 'group_by':
						$selectInn[$match[7]][]="{$match[8]}";
						break;
					case 'limit':
						$limit=explode(',', $match[9]);
						if(! $limit[1]) $limit=array(0,$limit[0]);
						$selectInn['limit']=$limit;
						break;
					case 'id':
						$selectInn['limit']=array(0,1);
						$selectInn['where'][]="(`{$tables[$selectInn['table_name']]['id'][0]}`={$match[9]})";
						break;
				}
			}
			elseif($match[10])
			{
				$selectInn['custom'].=$match[10];				
			}
			elseif($match[11] || $match[12])				
			{
				if($match[11]) $fullEnding=true;
				break;
			}	

			if($child)
			{
				$selectInn['childs'][]=selectConvert($selectExt, $selectInn['table_name']);
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
					$selectInn['individual_var']=true;
					$alias=substr($alias, 0, -1);				
				}
				$selectInn['table_alias']=$alias;
				$alias=false;
			}
			
			if($relationName)
			{							
				if(substr($relationName, -1)=='.')
				{
					$selectInn['individual_var']=true;
					$relationName=substr($relationName, 0, -1);
				}								
				
				if(substr($relationName, -1)==',')
				{
					$selectInn['no_var']=true;
					$relationName=substr($relationName, 0, -1);
				}								
				
				$relationParts=explode('.', $relationName);
				
				if(count($relationParts)==1) //обычная связь, avatar_image из user
				{
					$relationParent=$parentTable;
					$relationName=$relationParts[0];
					$relationInvert=false;
					if(! $selectInn['table_alias']) $selectInn['table_alias']=$relationName;
				}
				else //обратная связь, вида "avatar_image.user"
				{
					$relationParent=$relationParts[1];
					$relationName=$relationParts[0];
					$relationInvert=true;
					if(! $selectInn['table_alias']) $selectInn['table_alias']=$relationParent;
				}

				if($parentTable)
				{
					if(! $relationInvert)
					{
						if($relation=$tables[$relationParent]['childs'][$relationName])
						{
							$selectInn['table_name']=$relation['table_name'];
							$selectInn['relation_type']=$relation['relation_type'];
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
							$selectInn['table_name']=$relationParent;
							$selectInn['relation_type']=($relation['relation_type']=='parent_to_child' ? 'child_to_parent' : 'parent_to_child');
						}
					}
					$selectInn['relation_field']=$relation['relation_field'];
				}
				else
				{
					$selectInn['table_name']=$relationName;
				}
				
				$selectInn['id']=$tables[$selectInn['table_name']]['id'];
				//hack
				if($selectInn['relation_type']=='child_to_parent' && count($selectInn['id'])>1)
				{												
					$deleteIdIndex=array_search($selectInn['relation_field'], $selectInn['id']);
					unset($selectInn['id'][$deleteIdIndex]);
				}
				//! hack
				if(! $selectInn['id']) $selectInn['id']=array('id');
				
				$relationName=false;
			}
		}
				
		if($parentTable===null)
		{
			return $selectInn['childs'];
		}
		else
		{
			if(! $selectInn['table_name']) return false;
			
			if(! isset($selectInn['fields']))
			{
				foreach($tables[$selectInn['table_name']]['fields'] as $field) $selectInn['fields'][$field]="`$field`";
			}
			return $selectInn;
		}		
	}
	
	//! конвертация селект запроса из внешнего формата во внутренний
	
	// сделать селект запрос

	function selectDoRecursion($request, &$resultVar, $relationFieldValue)
	{
		$fields=$request['fields'];
		foreach($request['id'] as $id)
		{
			$fields[$id]="`$id`";
		}	
		foreach($request['childs'] as $childRequest)
		{
			if($childRequest['relation_type']=='parent_to_child')
			{
				$fields[$childRequest['relation_field']]="`{$childRequest['relation_field']}`";
			}
		}
		foreach($fields as $fieldAlias=>$field)
		{
			$fieldStrs[]="$field `$fieldAlias`";
		}

		$where=$request['where'];
		if($request['relation_type']=='child_to_parent')
		{
			$where[]="`{$request['relation_field']}`='".mysql_real_escape_string($relationFieldValue)."'";
		}
		elseif($request['relation_type']=='parent_to_child')
		{
			$where[]="`{$request['id'][0]}`='".mysql_real_escape_string($relationFieldValue)."'";
		}
		$where=$where ? 'where '.implode(' and ', $where) : '';

		$order_by=$request['order_by'] ? 'order by '.implode(', ', $request['order_by']) : '';
		
		if($request['limit'])
		{
			$limit='limit '.implode(', ', $request['limit']);
		}
		
		$rows=mysql_query('select '.implode(', ', $fieldStrs).' from '."`{$request['table_name']}` `{$request['table_alias']}` {$where} {$order_by} {$limit} {$request['custom']}");
		
		while($row=mysql_fetch_assoc($rows))
		{	
			$idValue=array();
			foreach($request['id'] as $idField)
			{
				$idValue[]=$row[$idField];
			}
			
			foreach($row as $fieldName=>$fieldValue)
			{
				if($request['no_var'])
				{
					$resultVar[$fieldName]=$fieldValue;
				}
				elseif($request['relation_type']=='parent_to_child' || $request['limit'][1]==1 || ($request['relation_field']==$request['id'][0] && count($request['id'])==1))
				{
					$resultVar[$request['table_alias']][$fieldName]=$fieldValue;
				}
				else
				{
					$resultVar[$request['table_alias'].'s'][implode(', ', $idValue)][$fieldName]=$fieldValue;
				}
			}
			
			if($request['relation_type']=='parent_to_child' || $request['limit'][1]==1 ||  ($request['relation_field']==$request['id'][0] && count($request['id'])==1))
			{
				if($request['individual_var'])
				{
					$childResultVar=&$resultVar[$request['table_alias']];
				}
				else
				{
					$childResultVar=&$resultVar;
				}
			}
			else
			{
				$childResultVar=&$resultVar[$request['table_alias'].'s'][implode(', ', $idValue)];
			}

			foreach($request['childs'] as $childRequest)
			{
				if($childRequest['relation_type']=='parent_to_child')
				{									
					if($relationFieldValue=$row[$childRequest['relation_field']])
					{
						selectDoRecursion($childRequest, $childResultVar, $relationFieldValue);
					}
				}
				else
				{
					selectDoRecursion($childRequest, $childResultVar, $idValue[0]);
				}
			}
		}
	}

	function selectDo(&$result, $selectRequest)
	{		
		$selectRequest=selectConvert($selectRequest);
		foreach($selectRequest as $childRequest)
		{
			selectDoRecursion($childRequest, $result, null);
		}
		return $result;
	}
	
	function sel(&$result, $selectRequest)
	{
		return selectDo($result, $selectRequest);
	}
	
	//! сделать селект запрос 

?>