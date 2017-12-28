<?php
require_once('../common/common.php');
include('include/isLogin.php');
$date1=trim($_REQUEST["date1"]);
$date2=trim($_REQUEST["date2"]);
if(!$date2) {
    $date2=date("Y-m-d");
}
if(!$date1){
    $date1=date('Y-m')."-01";
}
$year =date("Y",strtotime($date1));
$data=$hj=array();
//注册人数
    $sql="SELECT count(id) as reg,game_id,from_unixtime(reg_time,'%Y-%m-%d') as rdate FROM ".USERDB.".".REGINDEX.$year." where reg_time >=unix_timestamp('$date1 00:00:00') and reg_time<=unix_timestamp('$date2 23:59:59')  group by game_id,rdate order by game_id ASC ";
    $res=$db->find($sql); 
    foreach($res as $v){
        $data[$v['game_id']][$v['rdate']]['reg']=$v['reg'];
        $hj[$v['rdate']]['reg']+=$v['reg'];  //日期 【合计】
        $hj[$v['game_id']]['reg']+=$v['reg']; //游戏 【合计】
    }
//登陆人数
    $sql="SELECT count(id) as login,game_id,from_unixtime(login_time,'%Y-%m-%d') as ldate FROM ".USERDB.".".REGINDEX.$year." where reg_time>=unix_timestamp('$date1 00:00:00') and reg_time<=unix_timestamp('$date2 23:59:59') ".
         "and from_unixtime(login_time,'%Y-%m-%d') >='$date1' and from_unixtime(login_time,'%Y-%m-%d') <='$date2' group by game_id,ldate order by game_id asc";
    $res=$db->find($sql);
    foreach($res as $v){
        $data[$v['game_id']][$v['ldate']]['login']=$v['login'];
        $hj[$v['ldate']]['login']+=$v['login'];  //日期 【合计】
        $hj[$v['game_id']]['login']+=$v['login']; //游戏 【合计】
    }

$sql="select id,name from ".PAYDB.".".GAMELIST." where is_open=1 ";
$game_arr=$db->find($sql);
foreach ($game_arr as $v){
    $game_list[$v['id']]=$v['name'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf8" />
<title>各游戏注册按日统计</title>
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
                <DIV class=divOperation style="float: left;margin-left: 240px;">
                  <FORM id="myform" method="post" name="myform" action="">
                     起始日期
                    <input name="date1" type="text" class="box" id="date1"  onClick="WdatePicker();" value="<?=$date1?>"  size="10" />
                    &nbsp;&nbsp;结束日期
                    <input name="date2" type="text" class="box" id="date2"  onClick="WdatePicker();" value="<?=$date2?>"  size="10" />
                    &nbsp;&nbsp;<img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
                  </FORM>
                </DIV>
                <div style="float:right;margin:-1px 290px -10px 0">
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
    <td width="40">游戏\时间</td>
    <?php
	$d=$date1;
        $game_reg=array();
	while($d <= $date2) {
            $jsdata1.="'".substr($d,5)."',";
            foreach ($data as $k =>$v){
                $game_reg[$k].=$v[$d]['reg'] >0 ? $v[$d]['reg'].",":"0,";
            }
    ?>
        <td><?=$d?></td>
	<?php $d=date('Y-m-d',strtotime($d)+24*3600);} ?>
	<td><strong>合计：</strong></td>
  </tr>
<?php
    $j=0;
    if($data){
        foreach($data as $k=>$v) { ?>
    <tr class="<?php if ($j%2==0) echo 'trOdd'; else echo 'trEven'; $j++;?>" style="text-align:center;">    
            <td ><?=$k >0 ? $game_list[$k]:"平台官网"?><br/><a href="gameServerReg_d.php?game_id=<?=$k?>&date1=<?=$date1?>&date2=<?=$date2?>"><br/><font color="#17f326">[详细]</font></a></td>
        <?php $d=$date1;  while($d <= $date2) { ?>
            <td width="30" >
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><?=$v[$d]['reg'] >0 ? $v[$d]['reg']:"0"?></td>
                </tr>
                <tr>
                  <td><font color="#0000FF"><?=$v[$d]['login'] >0 ? $v[$d]['login'] :"0"?></font></td>
                </tr>
                <tr>
                  <td><font color="#FF0000">
                    <?=$v[$d]['reg'] >0 ? round($v[$d]['login']/$v[$d]['reg'],2)*100:"0"?>%</font></td>
                </tr>
              </table>
            </td>
        <?php $d=date('Y-m-d',strtotime($d)+24*3600); } ?>
        <td width="30" >
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><b><?=$hj[$k]['reg']?></b></td>
                    </tr>
                    <tr>
                        <td><b><font color="#0000FF"><?=$hj[$k]['login']?></font></b></td>
                    </tr>
                    <tr >
                        <td><font color="#FF0000"><?=$hj[$k]['reg'] >0 ? round($hj[$k]['login']/$hj[$k]['reg'])*100:"0"?>%</font></td>
                    </tr>
            </table>
        </td>
  </tr>
<?php }  }else { ?>
    <tr><td colspan="5" align="center"><font color="#FF0000">暂无数据</font></td></tr>
<?php } 
    if($data){
?>
<tr  class="table_list_head">
    <td><span>合计：</span></td>
<?php $d=$date1;  while($d <= $date2) { $login_total+=$hj[$d]['login']; $reg_total+=$hj[$d]['reg']; ?>
    <td width="30">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><b><?=$hj[$d]['reg'] >0 ? $hj[$d]['reg']:"0"?></b></td>
            </tr>
            <tr>
              <td><b><font color="#0000FF"><?=$hj[$d]['login'] >0 ? $hj[$d]['login']:"0"?></font></b></td>
            </tr>
            <tr ><td><font color="#FF0000"><?=$hj[$d]['reg'] >0 ? round($hj[$d]['login']/$hj[$d]['reg'],2)*100:"0"?>%</font></td></tr>
        </table>
    </td>
<?php $d=date('Y-m-d',strtotime($d)+24*3600);  } ?>
    <td width="30" bgcolor="#F2F2F2">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td><b><?=$reg_total+0?></b></td>
            </tr>
            <tr>
              <td><b><font color="#0000FF"><?=$login_total+0?></font></b></td>
            </tr>
            <tr ><td><font color="#FF0000"><?=$reg_total >0 ? round($login_total/$reg_total,2)*100:"0"?>%</font></td></tr>
        </table></td>
  </tr>
<?php } ?>
</table>
<div id="container" style="width: 900px; height: 400px; margin: 0 auto"></div>
<script type="text/javascript" >
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                defaultSeriesType: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: '游戏注册按日统计',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: [<?=substr($jsdata1,0,-1)?>]
            },
            yAxis: {
                title: {
                    text: '人数'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                return '<b>'+ this.series.name +'</b><br/>'+this.x +': '+ this.y +'人';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [
        <?php foreach ($game_reg as $k =>$v){?>
            {
                name: '<?=$k >0 ? $game_list[$k]:"平台官网"?>',
                data: [<?=substr($v,0,-1)?>]
            },
        <?php }?>
            ]
        });
    });
</script>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
</body>
</html>
