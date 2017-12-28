<?php
session_start();
set_time_limit(0);
require_once('../common/common.php');
include('include/isLogin.php');
$data = array();
$sdate=trim($_REQUEST["sdate"]);
$edate=trim($_REQUEST["edate"]);
$game_id=$_REQUEST['game_id'];
if($game_id>0){
    $filter=" and game_id=$game_id";
    $filter_game = true;
    $filter_game_id = $game_id;
}
if (!$sdate) {
    $sdate=date("Y-m-d",time());
}
if (!$edate) {
    $edate=$sdate;
}
$game_tmp = $db->find("select id,name,game_byname from ".PAYDB.".".GAMELIST." where is_open=1 order by id desc");
foreach($game_tmp as $val){
	$game_arr[$val['id']]=$val['name'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>开服数据总表</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18702"></HEAD>
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
      <INPUT id="act" type=hidden name="act" value="search" >
      投放日期：<INPUT  value="<?=$sdate?>" name="sdate" id="sdate" size="10" onClick="WdatePicker();" >-<INPUT  value="<?=$edate?>" name="edate" id="edate" size="10" onClick="WdatePicker();" >
	游戏：<select name="game_id">
	<option value="">全部</option>
	<?php foreach($game_arr as $k=>$val){ ?>
      <option value="<?=$k?>" <?php if($game_id==$k){ echo 'selected'; } ?> ><?=$val?></option>
        <?php } ?>
      </select>
        &nbsp;&nbsp;<img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
        &nbsp;&nbsp;<a href="?sdate=<?=date('Y-m-d',strtotime($sdate)-86400)?>&edate=<?=date('Y-m-d',strtotime($edate)-86400)?>&game_id=<?=$game_id?>">前一天</a>
        &nbsp;&nbsp;<a href="?sdate=<?=date('Y-m-d',strtotime($sdate)+86400)?>&edate=<?=date('Y-m-d',strtotime($edate)+86400)?>&game_id=<?=$game_id?>">后一天</a>
        &nbsp;&nbsp;<a href="?sdate=<?=date('Y-m-d')?>&edate=<?=date('Y-m-d')?>&game_id=<?=$game_id?>">当 天</a>
      </FORM>
      </DIV>
      </TD>
    </TR>
  </TBODY>
</TABLE>
<?php
$sql="select sum(reg_count) as reg,game_id,server_id from ".YYDB.".".REGTOTAL." where tdate>='$sdate' and tdate<='$edate' $filter and game_id>0 group by game_id,server_id order by game_id,server_id";
$res=$db->find($sql);
foreach($res as $v){
    $game_id=$v['game_id']+0;
    $server_id=$v['server_id']+0;
    $data[$game_id][$server_id]['reg']=$v['reg']+0;
    $sql="select name,create_date from ".PAYDB.".".SERVERLIST." where game_id='$game_id' and server_id='$server_id'";
    $re=$db->get($sql);
    $data[$game_id][$server_id]['name']=empty($re['name']) ? $server_id.'服' : $re['name'];
    $data[$game_id][$server_id]['time']=$re['create_date'];

    $sql="select sum(login_b1) as active,sum(login_old) as old from db_xieenet.login_total where tdate>='".date('Y-m-d',strtotime($sdate)+3600*24)."' and  tdate<='".date('Y-m-d',strtotime($edate)+3600*24)."' and game_id='$game_id' and server_id='$server_id'";
    $rre=$db->get($sql);
    $data[$game_id][$server_id]['active']=$rre['active']+0;
    $data[$game_id][$server_id]['old']=$rre['old']+0;

    $sql="select count(distinct user_name) as pay_num,sum(money) as pay from ".PAYDB.".".PAYLIST." where reg_date>='$sdate 00:00:00' and reg_date<='$edate 23:59:59' and game_id='$game_id' and server_id='$server_id'";
    $rre=$db->get($sql);
    $data[$game_id][$server_id]['pay']=$rre['pay']+0;
    $data[$game_id][$server_id]['pay_num']=$rre['pay_num']+0;
}

$tdate=$sdate;
while($tdate<=$edate){
    $site_arr=Array(); $gs_arr=Array();
    $sql="select sum(a.reg_count) as reg,a.agent_id,a.site_id,a.game_id,a.server_id,b.adtype,b.pay_way from ".YYDB.".".REGTOTAL." a,db_5399_unions.agent_site b where a.tdate='$tdate' and a.agent_id=b.agent_id and a.site_id=b.site_id group by site_id,game_id,server_id order by site_id,game_id,server_id";
    $res=$db->find($sql);
    foreach($res as $re){
        $site_id=$re['site_id']+0;
        $game_id=$re['game_id']+0;
        $server_id=$re['server_id']+0;
        
        $site_arr[$site_id][$game_id][$server_id]['reg']+=$re['reg']+0;
        $site_arr[$site_id]['reg']+=$re['reg']+0;
        $site_arr[$site_id]['agent_id']=$re['agent_id']+0;
        $site_arr[$site_id]['adtype']=$re['adtype'];
        $site_arr[$site_id]['pay_way']=$re['pay_way'];
        $gs_arr[$game_id][$server_id]=$server_id;
    }
    foreach($site_arr as $site_id=>$re){
        foreach($gs_arr as $game_id=>$val){
            if ($filter_game) {
                if ($game_id!=$filter_game_id) continue;
            }
            else {
                if ($game_id==0) continue;
            }
            foreach($val as $server_id){
                $cost=$re['reg']>0?$price*$site_arr[$site_id][$game_id][$server_id]['reg']/$re['reg']:0;
                $data[$game_id][$server_id]['cost']+=$cost;
            }
        }
    }
    $tdate=date('Y-m-d',strtotime($tdate)+86400);
}
?>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=2>
  <TBODY>
    <TR class=table_list_head>
 	<TD>游戏</TD>
        <TD>服务器</TD>
        <TD>开服时间</TD>
        <TD>注册</TD>
	<TD>活跃数</TD>
        <TD>活跃比例</TD>
        <TD>活跃成本</TD>
        <TD>老玩家数</TD>
	<TD>充值人数</TD>
	<TD>充值金额</TD>
	<TD>注册充值率</TD>
	<TD>充值ARPU值</TD>
        <TD>注册ARPU值</TD>
    </TR> 	 	 	 	 	 	
<?php
$data_for_excel[0]=array(iconv('UTF-8','GBK','游戏'),iconv('UTF-8','GBK','服务器'),iconv('UTF-8','GBK','开服时间'),iconv('UTF-8','GBK','注册'),iconv('UTF-8','GBK','活跃数'),iconv('UTF-8','GBK','活跃比例'),iconv('UTF-8','GBK','活跃成本'),iconv('UTF-8','GBK','老玩家数'),iconv('UTF-8','GBK','充值人数'),iconv('UTF-8','GBK','充值金额'),iconv('UTF-8','GBK','注册充值率'),iconv('UTF-8','GBK','充值ARPU值'),iconv('UTF-8','GBK','注册ARPU值'));
$i=1;
foreach($data as $game_id=>$re){
    foreach($re as $server_id=>$v){
        if(($v['cost']==0 && $v['reg']<100) || ($v['name']=='0服' && $v['cost']==0)){ continue; }
        $v['cost']=round($v['cost'],2);
        $total['cost']+=$v['cost'];
        $total['reg']+=$v['reg'];
        $total['active']+=$v['active'];
        $total['old']+=$v['old'];
        $total['pay']+=$v['pay'];
        $total['pay_num']+=$v['pay_num'];
		
        $active_per = $v['reg']>0?round($v['active']/$v['reg']*100,2):0;
        $active_one = $v['active']>0?round($v['cost']/$v['active'],2):0;
        $v['pay'] = round($v['pay'],2);
        $reg_pay_per = $v['reg']>0?round($v['pay_num']*100/$v['reg'],2):0;
        $pay_arpu = $v['pay_num']>0?round($v['pay']/$v['pay_num'],2):0;
        $reg_arpu = $v['reg']>0?round($v['pay']/$v['reg'],2):0;
?>
    <TR class="<?php if ($j%2==0) echo 'trOdd'; else echo 'trEven'; $j++;?>" style="text-align:center;">
        <TD><?=$game_arr[$game_id]?></TD>
        <TD><?=$v['name']?></TD>
        <TD><?=$v['time']?></TD>
        <TD><?=$v['reg']?></TD>
	<TD><?=$v['active']+0?></TD>
        <TD><?=$active_per?>%</TD>
        <TD>￥<?=$active_one?></TD>
        <TD><?=$v['old']+0?></TD>
	<TD><?=$v['pay_num']+0?></TD>
	<TD>￥<?=$v['pay']?></TD>
        <TD><?=$reg_pay_per?>%</TD>
	<TD><?=$pay_arpu?></TD>
	<TD><?=$reg_arpu?></TD>
    </TR>
<?php
	$data_for_excel[$i]=array(iconv('UTF-8','GBK',$game_arr[$game_id]),iconv('UTF-8','GBK',$v['name']),$v['time'],$v['cost'],$v['reg'],$v['active']+0,$active_per,$active_one,$v['old']+0,$v['pay_num']+0,$v['pay'],$reg_pay_per,$pay_arpu,$reg_arpu);
	$i++;
    }
}
$total_active_per = $total['reg']>0?round($total['active']/$total['reg']*100,2):0;
$total_active_one = $total['active']>0?round($total['cost']/$total['active'],2):0;
$total['pay'] = round($total['pay'],2);
$total_reg_pay_per = $total['reg']>0?round($total['pay_num']*100/$total['reg'],2):0;
$total_pay_arpu = $total['pay_num']>0?round($total['pay']/$total['pay_num'],2):0;
$total_reg_arpu = $total['reg']>0?round($total['pay']/$total['reg'],2):0;
$data_for_excel[$i]=array(iconv('UTF-8','GBK','合计'),'-','-',$total['cost'],$total['reg'],$total['active']+0,$total_active_per,$total_active_one,$total['old']+0,$total['pay_num']+0,$total['pay'],$total_reg_pay_per,$total_pay_arpu,$total_reg_arpu);
$_SESSION['data_for_excel']=serialize($data_for_excel);

?>
    <TR class=table_list_head>
        <TD  colspan="3">合计</TD>
        <TD><?=$total['reg']?></TD>
        <TD><?=$total['active']+0?></TD>
        <TD><?=$total_active_per?>%</TD>
        <TD>￥<?=$total_active_one?></TD>
        <TD><?=$total['old']+0?></TD>
        <TD><?=$total['pay_num']+0?></TD>
        <TD>￥<?=$total['pay']?></TD>
        <TD><?=$total_reg_pay_per?>%</TD>
        <TD><?=$total_pay_arpu?></TD>
        <TD><?=$total_reg_arpu?></TD>
    </TR>
</TBODY></TABLE>
<br />
<form action="download_excel.php" method="post"><input type="hidden" name="stage" value="yes"><input type="hidden" name="filename" value="91yxq平台<?=$sdate.'至'.$edate?>开服数据总览.xls"><input value="此报表导出excel" type="submit"></form>
<br />支出：((该渠道注册到该服用户数/该渠道总注册用户数)×该渠道当天总支出)+...所有有支出渠道当天当服支出...=该服当天支出，每天该服支出之和即为该时间段该服支出<br>
注册：该时间段注册到该服的用户数<br>
活跃：<!--该时间段注册的用户在后一天登陆该服的用户数-->该时间段注册到该服的用户在后一天登陆该服的用户数<br>
老玩家：该时间段起始日期前注册的用户在该时间段登陆该服的用户数<br>
充值：该时间段注册的用户在该服的充值
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
	$(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
</SCRIPT>
</BODY>
</HTML>