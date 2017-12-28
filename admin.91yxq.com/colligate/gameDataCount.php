<?php
require_once('../common/common.php');
include('include/isLogin.php');	
include("include/pay_way.inc.php");
$tdate = $_REQUEST["tdate"];
$orderby = $_REQUEST["orderby"];
$moneytype = $_REQUEST['moneytype']+0;
$timetype = $_REQUEST['timetype']+0;
$game_id = $_REQUEST["game_id"]+0;
$server_id = $_REQUEST["server_id"]+0;
! $tdate && $tdate = date("Y-m-d");

! $orderby && $orderby = 'total';

$money_type = 'money';
$moneytype == 2 && $money_type = 'paid_amount';
$timetype == 0 && $timetype=2;
$his = $timetype == 1 ? date(' H:i:s') : ' 23:59:59';
//昨天----------------------------上周【同天】---------------------//
$yesterday = date('Y-m-d', strtotime($tdate) - 3600 * 24);
$lastweek = date('Y-m-d', strtotime($tdate) - 3600 * 24 * 7);
$game_list_arr = $db ->find("SELECT * FROM ".PAYDB.".".GAMELIST." where 1  ORDER by id DESC ");
foreach ($game_list_arr as $v){
    $game_arr[$v['id']]=$v;
}
$filter='';
$game_id > 0 && $filter .= ' AND `game_id` =' . $game_id;
$server_id > 0 && $filter .= ' AND `server_id` =' . $server_id;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>收入合计查询</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18702"></HEAD>
<?php require_once('include/head_css_js.php');?>
<script language="javascript" type="text/javascript">
    function game_change(info) {
        if(!info){return false;}
            var uname = $("#user_name").val();
            var date1 = $("#tdate").val();
   window.location.href='gameDataCount.php?game_id='+info+'&user_name='+uname+'&tdate='+date1;
   }
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
      &nbsp;&nbsp;充值日期：
      <INPUT  value="<?=$tdate?>" name="tdate" id="tdate" size="20" onClick="WdatePicker();" >
      &nbsp;&nbsp;游戏：
      <SELECT name="game_id" id="game_id" onChange="game_change(this.value)">
	  <OPTION label="所有游戏" value="all" >所有游戏</OPTION>
       <?php  foreach( $game_list_arr as $val ) {?>
           <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
      <?php  } ?>	   
     </SELECT>
	 
     &nbsp;&nbsp;排序：
      <SELECT name="orderby" id="orderby">
	  <OPTION value="total" >按游戏总收入排序↓</OPTION>
      <OPTION value="arpu" <?php if($orderby=='arpu'){ echo 'selected="selected"'; } ?> >ARPU值↓</OPTION>
      <OPTION value="user" <?php if($orderby=='ucount'){ echo 'selected="selected"'; } ?> >付费用户↓</OPTION>
     </SELECT>   
	 &nbsp;&nbsp; 查看类型：
     <SELECT name="moneytype" id="moneytype">
      <OPTION value="1" <?php if($moneytype=='1'){ echo 'selected="selected"'; } ?> >充值面额</OPTION>
      <OPTION value="2" <?php if($moneytype=='2'){ echo 'selected="selected"'; } ?> >充值净值</OPTION>
     </SELECT> 
	 &nbsp;&nbsp; 时段选择：
     <SELECT name="timetype" id="timetype">
      <OPTION value="1" <?php if($timetype=='1'){ echo 'selected="selected"'; } ?> >现时</OPTION>
      <OPTION value="2" <?php if($timetype=='2'){ echo 'selected="selected"'; } ?> >整天</OPTION>
     </SELECT> 
	 &nbsp;&nbsp;
        <img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
         </FORM>
      </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>
  <?php 
