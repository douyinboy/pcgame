<?php
$fhandle=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/QQmobile_notify.log","a");
fwrite($fhandle,date("Y-m-d H:i:s")."	".$_SERVER["HTTP_CDN_SRC_IP"]."	".$_SERVER["REQUEST_URI"]."\r\n");
fclose($fhandle);

require_once("../include/config.inc.php");
require_once("../include/pay_funcs.php");

$sign = $_REQUEST['sign'];
$customerid = $_REQUEST['customerid'];
$sd51no = $_REQUEST['sd51no'];
$sdcustomno = $_REQUEST['sdcustomno'];
$mark = $_REQUEST['mark'];
$key = 'ff34636b0d912bb5ff45fb4482513f45';
$sign_one = strtoupper(md5('customerid='.$customerid.'&sd51no='.$sd51no.'&sdcustomno='.$sdcustomno.'&mark='.$mark.'&key='.$key));
if($sign != $sign_one){
	echo "签名1不正确";
	exit;
}
$resign = $_REQUEST['resign'];
$ordermoney = $_REQUEST['ordermoney'];
$state = $_REQUEST['state'];
$sign_two = strtoupper(md5('sign='.$sign_one.'&customerid='.$customerid.'&ordermoney='.$ordermoney.'&sd51no='.$sd51no.'&state='.$state.'&key='.$key));
if($resign != $sign_two){
	echo "签名2不正确";
	exit;
}
$realmoney = $ordermoney*0.98;
if($state == '1'){
	echo "<result>1</result>";
	$succ=1;
	$sql="select id,b_flag from pay_QQmobile where orderid='{$sdcustomno}'";
	$res=mysql_query($sql);
	$row=mysql_fetch_object($res);
	if ( $row->b_flag) {
		 header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$sdcustomno);exit;
	}
	if ($row) {
		mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='{$sdcustomno}'");
		$sql="update pay_QQmobile set sd51no='{$sd51no}',b_flag=1,sync_date=now(),succ=1 where orderid='{$sdcustomno}'";
		mysql_query($sql);
		if (!$row->b_flag) {
			pay_gameb("pay_QQmobile",$row->id,$sdcustomno);
		}
	}else {
		mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='{$sdcustomno}'");
		$sql="insert into pay_QQmobile (customerid,sd51no,orderid,ordermoney,realmoney,pay_date) values(
			'{$customerid}','{$sd51no}','{$sdcustomno}',{$ordermoney},{$realmoney},now())";
		mysql_query($sql);	
	}
}else{
	echo "<result>0</result>";
	header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$sdcustomno);exit;
}
	header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$sdcustomno);exit;


?>