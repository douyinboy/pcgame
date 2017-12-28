<?php
require_once('../common/common.php');	
include('include/isLogin.php');
require_once('include/cls.show_page.php');
$server_id=$_REQUEST["server_id"]+0;
$game_id=$_REQUEST["game_id"]+0;
$order=$_REQUEST["order"]+0;
$date1=$_REQUEST["date1"];
$date2=$_REQUEST["date2"];
$agent_id = $_REQUEST["agent_id"]+0;
$user_name=strip_tags(trim($_REQUEST["user_name"]));
$pp = isset($_GET['page'])?$_GET['page']:1;
if (!$date1) {
    $date1=date("Y-m-d");
}
if (!$date2) {
    $date2=date("Y-m-d");
}
if ( $order=='' ||  $order ==0) {
    $order = 0;
    $url="?date1=$date1&date2=$date2&game_id=$game_id&server_id=$server_id&order=1";
}  else {
    $url="?date1=$date1&date2=$date2&game_id=$game_id&server_id=$server_id&order=0";
}
$filter=" where b.id=a.game_id ";
if ($date1) {
    $filter.=" and a.pay_date>='$date1'";
}
if ($date2) {
    $filter.=" and a.pay_date<='$date2 23:59:59'";
}
if ($game_id) {
    $filter.=" and a.game_id='$game_id'";
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
if ($order==0) {
    $orderby=" group by a.user_name order by sum_money desc";
} else {
    $orderby=" group by a.user_name order by sum_money asc";
}
$page = new ShowPage;
$page->PageSize = 25;
$sql="select sum(a.money) as sum_money,a.user_name,a.reg_date,a.pay_date,a.agent_id,a.cid,a.from_url from ".PAYDB.".".PAYLIST." a,".PAYDB.".".GAMELIST." b $filter  $orderby ";
$page->Total = $db -> countsql($sql);
$sql.=" limit  ".$page->OffSet();
$paytop_payer_arr = $db ->find($sql);
$showpage = $page->ShowLink();
$game_list_arr = $db ->find("SELECT id,name FROM ".PAYDB.".".GAMELIST." where 1 order by id desc ");
$game_server_list_arr = array();
if($game_id){
    $game_server_list_arr = $db ->find("select distinct server_id,name from ".PAYDB.".".SERVERLIST." where  is_open=1 AND game_id=".$game_id." order by server_id ");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>玩家充值排行</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18702"></HEAD>
<?php require_once('include/head_css_js.php');?>
<script language="javascript" type="text/javascript">
    function game_change(info) {
        if(!info){return false;}
            var uname = $("#user_name").val();
            var date1 = $("#date1").val();
            var date2 = $("#date2").val();
            var agent_id = $("#agent_id").val();
            if(agent_id=='undefined'){
                agent_id='';
            }
        window.location.href='payRanking.php?game_id='+info+'&user_name='+uname+'&date1='+date1+'&date2='+date2+'&agent_id='+agent_id;
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
        &nbsp;玩家账号:
        <INPUT  value="<?=$user_name?>" name="user_name" id="user_name" size=20 >
            &nbsp;渠道ID:<input name="agent_id" id="agent_id" type="text" value="<?=$agent_id?>" size="7">
           &nbsp;游戏：
        <SELECT name="game_id" id="game_id" onChange="game_change(this.value)" ref="server_id">
            <OPTION label="所有游戏" value="" >所有游戏</OPTION>
         <?php foreach( $game_list_arr as $val ) {?>
             <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
        <?php } ?>	
       </SELECT>
           &nbsp;&nbsp;
           服务器：
           <SELECT name="server_id" id="server_id">
            <OPTION label="所有区服" value="" >所有区服</OPTION>
         <?php  foreach( $game_server_list_arr as $val ) {?>
             <OPTION value="<?=$val['server_id']?>" <?php if ( $val['server_id'] == $server_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
        <?php  }?>	
       </SELECT>
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
    <TD width="7%" align=middle>排行</TD>
    <TD width="9%" align=middle>玩家账号</TD>
    <TD width="7%" align=middle>渠道ID</TD>
    <TD width="26%" align=middle>充值游戏区服</TD>
    <TD width="15%" align=middle><a href="<?=$url?>">充值金额<?php if ($order==0) {?><font color='red' size="+2">↓</font><?php } else { ?><font color='red' size="+2">↑</font><?php }?></a></TD>
    <TD width="13%" align=middle>注册时间</TD>
    <TD width="19%" align=middle>最近充值时间</TD>
  </TR>
  <?php 
  $j = 0;
  $i = 0;
  foreach( $paytop_payer_arr as $val ) {
    $sql="select pay_date from ".PAYDB.".".PAYLIST." where user_name='".$val['user_name']."' order by id desc limit 1";
    $payer_pay_date = $db->get($sql);
    $val['pay_date'] = $payer_pay_date['pay_date'];
    $i++;
    $j++;
    $sql = "select b.name as game_name,a.server_id from ".PAYDB.".".PAYLIST." a,".PAYDB.".".GAMELIST." b $filter AND user_name='".$val['user_name']."' group by a.game_id order by a.game_id asc";
    $g_arr = $db ->find($sql);
    $game_list =$game_name ="";
    foreach ( $g_arr  as  $val2 ) {
        if ( $game_name !=$val2['game_name'] ) {
            if ($game_name=="") {
                $game_name = $val2['game_name'];
                $game_list .= $game_name; 
            } else {
                $game_name = $val2['game_name'];
                $game_list .= ")|".$game_name; 
            }
        }
        $game_list .=$val2['server_id']."服"; 
    }
    $agent_id = $adtype[$val['agent_id']] !='' ? $val['cid']:$val['agent_id'];
    $agent_info = $db->get("select * from ".GUILDINFO." where id='$agent_id'");
  ?>
  <TR id=newooo class="<?php if ($j%2==0) echo 'trOdd'; else echo 'trEven';?>"  height="100%" name="newooo">
        <TD align="center" noWrap><?=(($pp-1) * $page->PageSize)+$i?></TD>
        <TD align="center" noWrap><?=$val['user_name']?></TD>
	<TD align=middle><?=$agent_id?></TD>	
	<TD align="center" noWrap><?=$game_list?></TD>
	<TD align="center" noWrap><?=round($val['sum_money'],2)?></TD>
	<TD align="center" noWrap><?=$val['reg_date']?></TD>
	<TD align="center" noWrap><?=$val['pay_date']?></TD>
  </TR>
  <?php 
  }
  ?>
</TBODY></TABLE>
    <DIV align=left style="text-align: center;"><?=$showpage?></DIV>	
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
  </SCRIPT>
</BODY>
</HTML>