//当前时间【所选时间】查询各游戏区服各渠道收入情况【付款人数、金额、渠道、游戏区服】
    $sql="SELECT COUNT(DISTINCT `user_name`) AS `user`,ROUND(SUM(`{$money_type}`),1) AS money, `pay_way_id`,`game_id`,`server_id` FROM ".PAYDB.".".PAYLIST." WHERE `pay_date`>='{$tdate} 00:00:00' AND `pay_date`<='{$tdate}{$his}' AND `game_id`>0 {$filter} GROUP BY `game_id`,`server_id`,`pay_way_id` ORDER BY money DESC";
    $todaypay = $db ->find($sql);
    $game_pay_arr = $server_pay_arr = $hj=array();
    foreach ($todaypay as $v){
        $game_pay_arr[$v['game_id']][$v['pay_way_id']] += $v['money']; //各游戏渠道金额
        $game_pay_arr[$v['game_id']]['game_id'] = $v['game_id']; 
        $game_pay_arr[$v['game_id']]['user'] += $v['user']; //各游戏付款人数
        $game_pay_arr[$v['game_id']]['total'] += $v['money']; //各游戏总流水
        $hj['game'][$v['pay_way_id']] += $v['money']; 
        $hj['game']['user'] += $v['user'];
        $hj['game']['total'] += $v['money'];
        $server_pay_arr[$v['game_id']][$v['server_id']][$v['pay_way_id']] += $v['money'];
        $server_pay_arr[$v['game_id']][$v['server_id']]['user'] += $v['user'];
        $server_pay_arr[$v['game_id']][$v['server_id']]['game_id'] = $v['game_id'];
        $server_pay_arr[$v['game_id']][$v['server_id']]['total'] += $v['money'];
        $hj['server'][$v['pay_way_id']] += $v['money']; 
        $hj['server']['user'] += $v['user'];
        $hj['server']['total'] += $v['money'];
    }
//当前时间【所选时间】各游戏区服首充情况【游戏、服区、金额】
    $sql="SELECT `game_id`,`server_id`,ROUND(SUM(`money`),1) AS money FROM ".PAYDB.".".PAYFIRST." WHERE `pay_time` >= ".strtotime($tdate.' 00:00:00')." AND `pay_time` <= ".strtotime($tdate.$his)." AND `state`=1 {$filter} GROUP BY `game_id`,`server_id` ORDER BY money DESC";
    $todaypay_f = $db ->find($sql);
    foreach ($todaypay_f as $v){
        $game_pay_arr[$v['game_id']]['first'] += $v['money']; //各游戏首充
        $game_pay_arr[$v['game_id']]['total'] += $v['money']; //各游戏总流水
        $hj['game']['first'] += $v['money'];
        $hj['game']['total'] += $v['money'];
        $server_pay_arr[$v['game_id']][$v['server_id']]['first'] += $v['money']; //各游戏区服首充
        $server_pay_arr[$v['game_id']][$v['server_id']]['total'] += $v['money']; //各游戏区服总流水
        $hj['server']['first'] += $v['money'];
        $hj['server']['total'] += $v['money'];
    }
//当前时间【所选时间】各游戏区服各类型【1表示平台发放，2表示公会赔付】内充情况【游戏、区服、类型id,金额】
    $sql="SELECT `game_id`,`server_id`,`pay_type`,SUM(`money`) AS money FROM ".PAYDB.".".PAYINNER." WHERE `pay_time` >= ".strtotime($tdate.' 00:00:00')." AND `pay_time` <= ".strtotime($tdate.$his)." AND `state`=1 {$filter} GROUP BY `game_id`,`server_id`,`pay_type` ORDER BY money DESC";
    $todaypay_n= $db ->find($sql);
    foreach ($todaypay_n as $v){
        $game_pay_arr[$v['game_id']]['inner'][$v['pay_type']] += $v['money'];
        $game_pay_arr[$v['game_id']]['total'] += $v['money']; //各游戏总流水
        $hj['game']['inner'][$v['pay_type']] += $v['money'];
        $hj['game']['total'] += $v['money'];
        $server_pay_arr[$v['game_id']][$v['server_id']]['inner'][$v['pay_type']] += $v['money'];
        $hj['server']['inner'][$v['pay_type']] += $v['money'];
        $hj['server']['total'] += $v['money'];
    }
//当前时间【所选时间】各游戏区服V充情况【游戏、区服、金额】    
    $sql="SELECT `game_id`,`server_id`,SUM(`money`) AS money FROM ".PAYDB.".".PAYVIP." WHERE `pay_time` >= ".strtotime($tdate.' 00:00:00')." AND `pay_time` <= ".strtotime($tdate.$his)." AND `state`=1 {$filter} GROUP BY `game_id`,`server_id` ORDER BY money DESC";	
    $total_v = $db ->find($sql);
    foreach ($total_v as $v){
        $game_pay_arr[$v['game_id']]['vip'] += $v['money'];
        $game_pay_arr[$v['game_id']]['total'] += $v['money']; //各游戏总流水
        $hj['game']['vip'] += $v['money'];
        $hj['game']['total'] += $v['money'];
        $server_pay_arr[$v['game_id']][$v['server_id']]['vip'] = $v['money'];
        $hj['server']['vip'] += $v['money'];
        $hj['server']['total'] += $v['money'];
    }
