try{ajax=new XMLHttpRequest();}catch(e){try{ajax=new ActiveXObject("Microsoft.XMLHTTP");}catch(e){ajax=new ActiveXObject("Msxml2.XMLHTTP");};};
function counter(film)
{
  ajax.open('GET','counter.php?'+film,false);
  ajax.send(null);
}
counter('');
setTimeout('counter(counterparam)',500000);




//������� �������� ���������� urlencode();������ ������.
//________http://xpoint.ru/know-how/JavaScript/PoleznyieFunktsii?38#EscapeSovmestimyiySRusskimiBuk

var trans = [];
for (var i = 0x410; i <= 0x44F; i++)
  trans[i] = i - 0x350; // �-��-�
trans[0x401] = 0xA8;    // �
trans[0x451] = 0xB8;    // �

// ��������� ����������� ������� escape()
var escapeOrig = window.escape;

// �������������� ������� escape()
window.escape = function(str)
{
  var ret = [];
  // ���������� ������ ����� ��������, ������� ��������� ���������
  for (var i = 0; i < str.length; i++)
  {
    var n = str.charCodeAt(i);
    if (typeof trans[n] != 'undefined')
      n = trans[n];
    if (n <= 0xFF)
      ret.push(n);
  }
  return escapeOrig(String.fromCharCode.apply(null, ret));
}


//!!!!________http://xpoint.ru/know-how/JavaScript/PoleznyieFunktsii?38#EscapeSovmestimyiySRusskimiBuk






function claim(e)
{
  ajax.open('GET','claim.php?'+escape(document.getElementById('claimfilm').value),false);
  ajax.send(null);
  e.parentNode.parentNode.innerHTML='���� ������ ��������������...';
  //ajax.responseText;
  document.getElementById('emptyresult').innerHTML='������� �� �������, ���� ������ �������';
}

function vk_comment_callback(num,last_comment,date,sign)
{
	film=window.location.href;
	film=film.substr(film.lastIndexOf('film=')+5);
	film=escape(film);
	text=escape(last_comment);
	if(text!='')
	{
		ajax.open('GET','php/add_comment.php?film='+film+'&text='+text,false);
		ajax.send(null);
	}
}