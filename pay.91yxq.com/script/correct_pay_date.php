<?php
include_once(dirname(__DIR__) . "/include/config.inc.php");

$pdate = date("Y-m-d",strtotime("-15 day"));
$pdate_e = date("Y-m-d");
$sql="select id,orderid,pay_way_id from pay_list where pay_date='0000-00-00 00:00:00'";
$res=mysql_query($sql);
while ($row=mysql_fetch_object($res)) {
	   $pay_way_id = $row->pay_way_id;
	   $sql = "SELECT table_name,orderid FROM `pay_channel` where id=".$pay_way_id;
	   $res1 =mysql_query($sql);
	   $row1 =mysql_fetch_object($res1);
	   $table_name = trim( $row1->table_name );
	   $orderid = trim( $row1->orderid );
	   $sql = "SELECT pay_date,sync_date from $table_name where $orderid='".$row->orderid."'";
	   $res1 =mysql_query($sql);
	   $row1 =mysql_fetch_object($res1);
	   if ( $row->id > 0 ) {
	   mysql_query("UPDATE pay_list SET pay_date='".$row1->pay_date."',sync_date='".$row1->sync_date."' WHERE id=".$row->id." and orderid='".$row->orderid."'");
	   }
}

$sql="select id,orderid,sync_date from pay_list where pay_date>='$pdate 00:00:00' and pay_date<='$pdate_e 23:59:59' and DATE_FORMAT(pay_date,'%Y-%m-%d')<>DATE_FORMAT(sync_date,'%Y-%m-%d')";
$res=mysql_query($sql);
while ($row=mysql_fetch_object($res)) {
	   $pay_date = $row->sync_date;
	   mysql_query("UPDATE pay_list SET pay_date='".$pay_date."' WHERE id=".$row->id ." and orderid='".$row->orderid."'");
}
?>