//昨天【所选时间】各游戏区服收入情况【金额、游戏、区服】
    $sql="SELECT ROUND(SUM( `{$money_type}` ),1) AS money,`game_id`,`server_id` FROM ".PAYDB.".".PAYLIST." WHERE `pay_date` >= '{$yesterday} 00:00:00' AND `pay_date` <= '{$yesterday}{$his}' AND `game_id`>0 {$filter} GROUP BY `game_id`,`server_id` ORDER BY money DESC ";
    $yester_result = $db ->find($sql);
    foreach ($yester_result as $v){
        $game_pay_arr[$v['game_id']]['yesterday'] += $v['money'];
        $hj['game']['yesterday'] += $v['money'];
        $server_pay_arr[$v['game_id']][$v['server_id']]['yesterday'] = $v['money'];
        $hj['server']['yesterday'] += $v['money'];
    }
//昨天【所选时间】各游戏区服首充情况【游戏、区服、金额】
    $sql="SELECT `game_id`,`server_id`,ROUND(SUM(`money`),1) AS money FROM ".PAYDB.".".PAYFIRST." WHERE `pay_time` >= ".strtotime($yesterday.' 00:00:00')." AND `pay_time` <= ".strtotime($yesterday.$his)." AND `state`=1 {$filter} GROUP BY `game_id`,`server_id` ORDER BY money DESC";
    $total_f = $db ->find($sql);
    foreach ($total_f as $v){
        $game_pay_arr[$v['game_id']]['yesterday'] += $v['money'];
        $hj['game']['yesterday'] += $v['money'];
        $server_pay_arr[$v['game_id']][$v['server_id']]['yesterday'] += $v['money'];
        $hj['server']['yesterday'] += $v['money'];
    }
//昨天【所选时间】各游戏区服各类型【1表示平台发放，2表示公会赔付】内充情况【游戏、区服、类型id,金额】
    $sql="SELECT `game_id`,`server_id`,`pay_type`,SUM(`money`) AS money FROM ".PAYDB.".".PAYINNER." WHERE `pay_time` >= ".strtotime($yesterday.' 00:00:00')." AND `pay_time` <= ".strtotime($yesterday.$his)." AND `state`=1 {$filter} GROUP BY `game_id`,`server_id`,`pay_type` ORDER BY money DESC ";
    $total_n = $db ->find($sql);
    foreach ($total_n as $v){
        $game_pay_arr[$v['game_id']]['yesterday'] += $v['money'];
        $hj['game']['yesterday'] += $v['money'];
        $server_pay_arr[$v['game_id']][$v['server_id']]['yesterday'] += $v['money'];
        $hj['server']['yesterday'] += $v['money'];
    } 
//昨天【所选时间】各游戏区服V充情况【游戏、区服、金额】
    $sql="SELECT `game_id`,`server_id`,SUM(`money`) AS money FROM ".PAYDB.".".PAYVIP." WHERE `pay_time` >= ".strtotime($yesterday.' 00:00:00')." AND `pay_time` <= ".strtotime($yesterday.$his)." AND `state`=1 {$filter} GROUP BY `game_id`,`server_id` ORDER BY money DESC";	
    $total_v = $db->find($sql);
    foreach ($total_v as $v){
        $game_pay_arr[$v['game_id']]['yesterday'] += $v['money'];
        $hj['game']['yesterday'] += $v['money'];
        $server_pay_arr[$v['game_id']][$v['server_id']]['yesterday'] += $v['money'];
        $hj['server']['yesterday'] += $v['money'];
    }
