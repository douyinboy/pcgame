<?php
/*每月定时执行更新充值平台月数据*/
ini_set("display_errors", "On");
error_reporting(0);
set_time_limit(36000);
include_once(dirname(__DIR__) . "/include/config.inc.php");
//获取更新月份
if($_GET['mon'] !=''){
    $mon = $_GET['mon'];
}else{
    $mon = date('Y-m', time()-(intval(date('d'))*3600*24)); 
}
$ym = intval(str_replace('-', '', $mon));
$days = date("t",  strtotime($mon.'-01'));
$stime = strtotime($mon.'-01 00:00:00');
$etime = strtotime($mon.'-'.$days.' 23:59:59');
//获取游戏列表
$sql="select * from game_list";
$res=mysql_query($sql);
$gamelist = array();
//游戏充值接口返回
$gamemoney = array();
while($row = mysql_fetch_array($res)){
    $gamelist[$row['id']] = $row;
    $sql ="SELECT SUM(paid_amount) AS totalPay FROM pay_".$row['game_byname']."_log WHERE back_result=1 AND pay_date >='".$mon."-01 00:00:00' AND pay_date <='".$mon."-".$days." 23:59:59'";
    $restmp = mysql_query($sql);
    $rowtmp = mysql_fetch_object($restmp);
    $rowtmp->totalPay < 1 && $rowtmp->totalPay =0;
    $gamemoney[$row['id']]['api_success_money'] = $rowtmp ->totalPay;
}
$ptdata = array();
//update table  month_game_data
//获取公会当月游戏充值
$sql ="SELECT game_id, agent_id, sum(money) as totalMoney, sum(paid_amount) as totalAmount FROM pay_list WHERE  pay_date >='".$mon."-01 00:00:00' AND pay_date <='".$mon."-".$days." 23:59:59'  group by game_id, agent_id";
$res = mysql_query($sql);
while($row = mysql_fetch_array($res)){
    $ptdata[$row['game_id']][$row['agent_id']]['ptmoney'] = $row['totalMoney'];
    $ptdata[$row['game_id']][$row['agent_id']]['ptamount'] = $row['totalAmount'];
}
//获取游戏当月首充
$sql ="SELECT agent_id, game_id, SUM(money) AS totalPay FROM admin_pay_first WHERE state=1 AND pay_time >=".$stime." AND pay_time <=".$etime." group by game_id, agent_id";
$res = mysql_query($sql);
while($row = mysql_fetch_array($res)){
    $ptdata[$row['game_id']][$row['agent_id']]['firstpay'] = $row['totalPay'];
}
//获取游戏当月内充总额
$sql ="SELECT agent_id, game_id, SUM(money) AS totalPay FROM admin_pay_inner WHERE state=1 AND pay_time >=".$stime." AND pay_time <=".$etime." group by game_id, agent_id";
$res = mysql_query($sql);
while($row = mysql_fetch_array($res)){
    $ptdata[$row['game_id']][$row['agent_id']]['innerpay'] = $row['totalPay'];
}
//获取游戏当月公会赔付内充
$sql ="SELECT agent_id, game_id, SUM(money) AS totalPay FROM admin_pay_inner WHERE state=1  AND pay_type=2 AND pay_time >=".$stime." AND pay_time <=".$etime." group by game_id, agent_id";
$res = mysql_query($sql);
while($row = mysql_fetch_array($res)){
    $ptdata[$row['game_id']][$row['agent_id']]['innerpay2'] = $row['totalPay'];
}
//获取游戏当月充v总额
$sql ="SELECT agent_id, game_id, SUM(money) AS totalPay FROM admin_pay_vip WHERE state=1 AND pay_time >=".$stime." AND pay_time <=".$etime." group by game_id, agent_id";
$res = mysql_query($sql);
while($row = mysql_fetch_array($res)){
    $ptdata[$row['game_id']][$row['agent_id']]['vippay'] = $row['totalPay'];
}
//汇总记录
$tot = 0;
foreach($ptdata as $key => $v){
    foreach($v as $key2 =>$v2){
        $v2['vippay'] = $v2['vippay'] >0 ? $v2['vippay']:0;
        $v2['ptamount'] = $v2['ptamount'] >0 ? round($v2['ptamount'],2):0;
        $fc = $gamelist[$key]['fuildfc'] >0 ? $gamelist[$key]['fuildfc']:0;
        //公会游戏分成
        $yf = round(((($v2['ptamount'] * $fc)/100) -(intval($v2['innerpay2']) *0.35)), 2);
        //查询统计记录
        $sql = "SELECT id FROM month_guild_data WHERE ym=".$ym." AND agent_id=".$key2." AND game_id=".$key;
        $restmp = mysql_query($sql);
        $rowtmp = mysql_fetch_object($restmp);
        $str ="ym=".$ym.", game_id=".$key.",agent_id=".$key2.", fc=".$fc.",pay_money=".intval($v2['ptmoney']).", pay_account=".$v2['ptamount'].", 
            pay_first=".intval($v2['firstpay']).", pay_inner=".intval($v2['innerpay']).", pay_inner_pay=".intval($v2['innerpay2']).", 
            pay_vip=".$v2['vippay'].", guild_got_money=".$yf.", 
            rsync_time='".date("Y-m-d H:i:s")."'";
        if($rowtmp->id >0){
            $sql = "UPDATE month_guild_data SET ".$str." WHERE id=".$rowtmp->id;
        }else{
            $sql = "INSERT INTO month_guild_data SET ".$str;
        }
        //更新公会游戏数据
        mysql_query($sql);
        $tot = $tot + 1;
        //统计游戏月份数据
        $gamemoney[$key]['pay_money'] +=  intval($v2['ptmoney']);
        $gamemoney[$key]['pay_account'] += $v2['ptamount'];
        $gamemoney[$key]['first_money'] += intval($v2['firstpay']);
        $gamemoney[$key]['inner_money'] += intval($v2['innerpay']);
        $gamemoney[$key]['inner_pay_money'] += intval($v2['innerpay2']);
        $gamemoney[$key]['vip_money'] +=  $v2['vippay'];
    }
}
//更新上月游戏数据
foreach($gamemoney as $k =>$v){
    //游戏研发
    $yf = round(($v['pay_account'] + $v['first_money'] + $v['inner_money'] + $v['vip_money']), 2);
    //分成参考金额（以充值接口金额为主）
    $fcmoney = $yf*0.3;
    //查询统计记录
    $sql = "SELECT * FROM month_game_data WHERE ym=".$ym." AND game_id=".$k;
    $res8 = mysql_query($sql);
    $row8 = mysql_fetch_object($res8);
    $str ="ym=".$ym.", game_id=".$k.",fc=".$gamelist[$k]['fuildfc'].", pay_money=".$v['pay_money'].", pay_account=".$v['pay_account'].", 
        first_money=".$v['first_money'].", inner_money=".$v['inner_money'].", inner_pay_money=".$v['inner_pay_money'].", 
        vip_money=".$v['vip_money'].", api_success_money=".$v['api_success_money'].", game_api_money=".$yf.", game_pay=".$fcmoney.",rsync_time='".date("Y-m-d H:i:s")."'";
    if($row8->id >0){
        $sql ="UPDATE month_game_data SET ".$str." WHERE id=".$row8->id;
    }else{
        $sql ="INSERT INTO month_game_data SET ".$str;
    }
    if($yf >0){
        mysql_query($sql);
    }
}
mysql_close();
echo $tot;
?>