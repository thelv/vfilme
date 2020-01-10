<?php

	function esc($str)
	{
		return str_replace('>', '\>', "'".mysql_real_escape_string($str)."'");
	}

	function array_merge_smart($arr1, $arr2)
	{
		return array_merge(is_array($arr1) ? $arr1 : array(), is_array($arr2) ? $arr2 : array());
	}

	function &toArray(&$var)
	{
		if(! is_array($var))
		{
			$var=array($var);
		}
		return $var;
	}
	
	function array_unshift_not_num(&$array, $item)
	{
		if(! is_int($item)) array_unshift($array, $item);
	}
	
	function swap(&$a, &$b)
	{
		$m=$a;
		$a=$b;
		$b=$m;
	}
	
	//конвертация структуры бд из внешнего формата во внутренний
	
	function relationsConvert(&$relationsExt, $parentTable)
	{
		global $tables;
		static $fullEnding;
	
		if($parentTable===null)
		{
			$relation['table_name']='';
		}

		while(true)
		{
			preg_match('/(?:
				([\w\.]+)(?:-(\w+)|)\s*(?:\((\w+)\:(\w+)\)|)| #1,2,3,4
				(!\.)| #5
				(!) #6
			)(?:\s|\Z|(?=!))/x', $relationsExt, $match, PREG_OFFSET_CAPTURE);
			if(! $match) break;

			$relationsExt=substr($relationsExt, $match[0][1]+strlen($match[0][0]));
			foreach($match as &$val) $val=$val[0];
			if($match[1])
			{
				if(! isset($relation['table_name']))
				{
					if($parentTable)							
					{
						$relation['table_name']=$match[1];
						if(! $match[1]) die('nnn');					
						$relationAlias=$match[2] ? $match[2] : $match[1];
						if($match[3]=='id')
						{
							$relation['relation_type']='parent_to_child';
							$relation['relation_field']=$match[4];
						}
						else
						{
							$relation['relation_type']='child_to_parent';
							$relation['relation_field']=$match[3];
						}						
						$tables[$parentTable]['childs'][$relationAlias]=$relation;
					}
					else
					{
						$relation['table_name']=$match[1];
					}
				}
				else
				{
					$relationsExt="{$match[0]} {$relationsExt}";
					relationsConvert($relationsExt, $relation['table_name']);
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
				}
			}						
			elseif($match[5] || $match[6])
			{
				if($match[5]) $fullEnding=true;
				break;
			}
		}
	}
	
	function tablesConvert($tablesExt, $relationsExt)
	{
		global $tables;
		$tables=null;
	
		//convert tables
		foreach($tablesExt as $tableName=>$tableExt)
		{
			preg_match_all('/(?:\A|,)\s*(\w+)/s', $tableExt[0], $fieldsInn);
			$tables[$tableName]=array
			(
				'fields'=>$fieldsInn[1], 
				'id'=>(current($id=explode(', ', $tableExt['id'])) ? $id : array('id'))
			);
		}		
		
		//convert relations (and add to tables)
		relationsConvert($relationsExt);
	}

	//! конвертация структуры бд из внешнего формата во внутренний

?>