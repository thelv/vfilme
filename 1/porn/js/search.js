function searchopenclose(e)
  {
    if(e.parentNode.className=='opensearch'){e.parentNode.className='closesearch';}else
    {
      document.getElementById('quicksearch').className="closesearch";
      document.getElementById('extsearch').className="closesearch";
      document.getElementById('lettersearch').className="closesearch";
      e.parentNode.className='opensearch';
    }
  }

function showtooresult(e)
  {
    if(e.parentNode.className=='opensearch'){
      e.parentNode.className='closesearch';
      e.parentNode.style.marginTop='-1px';
      e.style.marginTop='0';
      e.innerHTML='показать похожие результаты';
    }else
    {
      e.parentNode.className='opensearch';
      e.parentNode.style.marginTop='0';
      e.style.marginTop='-1px';
      e.innerHTML='скрыть похожие результаты';
    }
  }

function closetoores(e)
  {
    e.parentNode.className='closesearch';
    e.parentNode.style.marginTop='-1px';
    var label=e.parentNode.lastChild;
    label.style.marginTop='0';
    label.innerHTML='показать похожие результаты';
  }

function normalinput(e)
  {
    if(e.className=="metainput"){
      e.value='';
      e.className='';
    }
  }

definfo='режиссер, актеры, жанр, страна, год и т.д.';
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
     e.innerHTML='далее...';
    }
    {}
  }