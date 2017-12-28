<?php
    require_once('../common/common.php');
	include('include/isLogin.php');	
    include("include/pay_way.inc.php");
    $date1=trim($_REQUEST["date1"]);
    $date2=trim($_REQUEST["date2"]);
    $game_id =trim($_REQUEST["game_id"]);
    $server_id =trim($_REQUEST["server_id"]);
    $moneytype=$_REQUEST['moneytype'];
    if($moneytype==2){
        $pay_field='paid_amount';
    } else {
        $pay_field='money';
    }
    if (!$date1) {
        $date1=date("Y-m-")."01";
    } 
    if (!$date2) {
        $date2=date("Y-m-d");
    }
    $month=  substr($date1,5,-3);
    if ($_SESSION['sp_gamelist'] && $_SESSION['dept']!=2) {
        $arr=explode('|',$_SESSION['sp_gamelist']);
        $sp_gamelist= $arr[0];
    }
    if ($sp_gamelist) {
        $filter .= " AND id IN (".$sp_gamelist.")";
        $f=" AND game_id IN (".$sp_gamelist.")";
    }
    $s=" WHERE  `pay_date`>='".$date1." 00:00:00' AND `pay_date`<='".$date2." 23:59:59' $f";
    if ( $game_id !='' && $game_id!=='all' ) {
        $s.= " AND game_id=".$game_id;
        $fs=" AND game_id=".$game_id;
    }
    if ( $server_id !='' && $server_id !='all' ) {
        $s.= " AND server_id=".$server_id;
    }
    $game_list_arr = $db ->find("SELECT id,name,game_byname FROM ".PAYDB.".".GAMELIST." WHERE 1 $filter ");
    $game_server_list_arr = $db ->find("select distinct server_id from ".PAYDB.".".SERVERLIST." where  is_open=1 $fs order by server_id DESC ");
    foreach($game_list_arr as $val){
        $game_list[]=$val;
        $game_arr[$val['id']]=$val['name'];
        $game_byname[$val['id']]=$val['game_byname'];
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML>
<HEAD>
<TITLE>日收入统计</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type>
<META name=GENERATOR content="MSHTML 8.00.6001.18702"></HEAD>
<?php require_once('include/head_css_js.php');?>
<script language="javascript" type="text/javascript">
    function game_change(info) {
    if(!info){return false;}
        var uname = $("#user_name").val();
        var date1 = $("#date1").val();
        var date2 = $("#date2").val();
   window.location.href='dataCount_d.php?game_id='+info+'&user_name='+uname+'&date1='+date1+'&date2='+date2;
   }
   function btnsubmit() {
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
            &nbsp;&nbsp;充值日期：
            <INPUT  value="<?=$date1?>" name="date1" id="date1" size="20" onClick="WdatePicker();" > -
              <INPUT  value="<?=$date2?>" name="date2" id="date2" size="20" onClick="WdatePicker();" >
            &nbsp;&nbsp;游戏：
            <SELECT name="game_id" id="game_id" onChange="game_change(this.value)">
                <OPTION label="所有游戏" value="all" >所有游戏</OPTION>
             <?php  foreach( $game_list_arr as $val ) { ?>
                 <OPTION value="<?=$val['id']?>" <?php if ( $val['id'] == $game_id ) { echo 'selected="selected"'; }?>><?=$val['name']?></OPTION>
            <?php }?>	
           </SELECT><input type="text" value="输入关键字" id="pro_keyword" size="8">
            &nbsp;&nbsp;
            服务器：
            <SELECT name="server_id" id="server_id">
                <OPTION label="所有区服" value="all" >所有区服</OPTION>
                <?php foreach( $game_server_list_arr as $val ) {?>
                <OPTION value="<?=$val['server_id']?>" <?php if ( $val['server_id'] == $server_id ) { echo 'selected="selected"'; }?>>双线<?=$val['server_id']?>服</OPTION>
                <?php }?>	
            </SELECT>
            &nbsp;&nbsp; 查看类型：
            <SELECT name="moneytype" id="moneytype">
                <OPTION value="1" <?php if($moneytype=='1'){ echo 'selected="selected"'; } ?> >充值面额</OPTION>
                <OPTION value="2" <?php if($moneytype=='2'){ echo 'selected="selected"'; } ?> >充值净值</OPTION>
            </SELECT> &nbsp;&nbsp;
            <img class="input2" align="top" src="images/mht224(1).tmp" type="image" onClick="btnsubmit();"> 
            </FORM>
        </DIV>
    </TD>
    </TR>
  </TBODY>
</TABLE>
<TABLE class=table_list border=0 cellSpacing=1 cellPadding=2>
  <TBODY>
  <TR class=table_list_head>
    <TD width="81" noWrap>日期</TD>
<?php foreach ($pay_way_arr as $k =>$v){ ?>
    <TD width=75><?=$v['payname']?></TD>
<?php } ?>
    <TD width="65">首充</TD>
    <TD width="65">充V</TD>
    <TD width="65">人工充值</TD>
    <TD width="65">平台发放</TD>
    <TD width="65">公会赔付</TD>
    <TD width="87">合计支付</TD>
    <TD width="78">付费人数</TD>
    <TD width="78">ARPU</TD>
  </TR>
<?php 
$wh2 = '';
if($game_id > 0)
    $wh2 .= ' AND game_id ='.$game_id;
if($server_id > 0)
    $wh2 .= ' AND server_id ='.$server_id;
$sql="select distinct DATE_FORMAT( pay_date, '%Y-%m-%d' ) as tdate from ".PAYDB.".".PAYLIST." $s AND game_id !=0 AND server_id !=0 order by tdate";
$pay_date_arr = $db ->find($sql);
$i=0;
foreach ( $pay_date_arr as $val) {
    $tdate=$val['tdate'];
    $sql="select count(distinct user_name) as pn from ".PAYDB.".".PAYLIST." $s  AND game_id !=0 AND server_id !=0  and pay_date>='$tdate' and pay_date<='$tdate 23:59:59'";
    $pre=$db->get($sql);
    $sql="select sum($pay_field) as sm,count(distinct user_name) as pn,pay_way_id from ".PAYDB.".".PAYLIST." $s AND game_id !=0 AND server_id !=0  and pay_date>='$tdate' and pay_date<='$tdate 23:59:59' group by pay_way_id";
    $pay_m_arr =$db ->find($sql);

    //首充
    $stime = strtotime($tdate." 00:00:00");
    $etime =  strtotime($tdate." 23:59:59");
    $sql ="SELECT sum(money) as fmoney FROM ".PAYDB.".".PAYFIRST." WHERE state=1 AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
    $fpay=$db->get($sql);

    //充v
    $sql ="SELECT sum(money) as vmoney FROM ".PAYDB.".".PAYVIP." WHERE state=1 AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
    $vpay=$db->get($sql);

    //内充
    $sql ="SELECT sum(money) as nmoney FROM ".PAYDB.".".PAYINNER." WHERE state=1 AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
    $npay=$db->get($sql);
    $totalrg = intval($fpay['fmoney']) + intval($vpay['vmoney']) + intval($npay['nmoney']);

    $sql ="SELECT sum(money) as nmoney FROM ".PAYDB.".".PAYINNER." WHERE pay_type=1 AND state=1 AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
    $pfpay=$db->get($sql);//平台发放

    $sql ="SELECT sum(money) as nmoney FROM ".PAYDB.".".PAYINNER." WHERE pay_type=2 AND state=1 AND pay_time>=".$stime." AND pay_time <=".$etime.$wh2;
    $ghpay=$db->get($sql);//公会赔付
    //人工充值结束
    $pay=array();
    $paysum1=$paysum2=0;
    foreach ( $pay_m_arr as $val2) {
        $pay[$val2["pay_way_id"]]=$val2['sm'];
        $paysum1 += $pay[$val2["pay_way_id"]];
        $paysum[$val2["pay_way_id"]] += $pay[$val2["pay_way_id"]];
    }
    
    $fpay_total += $fpay['fmoney'];
    $vpay_total += $vpay['vmoney'];
    $npay_total += $npay['nmoney'];
    $pfpay_total += $pfpay['nmoney'];
    $ghpay_total += $ghpay['nmoney'];

    $money1+=$paysum1;
    $money1 +=$totalrg;
    $paysum1+=$totalrg;
    $paysum[11] +=$totalrg;
    if($i==0){
        $datat="'".substr($tdate,8)."'";
        foreach ($pay_way_arr as $kk =>$vv){
            $data[$kk] = $pay[$kk] >0 ? $pay[$kk]:"0";  
        }
      } else {
      	$datat.=",'".substr($tdate,8)."'";
        foreach ($pay_way_arr as $kk =>$vv){
            $data[$kk].= $pay[$kk] >0 ? ",".$pay[$kk]:",0"; 
        }
    $hj_pn+=$pre['pn'];
    }
  ?>
    <TR class=<?php if ($i%2==0) echo 'trOdd'; else echo 'trEven';$i++;?>>
        <TD noWrap><?=$tdate?></TD>
    <?php foreach ($pay_way_arr as $kk =>$vv){ ?>
        <TD noWrap><?=round($pay[$kk],2)?></TD>
    <?php } ?>
        <TD noWrap><?=round($fpay['fmoney'],2)?></TD>
        <TD noWrap><?=round($vpay['vmoney'],2)?></TD>
        <TD noWrap><?=round($pfpay['nmoney'],2)?></TD>
        <TD noWrap><?=round($ghpay['nmoney'],2)?></TD>
        <TD noWrap><?=round($paysum1,2)?></TD>
        <TD noWrap><?=$pre['pn']?></TD>
        <TD noWrap><?=round($paysum1/$pre['pn'],2)?></TD>
    </TR>
  <?php } ?>
    <TR class="trEven">
        <TD noWrap><font color='red'>合计</font></TD>
    <?php foreach ($pay_way_arr as $kk =>$vv){ ?>
        <TD noWrap><?=round($paysum[$kk],2)?></TD>
    <?php } ?>
        <TD noWrap><?=round($fpay_total,2)?></TD>
        <TD noWrap><?=round($vpay_total,2)?></TD>
        <TD noWrap><?=round($pfpay_total,2)?></TD>
        <TD noWrap><?=round($ghpay_total,2)?></TD>
        <TD noWrap><?=round($money1,2)?></TD>
        <TD><?=$hj_pn?></TD>
        <TD><?=round($money1/$hj_pn,2)?></TD>
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
                text: '<?=$month?>月收入按日统计',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: [<?=$datat?>]
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
//                valueSuffix: '元'
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
        <?php foreach ($pay_way_arr as $kk =>$vv){?>
            {
                name: '<?=$vv['payname']?>',
                data: [<?=$data[$kk]?>]
            }, 
        <?php } ?>
            ]
        });
    });
</script>
<div id="container" style="width: 1000px; height: 400px; margin: 0 auto"></div>
<script language="javascript" type="text/javascript" src="js/My97DatePicker/WdatePicker.js"></script>
<SCRIPT>
    $(".table_list tr").mouseover(function(){$(this).addClass("trSelected");}).mouseout(function(){$(this).removeClass("trSelected");});
    search_pro();
  </SCRIPT>
</BODY>
</HTML>
