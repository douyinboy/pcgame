<?php
require_once('../common/common.php');
include('include/isLogin.php');	
require_once('include/cls.show_page.php');
include("include/pay_way.inc.php");
$server_id=$_REQUEST["server_id"];
$game_id=$_REQUEST["game_id"]+0;
$money=$_REQUEST["money"];
$time=$_REQUEST["time"];
$type=$_REQUEST["type"];
$date1=$_REQUEST["date1"];
$date2=$_REQUEST["date2"];
$agent_id = $_POST["agent_id"];
$user_name=$_REQUEST["user_name"];
$money_s = $_REQUEST["money_s"];
$money_e = $_REQUEST["money_e"];
$pp = isset($_GET['page'])?$_GET['page']:1;
if (!$date1) {
    $date1=date("Y-m-d");
}
if (!$date2) {
    $date2=date("Y-m-d");
}
$filter=" where b.id=a.game_id  and  a.game_id !=0 AND server_id !=0  ";
if ($date1) {
    $filter.=" and pay_date>='$date1'";
}
if ($date2) {
    $filter.=" and pay_date<='$date2 23:59:59'";
}
if ($game_id) {
    $filter.=" and a.game_id='$game_id'";
}
if ($money_s) {
    $filter.=" and a.money >='$money_s'";
}
if ($money_e) {
    $filter.=" and a.money <= '$money_e'";
}
if ($server_id) {
    $filter.=" and a.server_id='$server_id'";
}
if ($user_name) {
    $filter.=" and user_name='$user_name'";
}
if ( $agent_id ) {
    if (($adtype[$agent_id] !='' || $agent_id<1000)) {
         $filter.=" and cid='$agent_id'";
    } else {
        $filter.=" and agent_id='$agent_id'";
    }
}
if ( $type==1 ) {
    if ($money) {
        $money =0;
        $orderby=" order by money desc";
    } else {
        $money =1;
        $orderby=" order by money asc";
    }
} else if ( $type==2 ) {
    if ($time) { $time =0;} else { $time =1;}
    $orderby=" order by reg_date asc";
}else{
    $orderby=" order by pay_date desc";
}
$page = new ShowPage;
$page->PageSize = 25;
$sql="select a.*,b.name as game_name from ".PAYDB.".".PAYLIST." a,".PAYDB.".".GAMELIST." b ".$filter.$orderby ;
$page->Total = $db -> countsql($sql);
$sql.=" limit  ".$page->OffSet();
$pay_payer_arr = $db ->find($sql);
$showpage = $page->ShowLink();
$game_list_arr = $db ->find("SELECT id,name FROM ".PAYDB.".".GAMELIST." where 1 order by id desc");
$game_server_list_arr =array();
if($game_id){
    $game_server_list_arr = $db ->find("select distinct server_id,name from ".PAYDB.".".SERVERLIST." where  is_open=1 and game_id=".$game_id ."  order by server_id ");
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>玩家充值明细</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18702"></HEAD>
<?php require_once('include/head_css_js.php');?>
<script language="javascript" type="text/javascript">
    function game_change(info) {
        if(!info){return false;}
            var uname = $("#user_name").val();
            var date1 = $("#date1").val();
            var date2 = $("#date2").val();
   window.location.href='payList.php?game_id='+info+'&user_name='+uname+'&date1='+date1+'&date2='+date2;
   }
   function btnsubmit() {
   $("#myform").attr("action","?user_name="+$("#user_name").val()+"&date1="+$("#date1").val()+"&date2="+$("#date2").val()+"&agent_id="+$("#agent_id").val()+"&game_id="+$("#game_id").val()+"&server_id="+$("#server_id").val());
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
      日期：
	  <INPUT value="<?=$date1?>" onClick="WdatePicker()"  size=12 name="date1" id="date1"> -
	  <INPUT value="<?=$date2?>" onClick="WdatePicker()"  size=12 name="date2" id="date2">
      &nbsp;帐号:
      <INPUT  value="<?=$user_name?>" name="user_name" id="user_name" size=15 >
	 渠道ID:<INPUT  value="<?=$agent_id?>" name="agent_id" id="agent_id" size=5 >
	 &nbsp;游戏：
      <SELECT name="game_id" id="game_id" onChange="game_change(this.value)">
	  <OPTION label="所有游戏" value="" >所有游戏</OPTION>
       <?php foreach( $game_list_arr as $val ) {?>
           <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
      <?php }?>	
     </SELECT>
	 &nbsp;
	 服区：
	 <SELECT name="server_id" id="server_id">
	  <OPTION label="所有区服" value="" >所有区服</OPTION>
       <?php foreach( $game_server_list_arr as $val ) {?>
           <OPTION value="<?=$val['server_id']?>" <?php if ( $val['server_id'] == $server_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
      <?php }?>	
     </SELECT>
         &nbsp;金额：<INPUT  value="<?=$money_s?>" name="money_s" id="money_s" size=5 > - <INPUT  value="<?=$money_e?>" name="money_e" id="money_e" size=5 >
        <img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
    </FORM>
      </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=1230 height=40>
  <TBODY>
    <TR class=table_list_head>
        <TD width="3%" align=middle>序号</TD>
        <TD width="7%" align=middle>玩家账号</TD>
        <TD width="15%" align=middle>注册链接</TD>
        <TD width="12%" align=middle>公会名称（ID）</TD>
        <TD width="20%" align=middle>充值游戏区服</TD>
        <TD width="8%" align=middle>支付方式</TD>
	<TD width="10%" align=middle><a href="?date1=<?=$date1?>&date2=<?=$date2?>&game_id=<?=$game_id?>&server_id=<?=$server_id?>&money=<?=$money?>&type=1">充值金额<?php if (!$money) {?><font color='red' size="+2">↓</font><?php } else { ?><font color='red' size="+2">↑</font><?php }?></a></TD>
	<TD width="10%" align=middle>充值时间</TD>
	<TD width="10%" align=middle><a href="?date1=<?=$date1?>&date2=<?=$date2?>&game_id=<?=$game_id?>&server_id=<?=$server_id?>&time=<?=$time?>&type=2">注册时间<?php if (!$time) {?><font color='red' size="+2">↓</font><?php } else { ?><font color='red' size="+2">↑</font><?php }?></a></TD>
    </TR>
<?php 
    $j = 0;
    $i = 0;
    foreach( $pay_payer_arr as $val ) {
        $i++; $j++;
	$furl=$val['from_url'];
        if (strlen($furl)>50) {
            $furl=substr($furl,0,30)."...".substr($furl,-10);
        }
	$agent_id = $adtype[$val['agent_id']] !='' ? $val['cid']:$val['agent_id'];
        $agent_info = $db->get("select * from ".GUILDINFO." where id='$agent_id'");
  ?>
    <TR id=newooo class="<?php if ($j%2==0) echo 'trOdd'; else echo 'trEven';?>"  height="100%" name="newooo">
        <TD align=middle><?=(($pp-1) * $page->PageSize)+$i?></TD>
        <TD align=left><?=$val['user_name']?></TD>
        <TD align=left><?php if($val['from_url']){?><a href='<?=$val['from_url']?>' target='_blank'><?=$furl?></a><?php }else{echo'未知来路';}?></TD>
        <TD align=left><?=empty($agent_info['agentname']) ? "--":$agent_info['agentname']?>（<?=$agent_id?>）</TD>
        <TD align=middle><?=$val['game_name']?>-<?=$val['server_id']?>服</TD>
	<TD align=left><?=$pay_way_arr[$val['pay_way_id']]['payname']?></TD>
	<TD align=middle><?=$val['money']?></TD>
	<TD align=middle><?=$val['pay_date']?></TD>
	<TD align=middle><?=$val['reg_date']?></TD>
  </TR>
  <?php } ?>
</TBODY></TABLE>
    <DIV align=left style="text-align:center;"><?=$showpage?></DIV>	
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
  </SCRIPT>
</BODY>
</HTML>
