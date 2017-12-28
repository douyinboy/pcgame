<?php
//星启天充值卡业务支付通知脚本
$user_ip = $_SERVER["HTTP_CDN_SRC_IP"];
  if (!$user_ip) {
      $user_ip = $_SERVER['REMOTE_ADDR'];
  }

$fhandle=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/xqt_notify.log","a");
fwrite($fhandle,date("Y-m-d H:i:s")."	".$user_ip."	".$_SERVER["REQUEST_URI"]."\r\n");
fclose($fhandle);

require_once("../include/config.inc.php");
require_once("../include/pay_funcs.php");

$sign = $_REQUEST['sign'];
$customerid = $_REQUEST['customerid'];
$sd51no = $_REQUEST['sd51no'];
$sdcustomno = $_REQUEST['sdcustomno'];
$ordermoney = $_REQUEST['ordermoney'];
$cardno = $_REQUEST['cardno'];
$mark = $_REQUEST['mark'];
$des = $_REQUEST['des'];
$key = 'ff34636b0d912bb5ff45fb4482513f45';
$sign_one = strtoupper(md5('customerid='.$customerid.'&sd51no='.$sd51no.'&sdcustomno='.$sdcustomno.'&mark='.$mark.'&key='.$key));
if($sign != $sign_one){
	echo "签名1不正确";
	exit;
}
//充值卡的比率  因为光芒传奇接口的特殊性 多了一部分预处理
$pay_channel_list = array(32=>'0.84',33=>'1',34=>'0.99',35=>'0.95',36=>'0.95',37=>'0.95',38=>'0.95',39=>'0.95',40=>'0.95',41=>'0.86',42=>'0.88',43=>'0.88',44=>'0.82');
$state = $_REQUEST['state'];

if($state == '1'){
	echo "<result>1</result>";
	mysql_query("UPDATE pay_xqt SET realmoney={$ordermoney} WHERE orderid ='{$sdcustomno}'");
	$order_money = mysql_fetch_assoc(mysql_query("SELECT money,paid_amount,pay_gold,game,pay_channel FROM pay_orders WHERE orderid='{$sdcustomno}'"));
	if($ordermoney != $order_money['money']){
		$order_money['pay_gold'] += 0;
		$order_money['paid_amount'] += 0;
		$rate = $order_money['pay_gold'] / $order_money['paid_amount'];//RMB与元宝的比率
		$paid_amount = $pay_channel_list[$order_money['pay_channel']] *$ordermoney;
		if($order_money['game']==27){
			$paid_amount = intval($paid_amount);
		}
		$pay_gold = $paid_amount*$rate;
		mysql_query("UPDATE pay_orders SET money={$ordermoney},paid_amount={$paid_amount},pay_gold={$pay_gold} WHERE orderid='{$sdcustomno}'");
	}
	$succ=1;
	$sql="select id,b_flag from pay_xqt where orderid='{$sdcustomno}'";
	$res=mysql_query($sql);
	$row=mysql_fetch_object($res);
	if ( $row->b_flag) {
		 header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$sdcustomno);exit;
	}
	if ($row) {
		mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='{$sdcustomno}'");
		$sql="update pay_xqt set sd51no='{$sd51no}',b_flag=1,sync_date=now(),succ=1 where orderid='{$sdcustomno}'";
		mysql_query($sql);
		if (!$row->b_flag) {
			//pay_gameb("pay_xqt",$row->id,$sdcustomno);
		}
	}else {
		mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='{$sdcustomno}'");
		$sql="insert into pay_xqt (customerid,sd51no,orderid,ordermoney,pay_date) values(
			'{$customerid}','{$sd51no}','{$sdcustomno}',{$ordermoney},now())";
		mysql_query($sql);	
	}
	
}else{
	echo "<result>0</result>";
	header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$sdcustomno);exit;
}
	header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$sdcustomno);exit;


?>