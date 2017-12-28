<?php
/*每天定时执行补漏成功付款充值信息,每天零时5分执行*/
ini_set("display_errors", "On");
error_reporting(0);
set_time_limit(0);
//include_once("/www/pay.91yxq.com/include/dbconn_4.php");
require_once(substr(__DIR__,0,-6).'include/mysqli_config.inc.php');
require_once(substr(__DIR__,0,-6).'config/pay_way.inc.php');
//include_once("/www/pay.91yxq.com/include/funcs.php");
$max_date =  time()-86460;
$sql="SELECT * FROM `pay_orders` WHERE `sync_date` >= {$max_date} and `succ`=1";
$res=$mysqli->query( $sql );
while ($row=$res->fetch_object()) 
{
        //判断订单是否已经存在
        $r=$mysqli->query( "SELECT orderid FROM pay_list WHERE orderid='{$row->orderid}'" );
        $tmp=$r->fetch_object();
        if($tmp)
		{
            continue;
        }
        $rs=$mysqli->query( "SELECT agent_id, place_id, reg_time FROM 91yxq_users.users WHERE user_name='{$row->user}'" );
        $user=$rs->fetch_object();
        if ( $user->reg_time >0 ) 
		{
                 $reg_time = $user->reg_time;
        } 
		else 
		{
                 $reg_time =1388505600;//默认2014年1月1日
        }
		$real_pay_way_arr = array( 1=>0.004,3=>0.004,18=>0.007,30=>0.02,31=>0.02,32=>0.86,33=>0.0025,35=>0.035,36=>0.035,37=>0.035 );
        $year = date( "Y",$reg_time );
        $sql="select * from 91yxq_users.91yxq_agent_reg_".$year."  where user_name='$row->user'";
        $res2=$mysqli->query( $sql );
        $row2=$res2->fetch_object();
        $user_role = $row2 ->user_role;
        $agent_id= $user->agent_id;
        $reg_game_id=$row2->game_id;
        $reg_server_id=$row2->server_id;
        $placeid = $user->place_id;
        $cplaceid = $row2->ext1;
        $adid    = $row2->adid;
        $from_url=$row2->referer_url;
        $reg_date=date( "Y-m-d H:i:s",$row2->reg_time );
        $cid = $row2->agent_id;
        $paid_amount = $row->money * $pay_way_arr[$row->pay_channel]['pay_rate'];
		if(isset($real_pay_way_arr[$row->pay_channel]))
		{
			$money_float = $row->money * $real_pay_way_arr[$row->pay_channel];
			if( $money_float<0.01 )
			{
				$money_float = 0.01;
			}
			$money_float = round($money_float,2) * -1; 
			$pure_pay_money = bcadd($row->money,$money_float,2);
		}else{
			$pure_pay_money = 0;
		}
        $mysqli->query( "INSERT INTO pay_list(orderid, user_name, pay_way_id, money, paid_amount, sync_date, pay_date, agent_id, placeid, cplaceid, adid, reg_date, game_id, reg_game_id, reg_server_id, server_id, from_url, cid, user_ip,pure_api_money) values ('".$row->orderid."','".$row->user."', '".$row->pay_channel."','".($row->money)."','$paid_amount','".date("Y-m-d H:i:s",$row->sync_date)."','".date("Y-m-d H:i:s",$row->pay_date)."','$agent_id','$placeid','$cplaceid','$adid','$reg_date','".$row->game."','".$row->game."', '".$row->server."', '".$row->server."','$from_url','$cid','".long2ip($row->user_ip)."',{$pure_pay_money})" );
}
?>