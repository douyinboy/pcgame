<?php
require_once('../common/common.php');	
include("include/pay_way.inc.php");
require_once('include/ip.php');
include('include/isLogin.php');
$user_name = trim($_REQUEST["user_name"]);
$orderid =trim($_REQUEST["orderid"]);
$game_id =trim($_REQUEST["game_id"]);
$sql="SELECT * FROM ".PAYDB.".".GAMELIST." where is_open=1";
$game_list_arr = $db ->find($sql);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>元宝发放查询</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<?php require_once('include/head_css_js.php');?>
<script language="javascript" type="text/javascript">
    function btnsubmit() {
        $("#myform").submit();
    }
</script>
<BODY>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width="100%" height=32>
  <TBODY>
  <TR class=trEven>
    <TD>
      <DIV class=divOperation>
      <FORM id="myform" method="post" name="myform" action="">
        <INPUT id="act" type=hidden name="act" value="serach" > 
        &nbsp;&nbsp;充值帐号：
        <INPUT  value="<?=$user_name?>" name="user_name" id="user_name" size=20 >
        &nbsp;&nbsp;订单号：
          <INPUT value="<?=$orderid?>" size="30" name="orderid" id="orderid">
            &nbsp;&nbsp;游戏：
          <SELECT name="game_id" id="game_id" >
              <OPTION value="0">全部游戏</OPTION>
              <?php foreach( $game_list_arr as $val ) { ?>
                  <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
              <?php }?>	
           </SELECT>
            <img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
        </FORM>
      </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>
<?php 
if ( $_REQUEST['act'] =='serach' && ($user_name || $orderid)) { //begin 1 if 
        $filter =" WHERE 1";
        $sql="select game from ".PAYDB.".".PAYORDER." where orderid='".$orderid."' AND game !=0 AND server !=0";
        $data = $db ->get($sql);
        if ( $data['game'] >0 ) {
            $game_id  = $data['game'];
        }
        if ( $game_id >0 ) {
        $sql="SELECT * FROM ".PAYDB.".".GAMELIST."  WHERE id=".$game_id;
            $game_list_arr = $db ->findt($sql);
        }
        if ($user_name) {
            $filter .=" AND user_name = '$user_name'";
        }
        if ($orderid) {
            $filter .=" AND orderid = '$orderid'";
        }
        $QQWry=new QQWry;
        foreach ( $game_list_arr as $val) { 
             $game_table ='';
             $game_table = "`pay_".$val['game_byname']."_log`";
             $sql="SELECT * FROM ".PAYDB.".".$game_table." $filter ORDER BY id DESC";
             $pay_logs_arr = $db ->find($sql);
             if ( count( $pay_logs_arr )>0 ) { 
        ?>
                <?=$val['name'].$val['b_name']?>发放情况 查看该用户发放情况<BR>
                <TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=1226 height=40>
                  <TBODY>
                  <TR class=table_list_head>	
                        <TD width="7%" align=middle>玩家帐号</TD>
                        <TD width="14%" align=middle>订单号</TD>
                        <TD width="12%" align=middle>支付日期</TD>
                        <TD width="11%" align=middle><?=$val['b_name']?>数</TD>
                        <TD width="9%" align=middle>充值游戏</TD>
                        <TD width="11%" align=middle>充值游戏区服</TD>
                        <TD width="12%" align=middle>订单状态</TD>
                  </TR>
         <?php
		     $i =0;
		     foreach ($pay_logs_arr as $val2) { 
		 ?>
             <TR id=newooo class="<?php if ($i%2==0) echo 'trOdd'; else echo 'trEven';$i++;?>"  height="100%" name="newooo">
    		 <TD align=middle><?=$val2['user_name']?></TD>
             <TD align=middle><?=$val2['orderid']?></TD>
			 <TD align=middle><?=$val2['pay_date']?></TD>
			 <TD align=middle><?=$val2['pay_gold']?></TD>
             <TD align=middle><?php if ($val['id']) echo $val['name'];else echo '游戏ID：'.$val['id'];?></TD>
             <TD align=middle><?php if ($val2['server_id']>1000 ) echo '合'.($val2['server_id']-1000); else echo $val2['server_id'];?> 服</TD>
             <TD align=middle><?php if ($val2['pay_result']==''){ echo '失败'; } else { echo $val2['pay_result']."(".$val2['back_result'].")"; }?></TD>
             </TR>
		  <?php }  ?>
		  </TBODY></TABLE>
	<?php }   } } ?>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
  </SCRIPT>
</BODY>
</HTML>
