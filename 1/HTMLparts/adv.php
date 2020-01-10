<script src='js/jquery-latest.min.js'>
</script>
<style>
button { 
  border:0; 
  cursor:pointer; 
  font-weight:bold; 
  padding:0 20px 0 0; 
  text-align:center; 
}
button span { 
  position:relative; 
  display:block; 
  white-space:nowrap; 
  padding:0 0 0 20px; 
}

/*blue buttons*/
button.submitBtn { 
  background:url(img/btn_blue_right.gif) right no-repeat; 
  font-size:1em;   
}
button.submitBtn span { 
  height:50px; 
  line-height:50px;
  background:url(img/btn_blue_left.gif) left no-repeat;
  color:#fff; 
}
button.submitBtn:hover {
	background:url(img/btn_blue_right_hover.gif) right no-repeat; 
}
button.submitBtn:hover span {
	background:url(img/btn_blue_left_hover.gif) left no-repeat; 	
}
.ban{top:100px}
</style>


<div style='width:800px;height:90px;background:black;position:relative;overflow:hidden'>
	<div class="ban" id="ban1" style='position:absolute;left:50px;font-size:32px;color:white;font-weiglht:bold;line-height:90px;vertical-align:middle'>
		��� ������?
	</div>
	<div class="ban" id="ban2" style='position:absolute;left:245px;font-size:30px;color:#9f9;font-weiglht:bold;line-height:90px;vertical-align:middle'>
		������
	</div>
	<div class="ban" id="ban3" style='position:absolute;left:377px;font-size:30px;color:#f99;font-weiglht:bold;line-height:90px;vertical-align:middle'>
		�����
	</div>
	<div class="ban" id="ban4" style='position:absolute;left:490px;font-size:30px;color:#f99;font-weiglht:bold;margin-top:20px;vertical-align:middle' onclick='window.open("http://www.thelv.ru")'>
		<button value="submit" class="submitBtn"><span>�����</span></button>
	</div>		
</div>

<script>
	mt1=350;
	setTimeout('$("#ban1").animate({top: "0px"}, 1500);',500);
	setTimeout('$("#ban2").animate({top: "0px"}, 1500);',1800+mt1);
	setTimeout('$("#ban3").animate({top: "0px"}, 1500);',3100+mt1);
	setTimeout('$("#ban4").animate({top: "0px"}, 1500);',4400+mt1);
</script>