<?php 

//  header('Cache-Control: max-age=1000');
  header('Pragma: no-cache');
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'msie')!==False){$msie=true;}; ?>
    #wfilm{
      float:left;
      padding:0px 20px 0px 0px;
      width:780px;
<?php  if($msie){echo  "width:800px;\r\n";}  ?>
      font-size:15px;
    }
    #flash_player_container_outer{
      float:left;
      background:#E0E0D6;
  /*    padding:11px 42px 14px 38px;*/
      padding:11px 0px 14px 0px;
      border-right:1px solid black;
    }
    #flash_player_containter{
/*      height:343px;width:458px;  */
    }

  #wfilmactions{
    width:540px;
    <?php if($msie){echo "width:541px;";} ?>
  }
  #wfilmactions a{
    text-decoration:none;
    color:black;
  }
  .resultslabel{
    margin-top:3px;
    text-align:center;
    text-indent:0;
  }
  body{
    background-color:/*#FBFBFA*/#FDFDFC;;
  }
  #main{
    background-color:white;
  }