//上周各游戏区服充值情况【游戏、区服、金额】
    $sql="SELECT ROUND(SUM( `{$money_type}` ),1) AS money,`game_id`,`server_id` FROM ".PAYDB.".".PAYLIST."  WHERE `pay_date` >= '{$lastweek} 00:00:00' AND `pay_date` <= '{$lastweek}{$his}' AND `game_id`>0 {$filter} GROUP BY `game_id`,`server_id` ORDER BY money DESC";	
    $week_result = $db ->find($sql);
    foreach ($week_result as $v){
        $game_pay_arr[$v['game_id']]['week'] += $v['money'];
        $hj['game']['week'] += $v['money'];
        $server_pay_arr[$v['game_id']][$v['server_id']]['week'] += $v['money'];
        $hj['server']['week'] += $v['money'];
    }
//上周各游戏区服首充情况【游戏、区服、金额】  
    $sql="SELECT `game_id`,`server_id`,round(SUM(`money`),1) AS money FROM ".PAYDB.".".PAYFIRST." WHERE `pay_time` >= ".strtotime($lastweek.' 00:00:00')." AND `pay_time` <= ".strtotime($lastweek.$his)." AND `state`=1 {$filter} GROUP BY `game_id`,`server_id` ORDER BY money DESC";
    $total_f = $db ->find($sql);
    foreach ($total_f as $v){
        $game_pay_arr[$v['game_id']]['week'] += $v['money'];
        $hj['game']['week'] += $v['money'];
        $server_pay_arr[$v['game_id']][$v['server_id']]['week'] += $v['money'];
        $hj['server']['week'] += $v['money'];
    }
//上周各游戏区服各类型【1表示平台发放，2表示公会赔付】内充情况【游戏、区服、类型id,金额】
    $sql="SELECT `game_id`,`server_id`,`pay_type`,SUM(`money`) AS money FROM ".PAYDB.".".PAYINNER." WHERE `pay_time` >= ".strtotime($lastweek.' 00:00:00')." AND `pay_time` <= ".strtotime($lastweek.$his)." AND `state`=1 {$filter} GROUP BY `game_id`,`server_id`,`pay_type` ORDER BY money DESC";
    $total_n = $db ->find($sql);
    foreach ($total_n as $v){
        $game_pay_arr[$v['game_id']]['week'] += $v['money'];
        $hj['game']['week'] += $v['money'];
        $server_pay_arr[$v['game_id']][$v['server_id']]['week'] += $v['money'];
        $hj['server']['week'] += $v['money'];
    }
//上周【所选时间】各游戏区服V充情况【游戏、区服、金额】
    $sql="SELECT `game_id`,`server_id`,SUM(`money`) AS money FROM ".PAYDB.".".PAYVIP." WHERE `pay_time` >= ".strtotime($lastweek.' 00:00:00')." AND `pay_time` <= ".strtotime($lastweek.$his)." AND `state`=1 {$filter} GROUP BY `game_id`,`server_id` ORDER BY money DESC";
    $total_v = $db ->find($sql);
    foreach ($total_v as $v){
        $game_pay_arr[$v['game_id']]['week'] += $v['money'];
        $hj['game']['week'] += $v['money'];
        $server_pay_arr[$v['game_id']][$v['server_id']]['week'] += $v['money'];
        $hj['server']['week'] += $v['money'];
    }
    /***********插入arpu值 便于排序************/
    $game_pay_arr1=$orderby_arr =$server_pay_arr1=array();
    foreach ($game_pay_arr as  $key=>$val){  //按游戏
        $val['arpu']=$val['user'] <=0 ? "0":round($val['total']/$val['user'],2);
        $game_pay_arr1[$key]=$val;
    }
    foreach($game_pay_arr1 as $k=>$v){
        $orderby_arr[$k]= $v[$orderby];
    }
    array_multisort($orderby_arr, SORT_DESC,$game_pay_arr1);

?>
<!-----------------------------------------------按游戏统计------------------------------------------>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=2>
  <TBODY>
    <TR class=table_list_head>
        <TD width="37" noWrap>游戏区服</TD>
    <?php foreach ($pay_way_arr as $k =>$v){ ?>
        <TD width=75><?=$v['payname']?></TD>
    <?php } ?>
        <TD width="65">首充金额</TD>
        <TD width="65">VIP基恩</TD>
        <TD width="65">平台垫付</TD>
        <TD width="65">公会赔付</TD>
        <TD width="83">支付用户量</TD>
        <TD width="81">合计</TD>
        <TD width="65">ARPU值</TD>
        <TD width="74">收入比例</TD>
        <TD width="66">昨天增长</TD>
        <TD width="75">上周增长</TD>
  </TR>
  <!----
  ARPU值=总金额/付款人数；
  收入比例=各游戏总金额/总金额；
  昨天增长=今天金额-昨天金额；
  上周增长=今天金额-上周同一天金额
  ---->
