<?php 

  //  header('Cache-Control: max-age=1000');
  header('Pragma: no-cache');

if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'msie')!==False){$msie=true;}; ?>
    .findtext{
      background-color:#AAF;
      color:black;
    }
    .resultslabel a{
      font-size:15px;
      font-weight:bold;
      color:black;
      text-decoration:none;
      cursor:pointer;
    }
    .pages{
      padding-top:2px;
<?php if($msie){echo 'padding-top:1px;';} ?>
      position:absolute;
      width:788px;
      text-align:right;
      font-weight:bold;
      font-size:14px;
    }
    .pages a{
      text-decoration:none;
      color:black;
    }
    .pages form{
      display:inline;
    }
    .pages input{
      font-weight:bold;
      height:18px;
      border:1px solid #004;
      width:15px;
      text-align:center;
      font-size:14px;
    }
    .pages span{
      padding-left:7px;
    }

    .film{
      border-top:1px solid #77E;
      border-bottom:1px solid #77E;
      width:100%;
      margin-top:15px;
      overflow:visible;
    }
    .filmimg{
      background-color: #EEEEEE;
    }
    .filmimg a img{
      width:250px;
      height:188px;
      border:0;
      margin-top:-1px;
      margin-bottom:-1px;
    }
    .aboutfilm{
      padding:3px 30px 20px 30px;
      font-size:15px;
      background:white;
      overflow:visible;
    }
    .hidedesc span{
      display:block;
      position:absolute;
      visibility:hidden;  
      color:red;
    }
    .showdesc span{
      /*position:relative;
      visibility:visible;*/
      display:inline;
    }
    .deschider{
      color:#871727;
      text-decoration:underline;
      cursor:pointer;
    }
    .filmname{
      font-size:14px;
      font-weight:bold;
      text-align:left;
      margin-bottom:11px;
    }


    .tooreslabel{
      margin-top:0px;
      border-top:1px solid #AAA;
      border-bottom:1px solid #77E;
      display:block;
      width:100%;
      text-indent:20px;
      font-size:15px;
      color:#777;
      cursor:pointer;
      font-weight:bold;
      background-color:#EEEEEE;
    }
    .opensearch .tooreslabel{
      color:black;
    }
    .opensearch .toorestab{
      position:relative;
      visibility:visible;
    }
    .closesearch .toorestab{
      position:absolute;
      visibility:hidden;
    }
    .toorestab{
      display:block;
      width:100%;;
      height:15px;
      margin-bottom:-15px;
      cursor:pointer;
    }

  #main{
    overflow:visible;
  }