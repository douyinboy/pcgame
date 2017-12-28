<?php
include_once(dirname(__DIR__) . "/include/dbconn_4.php");
include_once(dirname(__DIR__) . "/include/config.inc.php");
include_once(dirname(__DIR__) . "/config/pay_way.inc.php");

$d1 = date("Y-m-d",strtotime(date("Y-m-d")) - 86400*8);
$filter=" where pay_date>='".$d1." 00:00:00' and stat=1 ";
$sql="SELECT * FROM  `pay_artificial` $filter ";
$res=mysql_query($sql);
while ($row=mysql_fetch_object($res)) {

	$sql="select * from pay_list where user_name='$row->user_name' limit 1";
	$res2=mysql_query($sql,$conn);
	$row2=mysql_fetch_object($res2);
	if ($row2) {
		$agent_id=$row2->agent_id;
		$adid=$row2->adid;
		$placeid=$row2->placeid;
		$cplaceid = $row2->cplaceid;
		$from_url=$row2->from_url;
		$reg_date=$row2->reg_date;
		$cid = $row2->cid;
	} else {
	    $user_tab = usertab($row->user_name);
		$res2=mysql_query("SELECT reg_time FROM $user_tab WHERE user_name='".$row->user_name."'",$conn_log);
		$row2=mysql_fetch_object($res2);
		if ( $row2->reg_time >0) {
			 $reg_time = $row2->reg_time;
		} else {
			 $reg_time =1293883200;//默认2011
		}
		$year = date("Y",$reg_time);
		$sql="select * from `91yxq_agent_reg_".$year."`  where user_name='$row->user_name'";
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

	$money=$row->money;
	$paid_amount = $row->money * $pay_way_arr[11]['pay_rate'];
	$sql = "select id from pay_list where orderid='".$row->orderid."'";
	$res1  = mysql_query($sql,$conn);
	$row1 = mysql_fetch_object($res1);
	if ($row1 -> id>0) {
	} else {
	  $sql="insert into pay_list (orderid,user_name,pay_way_id,money,paid_amount,sync_date,pay_date,agent_id,placeid,cplaceid,adid,reg_date,game_id,server_id,from_url,cid) values ('$row->orderid','$row->user_name','11','$money','$paid_amount','$row->pay_date ".date("H:i:s")."','$row->pay_date ".date("H:i:s")."','$agent_id','$placeid','$cplaceid','$adid','$reg_date','$row->game_id','$row->server_id','$from_url','$cid')";
	   mysql_query($sql,$conn);	
	}
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