<?php
    $i=0;
    foreach($game_pay_arr1 as $k=>$v){
        if($v['game_id']>0){
  ?>
    <TR class=<?php if ($i%2==0) echo 'trOdd'; else echo 'trEven';$i++;?>>
        <TD noWrap><?=$game_arr[$v['game_id']]['name']?></TD>
    <?php if(is_array($v)) foreach ($pay_way_arr as $key=>$val){ if(empty($v[$key])) $v[$key]=0;?>
        <TD noWrap><?=$v[$key]?></TD>
    <?php  }?>
	<TD noWrap><?=empty($v['first']) ? "0":$v['first']?></TD>
	<TD noWrap><?=empty($v['vip']) ? "0":$v['vip']?></TD>
	<TD noWrap><?=empty($v['inner'][1]) ? "0":$v['inner'][1]?></TD>
	<TD noWrap><?=empty($v['inner'][2]) ? "0":$v['inner'][2]?></TD>
	<TD noWrap><?=empty($v['user']) ? "0":$v['user']?></TD>
        <TD noWrap><?=empty($v['total']) ? "0":$v['total']?></TD>
        <TD noWrap><?=$v['arpu']?></TD>
        <TD noWrap><?=$hj['game']['total'] <=0 ? "0":round($v['total']/$hj['game']['total']*100,2)?>%</TD>
	<TD noWrap><?php if (($v['total']-$v['yesterday'])>0) echo '<font color="#00CC00">'.round(($v['total']-$v['yesterday']),2).'</font>';else echo '<font color="#FF0000">'.round(($v['total']-$v['yesterday']),2).'</font>';?></td>  
	<TD noWrap><?php if (($v['total']-$v['week'])>0) echo '<font color="#00CC00">'.round(($v['total']-$v['week']),2).'</font>';else echo '<font color="#FF0000">'.round(($v['total']-$v['week']),2).'</font>'; ?></td>
    </TR>
    <?php } }?>
    <TR class="trEven">
        <TD noWrap><font color="red">合计:</font></TD>
        <?php foreach ($pay_way_arr as $key=>$val){ if(empty($hj['game'][$key])) $hj['game'][$key]=0;?>
        <TD noWrap><?=$hj['game'][$key]?></TD>
        <?php  }?>
	<TD noWrap><?=$hj['game']['first']?></TD>
	<TD noWrap><?=$hj['game']['vip']?></TD>
	<TD noWrap><?=empty($hj['game']['inner'][1]) ? "0":$hj['game']['inner'][1]?></TD>
	<TD noWrap><?=$hj['game']['inner'][2]?></TD>
        <TD noWrap><?=$hj['game']['user']?></TD>
        <TD noWrap><?=$hj['game']['total']?></TD>
        <TD noWrap><?=$hj['game']['user'] <=0 ? "0":round($hj['game']['total']/$hj['game']['user'],2)?></TD>
        <TD noWrap>100%</TD>
	<TD noWrap><?php if (($hj['game']['total']-$hj['game']['yesterday'])>0) echo '<font color="#00CC00">'.round(($hj['game']['total']-$hj['game']['yesterday']),2).'</font>';else echo '<font color="#FF0000">'.round(($hj['game']['total']-$hj['game']['yesterday']),2).'</font>';?></td>  
	<TD noWrap><?php if (($hj['game']['total']-$hj['game']['week'])>0) echo '<font color="#00CC00">'.round(($hj['game']['total']-$hj['game']['week']),2).'</font>';else echo '<font color="#FF0000">'.round(($hj['game']['total']-$hj['game']['week']),2).'</font>';?></td> 
    </TR>
