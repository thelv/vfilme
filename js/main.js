	function showhidedesc(e)
	{
		desc=e.parentNode;
		if(desc.className=='hidedesc')
		{
			desc.className='showdesc';
			e.innerHTML='';
		}
		else
		{
			desc.className='hidedesc';
			e.innerHTML='далее...';
		}	
	}
	
	function show_fast_film(a)
	{
		if ($(a).attr('active')!=1){
			$(a).attr('active',1);					
			setTimeout(function(){if ($(a).attr('active')==1){$(a.parentNode.getElementsByClassName('fast_film')[0]).fadeIn(350);}},400);
		}
		else
		{
			//alert(1);
		}
	}
	function hide_fast_film(a)
	{		
		$(a).attr('active',0);		
		setTimeout(function(){$(a.parentNode.getElementsByClassName('fast_film')[0]).fadeOut(200)},250);
	}
	
	function get_random_film()
	{		
		$("#random input[type=submit]").attr("disabled","disabled");		
		$("#random input[type=submit]").attr("value","идет загрузка...");		
		$.ajax({url: "ajax_random.php", async:true, complete: function(jqXHR, textStatus)
		{			
			if(textStatus=="success")
			{
				$("#random_film").html(jqXHR.responseText);				
			}
			else
			{
				alert("ошибка загрузки фильма");
			}
			$("#random input[type=submit]").removeAttr("disabled");
			$("#random input[type=submit]").attr("value","показать другой");
		} });		
	}