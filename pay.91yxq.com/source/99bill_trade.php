<?php
// ======================= 传送参数设置  开始  =====================================
//* 表示 必填写项目.  ( )里的表示字符长度
$kq_target         = "https://www.99bill.com/gateway/recvMerchantInfoAction.htm";
$kq_merchantAcctId = "1002315094001";  //*  商家用户编号		(30)
$kq_inputCharset   = "1";	//   1 ->  UTF-8		2 -> GBK		3 -> GB2312   default: 1	(2)
$kq_pageUrl	   = "";	//   直接跳转页面	(256)
$kq_bgUrl	   = "http://pay.91yxq.com/api/sync_99bill.php";	//   后台传送页面	(256)
$kq_version	   = "v2.0";	//*	 版本  固定值 v2.0	(10)
$kq_language	   = "1";	//*  默认 1 ， 显示 汉语	(2)
$kq_signType	   = "4";   //*  固定值 1 表示 MD5 加密方式 , 4 表示 PKI 证书签名方式	(2)
$kq_payerName	   = "";	//   英文或者中文字符	(32)
$kq_payerContactType = "1";  //  支付人联系类型  固定值： 1  代表电子邮件方式 (2)
$kq_payerContact   = "qiquwangluo@qq.com";	//	 支付人联系方式	(50)
$kq_orderId=trim($row->orderid); //*  字母数字或者, _ , - ,  并且字母数字开头 并且在自身交易中式唯一	(50)
	
$kq_orderAmount	= $row->money * 100;	//*	  字符金额 以 分为单位 比如 10 元， 应写成 1000	(10)
$kq_orderTime		= date('YmdHis');  //*  交易时间  格式: 20110805110533
$kq_productName	= "91yxq游戏充值";	//	  商品名称英文或者中文字符串(256)
$kq_productNum		= "1";	//	  商品数量	(8)
$kq_productId		= "";   //    商品代码，可以是 字母,数字,-,_   (20) 
$kq_productDesc	= "91yxq游戏充值";	//	  商品描述， 英文或者中文字符串  (400)
$kq_ext1			= "";   //	  扩展字段， 英文或者中文字符串，支付完成后，按照原样返回给商户。 (128)
$kq_ext2			= "";
if ( $paymethod=='bankPay' ) {
$kq_payType		= "10";
} else {
$kq_payType		= "00";
}
$kq_bankId		= strtoupper($defaultbank);  // 银行代码 银行代码 要在开通银行时 使用， 默认不开通 (8)
$kq_redoFlag		= "1";   // 同一订单禁止重复提交标志  固定值 1 、 0       
$kq_pid			= "";   //  合作伙伴在快钱的用户编号 (30)
// ======================= 传送参数设置  结束  =====================================
// ======================= 快钱 封装代码 ! ! 勿随便更改 开始  =====================================
function kq_ck_null($kq_va,$kq_na){if($kq_va == ""){$kq_va="";}else{return $kq_va=$kq_na.'='.$kq_va.'&';}}

	$kq_all_para=kq_ck_null($kq_inputCharset,'inputCharset');
	$kq_all_para.=kq_ck_null($kq_pageUrl,"pageUrl");
	$kq_all_para.=kq_ck_null($kq_bgUrl,'bgUrl');
	$kq_all_para.=kq_ck_null($kq_version,'version');
	$kq_all_para.=kq_ck_null($kq_language,'language');
	$kq_all_para.=kq_ck_null($kq_signType,'signType');
	$kq_all_para.=kq_ck_null($kq_merchantAcctId,'merchantAcctId');
	$kq_all_para.=kq_ck_null($kq_payerName,'payerName');
	$kq_all_para.=kq_ck_null($kq_payerContactType,'payerContactType');
	$kq_all_para.=kq_ck_null($kq_payerContact,'payerContact');
	$kq_all_para.=kq_ck_null($kq_orderId,'orderId');
	$kq_all_para.=kq_ck_null($kq_orderAmount,'orderAmount');
	$kq_all_para.=kq_ck_null($kq_orderTime,'orderTime');
	$kq_all_para.=kq_ck_null($kq_productName,'productName');
	$kq_all_para.=kq_ck_null($kq_productNum,'productNum');
	$kq_all_para.=kq_ck_null($kq_productId,'productId');
	$kq_all_para.=kq_ck_null($kq_productDesc,'productDesc');
	$kq_all_para.=kq_ck_null($kq_ext1,'ext1');
	$kq_all_para.=kq_ck_null($kq_ext2,'ext2');
	$kq_all_para.=kq_ck_null($kq_payType,'payType');
	$kq_all_para.=kq_ck_null($kq_bankId,'bankId');
	$kq_all_para.=kq_ck_null($kq_redoFlag,'redoFlag');
	$kq_all_para.=kq_ck_null($kq_pid,'pid');

        $kq_all_para=rtrim($kq_all_para,'&');

	$priv_key = file_get_contents("./include/hd/99bill-rsa.pem"); //私钥

	$pkeyid = openssl_get_privatekey($priv_key);

	// compute signature
	openssl_sign($kq_all_para, $signMsg, $pkeyid,OPENSSL_ALGO_SHA1);

	// free the key from memory
	openssl_free_key($pkeyid);

	$kq_sign_msg = base64_encode($signMsg);
    $kq_get_url=$kq_target.'?'.$kq_all_para.'&signMsg='.$kq_sign_msg;
// ======================= 快钱 封装代码 ! ! 勿随便更改 结束  =====================================
$sql="select id from pay_99bill  where user_name='".$row->user."' and orderid='$kq_orderId'";
$query=mysql_query($sql);
$queryrow=mysql_fetch_object($query);
if (!$queryrow) {
	$sql="INSERT INTO `pay_99bill`(`payerName`,`orderid`,`orderAmount`,`orderTime`,`payAmount`,`user_ip`,`game_id`,`server_id`,`b_num`,`user_name`,`pay_date`,`bankId`,`signMsg`,`taocan_id`,`pay_type`) values('".$row->user."','$kq_orderId','$kq_orderAmount','$kq_orderTime','$kq_orderAmount','$user_ip','".$row->game."','".$row->server."','".$row->pay_gold."','".$row->user."',now(),'$bankId','$kq_sign_msg','$tid','$pay_type')";
	$r=mysql_query($sql);
	if (!$r) {
		$f=fopen("/www/weblog/mysql_err.log","a");
		if ($f) {
			fputs($f,date("Y-m-d H:i:s")."	".$sql."	".mysql_error()."\n");
			fclose($f);
		}
	}
}
?>