<script language="JavaScript">
function setCookie (name, value, expires, path, domain, secure) {
      document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

  if (confirm("������ � ������ �����. ������������������ ���� ���������! ��� ��� ���� 18 ���?(��=��� ���� 18/������=��� ���� ��� 18)")) {
        setCookie('porn','1');
	parent.location='<?php if($_GET['q']){echo $_GET['q'];}else{echo 'search.php';}  ?>';
	}
  else {
	setCookie('porn','0');
        parent.location='http://vfilme.ru';
	}

</script>
