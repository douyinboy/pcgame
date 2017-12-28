<?php
//汇付宝通知脚本  联系人 ：  李胤昆 QQ903750249
! $_POST && exit(header('location:http://pay.91yxq.com'));
$_POST['return_msg'] && exit(header('location:http://pay.91yxq.com'));
$user_ip = $_SERVER["HTTP_CDN_SRC_IP"];
  if (!$user_ip) {
      $user_ip = $_SERVER['REMOTE_ADDR'];
  }

$fhandle=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/jct_notify.log","a");
fwrite($fhandle,date("Y-m-d H:i:s")."	".$user_ip."	".$_SERVER["REQUEST_URI"]. "      " . http_build_query($_POST) . "\r\n");
fclose($fhandle);

require_once("../include/config.inc.php");
require_once("../include/pay_funcs.php");
$sign = $_POST['sign'];
unset($_POST['sign']);
$post = array_filter($_POST);
ksort($post);
$match_sign = strtoupper(md5(http_build_query($post) . '&key=0ty8S61se5KlF3aOOKHOjRo0J3SnkRiIwTRADruQV4mX7CWPKzh8T6LGryo6Hdeu'));
$sign !== $match_sign && exit(header('location:http://pay.91yxq.com'));
$orderid = $post['out_trade_no'];
$order_arr = mysql_fetch_array(mysql_query("select money,paid_amount,pay_gold from pay_orders where orderid='{$orderid}'"));
if ($post['total_fee'] < bcmul($order_arr[0], 100)) {
	$rate = bcdiv($order_arr[2], $order_arr[1]);
	$real_money = bcdiv($post['total_fee'], 100, 2);
	$new_paid_amount = bcmul($real_money, 0.98, 2);
	$order_arr = array('money' => $real_money, 'paid_amount' => $new_paid_amount);
	$new_pay_gold = bcmul($new_paid_amount, $rate);
	mysql_query("UPDATE pay_orders SET money={$real_money},paid_amount={$new_paid_amount},pay_gold={$new_pay_gold} where orderid='{$orderid}'");
}
if($post['return_code'] == 'SUCCESS' && $post['trade_state'] == 1){
	$sql="select id,b_flag from pay_jct where orderid='{$orderid}'";
	$res=mysql_query($sql);
	$row=mysql_fetch_object($res);
	if ( $row->b_flag) {
		 header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$orderid);exit;
	}
	if($row){
		mysql_query("UPDATE 91yxq_recharge.pay_orders SET sync_date=".time().",succ=1 WHERE orderid='{$orderid}'");
		mysql_query("update 91yxq_recharge.pay_jct SET succ=1,merchantId='{$post['merchantId']}',payTendOrderId='{$post['payTendOrderId']}',b_flag=1,sync_date=" . time() . " where orderid='{$orderid}'");
		if (!$row->b_flag) {
			pay_gameb("pay_jct",$row->id,$orderid);
		}
	}else{
		mysql_query("UPDATE 91yxq_recharge.pay_orders SET sync_date=".time().",succ=1 WHERE orderid='{$orderid}'");
		mysql_query("INSERT INTO 91yxq_recharge.pay_jct (orderid,merchantId,payTendOrderId,money,paid_amount,succ,pay_date,sync_date) VALUES ('{$orderid}','{$post['merchantId']}','{$post['payTendOrderId']}',{$order_arr['money']},{$order_arr['paid_amount']},1,".time().",".time().")");
	}
	exit(json_encode(array('return_code' => 'SUCCESS', 'return_msg' => '')));
}else{
	echo 'error';
	header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$orderid);exit;
}
?>