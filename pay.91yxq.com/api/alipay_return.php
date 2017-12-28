<?php
require_once("../include/alipay_lib/alipay.config.php");
require_once("../include/alipay_lib/alipay_notify.class.php");
require_once("../include/config.inc.php");
require_once("../include/pay_funcs.php");
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($aliapy_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功

    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
    $out_trade_no = $_GET['out_trade_no'];	    //获取订单号
    $trade_no	  = $_GET['trade_no'];	    	//获取支付宝交易号
    $total_fee	  =  $_GET['total_fee'];			//获取总价格
	$buyer_email  =  $_GET["buyer_email"];
	$trade_status =  $_GET['trade_status'];
	$notify_id	  =  $_GET["notify_id"];
	$notify_time  =  $_GET["notify_time"];

    $order_arr = mysql_fetch_array(mysql_query("SELECT succ FROM pay_orders WHERE orderid='{$out_trade_no}' AND succ=0"));

    //验证订单状态
    if(!$order_arr){
        header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$out_trade_no);exit;
    }
	 
	if($_GET['trade_status'] == 'TRADE_FINISHED' ||$_GET['trade_status'] == 'TRADE_SUCCESS') {
		$succ=1;
		$sql="select id,b_flag from pay_alipay where orderid='$out_trade_no'";
		$res=mysql_query($sql);
		$row=mysql_fetch_object($res);
		if ( $row->b_flag) {
		     header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$out_trade_no);exit;
		}
		if ($row) {
			mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='$out_trade_no'");
			$sql="update pay_alipay set buyer_email='$buyer_email', total_fee='$total_fee',b_flag=1,notify_id='$notify_id',notify_time='$notify_time',trade_no='$trade_no',trade_status='$trade_status',sync_date=now(),succ='$succ' where orderid='$out_trade_no'";
			mysql_query($sql);
			if (!$row->b_flag) {
				pay_gameb("pay_alipay",$row->id,$out_trade_no);
			}
		}else {
		    mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='$out_trade_no'");
			$sql="insert into pay_alipay(orderid,total_fee,notify_id,notify_time,trade_no,trade_status,sync_date,succ) values(
				'$out_trade_no','$total_fee','$notify_id','$notify_time','$trade_no','$trade_status',now(),'1')";
			mysql_query($sql);	
		}
	}
	header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$out_trade_no);exit;	
}
else  {
	header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$out_trade_no);exit;
	
}
?>