<?php

	$dbInitSql="
		create unique index `serial_unique_index` on `serial` (`myshows_serial_id`);
		create unique index `serie_unique_index` on `serie` (`myshows_serie_id`);
		create unique index `video_unique_index` on `video` (`vk_video_id`, `serie_id`);
		
		create unique index `serial_alias_index` on `serial` (`alias`);
		
		create index `serie_serial_index` on `serie` (`serial_id`);
		create index `video_serie_index` on `video` (`serie_id`);
		create index `serie_serial_serie_index` on `serie` (`serial_id`, `season`, `serie`);
	";
		
	$dbInitSql.="
		insert into 
			`serial` 
		(
			`myshows_serial_id`, `title`, `ru_title`, `image`
		) 
		select 
			`id`, `title`, `ruTitle`, `image`
		from 
			`myshows_serial` n
		where
			`MY_published`
		order by
			'id'
		on duplicate key update 
			`myshows_serial_id`=n.`id`, `title`=n.`title`, `ru_title`=n.`ruTitle`, `image`=n.`image`
		;
		
		insert into 
			`serie` 
		(
			`myshows_serie_id`, `season`, `serie`, `serial_id`
		) 
		select 
			m.`id`, m.`seasonNumber`, m.`episodeNumber`, s.`id`
		from 
			`myshows_serie` m
		join
			`serial` s on s.`myshows_serial_id`=m.`MY_myshows_serial_id`
		on duplicate key update
			`myshows_serie_id`=m.`id`, `season`=m.`seasonNumber`, `serie`=m.`episodeNumber`, `serial_id`=s.`id`
		;
		
		insert into 
			`video` 
		(
			`vk_video_id`, `player`, `serie_id`
		) 
		select 
			v.`id`, v.`player`, s.`id`
		from 
			`vk_video` v
		join
			`serie` s on s.`myshows_serie_id`=v.`MY_myshows_serie_id`
		where
			`match`='1'
		on duplicate key update
			`vk_video_id`=v.`id`, `player`=v.`player`, `serie_id`=s.`id`
		;
	";

?>