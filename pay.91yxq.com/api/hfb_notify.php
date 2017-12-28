<?php
//汇付宝通知脚本  联系人 ：  李胤昆 QQ903750249
$user_ip = $_SERVER["HTTP_CDN_SRC_IP"];
  if (!$user_ip) {
      $user_ip = $_SERVER['REMOTE_ADDR'];
  }

$fhandle=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/hfb_notify.log","a");
fwrite($fhandle,date("Y-m-d H:i:s")."	".$user_ip."	".$_SERVER["REQUEST_URI"]."\r\n");
fclose($fhandle);

require_once("../include/config.inc.php");
require_once("../include/pay_funcs.php");

$result = $_REQUEST['result'];
$pay_message = $_REQUEST['pay_message'];
$agent_id = $_REQUEST['agent_id'];
$jnet_bill_no = $_REQUEST['jnet_bill_no'];
$orderid = $_REQUEST['agent_bill_id'];
$pay_type = $_REQUEST['pay_type'];
$pay_amt = $_REQUEST['pay_amt'];
$remark = iconv('gb2312','utf-8',urldecode($_REQUEST['remark']));
$sign = $_REQUEST['sign'];

if($sign!=md5("result={$result}&agent_id={$agent_id}&jnet_bill_no={$jnet_bill_no}&agent_bill_id={$orderid}&pay_type={$pay_type}&pay_amt={$pay_amt}&remark={$remark}&key=9F042D5FA97E4E8F89F77FDB")){
	exit('error');
}
$order_arr = mysql_fetch_row(mysql_query("select money,paid_amount,pay_gold from pay_orders where orderid='{$orderid}'"));
if($pay_amt<$order_arr[0]){
	$byte = round($pay_amt / $order_arr[0],2);
	$new_paid_amount = $order_arr[1] * $byte;
	$times = $order_arr[2] / $order_arr[1];
	$new_pay_gold = $new_paid_amount * $times;
	mysql_query("UPDATE pay_orders SET money={$pay_amt},paid_amount={$new_paid_amount},pay_gold={$new_pay_gold} where orderid='{$orderid}'");
}
if($result==1){
	$sql="select id,b_flag from pay_hfb where orderid='{$orderid}'";
	$res=mysql_query($sql);
	$row=mysql_fetch_object($res);
	if ( $row->b_flag) {
		 header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$orderid);exit;
	}
	if($row){
		mysql_query("UPDATE 91yxq_recharge.pay_orders SET sync_date=".time().",succ=1 WHERE orderid='{$orderid}'");
		mysql_query("update 91yxq_recharge.pay_hfb SET result=1,jnet_bill_no='{$jnet_bill_no}',b_flag=1,sync_date=now(),succ=1 where orderid='{$orderid}'");
		if (!$row->b_flag) {
			pay_gameb("pay_hfb",$row->id,$orderid);
		}
	}else{
		mysql_query("UPDATE 91yxq_recharge.pay_orders SET sync_date=".time().",succ=1 WHERE orderid='{$orderid}'");
		mysql_query("INSERT INTO 91yxq_recharge.pay_hfb (result,agent_id,jnet_bill_no,orderid,pay_type,pay_amt,pay_date) VALUES (1,{$agent_id},'{$jnet_bill_no}','{$orderid}',{$pay_type},{$pay_amt},now())");
	}
	echo 'ok';
}else{
	echo 'error';
	header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$orderid);exit;
}
?>