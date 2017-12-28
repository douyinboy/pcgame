<?php
//功能函数。将变量值不为空参数组成字符串
$fhandle=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/sync_tele_unicom.log","a");
fwrite($fhandle,date("Y-m-d H:i:s")."	".$_SERVER["HTTP_CDN_SRC_IP"]."	".$_SERVER["REQUEST_URI"]."\r\n");
fclose($fhandle);

function appendParam($returnStr,$paramId,$paramValue){
	if($returnStr!=""){
		if($paramValue!=""){
			$returnStr.="&".$paramId."=".$paramValue;
		}
	}else{
		If($paramValue!=""){
			$returnStr=$paramId."=".$paramValue;
		}
	}
	return $returnStr;
}
require_once("../include/config.inc.php");
require_once("../include/pay_funcs.php");

$merchantAcctId=trim($_REQUEST['merchantAcctId']);

//设置预付费卡网关密钥
///区分大小写
//获取网关版本.固定值
///本代码版本号固定为v2.0
$version=trim($_REQUEST['version']);

//获取语言种类.固定选择值。
///只能选择1、2
///1代表中文；2代表英文
$language=trim($_REQUEST['language']);

//获取支付方式
///可选择00、41、42、43、44、52、53、54
///00 代表快钱默认支付方式，目前为神州行卡密支付和快钱账户支付；41 代表快钱账户支付；42 代表神州行卡密支付和快钱账户支付；43 代表联通卡密支付和快钱账户支付；44 代表神州行卡密支付和联通卡密支付和快钱账户支付；52 代表神州行卡密支付；53 代表联通卡密支付；54 代表神州行卡密支付和联通卡密支付
$payType=trim($_REQUEST['payType']);

//预付费卡序号
///如果通过预付费卡直接支付时返回
$cardNumber=trim($_REQUEST['cardNumber']);

//获取预付费卡密码
///如果通过预付费卡直接支付时返回
$cardPwd=trim($_REQUEST['cardPwd']);

//获取商户订单号
$orderId=trim($_REQUEST['orderId']);


//获取原始订单金额
///订单提交到快钱时的金额，单位为分。
///比方2 ，代表0.02元
$orderAmount=trim($_REQUEST['orderAmount']);

//获取快钱交易号
///获取该交易在快钱的交易号
$dealId=trim($_REQUEST['dealId']);


//获取商户提交订单时的时间
///14位数字。年[4位]月[2位]日[2位]时[2位]分[2位]秒[2位]
///如：20080101010101
$orderTime=trim($_REQUEST['orderTime']);

//获取扩展字段1
///与商户提交订单时的扩展字段1保持一致
$ext1=trim($_REQUEST['ext1']);

//获取扩展字段2
///与商户提交订单时的扩展字段2保持一致
$ext2=trim($_REQUEST['ext2']);

//获取实际支付金额
///单位为分
///比方 2 ，代表0.02元
$payAmount=trim($_REQUEST['payAmount']);

//获取快钱处理时间
$billOrderTime=trim($_REQUEST['billOrderTime']);

//获取处理结果
///10代表支付成功； 11代表支付失败
$payResult=trim($_REQUEST['payResult']);

//获取签名类型
///1代表MD5签名
///当前版本固定为1
$signType=trim($_REQUEST['signType']);

//充值卡类型 
//0 代表神州行充值卡
//1 代表联通卡充值
//3 代表电信卡充值
//4 代表骏网一卡通
//9 代表已开通任一卡类型

$bossType=trim($_REQUEST['bossType']);
if ($bossType==3) {
$key = "EMJZYWHGN5DUTHK6";
}else if ($bossType==4) {
$key = "X49334NW86R63A8R";
} else if($bossType==1) {
$key = "698UGGCFEYLFIDA2";
}
//充值卡类型 ,比喻商户提交bossType类型为9，用户实际支付的卡类型为0，则receiveBossType 返回0
//0 代表神州行充值卡
//1 代表联通卡充值
//3 代表电信卡充值
//4 代表骏网一卡通
//9 代表已开通任一卡类型
$receiveBossType = trim($_REQUEST['receiveBossType']);

//用户实际支付的卡类型对应的收款账号，必须对应receiveBossType卡类型收款账号
$receiverAcctId = trim($_REQUEST['receiverAcctId']);

//获取加密签名串
$signMsg=trim($_REQUEST['signMsg']);

$stat=$payResult+0;
//生成加密串。必须保持如下顺序。
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"merchantAcctId",$merchantAcctId);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"version",$version);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"language",$language);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"payType",$payType);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"cardNumber",$cardNumber);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"cardPwd",$cardPwd);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"orderId",$orderId);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"orderAmount",$orderAmount);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"dealId",$dealId);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"orderTime",$orderTime);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"ext1",$ext1);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"ext2",$ext2);	
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"payAmount",$payAmount);
    $merchantSignMsgVal=appendParam($merchantSignMsgVal,"billOrderTime",$billOrderTime);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"payResult",$payResult);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"signType",$signType);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"bossType",$bossType);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"receiveBossType",$receiveBossType);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"receiverAcctId",$receiverAcctId);
	$merchantSignMsgVal=appendParam($merchantSignMsgVal,"key",$key);
    $merchantSignMsg= md5($merchantSignMsgVal);

if($payResult!="10" || strtoupper($signMsg)!=strtoupper($merchantSignMsg)){
	echo "<result>1</result><redirecturl>http://pay.91yxq.com/pay_to_show.php?orderid=$orderId</redirecturl>";
	exit();
}

$amount=$payAmount/100;

$sql="select id,b_flag from pay_99bill_szx where orderid='$orderId'";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);
if ($row) {
	if ($payResult=="10") {
	    mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='$orderId'");
		$sql="update pay_99bill_szx set b_flag=1,dealId='$dealId',dealTime='$dealTime',payAmount='$payAmount',payResult='$payResult',signMsg='$signMsg',sync_date=now(),succ='1' where orderid='$orderId'";
		mysql_query($sql);
		if (!$row->b_flag) {
			pay_gameb("pay_99bill_szx",$row->id,$orderId);
		}
	}
} else {
    mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='$orderId'");
    $sql="insert into  pay_99bill_szx(orderid,orderAmount,payAmount,payResult,errCode,signMsg,sync_date) values(
            '$orderId','$orderAmount','$payAmount','$payResult','$errCode','$signMsg',now())";
    mysql_query($sql);		
}
echo "<result>1</result><redirecturl>http://pay.91yxq.com/pay_to_show.php?orderid=$orderId</redirecturl>";
?>