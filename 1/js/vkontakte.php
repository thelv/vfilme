<?php

header('Cache: 0');
header('Pragma: no-cache');
header('Content-Type: text/javascript');

?>  

  s=document.body.innerHTML;
  
  s=s.replace(/[\r\n]/g,' ');
  
  reg1=/host:'(\d+).*vtag:'([^']+)'.*vkid:'(\d+)/m;
    
  ar=reg1.exec(s);
  
  if(ar){
  dl='http://v'+ar[1]+'.vkadre.ru/assets/videos/'+ar[2]+ar[3]+'.vk.flv';
  
  d=document.createElement('div');
  d.setAttribute('style','position:absolute;postion:fixed;width:100%;left:0;text-align:center;top:0;');
  d.innerHTML='<div align=center style="position:absolute;top:0;text-align:center;width:300px;left:50%;margin-left:-300px"><a name=vfilme_top></a><div id=vfilme_download style="text-align:center;display:block;margin-left:100px;padding:6px;position:normal;width:350px;height:95px;background:#eee;border:1px solid gray;border-top:0;background:#eee url(http://vfilme.ru/img/vfilme4.png) 0 4px no-repeat"> <div style="text-align:right;color:#933;"><span style="border-bottom:1px dashed #933;cursor:pointer;" onclick="this.parentNode.parentNode.parentNode.parentNode.style.display=\'none\';">cкрыть</span></div> <div align="center"><a class=downloadbutton style="display:block;text-align:center;text-decoration:underline;font-size:22px;padding:2px 5px;color:;width:100px;margin-bottom:10px;margin-top:10px" href='+dl+'>		Скачать 	</a> </div> нажмите на ссылку для скачивания правой кнопкой мыши и выберите "Сохранить ссылку как..." или "Сохранить объект как..."	</div></div></div>';
  
  //window.location=window.location+"#vfilme_top";
  
  document.body.appendChild(d);
  }
  
 //javascript:(function(){var s=document.createElement('script');s.src='http://localhost/vf/js/vkontakte.js';s.type='text/javascript';document.getElementsByTagName('head')[0].appendChild(s); })();
//javascript:(function(){var s=document.createElement('script');s.src='http://localhost/vf/js/vkontakte.js?'+Math.random();s.type='text/javascript';document.getElementsByTagName('head')[0].appendChild(s); })();