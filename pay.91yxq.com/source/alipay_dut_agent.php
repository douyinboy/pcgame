<?php
/* *
 * 功能：游戏内支付签约接口接入页
 * 版本：3.2
 * 修改日期：2011-03-25
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************注意*************************
 * 如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 * 1、商户服务中心（https://b.alipay.com/support/helperApply.htm?action=consultationApply），提交申请集成协助，我们会有专业的技术工程师主动联系您协助解决
 * 2、商户帮助中心（http://help.alipay.com/support/232511-16307/0-16307.htm?sh=Y&info_type=9）
 * 3、支付宝论坛（http://club.alipay.com/read-htm-tid-8681712.html）
 * 如果不想使用扩展功能请把扩展功能参数赋空值。
 */
/**************************请求参数**************************/

//必填参数//

//商户网站唯一签约号，代扣协议中标示玩家的唯一签约号（确保在商户系统中商户网站唯一）
$external_sign_no	= trim($row->user);

//游戏账号
$external_user_id	= trim($row->user);

//代扣项代码
$item_code			= "DEFAULT";

//协议代码
$protocol_code		= "game_charge";

/************************************************************/

//构造要请求的参数数组，无需改动
$total_fee=$row->money;
$out_trade_no = trim($row->orderid);
$sql="select id from pay_alipay  where user_name='".$row->user."' and orderid='".$out_trade_no."'";
$query=mysql_query($sql);
$queryrow=mysql_fetch_object($query);
if (!$queryrow) {
	$sql="INSERT INTO `pay_alipay`(`user_name`,`orderid`,`total_fee`,`paymethod`,`defaultbank`,`user_ip`,`game_id`,`server_id`,`b_num`,`pay_date`,`sn`,`taocan_id`) VALUES('".$row->user."','$out_trade_no','$total_fee','agent','agent','$user_ip','".$row->game."','".$row->server."','".$row->pay_gold."',now(),'$sn','$taocan_id')";
	$r=mysql_query($sql);
}

//判断是否签约用户
$query=mysql_query("SELECT id,status from `pay_dut_customer` where user_name='".trim($row->user)."'");
$queryrow=mysql_fetch_object($query);

if ( trim($queryrow->status) =='S' ) { //签约用户,直接代理扣款
     require_once(dirname(__DIR__) . "/include/alipay_lib/dut_agent/alipay.config.php");
     require_once(dirname(__DIR__) . "/include/alipay_lib/dut_agent/alipay_service.class.php");
	 /**************************请求参数**************************/
	//必填参数//
	//商户订单号，需保证唯一性
	$out_order_no		= $out_trade_no;
	//商户网站唯一签约号，对应游戏内支付签约接口(dut.customer.sign)请求参数external_sign_no
	//$external_sign_no
	//商户产品名称
	$item_name			= '游戏币';
	//买家的商户网站账号 
	//$external_user_id 	= $_POST['external_user_id'];
	//商品名称
	$subject			= '游戏币';
	//付款金额
	$price				= $total_fee;
	//代扣项代码
	$item_code			= "DEFAULT";
	//协议代码
	$protocol_code		= "game_charge";
	/************************************************************/
	//构造要请求的参数数组，无需改动
	$parameter = array(
			"service"			=> "dut.agent",
			"partner"			=> trim($alipay_config['partner']),
			"notify_url"		=> trim($alipay_config['notify_url']),
			"out_order_no"		=> $out_order_no,
			"external_sign_no"	=> $external_sign_no,
			"item_name"			=> $item_name,
			"external_user_id"	=> $external_user_id,
			"subject"			=> $subject,
			"price"				=> $price,
			"item_code"			=> $item_code,
			"protocol_code"		=> $protocol_code,
			"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
	);
	//print_r($parameter);die;
	//构造通用代扣付款接口
	$alipayService = new AlipayService($alipay_config);
	$doc = $alipayService->dut_agent($parameter);
	
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	
	//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
	
	//解析XML
	$response = '';
	if( ! empty($doc->getElementsByTagName( "response" )->item(0)->nodeValue) ) {
		$response= $doc->getElementsByTagName( "response" )->item(0)->nodeValue;
	}
	else {
		$response= $doc->getElementsByTagName( "error" )->item(0)->nodeValue;
	}
	//echo $response;
// 	$sHtml = "<form id='order' name='order' action='"."http://pay.91wan.com/loading.php' method='get'>";
// 	$sHtml.= "<input type='hidden' name='type' value='1'/>";
// 	$sHtml.= "<input type='hidden' name='orderid' value='".$out_trade_no."'/>";
//     $sHtml = $sHtml."<input type='submit' value='提交'></form>";
// 	$sHtml = $sHtml."<script>document.forms['order'].submit();</script>";
	
	$sHtml = "<script language='javascript'>location.href='http://pay.91yxq.com/pay_to_show.php?orderid=$out_trade_no';</script>";
	
	$html_text = $sHtml;
	
	
	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
} else {
    require_once(dirname(__DIR__) . "/include/alipay_lib/dut_customer_sign/alipay.config.php");
    require_once(dirname(__DIR__) . "/include/alipay_lib/dut_customer_sign/alipay_service.class.php");
	$resq = mysql_query("select id from `pay_dut_customer` where user_name='".$external_sign_no."'");
	$rowq = mysql_fetch_object($resq);

	if ( $rowq->id >0 ) {
		$sql = "UPDATE `pay_dut_customer` SET `external_orderid`='".$out_trade_no."' WHERE user_name='".$external_sign_no."'";
	     mysql_query($sql);
	} else {
		$sql = "INSERT INTO `pay_dut_customer`(`user_name`,`external_orderid`) VALUES('".trim($external_sign_no)."','".$out_trade_no."')";
	     mysql_query($sql);
	}
		
	$parameters = array(
			"service"			=> "dut.customer.sign",
			"partner"			=> trim($alipay_config['partner']),
			"_input_charset"    => "utf-8",
			"notify_url"		=> trim($alipay_config['notify_url']),
			"return_url"		=> trim($alipay_config['return_url']),
			"item_code"			=> $item_code,
			"external_user_id"	=> $external_user_id,
			"protocol_code"		=> $protocol_code,
			"external_sign_no"	=> $external_sign_no,
			"is_new_page"       => "true"
	);
	asort($parameters);
	$i =0;
	foreach ($parameters as $key => $val) {
			 if ( $i==0 ) {
				  $sing_str .= $key."=".$val;
			 } else {
				  $sing_str .= "&".$key."=".$val;
			 }
			 $i++;
	}
	$sign = md5($sing_str);
	$parameter = array(
			"service"			=> "dut.customer.sign",
			"partner"			=> trim($alipay_config['partner']),
			"sign"			    => $sign,
			"sign_type"         => "MD5",
			"_input_charset"    => "utf-8",
			"notify_url"		=> trim($alipay_config['notify_url']),
			"return_url"		=> trim($alipay_config['return_url']),
			"item_code"			=> $item_code,
			"external_user_id"	=> $external_user_id,
			"protocol_code"		=> $protocol_code,
			"external_sign_no"	=> $external_sign_no,
			"is_new_page"       => "true"
	);
	//构造游戏内支付签约接口
	$alipayService = new AlipayService($alipay_config);
	$html_text = $alipayService->dut_customer_sign($parameter);
}
?>