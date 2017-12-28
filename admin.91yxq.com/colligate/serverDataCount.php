<?php
require_once('../common/common.php');	
include('include/isLogin.php');
$server_id=$_REQUEST["server_id"]+0;
$game_id=$_REQUEST["game_id"]+0;
$tdate=$_REQUEST["tdate"];
if (!$tdate){ $tdate=date('Y-m-d',time());}
$money = $_REQUEST['money']+0;
$type = $_REQUEST['type']+0;
if ($_SESSION['sp_gamelist']) {
    $arr=explode('|',$_SESSION['sp_gamelist']);
    $sp_gamelist= $arr[0];
    $first_game = explode(',',$sp_gamelist);
    if ( !$game_id ) $game_id = $first_game[0];
}
$filter=" where 1 ";
if ($game_id) {
    $filter.=" and game_id='$game_id'";
}
if ($server_id) {
    $filter.=" and server_id='$server_id'";
}
if ($sp_gamelist) {
    $filter.=" and game_id in ($sp_gamelist)";
    $s = " WHERE 1 AND id IN ($sp_gamelist);"; 
}
if ( $type==1 ) {
    $sql="select sum(money) as pay_sum,count(user_name) as pt,count(distinct user_name) as p,server_id,game_id from ".PAYDB.".".PAYLIST." $filter AND game_id >0 AND server_id >0 and pay_date<='$tdate 23:59:59' group by game_id,server_id order by  pay_sum desc";
} else {
    $sql="select sum(money) as pay_sum,count(user_name) as pt,count(distinct user_name) as p,server_id,game_id from ".PAYDB.".".PAYLIST." $filter AND game_id >0 AND server_id >0 and pay_date<='$tdate 23:59:59' group by game_id,server_id order by server_id desc";
}

$pay_game_arr = $db ->find($sql);

$game_list_arr = $db ->find("SELECT id,name,game_byname FROM db_5399_pay.`game_list` $s ");
$game_server_list_arr = $db ->find("select distinct(server_id),name from db_5399_pay.game_server_list where game_id='$game_id' order by server_id desc");
foreach($game_server_list_arr as $val){
    $game_server_arr[$val['server_id']]=$val['name'];
}
foreach($game_list_arr as $val){
    $game_arr[$val['id']]=$val['name'];
    $game_byname[$val['id']]=$val['game_byname'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>各服总收入统计</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18702"></HEAD>
<?php require_once('include/head_css_js.php');?>
<script language="javascript" type="text/javascript">
   function btnsubmit() {
   $("#myform").attr("action","?user_name="+$("#user_name").val()+"&date1="+$("#date1").val()+"&date2="+$("#date2").val()+"&agent_id="+$("#agent_id").val()+"&game_id="+$("#game_id").val()+"&server_id="+$("#server_id").val());
   $("#myform").submit();
   }
var pro_str=<?=json_encode($game_arr)?>;
var pro_str_byname=<?=json_encode($game_byname)?>;
</script>
<BODY>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width="100%" height=32>
  <TBODY>
  <TR class=trEven>
    <TD>
      <DIV class=divOperation>
        <FORM id="myform" method="post" name="myform" action="">
            <INPUT id="act" type=hidden name="act" value="serach" >
            &nbsp;游戏：
            <SELECT name="game_id" id="game_id" onChange="document.location.href='serverDataCount.php?game_id='+this.value;">
                <OPTION label="所有游戏" value="" >所有游戏</OPTION>
            <?php foreach( $game_list_arr as $val ) { ?>
                <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
            <?php } ?>	
            </SELECT><input type="text" value="输入关键字" id="pro_keyword" size="8">
               &nbsp;&nbsp;
                服务器：
            <SELECT name="server_id" id="server_id">
                <OPTION label="所有区服" value="" >所有区服</OPTION>
            <?php foreach( $game_server_arr as $id=>$val ) { ?>
                <OPTION value="<?=$id?>" <?php if ( $id == $server_id ) { echo 'selected="selected"'; }?>><?=$val?></OPTION>
            <?php }?>	
            </SELECT>
           &nbsp;&nbsp;自开服到：
            <INPUT  value="<?=$tdate?>" name="tdate" id="tdate" size="20" onClick="WdatePicker();" >
            <img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
            注：本数据会定时更新
        </FORM>
      </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>
    
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=1230 height=40>
  <TBODY>
    <TR class=table_list_head>
        <TD width="6%" align=middle>游戏区服</TD>
        <TD width="6%" align=middle><a href="?game_id=<?=$game_id?>&server_id=<?=$server_id?>&type=1">支付金额<?php if (!$money) {?><font color='red' size="+2">↓</font><?php } else { ?><font color='red' size="+2">↑</font><?php }?></a></TD>
	<TD width="6%" align=middle>付费次数</TD>
	<TD width="7%" align=middle>付费人数</TD>
        <TD width="5%" align=middle>ARPU值</TD>
  </TR>
<?php 
    $i = 0;
    foreach( $pay_game_arr as $val ) {
        $pay_sum_s += $val['pay_sum'];
        $pt_s += $val['pt'];
        $p_s += $val['p'];
?>
  <TR id=newooo class="<?php if ($i%2==0) echo 'trOdd'; else echo 'trEven';?>"  height="100%" name="newooo">
    <TD align=middle><?=$game_arr[$val['game_id']].$val['server_id'].'服'; ?></TD>
    <TD align=middle><?=round($val['pay_sum'],2)?></TD>
    <TD align=middle><?=$val['pt']?></TD>
    <TD align=middle><?=$val['p']?></TD>
    <TD align=middle><?php if ( $val['p']>0 ) echo round($val['pay_sum']/$val['p'],2);else echo '0';?></TD>  
  </TR>
<?php $i++;}?>
  <TR id=newooo class="trOdd"  height="100%" name="newooo">
    <TD align=middle>合计</TD>
    <TD align=middle><?=round($pay_sum_s,2)?></TD>
    <TD align=middle><?=$pt_s?></TD>
    <TD align=middle><?=$p_s?></TD>
    <TD align=middle><?php if ( $p_s>0 ) echo round($pay_sum_s/$p_s,2);else echo '0';?></TD>  
  </TR>
</TBODY></TABLE>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
	search_pro();
  </SCRIPT>
</BODY>
</HTML>
