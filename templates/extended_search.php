<?php
	$general['block1']='extended_search';
	$general['block2']='rows';	
	$general['disable_h1']=true;
	$rows['block']='extended_search';
	$extended_search['page']=$page;
	$extended_search['films']=$films;
	$extended_search['name']=$name;
	$extended_search['info']=$info;
	$extended_search['genre']=$genre;
	$extended_search['films_on_page']=$FILMS_ON_PAGE;
	$extended_search['films_number']=$films_number;
	$extended_search['no_request']=$no_request;
	
	include includeblock('general');
?>