</TBODY>
</TABLE>
<!-----------------------------------------------按区服统计------------------------------------------>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=2>
  <TBODY>
    <TR class=table_list_head>
        <TD width="37" noWrap>游戏区服</TD>
    <?php foreach ($pay_way_arr as $k =>$v){ ?>
        <TD width=75><?=$v['payname']?></TD>
    <?php } ?>
        <TD width="65">首充金额</TD>
	<TD width="65">VIP金额</TD>
	<TD width="65">平台垫付</TD>
	<TD width="65">公会赔付</TD>
        <TD width="83">付费用户</TD>
	<TD width="81">总金额</TD>
	<TD width="65">ARPU值</TD>
	<TD width="74">收入比例</TD>
	<TD width="66">昨天增长</TD>
	<TD width="75">上周增长</TD>
  </TR>
  <?php	 
    $i=0;
    foreach($server_pay_arr as $k=>$v){
        if(is_array($v)){
        foreach ($v as $s =>$m){
            if($m['game_id'] >0){
  ?>
    <TR class=<?php if ($i%2==0) echo 'trOdd'; else echo 'trEven';$i++;?>>
        <TD noWrap><?=$game_arr[$m['game_id']]['name'] . $s . '服'?></TD>
    <?php if(is_array($m)) foreach ($pay_way_arr as $key=>$val){ if(empty($m[$key])) $m[$key]=0;?>
        <TD noWrap><?=$m[$key]?></TD>
    <?php  }?>
	<TD noWrap><?=empty($m['first']) ? "0":$m['first']?></TD>
	<TD noWrap><?=empty($m['vip']) ? "0":$m['vip']?></TD>
	<TD noWrap><?=empty($m['inner'][1]) ? "0":$m['inner'][1]?></TD>
	<TD noWrap><?=empty($m['inner'][2]) ? "0":$m['inner'][2]?></TD>
	<TD noWrap><?=empty($m['user']) ? "0":$m['user']?></TD>
        <TD noWrap><?=empty($m['total']) ? "0":$m['total']?></TD>
        <TD noWrap><?=$m['user'] <=0 ? "0":round($m['total']/$m['user'],2)?></TD>
        <TD noWrap><?=$hj['server']['total'] <=0 ? "0":round($m['total']/$hj['server']['total']*100,2)?>%</TD>
	<TD noWrap><?php if (($m['total']-$m['yesterday'])>0) echo '<font color="#00CC00">'.round(($m['total']-$m['yesterday']),2).'</font>';else echo '<font color="#FF0000">'.round(($m['total']-$m['yesterday']),2).'</font>';?></td>  
	<TD noWrap><?php if (($m['total']-$m['week'])>0) echo '<font color="#00CC00">'.round(($m['total']-$v['week']),2).'</font>';else echo '<font color="#FF0000">'.round(($m['total']-$m['week']),2).'</font>'; ?></td>
    </TR>
    <?php  } } } }?>
    <TR class="trEven">
        <TD noWrap><font color="red">合计:</font></TD>
        <?php foreach ($pay_way_arr as $key=>$val){ if(empty($hj['server'][$key])) $hj['server'][$key]=0;?>
        <TD noWrap><?=$hj['server'][$key]?></TD>
        <?php  }?>
	<TD noWrap><?=$hj['server']['first']?></TD>
	<TD noWrap><?=$hj['server']['vip']?></TD>
	<TD noWrap><?=empty($hj['server']['inner'][1]) ? "0":$hj['server']['inner'][1]?></TD>
	<TD noWrap><?=$hj['server']['inner'][2]?></TD>
        <TD noWrap><?=$hj['server']['user']?></TD>
        <TD noWrap><?=$hj['server']['total']?></TD>
        <TD noWrap><?=$hj['server']['user'] <=0 ? "0":round($hj['server']['total']/$hj['server']['user'],2)?></TD>
        <TD noWrap>100%</TD>
	<TD noWrap><?php if (($hj['server']['total']-$hj['server']['yesterday'])>0) echo '<font color="#00CC00">'.round(($hj['server']['total']-$hj['server']['yesterday']),2).'</font>';else echo '<font color="#FF0000">'.round(($hj['server']['total']-$hj['server']['yesterday']),2).'</font>';?></td>  
	<TD noWrap><?php if (($hj['server']['total']-$hj['server']['week'])>0) echo '<font color="#00CC00">'.round(($hj['server']['total']-$hj['server']['week']),2).'</font>';else echo '<font color="#FF0000">'.round(($hj['server']['total']-$hj['server']['week']),2).'</font>';?></td> 
    </TR>
</TBODY></TABLE>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
  </SCRIPT>
</BODY>
</HTML>
