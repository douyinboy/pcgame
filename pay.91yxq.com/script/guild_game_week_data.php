<?php
set_time_limit(3600);
//每周1执行一次，统计上周公会游戏结算数据
include_once(dirname(__DIR__) . "/include/dbconn_4.php");
include_once(dirname(__DIR__) . "/include/config.inc.php");
include_once(dirname(__DIR__) . "/include/funcs.php");
/*
//临时处理链接提取错误纠正
$sql ="select user_name from 91yxq_users.91yxq_agent_reg_2015 where agent_id=793 and game_id=23 and server_id=89";
$res=mysql_query($sql);
while ($row=mysql_fetch_object($res)) {
    $sql ="update pay_list set agent_id=793, placeid=0 where user_name='".$row ->user_name."' and game_id=23 and server_id=89";
    //$sql = "update 91yxq_users.users set agent_id=793 , place_id=0 where user_name='".$row ->user_name."'";
    mysql_query($sql);
}
die; */
//统计起始时间

$date=date('Y-m-d');  //当前日期	 
$first=1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
$w=date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
$now_start=date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
$now_end=date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期
$pay_date_s2=date('Y-m-d',strtotime("$now_start - 7 days"));  //上周开始日期
$pay_date_s = $pay_date_s2;
$pay_date_e=date('Y-m-d',strtotime("$now_start - 1 days"));  //上周结束日期

//上周是本年的第几个周
$weekth = intval(date('W', strtotime($pay_date_s2)));
//先删除当周数据
$sql = "DELETE FROM guild_game_week_statistics WHERE weekth =".intval($weekth);
mysql_query($sql);
//获取游戏信息
$game = array();
$sql = "SELECT id, name, fuildfc FROM game_list";
$res=mysql_query($sql);
while ($row=mysql_fetch_object($res)) {
    $game[$row->id] = $row ->fuildfc;
}
//获取公会信息
$agent =array();
$sql = "SELECT id, agentname FROM 91yxq_admin.agent where state =1";
$res=mysql_query($sql);
while ($row=mysql_fetch_object($res)) {
    $agent[$row->id] = $row ->agentname;
}
//获取调控部分
$controlpart = array();
$sql = "SELECT guild_id, game_id, adjust FROM guild_divide_adjust WHERE start=1";
$res=mysql_query($sql);
while ($row=mysql_fetch_object($res)) {
    $controlpart[$row->guild_id][$row->game_id] = $row ->adjust;
}
//首充
$payfirst = array();
$sql ="SELECT agent_id, game_id, sum(money) as fmoney FROM admin_pay_first WHERE pay_time >=".strtotime($pay_date_s2 ."00:00:00")." 
        AND pay_time <=".strtotime($pay_date_e ."23:59:59")." AND state=1 GROUP BY agent_id, game_id";
$res=mysql_query($sql);
while ($row=mysql_fetch_object($res)) {
    $payfirst[$row->agent_id][$row->game_id] = $row ->fmoney;
}
//赔付
$payinner = array();
$sql ="SELECT agent_id, game_id, sum(money) as nmoney FROM admin_pay_inner WHERE pay_time >=".strtotime($pay_date_s2 ."00:00:00")." 
        AND pay_time <=".strtotime($pay_date_e ."23:59:59")." AND state=1 AND pay_type=2 GROUP BY agent_id, game_id";
$res=mysql_query($sql);
while ($row=mysql_fetch_object($res)) {
    $payinner[$row->agent_id][$row->game_id] = $row ->nmoney;
}
//充v
$payvip = array();
$sql ="SELECT agent_id, game_id, sum(money) as vmoney FROM admin_pay_vip WHERE pay_time >=".strtotime($pay_date_s2 ."00:00:00")." 
        AND pay_time <=".strtotime($pay_date_e ."23:59:59")." AND state=1 GROUP BY agent_id, game_id";
$res=mysql_query($sql);
while ($row=mysql_fetch_object($res)) {
    $payvip[$row->agent_id][$row->game_id] = $row ->vmoney;
}
//获取充值
$pay = array();
$filter=" WHERE pay_date >= '".$pay_date_s ." 00:00:00' AND pay_date <= '".$pay_date_e ." 23:59:59'";
$sql="SELECT agent_id, game_id, SUM(money) as totalmoney, SUM(paid_amount) as totalamount FROM `pay_list` 
      $filter GROUP BY agent_id, game_id ORDER BY totalamount DESC";
