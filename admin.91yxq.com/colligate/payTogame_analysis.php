<?php
require_once('../common/common.php');
include('include/isLogin.php');
$server_id=$_REQUEST["server_id"];
$game_id=$_REQUEST["game_id"]+0;
$tm=time();
$filter=" where 1";
if ($game_id>0) {
    $filter.=" and game_id='$game_id'";
}
if ($server_id>0) {
    $filter.=" and server_id='$server_id'";
}
if ($_SESSION['sp_gamelist']) {
    $arr=explode('|',$_SESSION['sp_gamelist']);
    $sp_gamelist= $arr[0];
}
$s='where 1';
if ($sp_gamelist) {
    $filter.=" and a.game_id in ($sp_gamelist)";
	$s = " AND id IN ($sp_gamelist);"; 
}
//今天 0
$sdate=date('Y-m-d',$tm);
$edate=date('Y-m-d H:i:s',$tm);
$gameserver= $game_id >0 ? "server_id":"game_id";
$sql="select sum(money) as money,count(id) as pay_times,count(distinct user_name) as pay_num,$gameserver from ".PAYDB.".".PAYLIST." $filter  AND game_id !=0 AND server_id !=0  and pay_date>='$sdate 00:00:00' and pay_date<='$edate' group by $gameserver";
$res=$db->find($sql);
foreach($res as $v){
    $data[$v[$gameserver]][0]['money']=$v['money'];
    $data[$v[$gameserver]][0]['pay_times']=$v['pay_times'];
    $data[$v[$gameserver]][0]['pay_num']=$v['pay_num'];
    $total[0]['money']+=$v['money'];
    $total[0]['pay_times']+=$v['pay_times'];
    $total[0]['pay_num']+=$v['pay_num'];
    $total[0]['tdate']=$sdate;
}
//昨天 1
$sdate=date('Y-m-d',$tm-86400);
$edate=date('Y-m-d H:i:s',$tm-86400);
$sql="select sum(money) as money,count(id) as pay_times,count(distinct user_name) as pay_num,$gameserver from ".PAYDB.".".PAYLIST." $filter AND game_id !=0 AND server_id !=0 and pay_date>='$sdate 00:00:00' and pay_date<='$edate' group by $gameserver";
$res=$db->find($sql);
foreach($res as $v){
    $data[$v[$gameserver]][1]['money']=$v['money'];
    $data[$v[$gameserver]][1]['pay_times']=$v['pay_times'];
    $data[$v[$gameserver]][1]['pay_num']=$v['pay_num'];
    $total[1]['money']+=$v['money'];
    $total[1]['pay_times']+=$v['pay_times'];
    $total[1]['pay_num']+=$v['pay_num'];
    $total[1]['tdate']=$sdate;
}
//前天 2
$sdate=date('Y-m-d',$tm-86400*2);
$edate=date('Y-m-d H:i:s',$tm-86400*2);
$sql="select sum(money) as money,$gameserver from ".PAYDB.".".PAYLIST." $filter AND game_id !=0 AND server_id !=0  and pay_date>='$sdate 00:00:00' and pay_date<='$edate' group by $gameserver";
$res=$db->find($sql);
foreach($res as $v){
    $data[$v[$gameserver]][2]['money']=$v['money'];
    $total[2]['money']+=$v['money'];
    $total[2]['tdate']=$sdate;
}
//上周 7
$sdate=date('Y-m-d',$tm-86400*7);
$edate=date('Y-m-d H:i:s',$tm-86400*7);
$sql="select sum(money) as money,$gameserver from ".PAYDB.".".PAYLIST." $filter  AND game_id !=0 AND server_id !=0  and pay_date>='$sdate 00:00:00' and pay_date<='$edate' group by $gameserver";
$res=$db->find($sql);
foreach($res as $v){
    $data[$v[$gameserver]][7]['money']=$v['money'];
    $total[7]['money']+=$v['money'];
    $total[7]['tdate']=$sdate;
}
//上月 30
$sdate=date('Y-m-d',$tm-86400*30);
$edate=date('Y-m-d H:i:s',$tm-86400*30);
$sql="select sum(money) as money,$gameserver from ".PAYDB.".".PAYLIST." $filter AND game_id !=0 AND server_id !=0  and pay_date>='$sdate 00:00:00' and pay_date<='$edate' group by $gameserver";
$res=$db->find($sql);
foreach($res as $v){
    $data[$v[$gameserver]][30]['money']=$v['money'];
    $total[30]['money']+=$v['money'];
    $total[30]['tdate']=$sdate;
}

