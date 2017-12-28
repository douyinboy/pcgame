<?php
require_once('../common/common.php');
include('include/isLogin.php');
$date1=trim($_REQUEST["date1"]);
$date2=trim($_REQUEST["date2"]);
$game_id =intval($_REQUEST["game_id"])+0;
$game="";
if( $game_id >0){
    $game.=" and game_id =".$game_id;
}
if(!$date2) {
    $date2=date("Y-m-d");
}
if(!$date1){
    $date1=date('Y-m')."-01";
}
$year =date("Y",strtotime($date1));
$data=$hj=array();
//注册人数
    $sql="SELECT count(id) as reg,agent_id,from_unixtime(reg_time,'%Y-%m-%d') as rdate FROM ".USERDB.".".REGINDEX.$year." where reg_time >=unix_timestamp('$date1 00:00:00') and reg_time<=unix_timestamp('$date2 23:59:59')  $game  group by agent_id,rdate order by agent_id ASC ";
    $res=$db->find($sql); 
    foreach($res as $v){
        $data[$v['agent_id']][$v['rdate']]['reg']=$v['reg'];
        $hj[$v['rdate']]['reg']+=$v['reg'];  //日期 【合计】
        $hj[$v['agent_id']]['reg']+=$v['reg']; //游戏 【合计】
    }
//登陆人数
    $sql="SELECT count(id) as login,agent_id,from_unixtime(login_time,'%Y-%m-%d') as ldate FROM ".USERDB.".".REGINDEX.$year." where reg_time>=unix_timestamp('$date1 00:00:00') and reg_time<=unix_timestamp('$date2 23:59:59') ".
         "and from_unixtime(login_time,'%Y-%m-%d') >='$date1' and from_unixtime(login_time,'%Y-%m-%d') <='$date2' $game group by agent_id,ldate order by agent_id asc";
    $res=$db->find($sql);
    foreach($res as $v){
        $data[$v['agent_id']][$v['ldate']]['login']=$v['login'];
        $hj[$v['ldate']]['login']+=$v['login'];  //日期 【合计】
        $hj[$v['agent_id']]['login']+=$v['login']; //游戏 【合计】
    }