$res=mysql_query($sql);
while ($row=mysql_fetch_object($res)) {
    $pay[$row->agent_id][$row->game_id]['totalmoney'] = $row ->totalmoney;
    $pay[$row->agent_id][$row->game_id]['totalamount'] = $row ->totalamount;
}
//循环公会
foreach($agent as $k => $v){
    //循环游戏
    foreach($game as $k2 => $v2){
        $pay_money = intval($pay[$k][$k2]['totalmoney']);
        $paid_amount = round($pay[$k][$k2]['totalamount'], 2);
        $pay_first = $payfirst[$k][$k2] > 0 ? intval($payfirst[$k][$k2]) :0;
        $pay_inner = $payinner[$k][$k2] > 0 ?intval($payinner[$k][$k2]):0;
        $pay_vip = $payvip[$k][$k2] >0 ? intval($payvip[$k][$k2]) : 0;
        $fc =  $controlpart[$k][$k2] > 0 ? $controlpart[$k][$k2] : $v2;
        $dfc= $fc-$v2; //调配差值(百分比)
        //计算应结算金额  应付金额 = 充值流水 * （游戏通用分成点数 + 宏观调控点数） - 赔付内充*35%
        $jie_pay = round(($paid_amount * $fc / 100), 2)  - round(($pay_inner *35/100), 2);
        $deploy_jie=round(($paid_amount * $dfc / 100), 2);
        if($pay_vip >0 || $pay_inner > 0 || $pay_first > 0 || $paid_amount >0){
            $sql ="INSERT INTO  guild_game_week_statistics "
                . "(weekth, wsdate, wedate, agent_id, game_id, pay_money, pay_amount, pay_first, pay_inner, pay_vip, fc, pay_jie, deploy_jie, stime) VALUES "
                . "(".$weekth.", ".date("Ymd", strtotime($pay_date_s2)).", ".date("Ymd", strtotime($pay_date_e)).", ".$k.", ".$k2.", ".$pay_money.", ".$paid_amount.", ".$pay_first.
                ", ".$pay_inner.", ".$pay_vip.", ".$fc.", ".$jie_pay.", ".$deploy_jie.", ".time().")";
            $r = mysql_query($sql);
            $insertid = mysql_insert_id();
            if($r){
                //修改pay_list表的统计状态
                $sql = "UPDATE pay_list SET jie_id=".$insertid.", is_account=1  WHERE pay_date >= '".$pay_date_s .
                        " 00:00:00' AND pay_date <= '".$pay_date_e ." 23:59:59' AND agent_id=".$k.
                        " AND game_id=".$k2;
                if(mysql_query($sql)){
                    //记录
                }else{
                    //日志记录
                }
            } 
        }
    }
}
//$sql ="delete from guild_game_week_statistics where weekth=".$weekth." and pay_amount = 0.00 and pay_first < 1 and pay_inner < 1 and pay_vip < 1";
//mysql_query($sql);

/*
while ($row=mysql_fetch_object($res)){
    $pay_money = intval($row ->totalmoney);
    $paid_amount = round($row ->totalamount, 2);
    $pay_first = $payfirst[$row ->agent_id][$row ->game_id] >0 ? intval($payfirst[$row ->agent_id][$row ->game_id]) :0;
    $pay_inner = $payinner[$row ->agent_id][$row ->game_id] > 0 ?intval($payinner[$row ->agent_id][$row ->game_id]):0;
    $pay_vip = $payvip[$row ->agent_id][$row ->game_id] >0 ? intval($payvip[$row ->agent_id][$row ->game_id]) : 0;
    $fc =  $controlpart[$row->agent_id][$row->game_id] > 0 ? $controlpart[$row->agent_id][$row->game_id] : $game[$row ->game_id];
    //计算应结算金额  应付金额 = 充值流水 * （游戏通用分成点数 + 宏观调控点数） - 赔付内充*35%
    $jie_pay = round(($paid_amount * $fc / 100), 2)  - round(($pay_inner *35/100) , 2);
    $sql ="SELECT id FROM guild_game_week_statistics WHERE wsdate =".  date("Ymd", strtotime($pay_date_s2))." AND wedate=".  date("Ymd", strtotime($pay_date_e))." AND agent_id=".$row ->agent_id." AND game_id=".$row ->game_id;
    $result = mysql_query($sql);
    $tmp = mysql_fetch_object($result);
    if(is_object($tmp) && $tmp ->id >0){
        $sql ="UPDATE  guild_game_week_statistics SET weekth=".$weekth.", wsdate=".date("Ymd", strtotime($pay_date_s2)).
                ", wedate=".date("Ymd", strtotime($pay_date_e)).", agent_id=".$row ->agent_id.", game_id=".$row ->game_id.
                ", pay_money=".$pay_money.", pay_amount=".$paid_amount.", pay_first=".$pay_first.
            ", pay_inner=".$pay_inner.", pay_vip=".$pay_vip.", fc= ".$fc.", pay_jie=".$jie_pay.", stime=".time().
            " WHERE wsdate =".  date("Ymd", strtotime($pay_date_s2))." AND wedate=".date("Ymd", strtotime($pay_date_e)).
            " AND agent_id=".$row ->agent_id." AND game_id=".$row ->game_id;
        $r = mysql_query($sql);
         //修改pay_list表的统计状态
        if($r){
            $sql = "UPDATE pay_list SET jie_id=".$insertid.", is_account=1  WHERE pay_date >= '".$pay_date_s .
                    " 00:00:00' AND pay_date <= '".$pay_date_e ." 23:59:59' AND agent_id=".$row->agent_id.
                    " AND game_id=".$row ->game_id;
            if(mysql_query($sql)){
                //记录
            }else{
                //日志记录
            }
        }
        $insertid = $tmp ->id;   
    }else{
        $sql ="INSERT INTO  guild_game_week_statistics "
            . "(weekth, wsdate, wedate, agent_id, game_id, pay_money, pay_amount, pay_first, pay_inner, pay_vip, fc, pay_jie, stime) VALUES "
            . "(".$weekth.", ".date("Ymd", strtotime($pay_date_s2)).", ".date("Ymd", strtotime($pay_date_e)).", ".$row ->agent_id.", ".$row ->game_id.", ".$pay_money.", ".$paid_amount.", ".$pay_first.
            ", ".$pay_inner.", ".$pay_vip.", ".$fc.", ".$jie_pay.", ".time().")";
        $r = mysql_query($sql);
        $insertid = mysql_insert_id();
        if($r){
            //修改pay_list表的统计状态
            $sql = "UPDATE pay_list SET jie_id=".$insertid.", is_account=1  WHERE pay_date >= '".$pay_date_s .
                    " 00:00:00' AND pay_date <= '".$pay_date_e ." 23:59:59' AND agent_id=".$row->agent_id.
                    " AND game_id=".$row ->game_id;
            if(mysql_query($sql)){
                //记录
            }else{
                //日志记录
            }
        }   
    } 
}*/
?>