$game_list_arr = $db ->find("SELECT id,name,game_byname FROM ".PAYDB.".".GAMELIST." $s and is_open=1");
foreach($game_list_arr as $v){
    $game_list[$v['id']]=$v['name'];
    $game_byname[$v['id']]=$v['game_byname'];
}
if($game_id>0){
    $server_list_arr = $db ->find("select distinct server_id,name from ".PAYDB.".".SERVERLIST." where game_id=$game_id order by server_id DESC");
    foreach($server_list_arr as $v){
        $server_list[$v['server_id']]=$v['name'];
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>实时充值同期对比</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18702"></HEAD>
<?php require_once('include/head_css_js.php');?>
<script language="javascript" type="text/javascript">
   function btnsubmit() {
   $("#myform").submit();
   }
var pro_str=<?=json_encode($game_list)?>;
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
            <SELECT name="game_id" id="game_id" onChange="window.location.href='payTogame_analysis.php?game_id='+this.value;">
                <OPTION label="所有游戏" value="" >所有游戏</OPTION>
            <?php foreach( $game_list as $id=>$name ) { ?>
                <OPTION value="<?=$id?>" <?php if ( $id == $game_id ) { echo 'selected="selected"'; }?>><?=$name?></OPTION>
            <?php }?>	
            </SELECT><input type="text" value="输入关键字" id="pro_keyword" size="8">
             &nbsp;服务器：
            <SELECT name="server_id" id="server_id">
                <OPTION label="所有服" value="" >所有服</OPTION>
            <?php if($server_list){
                foreach( $server_list as $id=>$name ) { ?>
                <OPTION value="<?=$id?>" <? if ( $id == $server_id ) { echo 'selected="selected"'; }?>><?=$name?></OPTION>
            <?php } }?>	
            </SELECT>
                <img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
        </FORM>
        </DIV>
    </TD>
    </TR>
  </TBODY>
</TABLE>
<div id="container" style="width: 800px; height: 200px; margin: 0 auto"></div><p>
注： 显示数据为当天 00:00:00至<?=date('H:i:s',$tm)?><br>
提示： 鼠标移到箭头上可显示差额  <img src="images/up.gif">表示今天比同期多  <img src="images/down.gif">表示今天比同期少
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=3 width=1230 height=40>
    <TBODY>
    <TR class=table_list_head>
        <TD align=middle></TD>
        <TD align=middle colspan="5">充值金额同期对比</TD>
        <TD align=middle colspan="4">与昨天数据对比</TD>
        <TD>-----</TD>
    </TR>  
    <TR class=table_list_head>
        <TD align=middle>游戏\时间</TD>
        <TD align=middle>上月(<?=$total[30]['tdate']?>)</TD>
        <TD align=middle>上周(<?=$total[7]['tdate']?>)</TD>
        <TD align=middle>前天(<?=$total[2]['tdate']?>)</TD>
        <TD align=middle>昨天(<?=$total[1]['tdate']?>)</TD>
        <TD align=middle>今天(<?=$total[0]['tdate']?>)</TD>
        <TD align=middle>充值次数</TD>
        <TD align=middle>充值人数</TD>
        <TD align=middle>ARPU值</TD>
        <TD align=middle>增长</TD>
        <TD>收入比例图</TD>
    </TR>
<?php
    $i=0;
    if($data){
    foreach($data as $id=>$v){
        if($game_id>0){ 
            $name=$server_list[$id]; 
        } else { 
            $name=$game_list[$id]; 
        }
        $arpu1=$v[0]['pay_num']>0?round($v[0]['money']/$v[0]['pay_num'],2):0;
	$arpu2=$v[1]['pay_num']>0?round($v[1]['money']/$v[1]['pay_num'],2):0;
?>
    <TR class="<?php if ($i%2==0) echo 'trOdd'; else echo 'trEven';?>">
        <TD align=middle><?=$name?></TD>
        <TD align=middle>￥<?=round($v[30]['money'],2)?><?php $ct=$v[0]['money']-$v[30]['money']; if($ct<0){ ?><img src="images/down.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } else if($ct>0) { ?><img src="images/up.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } ?></TD>
	<TD align=middle>￥<?=round($v[7]['money'],2)?><?php $ct=$v[0]['money']-$v[7]['money']; if($ct<0){ ?><img src="images/down.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } else if($ct>0) { ?><img src="images/up.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } ?></TD>
	<TD align=middle>￥<?=round($v[2]['money'],2)?><?php $ct=$v[0]['money']-$v[2]['money']; if($ct<0){ ?><img src="images/down.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } else if($ct>0) { ?><img src="images/up.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } ?></TD>
        <TD align=middle>￥<?=round($v[1]['money'],2)?><?php $mt=round($v[0]['money']-$v[1]['money']); if($mt<0){ ?><img src="images/down.gif" alt="<?=$mt?>" title="<?=$mt?>" /><?php } else if($mt>0) { ?><img src="images/up.gif" alt="<?=$mt?>" title="<?=$mt?>" /><?php } ?></TD>
	<TD align=middle>￥<?=round($v[0]['money'],2)?></TD>
        <TD align=middle><?=$v[0]['pay_times']+0?><?php $ct=$v[0]['pay_times']-$v[1]['pay_times']; if($ct<0){ ?><img src="images/down.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } else if($ct>0) { ?><img src="images/up.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } ?></TD>
	<TD align=middle><?=$v[0]['pay_num']+0?><?php $ct=$v[0]['pay_num']-$v[1]['pay_num']; if($ct<0){ ?><img src="images/down.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } else if($ct>0) { ?><img src="images/up.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } ?></TD>
        <TD align=middle><?=$arpu1?><?php $ct=$arpu1-$arpu2; if($ct<0){ ?><img src="images/down.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } else if($ct>0) { ?><img src="images/up.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } ?></TD>
        <TD align=middle><?php if($mt<0){ ?><font color="red"><?=$mt?></font><?php } else if($mt>0) { ?><font color="#00FF00"><?=$mt?></font><?php } else { echo '-'; } ?></TD>
        <TD><img src="images/mht1B8(1).tmp" height="10" width="<?php $bl=round(($v[0]['money']/$total[0]['money'])*100,2); echo $bl>1?$bl:1; ?>"><?=$bl?>%</TD>
    </TR>
<?php $i++;}}?>
    <TR class=table_list_head>
        <TD align=middle>合计</TD>
        <TD align=middle>￥<?=round($total[30]['money'],2)?><?php $ct=$total[0]['money']-$total[30]['money']; if($ct<0){ ?><img src="images/down.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } else if($ct>0) { ?><img src="images/up.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } ?></TD>
        <TD align=middle>￥<?=round($total[7]['money'],2)?><?php $ct=$total[0]['money']-$total[7]['money']; if($ct<0){ ?><img src="images/down.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } else if($ct>0) { ?><img src="images/up.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } ?></TD>
        <TD align=middle>￥<?=round($total[2]['money'],2)?><?php $ct=$total[0]['money']-$total[2]['money']; if($ct<0){ ?><img src="images/down.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } else if($ct>0) { ?><img src="images/up.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } ?></TD>
        <TD align=middle>￥<?=round($total[1]['money'],2)?><?php $mt=round($total[0]['money']-$total[1]['money']); if($mt<0){ ?><img src="images/down.gif" alt="<?=$mt?>" title="<?=$mt?>" /><?php } else if($mt>0) { ?><img src="images/up.gif" alt="<?=$mt?>" title="<?=$mt?>" /><?php } ?></TD>
        <TD align=middle>￥<?=round($total[0]['money'],2)?></TD>
        <TD align=middle><?=$total[0]['pay_times']?><?php $ct=$total[0]['pay_times']-$total[1]['pay_times']; if($ct<0){ ?><img src="images/down.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } else if($ct>0) { ?><img src="images/up.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } ?></TD>
        <TD align=middle><?=$total[0]['pay_num']?><?php $ct=$total[0]['pay_num']-$total[1]['pay_num']; if($ct<0){ ?><img src="images/down.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } else if($ct>0) { ?><img src="images/up.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } ?></TD>
        <TD align=middle><?php 
            $arpu1=$total[0]['pay_num']>0?round($total[0]['money']/$total[0]['pay_num'],2):0;
            $arpu2=$total[1]['pay_num']>0?round($total[1]['money']/$total[1]['pay_num'],2):0;
            echo $arpu1;  $ct=$arpu1-$arpu2; if($ct<0){ ?><img src="images/down.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } else if($ct>0) { ?><img src="images/up.gif" alt="<?=$ct?>" title="<?=$ct?>" /><?php } ?>
        </TD>
        <TD align=middle><?php if($mt<0){ ?><font color="red"><?=$mt?></font><?php } else if($mt>0) { ?><font color="#00FF00"><?=$mt?></font><?php } else { echo '-'; } ?></TD>
        <TD></TD>
    </TR>
</TBODY></TABLE>
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
                    text: '合计收入对比趋势图',
                    x: -20 //center
            },
            subtitle: {
                    text: '',
                    x: -20
            },
            xAxis: {
                    categories: ['上月(<?=$total[30]['tdate']?>)','上周(<?=$total[7]['tdate']?>)','前天(<?=$total[2]['tdate']?>)','昨天(<?=$total[1]['tdate']?>)','今天(<?=$total[0]['tdate']?>)']
            },
            yAxis: {
                    title: {
                            text: '收入（元）'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                    }]
            },
            tooltip: {
                    formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                                    this.x +': '+ this.y +'元';
                    }
            },
            legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: 0,
                    y: 100,
                    borderWidth: 0
            },
            series: [{
                    name: '合计收入',
                    data: [<?=@intval($total[30]['money'])?>,<?=@intval($total[7]['money'])?>,<?=@intval($total[2]['money'])?>,<?=@intval($total[1]['money'])?>,<?=@intval($total[0]['money'])?>]
            }]
        });
				
    });
</script>
<SCRIPT type="text/javascript">
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
	search_pro();
  </SCRIPT>
</BODY>
</HTML>
