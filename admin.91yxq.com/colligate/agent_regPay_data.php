<?php
require_once('../common/common.php');
include('include/isLogin.php');
$data = array();
$tdate=trim($_REQUEST["tdate"]);
$tdate2=trim($_REQUEST["tdate2"]);
$adtype=$_REQUEST['adtype'];
$webtype=$_REQUEST['webtype'];
$payway=$_REQUEST['payway'];
$agent_id=$_REQUEST['agent_id'];
$ssite_id=$_REQUEST['ssite_id'];
$autor=$_REQUEST['autor'];
$groupby=$_REQUEST['groupby'];
if (!$tdate) {
    $tdate=date("Y-m-d",time());
}
if (!$tdate2) {
    $tdate2=$tdate;
}
/**后台管理人员*/
$sql=" select * from ".ADMINUSERS." where uLoginState=1";
$chargeman_arr=$db ->find($sql);


$sql="select id,name,game_byname from ".PAYDB.".".GAMELIST." where is_open=1 order by id DESC ";
$game_tmp = $db->find($sql);
foreach($game_tmp as $val){
    $game_arr[$val['id']]=$val['name'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>公会注册充值数据表</TITLE>
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
        投放日期：<INPUT  value="<?=$tdate?>" name="tdate" id="tdate" size="10" onClick="WdatePicker();" >-<INPUT  value="<?=$tdate2?>" name="tdate2" id="tdat2e" size="10" onClick="WdatePicker();" >
        公会ID：<INPUT  value="<?=$agent_id?>" name="agent_id" id="agent_id" size="6" >
        公会成员ID：<INPUT  value="<?=$ssite_id?>" name="ssite_id" id="ssite_id" size="6" >
	负责人：<select name="autor">
	<option value="">全部</option>
	<?php foreach($chargeman_arr as $val){ ?>
            <option value="<?=$val['uid']?>" <?php if($autor==$val['uid']){ echo 'selected'; } ?> ><?=$val['uName']?></option>
        <?php } ?>
      </select>
	 &nbsp;&nbsp;<img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
      </FORM>
      </DIV>
        <div style="float:right;margin:-35px 200px -7px 0">
            <h4>
                    <a href="agent_regPay_data.php?tdate=<?=date('Y-m-d',strtotime($tdate)-86400)?>&groupby=<?=$groupby?>&agent_id=<?=$agent_id?>&ssite_id=<?=$ssite_id?>&adtype=<?=$adtype?>&webtype=<?=$webtype?>&payway=<?=$payway?>&autor=<?=$autor?>"><font color="color:#336699">前一天</font></a>
            &nbsp;<a href="agent_regPay_data.php?tdate=<?=date('Y-m-d',strtotime($tdate)+86400)?>&groupby=<?=$groupby?>&agent_id=<?=$agent_id?>&ssite_id=<?=$ssite_id?>&adtype=<?=$adtype?>&webtype=<?=$webtype?>&payway=<?=$payway?>&autor=<?=$autor?>"><font color="color:#336699">后一天</font></a>
            &nbsp;<a href="agent_regPay_data.php?tdate=<?=date('Y-m-d')?>&groupby=<?=$groupby?>&agent_id=<?=$agent_id?>&ssite_id=<?=$ssite_id?>&adtype=<?=$adtype?>&webtype=<?=$webtype?>&payway=<?=$payway?>&autor=<?=$autor?>"><font color="color:#336699">当天</font></a>
            </h4>
        </div>
      </TD>
    </TR>
  </TBODY>
</TABLE>
<?php
//默认数据 内部联盟按广告位id归类
$filter=" where a.tdate>='$tdate' and a.tdate<='$tdate2'";
if($adtype>0){
    $filter.=" and b.adtype=$adtype";
}
if($webtype>0){
    $filter.=" and b.webtype=$webtype";
}
if($payway>0){
    $filter.=" and b.pay_way=$payway";
}
if($agent_id>0){
    $filter.=" and b.agent_id=$agent_id";
}
if($ssite_id>0){
    $filter.=" and b.site_id=$ssite_id";
}
if($autor){
    $filter.=" and c.adduid='$autor'";
}   
$sql="select sum(a.reg_count) as reg,b.site_id,b.author,b.agent_id,b.adtype,b.pay_way,c.agentname from ".YYDB.".".REGTOTAL." a,".ADMINTABLE.".".GUILDMEMBER." b,".ADMINTABLE.".".GUILDINFO." c $filter and a.site_id>0 and b.agent_id=c.id and a.site_id=b.site_id group by b.site_id order by site_id";
$res=$db->find($sql);
foreach($res as $v){
    $site_id=$v['site_id'];
    $site_arr[$site_id]=$v['agentname'].'·'.$v['author'];

    $data[$site_id]['reg']=$v['reg']+0;
    $total['reg']+=$v['reg']; 
    $td=$tdate;
    $sql="select sum(login_b1) as active,sum(login_old) as old from ".YYDB.".".LOGINTOTAL." where tdate>='".date('Y-m-d',strtotime($tdate)+3600*24)."' and  tdate<='".date('Y-m-d',strtotime($tdate2)+3600*24)."' and site_id='$site_id'";
    $rre=$db->get($sql);
    $data[$site_id]['active']=$rre['active']+0;
    $data[$site_id]['old']=$rre['old']+0;
    $total['active']+=$rre['active'];
    $total['old']+=$rre['old'];
    $sql="select count(distinct user_name) as pay_num,sum(money) as pay from ".PAYDB.".".PAYLIST." where game_id !=0 AND server_id !=0 and placeid='$site_id' and reg_date>='$tdate 00:00:00' and reg_date<='$tdate2 23:59:59'";
    $rre=$db->get($sql);
    $data[$site_id]['pay']=$rre['pay']+0;
    $data[$site_id]['pay_num']=$rre['pay_num']+0;
    $total['pay']+=$rre['pay'];
    $total['pay_num']+=$rre['pay_num'];
}

$sql="select id,name,game_byname from ".PAYDB.".".GAMELIST." where is_open=1 order by id desc ";
$re=$db->find($sql);
foreach($re as $v){
    $game_arr[$v['id']]['name']=$v['name'];
    $game_arr[$v['id']]['game_byname']=$v['game_byname'];
}
?>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=2>
  <TBODY>
    <TR class=table_list_head>
 	<TD>公会成员id</TD>
        <TD>公会名·成员名</TD>
        <TD>注册</TD>
        <TD>活跃数</TD>
        <TD>活跃比例</TD>
        <TD>老玩家数</TD>
        <TD>充值人数</TD>
        <TD>充值金额</TD>
        <TD>注册充值率</TD>
        <TD>充值ARPU值</TD>
        <TD>注册ARPU值</TD>
    </TR>
<?php
foreach($data as $site_id=>$v){
?>
    <TR class="<?php if ($j%2==0) echo 'trOdd'; else echo 'trEven'; $j++;?>" style="text-align:center;">
	<TD><?=$site_id?></TD>
        <TD><?=$site_arr[$site_id]?></TD>
        <TD><?=$v['reg']?></TD>
        <TD><?=$v['active']+0?></TD>
        <TD><?=$v['reg']>0?round($v['active']/$v['reg']*100,2):0?>%</TD>
        <TD><?=$v['old']+0?></TD>
        <TD><?=$v['pay_num']+0?></TD>
        <TD>￥<?=round($v['pay'],2)?></TD>
        <TD><?=$v['reg']>0?round($v['pay_num']*100/$v['reg'],2):0?>%</TD>
        <TD><?=$v['pay_num']>0?round($v['pay']/$v['pay_num'],2):0?></TD>
        <TD><?=$v['reg']>0?round($v['pay']/$v['reg'],2):0?></TD>
  </TR>
<?php } ?>
    <TR class=table_list_head>
        <TD  colspan="2">合计</TD>
        <TD><?=$total['reg']?></TD>
        <TD><?=$total['active']+0?></TD>
        <TD><?=$total['reg']>0?round($total['active']/$total['reg']*100,2):0?>%</TD>
        <TD><?=$total['old']+0?></TD>
        <TD><?=$total['pay_num']+0?></TD>
        <TD>￥<?=round($total['pay'],2)?></TD>
        <TD><?=$total['reg']>0?round($total['pay_num']*100/$total['reg'],2):0?>%</TD>
        <TD><?=$total['pay_num']>0?round($total['pay']/$total['pay_num'],2):0?></TD>
        <TD><?=$total['reg']>0?round($total['pay']/$total['reg'],2):0?></TD>
  </TR> 	 	 	 	 	 	
</TBODY></TABLE>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
  </SCRIPT>
</BODY>
</HTML>