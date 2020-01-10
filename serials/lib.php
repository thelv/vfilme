<?php

	//templates

	function templateRender($template, $data, $options)
	{
		global $globals;
		extract($globals);
		
		extract($data);
		ob_start();
		include templateCompile($template);
		return ob_get_clean();
	}
	
	function templateCompile($template)
	{
		$compiledPath='compiled/templates/'.$template.'.php';
		if(true)//! file_exists($compiledPath)
		{
			$content=file_get_contents('templates/'.$template.'.php');
			if($content{0}=='?')
			{
				preg_match('/\A\?(.*)[\r\n]/U', $content, $settings);
				parse_str($settings[1], $settings);
				if($settings['parent_template'])
				{
					$content=preg_replace('/\A\?(.*)[\r\n]/U', '', $content);
					$content=
						"<?php ob_start(); ?>
						{$content}
						<?php
							\$content=ob_get_clean(); 
							templateCompile('{$settings['parent_template']}');
							include 'compiled/templates/{$settings['parent_template']}.php';
						?>
					";
				}
			}
			//$content=preg_replace('/template_include (?:[\'"])(.*)(?:[\'"]);/U', 'templateCompile("$1");include "templates_compiled/$1.php";', $content);
			
			$content=preg_replace_callback('/(<(?:input|select|textarea) name=")(.*)([<="])/U', $requestEncode=function($match)
			{				
				$match[2]=str_replace('.', '/', $match[2]);
				$match[2]=str_replace(' ', '^', $match[2]);
				$match[2]=str_replace('[', '(', $match[2]);
				$match[2]=str_replace(']', ')', $match[2]);
				return "{$match[1]}{$match[2]}{$match[3]}";
			}, $content);
			
			//$content=preg_replace_callback('/(href=[\'"]request?)([^\'"]*)([\'"])/U', $requestEncode, $content);
			$content=preg_replace_callback('/(?:(\\\\\\\\)|(\\\\\$)|\$(\$|=|\?|0|\')(\w+(\[[\w\'"]+\])*(?: (?=\[)|)))/', function($match)
			{
				if($match[4])
				{
					$match[4]=preg_replace('/\[(\w+)\]/', "['$1']", $match[4]);
					switch($match[3])
					{
						case '$':
							$func='htmlspecialchars';
							break;
						case '=':
							$func='';
							break;
						case '?':
							$func='urlencode';
							break;
						case '0':
							$func='(int)';
							break;
						case "'":							
							return "<?= str_replace(array(\"\\r\",\"\\n\"), array('\\r','\\n'), addslashes($".$match[4].")) ?>";							
							break;
					}					
					return "<?= $func($".$match[4].") ?>";
				}
				elseif($match[2])
				{
					return '$';
				}
				elseif($match[1])
				{
					return '\\';					
				}
			}, $content);
			mkdir(dirname($compiledPath), 0777, true);
			file_put_contents($compiledPath, $content);
		}		
		return $compiledPath;
	}
	
	function render($template, $data, $options)
	{		
		return templateRender($template, $data, $options);
	}
	
	//! templates
	
	//compile
	
	function compile($file)
	{
		$compiledPath='compiled/'.$file;
		if(true)//! file_exists($compiledPath)
		{
			$content=preg_replace_callback('/(?:(\\\\\\\\)|(\\\\\$)|\$(\"|\=|0|\?)(\w+(\[[\w\'"]+\])*)(?:\.|))/', function($match)
			{
				if($match[4])
				{
					switch($match[3])
					{
						case '"':
							$func='mysql_real_escape_string';
							$quote="\\'";
							break;
						case '=':
							$func='';
							break;					
						case '0':
							$func='(int)';
							break;
						case '?':
							$func='urlencode';
							break;
					}
					$match[4]=preg_replace('/\[(\w+)\]/', "['$1']", $match[4]);
					return "$quote'.$func($".$match[4].").'$quote";
				}
				elseif($match[2])
				{
					return '$';
				}
				elseif($match[1])
				{
					return '\\';					
				}
			}, file_get_contents($file));
			
			$content=preg_replace('/compile_include [\'"](.*)[\'"];/', 'include compile("$1");', $content);
			$content=preg_replace('/(\A|[\r\n])(\s*)compile_globals;/', '$1$2global $globals; extract($globals);', $content);
			
			mkdir(dirname($compiledPath), 0777, true);
			file_put_contents($compiledPath, $content);
		}
		return $compiledPath;
	}
	
	//! compile
	
	//functions
	
	function functionCreate($function)
	{
		global $functions;
		global $functionLastId;		
		
		$functions[++$functionLastId]=$function;
		return $functionLastId;
	}
	
	function functionGet($id)
	{
		global $functions;
		
		return $functions[$id];
	}
	
	function f($function)
	{
		return functionCreate($function);
	}
	
	//! functions
	
	//view
	
	function viewSelect($options, $selected)
	{
		$selected=(int)$selected;
		echo "<option ".($selected==$option['id'] ? 'selected' : '')." value=0>--не выбрано--</option>";
		foreach($options as $option)
		{
			echo "<option ".($selected==$option['id'] ? 'selected' : '')." value={$option['id']}>{$option['name']}</option>";			
		}
	}
	
	function viewCheckboxes($options, $checked, $name)
	{
		foreach($options as $id=>$option)
		{
			echo "<input type='checkbox' name='{$name}={$id}' ".($checked[$id] ? 'checked' : '')."> ".htmlspecialchars($option['name'])."<br>";
		}
		echo '!!!';
	}
	
	//! view
	
	//image functions
	
	function img($img, $size)
	{
		global $imgEncryptionCode;
	
		if($size)
		{
			return "/"."upload/img/{$img['id']}.{$size}.".md5("{$img['id']}.{$size}.{$imgEncryptionCode}").'.jpg';
		}
		else
		{
			return "/"."upload/img/{$img['id']}.".md5("{$img['id']}.{$imgEncryptionCode}").'.jpg';
		}
	}
	
	function imgCreate($name)
	{
		global $imgEncryptionCode;
	
		return "$name.".md5("$name.$imgEncryptionCode");
	}
	
	function imgResize($path)
	{
		global $imgEncryptionCode;
	
		$pathInfo=pathinfo($path);
		$fileName=$pathInfo['filename'];
		$dirName=$pathInfo['dirname'];
		list($name, $size, $sign)=explode('.', $fileName);
		if(md5("$name.$size.$imgEncryptionCode")!=$sign) return;
		$origPath="$dirName/$name.".md5("$name.$imgEncryptionCode").'.jpg';
		
		preg_match('/\A(\d*)(?:(x(\d*))|)\Z/', $size, $match);
		$maxWidth=$match[1];
		$maxHeight=$match[2] ? $match[3] : $maxWidth;
			
		list($width, $height) = getimagesize($origPath);
		$scale=min(1, $maxWidth ? $maxWidth/$width : 1, $maxHeight ? $maxHeight/$height : 1);
		$newWidth=$width*$scale;
		$newHeight=$height*$scale;

		$newImage = imagecreatetruecolor($newWidth, $newHeight);
		$image = imagecreatefromjpeg($origPath);
		imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

		imagejpeg($newImage, $path, 100);
	}
	
	//! image functions
	
	//node.js functions
	
	function nodejsSet($id){
	
		global $nodejsEncryptionCode;	
		file_get_contents("http://127.0.0.1:8080/?type=set&id=$id&sign=".md5("set.{$id}.{$nodejsEncryptionCode}"));
		
	}
	
	function nodejsClear($id){
		
		global $nodejsEncryptionCode;
		file_get_contents("http://127.0.0.1:8080/?type=clear&id=$id&sign=".md5("clear.{$id}.{$nodejsEncryptionCode}"));
	
	}
	
	//! node.js functions
	
	//custom
	
	function search($q, $offset, $limit)
	{
		include_once 'lib/sphinxapi.php';
		$cl = new SphinxClient ();
		$sql = "";
		$mode = SPH_MATCH_ALL;
		$host = "localhost";
		$port = 9312;
		$index = "*";
		$groupby = "";
		$groupsort = "@group desc";
		$filter = "group_id";
		$filtervals = array();
		$distinct = "";
		$sortby = "";
		$sortexpr = "";
		$limit = 31;
		$ranker = SPH_RANK_PROXIMITY_BM25;
		$select = "";
		$cl->SetServer ( $host, $port );
		$cl->SetConnectTimeout ( 1 );
		$cl->SetArrayResult ( true );
		$cl->SetWeights ( array ( 100, 1 ) );
		$cl->SetMatchMode ( $mode );
		if ( count($filtervals) )	$cl->SetFilter ( $filter, $filtervals );
		if ( $groupby )				$cl->SetGroupBy ( $groupby, SPH_GROUPBY_ATTR, $groupsort );
		if ( $sortby )				$cl->SetSortMode ( SPH_SORT_EXTENDED, $sortby );
		if ( $sortexpr )			$cl->SetSortMode ( SPH_SORT_EXPR, $sortexpr );
		if ( $distinct )			$cl->SetGroupDistinct ( $distinct );
		if ( $select )				$cl->SetSelect ( $select );
		if ( $limit )				$cl->SetLimits ( $offset, $limit);
		$cl->SetRankingMode ( $ranker );
		$res = $cl->Query ( $q, $index );

		foreach($res['matches'] as $match)
		{
			$ids[]=(int)$match['id'];
		}
		return $ids;
	}
	
	function mySerials()
	{
		return array_reverse(preg_split('/[^\d]+/', $_COOKIE['favorites'], -1, PREG_SPLIT_NO_EMPTY));
	}
	
	function imgCover($serial)
	{
		return '/serials/img/covers/'.(int)$serial['id'].'.jpg';
	}
	
?>