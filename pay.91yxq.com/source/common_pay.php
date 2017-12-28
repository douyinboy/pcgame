<?php
require_once(dirname(__DIR__) . "/include/alipay_lib/alipay.config.php");
require_once(dirname(__DIR__) . "/include/alipay_lib/alipay_service.class.php");
$out_trade_no = $_POST['out_trade_no'];
$total_fee = $_POST['total_fee'];
$bank_type = $_POST['bank_type'];

$url = 'http://pay.91yxq.com/api/changfuyun_callback.php';
$sign = md5("userid={$alipay_params['partner']}&orderid={$out_trade_no}&bankid={$bank_type}&keyvalue={$alipay_params['key']}");
$sign2 = md5("money={$total_fee}&userid={$alipay_params['partner']}&orderid={$out_trade_no}&bankid={$bank_type}&keyvalue={$alipay_params['key']}");
$url = "http://pay.changfpay.com/pay.aspx?userid={$alipay_params['partner']}&orderid={$out_trade_no}&money={$total_fee}&url={$url}&bankid={$bank_type}&sign={$sign}&ext=33&sign2={$sign2}";
header("Location:" . $url);
exit;

?>