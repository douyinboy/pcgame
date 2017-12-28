<?php
/*每天定时执行补漏更新成功付款充值信息,中午12点之前执行都会查询昨日及今日订单列表*/
ini_set("display_errors", "On");
error_reporting(0);
set_time_limit(0);
//include_once("/www/pay.91yxq.com/include/dbconn_4.php");
include_once(dirname(__DIR__) . "/include/config.inc.php");
//include_once("/www/pay.91yxq.com/include/funcs.php");
include_once(dirname(__DIR__) . "/config/pay_way.inc.php");

    $max_date =  time()-120;
    $filter=" where sync_date >= $max_date and succ=1 ";
    $sql="select * from pay_orders $filter";
    $res=mysql_query($sql);
    while ($row=mysql_fetch_object($res)) {
            //判断订单是否已经存在
            $r=mysql_query("SELECT orderid FROM pay_list WHERE orderid='".$row->orderid."'");
            $tmp=mysql_fetch_object($r);
            if($tmp){
                continue;
            }
            $rs=mysql_query("SELECT agent_id, place_id, reg_time FROM 91yxq_users.users WHERE user_name='".$row->user."'");
            $user=mysql_fetch_object($rs);
            if ($user->reg_time >0) {
                     $reg_time = $user->reg_time;
            } else {
                     $reg_time =1388505600;//默认2014年1月1日
            }
            $year = date("Y",$reg_time);
            $sql="select * from 91yxq_users.91yxq_agent_reg_".$year."  where user_name='$row->user'";
            $res2=mysql_query($sql);
            $row2=mysql_fetch_object($res2);
            $user_role = $row2 ->user_role;
            $agent_id= $user->agent_id;
            $reg_game_id=$row2->game_id;
            $reg_server_id=$row2->server_id;
            $placeid = $user->place_id;
            $cplaceid = $row2->ext1;
            $adid    = $row2->adid;
            $from_url=$row2->referer_url;
            $reg_date=date("Y-m-d H:i:s",$row2->reg_time);
            $cid = $row2->agent_id;
            $paid_amount = $row->money * $pay_way_arr[$row->pay_channel]['pay_rate'];
            $sql="INSERT INTO pay_list(orderid, user_name, pay_way_id, money, paid_amount, sync_date, pay_date, agent_id, placeid, cplaceid, adid, reg_date, game_id, reg_game_id, reg_server_id, server_id, from_url, cid, user_ip) values ('".$row->orderid."','".$row->user."', '".$row->pay_channel."','".($row->money)."','$paid_amount','".date("Y-m-d H:i:s",$row->sync_date)."','".date("Y-m-d H:i:s",$row->pay_date)."','$agent_id','$placeid','$cplaceid','$adid','$reg_date','".$row->game."','".$row->game."', '".$row->server."', '".$row->server."','$from_url','$cid','".long2ip($row->user_ip)."')";
            mysql_query($sql);
    }
/*
//归类渠道数据表
include("/www/pay.91yxq.com/include/dbconn_9.php");
$sql = "SELECT id,agent_id,placeid FROM `pay_list` WHERE pay_date>='".date('Y-m-d')." 00:00:00' AND pay_date<='".date('Y-m-d')." 23:59:59' AND cid>0";
$res = mysql_query($sql,$conn);
while ($row = mysql_fetch_object($res)) {
       $agent_id = $row->agent_id;
       $placeid = $row->placeid;
       $res1 = mysql_query("SELECT adtype FROM 91yxq_admin.`agent_site` where agent_id=".$agent_id." and site_id=".$placeid,$conn_12);
       $row1 = mysql_fetch_object($res1);
       if  ($row1) {
            $cid = $row1 ->adtype;
       }
       mysql_query("UPDATE `pay_list` SET cid='".$cid."' where id=".$row->id,$conn);
}
//归类渠道数据表
 * 
 */
?>