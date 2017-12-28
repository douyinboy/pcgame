<?php
include_once(dirname(__DIR__) . "/include/config.inc.php");
include_once(dirname(__DIR__) . "/include/funcs.php");






$pay_date_s = date("Y-m-d",strtotime("-7 day"));
$pay_date_e = date("Y-m-d");

$filter=" where pay_date >= ".strtotime($pay_date_s ."00:00:00")." and pay_date <= ".strtotime($pay_date_e ."23:59:59")." and succ=1 ";
$sql="select * from `pay_orders` $filter";
$res=mysql_query($sql);
while ($row=mysql_fetch_object($res)) {
	
	$sql="select orderid,id from pay_list where orderid='".$row->orderid."' limit 1";
	$res2=mysql_query($sql);
	$row2=mysql_fetch_object($res2);
	if ( $row2->id>0 ) {
	     continue;
	}
	
	$sql="select * from pay_list where user_name='$row->user' limit 1";
	$res2=mysql_query($sql);
	$row2=mysql_fetch_object($res2);
	if ($row2) {
		$agent_id=$row2->agent_id;
		$placeid = $row2->placeid;
		$cplaceid = $row2->cplaceid;
		$adid = $row2->adid;
		$from_url=$row2->from_url;
		$reg_date=$row2->reg_date;
		$cid = $row2->cid;
	} else {
	    $user_tab = usertab($row->user);
		$res2=mysql_query("SELECT reg_time FROM $user_tab WHERE user_name='".$row->user."'",$conn_log);
		$row2=mysql_fetch_object($res2);
		if ( $row2->reg_time >0) {
			 $reg_time = $row2->reg_time;
		} else {
			 $reg_time =1356969600;//默认2011
		}
		$year = date("Y",$reg_time);
		$sql="select * from `91yxq_agent_reg_".$year."`  where user_name='$row->user'";
		$res2=mysql_query($sql,$conn_log);
		$row2=mysql_fetch_object($res2);
		$agent_id= $row2->agent_id;
		$placeid = $row2->placeid;
		$cplaceid = $row2->ext1;
		$adid    = $row2->adid;
		$from_url=$row2->referer_url;
		$reg_date=date("Y-m-d H:i:s",$row2->reg_time);
		$cid = $row2->agent_id;
		$flag = true;
	}
	
	$paid_amount = $row->money * $pay_way_arr[$row->pay_channel]['pay_rate'];
	$sql="insert into pay_list (orderid,user_name,pay_way_id,money,paid_amount,sync_date,pay_date,agent_id,placeid,cplaceid,adid,reg_date,game_id,server_id,from_url,cid,user_ip) values ('".$row->orderid."','".$row->user."','".$row->pay_channel."','".($row->money)."','$paid_amount','".date("Y-m-d H:i:s",$row->sync_date)."','".date("Y-m-d H:i:s",$row->pay_date)."','$agent_id','$placeid','$cplaceid','$adid','$reg_date','".$row->game."','".$row->server."','$from_url','$cid','".long2ip($row->user_ip)."')";
	mysql_query($sql);
	
}

//归类渠道数据表
include(dirname(__DIR__) . "/include/dbconn_9.php");
$sql = "SELECT id,agent_id,placeid FROM `pay_list` WHERE pay_date>='".date('Y-m-d')." 00:00:00' AND pay_date<='".date('Y-m-d')." 23:59:59' AND cid>1000";
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
?>
