<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>$$_title</title>
		<meta name="keywords" value="<? $_keywords=implode(', ', $_keywords) ?>$$_keywords"/>
		<meta name="description" value="$$_description"/>
		<script src='/serials/js/jquery.js'></script>
		<script src='/serials/js/jquery.cookie.js'></script>
		<script src='/serials/js/jquery.autocomplete.js'></script>
		<script type="text/javascript" src="http://vk.com/js/api/share.js?11" charset="windows-1251"></script>
		<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?14"></script>
		<script type="text/javascript">
			VK.init({apiId: 2010028, onlyWidgets: true});
		</script>
		<meta property="og:title" content="$$_ogTitle"/>
		<meta property="og:image" content="http://vfilme.ru$$_ogImage"/>
		<meta property="og:description" content="$$_ogDescription"/>
		<link rel="shortcut icon" href="/serials/img/favicon.ico" />
		<style>
			body{background:#c2c2c2;vertical-align:middle}
			a{color:#00b}
			a:visited{color:#609}
			*{border:0;padding:0;margin:0;font-family:"times new roman";vertical-align:middle}
			#top{overflow:hidden;padding-top:5px}
			#top h1{float:left;margin-right:4px}
			#top h1 a{text-decoration:none;font-size:17px;color:#22a;display:block}
			#top form{float:left}
			#top input[type=text]{border:1px solid #aaa;font-size:17px;width:298px;margin-left:3px;text-indent:4px}
			#top input[type=submit]{border:1px solid #aaa;font-size:16px;padding:0 4px}
			#mySerialsLink{color:#22a;font-size:17px;text-decoration:none;font-weight:bold;float:right;}
			#mySerialsLink img{width:20px;display:block;float:right;padding-left:6px;padding-right:1px}
			#main{width:720px;padding:0 35px 0 35px;margin:0 auto;background:#eee;min-height:100%;border:1px solid #ccc;border-width:0 1px;overflow:hidden;position:absolute;left:50%;margin-left:-396px}
			#main hr{border-bottom:1px solid #aaa;margin:6px -35px 6px -35px;}
			#top h1 a, #mySerialsLink{line-height: 23px;}
			
			.serial > div{float:left;width:216px;display:block;margin:10px 35px 10px 0;float:left;text-decoration:underline}
			.serial > div > div {width:216px;height:120px;overflow:hidden;background:#f4f4f4;margin-bottom:2px;position:relative}
			.serial > div > div > img{display:block;max-width:216px;max-height:320px;}
			.serial:nth-child(3n+1) > div{clear:both}
			.serial:nth-child(3n) > div{margin-right:0}
			
			#loadPages{border-top:1px solid #999;padding:3px 0 12px 0;clear:both;color:gray;text-align:center}
			#main > h1{font-size:16px;}
			#main > h1 a{color:#000;vertical-align:top;text-decoration:none}
			#main > h1 a:hover{text-decoration:underline}
			
			iframe, #noPlayer{width:720px;height:480px;overflow:hidden;margin:0px 0 8px 0}
			#seriesLinks td, #videoVersions td{padding-top:0px;}
			#seriesLinks td, #videoVersions td{position:relative;top:-1px}
			#seriesLinks td:first-child, #videoVersions td:first-child{padding-right:4px;width:10px;white-space:nowrap;top:0}
			#seriesLinks tr:first-child td, #videoVersions tr:first-child td{padding-bottom:1px}
			#seriesLinks{float:left;width:470px;}
			#videoVersions{float:right;width:215px;}
			#videoVersions tr{vertical-align:bottom}
			#activeSeriesLink{text-decoration:none;cursor:default;background:#bbb;padding:0 3px;}
			.seriesLinkNoVideo{color:#aaa}
			a:visited.seriesLinkNoVideo{color:#aaa}
			
			.like{float:left;display:block;vertical-align:top !important;min-height:20px}
			.like *{vertical-align:top !important}						
			#vk_like, #vk_like_button{-overflow:hidden;}			
			#facebook_like{width:76px;padding-left:0px}
			#tweeter_like{height:20px}
			#tweeter_like, #tweeter_like iframe{width:95px !important;overflow:hidden}
			#google_plus_like, #google_plus_like > div, #google_plus_like iframe{width:70px !important;oveflow:hidden}
			#vk_like{}
			#vk_like, #vk_like_button{-overflow:hidden;}
			#serialShare{margin: 7px 0 10px 0;float:left}
			#serialsShare{margin:11px 0 5px 0}
			
			#addToFavorites{float:right;color:#555;margin-top:8px;font-size:16px;cursor:pointer}
			#addToFavoritesImage{width:20px;top:4px;margin-left:7px;float:right;margin-top:-1px;}
			.removeFromFavorites{position:absolute;right:0;top:0;border:1px solid #aaa;width:15px;background:white;height:15px;padding:0;margin:0}
			.removeFromFavorites img{width:15px;display:block}
			
			#emptySerials{padding:5px 0;color:gray}
			
			#comments{padding-top:9px;clear:both;float:top;margin-top:15px;clear:both}
			#vk_comments{padding:15px 0; border-top:1px solid #aaa;float:top}
			
			#noPlayer{line-height:480px;color:#727272;text-align:center;border:1px solid #bbb;background:#ddd	}
			
			.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; cursor:pointer}
			.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
			.autocomplete-selected { background: #F0F0F0; }
			.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; vertical-align:top}
		</style>		
		<script>
			loadPages={			
				
				loading: false,
				
				page: 0,
				
				init: function(page){
				
					this.page=page;
								
					$(window).bind('scroll', this.bindFunction=function(){
					
						if($('#loadPages').position().top<$(window).height()+$(window).scrollTop()+80){
						
							loadPages.load();
						
						}
						
					});
					
				},

				end: function(){
					
					$('body').append('<style>#loadPages{display:none}</style>');
					$(window).unbind('scroll', this.bindFunction);
					
				},
				
				html: '\
					<div id="loadPages" onclick="loadPages.load()">\
						загрузить еще\
					</div>\
				',
				
				load: function(){
					
					if(this.loading) return;
					this.loading=true;
					$('#loadPages').html('загружается...');
					this.page++;
					
					$.ajax({
						
						url: '<?= url('ajax/serials') ?>?q=$?url[q]&p='+this.page,
						
						complete: function(res){
						
							$('#serials').append(res.responseText);						
							$('#loadPages').html('загрузить еще');
							if(! res.responseText) loadPages.end();
							loadPages.loading=false;
							
						}
						
					});
					
				}
				
			}
			
			if(! $.cookie('favorites')) $.cookie('favorites', '', {expires: 1000, path: '/'});
			profile={
			
				isFavorite: function(id){
						
					return $.cookie('favorites').indexOf('*'+id+'*')!=-1;
				
				},
			
				addToFavorites: function(id, add){
				
					if(add){
					
						if(! this.isFavorite(id)) $.cookie('favorites', $.cookie('favorites')+'*'+id+'*', {expires: 1000, path: '/'});
					
					}else{
					
						$.cookie('favorites',  $.cookie('favorites').replace('*'+id+'*', ''), {expires: 1000, path: '/'});
					
					}
				}	
			}
			
			var serials=<?= block('autocompleteSerials') ?>;
			
			$('document').ready(function(){
			console.log($('#top form input[type=text]'));
				$('#top form input[type=text]').autocomplete({
					maxHeight: 500,
					lookup: serials,
					onSelect: function (suggestion) {
						$('#top form input').attr('disabled', '');
						window.location='/<?= $SERIALI.'/' ?>'+suggestion.data;
					}
				});
			});
		</script>
    </head>    
    <body>  
		<div id="main">
			<div id="top">
				<h1>
					<a href='<?= url('serials') ?>'>В Фильме.ру - сериалы</a>
				</h1>
				<form action="<?= url('search') ?>">
					<input type="text" name="q" value="$$url[q]">
					<input type="submit" value="поиск">
				</form>
				<a id="mySerialsLink" href="<?= url('mySerials') ?>">
					<img src='/serials/img/fav.png'/>
					Мои сериалы					
				</a>
			</div>
			<hr>
			$=content
		</div>
		<!--LiveInternet counter--><script type="text/javascript">document.write('<img src="http://counter.yadro.ru/hit?r' + escape(document.referrer) + ((typeof(screen)=='undefined')?'':';s'+screen.width+'*'+screen.height+'*'+(screen.colorDepth?screen.colorDepth:screen.pixelDepth)) + ';u' + escape(document.URL) + ';' + Math.random() + '" width=1 height=1 alt="">')</script><!--/LiveInternet-->
	</body>
</html>