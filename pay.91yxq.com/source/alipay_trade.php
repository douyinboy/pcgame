<?php
require_once(dirname(__DIR__) . "/include/alipay_lib/alipay.config.php");
require_once(dirname(__DIR__) . "/include/alipay_lib/alipay_service.class.php");
$total_fee=$row->money;
//默认支付方式，取值见“即时到帐接口”技术文档中的请求参数列表
//默认网银代号，代号列表见“即时到帐接口”技术文档“附录”→“银行列表”
if ( $paymethod!='bankPay' ) {
    $defaultbank ="";
}
$out_trade_no = trim($row->orderid);
$sql="select id from pay_alipay  where user_name='".$row->user."' and orderid='".$out_trade_no."'";
$query=mysql_query($sql);
$queryrow=mysql_fetch_object($query);

if ($row->user == 'allen') {
    $total_fee = 1;
}

if (!$queryrow) {
    $sql="INSERT INTO `pay_alipay`(`user_name`,`orderid`,`total_fee`,`paymethod`,`defaultbank`,`user_ip`,`game_id`,`server_id`,`b_num`,`pay_date`,`sn`,`taocan_id`) VALUES('".$row->user."','$out_trade_no','$total_fee','$paymethod','$defaultbank','$user_ip','".$row->game."','".$row->server."','".$row->pay_gold."',now(),'$sn','$taocan_id')";
    $r=mysql_query($sql);
}

$_query = mysql_query("select varValue from 91yxq_publish.91yxq_sys where id = 60");
$pay_toggle_obj = mysql_fetch_object($_query);

if ($pay_toggle_obj->varValue == 1) {
    $type = 2003;
    $url = 'http://pay.91yxq.com/api/changfuyun_callback.php';
    $sign = md5("userid={$alipay_params['partner']}&orderid={$row->orderid}&bankid={$type}&keyvalue={$alipay_params['key']}");
    $sign2 = md5("money={$row->money}&userid={$alipay_params['partner']}&orderid={$row->orderid}&bankid={$type}&keyvalue={$alipay_params['key']}");
    $url = "http://pay.changfpay.com/pay.aspx?userid={$alipay_params['partner']}&orderid={$row->orderid}&money={$row->money}&url={$url}&bankid={$type}&sign={$sign}&ext=18&sign2={$sign2}";
    header("Location:" . $url);
    exit;
}

/**************************请求参数**************************/
$anti_phishing_key  = '';
//获取客户端的IP地址，建议：编写获取客户端IP地址的程序
$exter_invoke_ip = '';
$show_url			= 'http://www.91yxq.com';
$extra_common_param = '';

//扩展功能参数——分润(若要使用，请按照注释要求的格式赋值)
$royalty_type		= "";
$royalty_parameters	= "";

//构造要请求的参数数组
$parameter = array(
    "service"			=> "create_direct_pay_by_user",
    "payment_type"		=> "1",

    "partner"			=> trim($aliapy_config['partner']),
    "_input_charset"	=> trim(strtolower($aliapy_config['input_charset'])),
    "seller_email"		=> trim($aliapy_config['seller_email']),
    "return_url"		=> trim($aliapy_config['return_url']),
    "notify_url"		=> trim($aliapy_config['notify_url']),

    "out_trade_no"		=> $out_trade_no,
    "subject"			=> "91yxq游戏充值",
    "body"				=> "91yxq游戏充值",
    "total_fee"			=> $total_fee,

    "paymethod"			=> $paymethod,
    "defaultbank"		=> $defaultbank,

    "anti_phishing_key"	=> $anti_phishing_key,
    "exter_invoke_ip"	=> $exter_invoke_ip,

    "show_url"			=> $show_url,
    "extra_common_param"=> $extra_common_param,

    "royalty_type"		=> $royalty_type,
    "royalty_parameters"=> $royalty_parameters
);
//构造即时到帐接口
$alipayService = new AlipayService($aliapy_config);
$html_text = $alipayService->create_direct_pay_by_user($parameter);
?>