//游戏列表
$sql="select id,name from ".PAYDB.".".GAMELIST." where is_open=1 order by id desc";
$game_arr=$db->find($sql);
foreach ($game_arr as $v){
    $game_list[$v['id']]=$v['name'];
}
//公会列表
$sql=" select * from ".GUILDINFO." where state =1 ";
$agent=$db ->find($sql);
foreach ($agent as $v){
    $agent_list[$v['id']]=$v['agentname'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf8" />
<title>公会注册按日统计</title>
<?php require_once('include/head_css_js.php');?>
<script type="text/javascript" >
$(function(){  
    $("#tb tr").mouseover(function(){  
        $(this).addClass("trSelected");  
    });  
    $("#tb tr").mouseout(function(){  
        $(this).removeClass("trSelected");  
    });  
}); 
function btnsubmit() {
    $("#myform").submit();
}
</script>
</head>
<body>
   <TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width="100%" height=32>
    <TBODY>
        <TR class=trEven>
          <TD>
                <DIV class=divOperation style="float: left;margin-left: 130px;">
                  <FORM id="myform" method="post" name="myform" action="">
                     起始日期
                    <input name="date1" type="text" class="box" id="date1"  onClick="WdatePicker();" value="<?=$date1?>"  size="10" />
                    &nbsp;&nbsp;结束日期
                    <input name="date2" type="text" class="box" id="date2"  onClick="WdatePicker();" value="<?=$date2?>"  size="10" />
                    游戏<span class="text_zhifu">
                    <select name="game_id" class="box" id="game_id"   >
                        <option value="0">全部</option>
                        <?php foreach($game_arr as $games){ ?>
                        <option value="<?=$games['id']?>" <?php if ($games['id']==$game_id) {echo " selected";} ?> ><?=$games['name']?></option>
                        <?php } ?>
                    </select>
                    </span>
                    &nbsp;&nbsp;<img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
                  </FORM>
                </DIV>
                <div style="float:right;margin:-1px 240px -10px 0">
                    黑色:注册
                    <font color="#0000FF" style="margin-left:20px">蓝色:登录</font>
                    <font color="#FF0000" style="margin-left:20px">红色:登录率</font>
                </div>
            </TD>
        </TR>
    </TBODY> 
  </TABLE>
<table width="99%" border="0" class="table_list" id="tb">
    <tr class="table_list_head">
        <td width="40">公会ID\时间</td>
        <td width="30">公会名称</td>
    <?php
    $d=$date1;
    while($d<=$date2) {
    ?>
        <td><?=$d?></td>
	<?php $d=date('Y-m-d',strtotime($d)+24*3600); } ?>
	<td><strong>合计</strong></td>
  </tr>
<?php
    $j=0;
    if($data){
        foreach($data as $agentid=>$v) {
?>
    <tr class="<?php if ($j%2==0) echo 'trOdd'; else echo 'trEven'; $j++;?>" style="text-align:center;">
        <td><?=$agentid?></td>
        <td><?=empty($agent_list[$agentid]) ? "未知公会":$agent_list[$agentid]?><br/><a href="guildMenberReg_d.php?game_id=<?=$game_id?>&agent_id=<?=$agentid?>&date1=<?=$date1?>&date2=<?=$date2?>"><br/><font color="#17f326">[详细]</font></a></td>
    <?php
	$d=$date1;
	while($d<=$date2) { ?>
        <td width="30" >
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><?=$v[$d]['reg']+0?></td>
                </tr>
                <tr>
                  <td><font color="#0000FF"><?=$v[$d]['login']+0?></font></td>
                </tr>
                <tr>
                  <td><font color="#FF0000">
                    <?=$v[$d]['reg'] >0 ? round($v[$d]['login']*100/$v[$d]['reg'],2):"0"?>%</font>
                  </td>
                </tr>
            </table>
        </td>
	<?php $d=date('Y-m-d',strtotime($d)+24*3600); } ?>
	<td width="30" >
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><b><?=$hj[$agentid]['reg']+0?></b></td>
                </tr>
                <tr>
                  <td><b><font color="#0000FF"><?=$hj[$agentid]['login']+0?></font></b></td>
                </tr>
                <tr ><td><font color="#FF0000">
              <?=$hj[$agentid]['reg'] >0 ? round($hj[$agentid]['login']/$hj[$agentid]['reg'],2)*100:"0"?>%</font></td>
                </tr>
            </table>
        </td>
<?php } ?>
  </tr>
 <?php } else { ?>
	<tr><td colspan="5" align="center"><font color="#FF0000">暂无数据</font></td></tr>
<?php }
    if($data){
?>
  <tr  class="table_list_head">
    <td><span>合计：</span></td>
    <td><span>--</span></td>
<?php
    $d=$date1;
    $reg=$login=0;
    while($d<=$date2) {
        $reg+=$hj[$d]['reg'];$login+=$hj[$d]['login'];
?>
    <td width="30">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><b><?=$hj[$d]['reg']+0?></b></td>
            </tr>
            <tr>
              <td><b><font color="#0000FF"><?=$hj[$d]['login']+0?></font></b></td>
            </tr>
        <tr ><td><font color="#FF0000">
          <?=$hj[$d]['reg'] >0 ? round($hj[$d]['login']/$hj[$d]['reg'],2)*100:"0"?>%</font></td></tr>
        </table></td>
    <?php $d=date('Y-m-d',strtotime($d)+24*3600); } ?>
    <td width="30">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><b><?=$reg+0?></b></td>
            </tr>
            <tr>
              <td><b><font color="#0000FF"><?=$login+0?></font></b></td>
            </tr>
            <tr ><td><font color="#FF0000">
          <?=$reg >0 ? round($login/$reg,2)*100:"0"?>%</font></td></tr>
        </table></td>
  </tr>
<?php }?>
</table>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
</body>
</html>
