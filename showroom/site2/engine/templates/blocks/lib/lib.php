<?php
	function pages($page,$last_page,$url)
	{		
		$group_first_page=max(1,$page-3);		
		if($group_first_page!=1) 
		{
			$group_last_page=min($group_first_page+6,$last_page);
		}
		else
		{
			$group_last_page=min($group_first_page+7,$last_page);
		}
		$group_first_page=max(1,min($group_last_page-6,$group_first_page));
		if($group_first_page==2) $group_first_page=1;
		if($group_last_page==$last_page-1) $group_last_page=$last_page;
		if($group_first_page!=1)
		{
			echo "<a class=page_link href='${url}1' style='padding-right:0'>1</a> . . . ";
		}
		for($i=$group_first_page;$i<=$group_last_page;$i++)
		{
			if ($i==$page)
			{
				echo "<b class=page_link>$i</b> ";							
			}
			elseif($i==$page-1)
			{
				echo "<a class=page_link href='${url}${i}' style='padding-right:0'>${i}</a> ";
			}
			else
			{
				echo "<a class=page_link href='${url}${i}'>${i}</a> ";
			}						
		}
		if($group_last_page!=$last_page)
		{
			echo " . . . <a class=page_link href='${url}${last_page}' style='padding-right:0'>${last_page}</a>";
		}
	}
?>