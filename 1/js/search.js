function searchopenclose(e)
  {
    if(e.parentNode.className=='opensearch'){e.parentNode.className='closesearch';}else
    {
      document.getElementById('quicksearch').className="closesearch";
      document.getElementById('extsearch').className="closesearch";
      document.getElementById('lettersearch').className="closesearch";
      document.getElementById('clubsearch').className="closesearch";
      document.getElementById('newsearch').className="closesearch";
      e.parentNode.className='opensearch';
    }
  }

function showtooresult(e)
  {
    if(e.parentNode.className=='opensearch'){
      e.parentNode.className='closesearch';
      e.parentNode.style.marginTop='-1px';
      e.style.marginTop='0';
      e.innerHTML='�������� ������� ����������';
    }else
    {
      e.parentNode.className='opensearch';
      e.parentNode.style.marginTop='0';
      e.style.marginTop='-1px';
      e.innerHTML='������ ������� ����������';
    }
  }

function closetoores(e)
  {
    e.parentNode.className='closesearch';
    e.parentNode.style.marginTop='-1px';
    var label=e.parentNode.lastChild;
    label.style.marginTop='0';
    label.innerHTML='�������� ������� ����������';
  }

function normalinput(e)
  {
    if(e.className=="metainput"){
      e.value='';
      e.className='';
    }
  }

definfo='��������, ������, ����, ������, ��� � �.�.';
function metainput(e)
  {
    if(e.value==''){
      e.className='metainput';
      e.value=definfo;
    }
  }

function showhidedesc(e)
  {
    desc=e.parentNode;
    if(desc.className=='hidedesc')
    {desc.className='showdesc';
     e.innerHTML='';}
    else
    {desc.className='hidedesc';
     e.innerHTML='�����...';
    }
    {}
  }

function cl(link)
{
 var img = new Image(1,1);
 img.src = 'http://www.liveinternet.ru/click?*' + link;
}
