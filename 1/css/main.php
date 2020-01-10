<?php 

  //  header('Cache-Control: max-age=1000');
  header('Pragma: no-cache');

if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'msie')!==False){$msie=true;}; ?>
    *{
      margin:0;
      padding:0;
      border:0;
    }
    #main{
      width:800px;
<?php if($msie){echo 'width:802px;';}; ?>
      border: 1px solid #77A;
      border-top:0;
      border-bottom:0;
      text-align:left;
      overflow:hidden;
    }  
    #mainpagelink{
      width:100%;
      height:40px;
      line-height:40px;
      text-indent:20px;
      background:black;
      color:white;
    }
    #mainpagelink a{
      color:white;
    }
    #description{
      width:100%;
      background: #772;
      font-size:20px;
      color: #DDD;
      padding:6px 0 4px 0;
      text-indent:140px;
      line-height:30px;
    }
    #description a{
      color: #DDD;
      text-decoration: none;
    }
    .searchlabel{
      display:block;
      width:100%;
      text-indent:20px;
      font-size:15px;
      color:black;
      cursor:pointer;
      font-weight:bold;
      text-decoration:none;
    }
    #quicksearch form{
      padding:18px 30px 17px 120px;
      font-size:16px;
    }
    #extsearch form{
      padding:3px 0 15px 69px;
    }
    #extsearch table{
      font-size:16px;
    } 
    #extsearch table td{
      padding:9px 15px 0px 0px;
    }
    .searchform input{
      padding-left:7px;
      border:1px solid #002;
      font-size:15px;
    }
    #quicksearch input{
      width: 500px;
    } 
    #extsearch input{
      width: 490px;
    }
    .metainput{
      color:#777;
    }
    .searchform select{
      width:490px;
      padding-left:7px;
      font-size:15px;
      border:1px solid black;
    }
    #lettersearch div{
      padding: 12px 20px 10px 20px;
      font-size:17px;
      line-height:20px;
    }
    #lettersearch div a{
      cursor:pointer;
      color: black;
      text-decoration:none;
    }
    #selectedl{
      font-weight:bold;
    }
    #clubsearch div{
      margin:10px;
    }
    #clubsearch P{
      margin-bottom:8px;
    }
    #clubsearch div a{
      font-weight:bold;color:black;
    }
    .closesearch{
      margin-bottom:2px;
    }
    .closesearch div{
      position:absolute;
      visibility:hidden;
    }
    .closesearch form{
      position:absolute;
      left:-10000;
    } 
    .opensearch .searchlabel{
       background: #A7A7B7 url(../img/openlabel.png) no-repeat 0 -1px;
       border-top: 1px solid #004;
    }
    .closesearch .searchlabel{
       background: #EEEEE0 url(../img/closelabel.png) no-repeat 0 -1px;
       border-top: 1px solid #AAA;
       color: #777;
    }
    #lastsearch{
      padding-bottom:12px;
      margin-bottom:0;
    }
    .resultslabel{
      width:100%;
      line-height:13px;
      padding:3px 0px 4px 0px;
      border-top:1px solid #004;
      border-bottom:1px solid #004;
      font-size:15px;
      font-weight:bold;
      background:#A7A7B7;
      text-indent:15px;
    }


    .filmactions{
      font-size:14px;
      text-align:left;
      vertical-align:bottom;   
      background-color:white;
    }
    .filmactions div{
      float:left;
      background-color: #EEEEEE;
    }
    .filmactions div a{        
      color:#9999AA;
      text-decoration:none;
    }

   .new{color:#050;padding-right:1px}
.searchlabel .new{color:#080;}
   h1{font-size:16px}
    .opensearch#newsearch{margin-bottom:2px}