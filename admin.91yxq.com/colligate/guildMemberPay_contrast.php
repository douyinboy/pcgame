<?php
set_time_limit(0);
require_once('../common/common.php');
include('include/isLogin.php');
$tdate=trim($_REQUEST["tdate"]);
$edate=trim($_REQUEST["edate"]);
$game_id=$_POST['game_id']+0;
$agent_id=  intval($_REQUEST['agent_id']);
if (!$tdate) {
    $tdate=date("Y-m-d",time());
}
if (!$edate) {
    $edate=$tdate;
}
$f="";
if($game_id>0){
    $f.=" and game_id=$game_id";
}
if($agent_id >0){
    $f.=" and agent_id=$agent_id";
}
$sql="select id,name from ".PAYDB.".".GAMELIST." where is_open=1 order by id desc";
$game_tmp = $db->find($sql);
foreach($game_tmp as $val){
    $game_arr[$val['id']]=$val['name'];
}
$sql="select sum(money) as money,count(distinct user_name) as pay_num,count(id) as payt,placeid as site_id from ".PAYDB.".".PAYLIST." where pay_date>='$tdate 00:00:00' and pay_date<'$edate 23:59:59' $f group by placeid order by money desc";
$res=$db->find($sql);
$data = array();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>渠道收入比例</TITLE>
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
        <DIV class=divOperation style="float: left;">
            <FORM id="myform" method="post" name="myform" action="">
                <INPUT id="act" type=hidden name="act" value="search" >
                投放日期：<INPUT  value="<?=$tdate?>" name="tdate" id="tdate" size="10" onClick="WdatePicker();" >-<INPUT  value="<?=$edate?>" name="edate" id="edate" size="10" onClick="WdatePicker();" >
                &nbsp;&nbsp;公会ID：<INPUT  value="<?=$agent_id >0 ? $agent_id:""?>" name="agent_id" id="agent_id" size="6" >  
                &nbsp;&nbsp;游戏：
                <SELECT name="game_id" id="game_id">
                    <OPTION label="所有游戏" value="0" >所有游戏</OPTION>
                  <?php foreach( $game_arr as $key=>$val ) {?>
                     <OPTION value="<?=$key?>" <?php if ( $key == $game_id ) { echo 'selected="selected"'; }?>><?=$val?></OPTION>
                  <?php  }?>	
               </SELECT>
                   &nbsp;&nbsp;<img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
            </FORM>
        </DIV>
        <div style="float:right;margin:-15px 290px -10px 0">
            <h4>
                    <a href="guildMemberPay_contrast.php?tdate=<?=date('Y-m-d',strtotime($tdate)-86400)?>&agent_id=<?=$agent_id?>"><font color="color:#336699">前一天</font></a>
            &nbsp;<a href="guildMemberPay_contrast.php?tdate=<?=date('Y-m-d',strtotime($tdate)+86400)?>&agent_id=<?=$agent_id?>"><font color="color:#336699">后一天</font></a>
            &nbsp;<a href="guildMemberPay_contrast.php?tdate=<?=date('Y-m-d')?>&agent_id=<?=$agent_id?>"><font color="color:#336699">当天</font></a>
            </h4>
        </div>
      </TD>
    </TR>
  </TBODY>
</TABLE>
<?php
foreach($res as $v){
    $site_id=$v['site_id'];
    $sql="select a.author,b.agentname from ".GUILDMEMBER." a,".GUILDINFO." b where a.agent_id=b.id and a.site_id='$site_id'";
    $sre=$db->get($sql);
    if(!$sre){
        $data[0]['pay_num']+=$v['pay_num'];
        $data[0]['money']+=$v['money'];
        $data[0]['payt']+=$v['payt'];
    } else {
        $data[$site_id]['pay_num']=$v['pay_num'];
        $data[$site_id]['money']=$v['money'];
        $data[$site_id]['payt']=$v['payt'];
        $data[$site_id]['author']=$sre['agentname'].'·'.$sre['author'];
        $td=$tdate;
    }
    $total['money']+=$v['money'];
    $total['pay_num']+=$v['pay_num'];
    $total['payt']+=$v['payt'];
}
$data[0]['author']='其它(未知来路)';
?>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=2>
  <TBODY>
    <TR class=table_list_head>
 	<TD>成员id</TD>
        <TD>公会·成员</TD>
        <TD>充值次数</TD>
	<TD>充值人数</TD>
	<TD>充值金额</TD>
	<TD>收入比例</TD>
	<TD>ARPU值</TD>
    </TR>  	 	 	 	 	
<?php
foreach($data as $site_id=>$v){
?>
    <TR class="<?php if ($j%2==0) echo 'trOdd'; else echo 'trEven'; $j++;?>" style="text-align:center;">
	<TD><?=$site_id?></TD>
        <TD><?=$v['author']?></TD>
        <TD><?=$v['payt']?></TD>
        <TD><?=$v['pay_num']?></TD>
	<TD><?=round($v['money'],2)?></TD>
        <TD><?=$total['money']>0?round($v['money']/$total['money']*100,2):0?>%</TD>
        <TD><?=$v['pay_num']>0?round($v['money']/$v['pay_num'],2):0?></TD>
  </TR>
<?php
}
?>
    <TR class=table_list_head>
        <TD  colspan="2">合计</TD>
        <TD><?=$total['payt']?></TD>
        <TD><?=$total['pay_num']?></TD>
        <TD><?=round($total['money'],2)?></TD>
        <TD>100%</TD>
	<TD><?=$total['pay_num']>0?round($total['money']/$total['pay_num'],2):0?></TD>
  </TR> 	
</TBODY></TABLE>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
  </SCRIPT>
</BODY>
</HTML>