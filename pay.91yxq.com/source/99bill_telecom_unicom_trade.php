<?php
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
$amount=$row->money;
$inputCharset=1;
$bgUrl="http://pay.91yxq.com/api/sync_tele_unicom.php";
$version="v2.0";
$language="1";
$signType="1";
$payerName=$row->user;
$payerContactType="1";
$payerContact="";
$fullAmountFlag="0";
//充值卡类型 
//0 代表神州行充值卡
//1 代表联通卡充值
//3 代表电信卡充值
//4 代表骏网一卡通
//9 代表已开通任一卡类型
if ($row->pay_channel ==9) {
	$bossType =4;
	$merchantAcctId="1002315094005";//商户ID
	$key = "X49334NW86R63A8R";//密钥
}else if ($row->pay_channel ==14) {
	$bossType =3;
	$merchantAcctId="1002315094004";//商户ID
	$key = "EMJZYWHGN5DUTHK6";//密钥
} else if ($row->pay_channel ==15) {
	$bossType =1;
	$merchantAcctId="1002315094003";//商户ID
	$key = "698UGGCFEYLFIDA2";//密钥
}
$productName="91yxq游戏充值";
$productNum="1";
$productId="";
$productDesc="";
$payType="42";
$redoFlag="1";
$pid="";
$orderAmount=$amount*100;
$orderId=trim($row->orderid);
$sql="select id,orderTime,orderid,signMsg from pay_99bill_szx  where user_name='".$row->user_name."' and orderid='".$row->orderid."'";
$query=mysql_query($sql);
$queryrow=mysql_fetch_object($query);
if (!$queryrow) {
	$orderTime=date("YmdHis");
	$signMsgVal=appendParam($signMsgVal,"inputCharset",$inputCharset);
	$signMsgVal=appendParam($signMsgVal,"bgUrl",$bgUrl);
	$signMsgVal=appendParam($signMsgVal,"pageUrl",$pageUrl);
	$signMsgVal=appendParam($signMsgVal,"version",$version);
	$signMsgVal=appendParam($signMsgVal,"language",$language);
	$signMsgVal=appendParam($signMsgVal,"signType",$signType);
	
	$signMsgVal=appendParam($signMsgVal,"merchantAcctId",$merchantAcctId);
	$signMsgVal=appendParam($signMsgVal,"payerName",urlencode($payerName));
	$signMsgVal=appendParam($signMsgVal,"payerContactType",$payerContactType);
	$signMsgVal=appendParam($signMsgVal,"payerContact",$payerContact);
	
	$signMsgVal=appendParam($signMsgVal,"orderId",$orderId);
	$signMsgVal=appendParam($signMsgVal,"orderAmount",$orderAmount);
	$signMsgVal=appendParam($signMsgVal,"payType",$payType);
	$signMsgVal=appendParam($signMsgVal,"fullAmountFlag",$fullAmountFlag);
	$signMsgVal=appendParam($signMsgVal,"orderTime",$orderTime);
	$signMsgVal=appendParam($signMsgVal,"productName",urlencode($productName));
	$signMsgVal=appendParam($signMsgVal,"productNum",$productNum);
	$signMsgVal=appendParam($signMsgVal,"productId",$productId);
	$signMsgVal=appendParam($signMsgVal,"productDesc",urlencode($productDesc));
	$signMsgVal=appendParam($signMsgVal,"ext1",urlencode($ext1));
	$signMsgVal=appendParam($signMsgVal,"ext2",urlencode($ext2));
	$signMsgVal=appendParam($signMsgVal,"bossType",$bossType);
	$signMsgVal=appendParam($signMsgVal,"key",$key);
	$signMsg= strtoupper(md5($signMsgVal)); //安全校验域
	$sql="INSERT INTO `pay_99bill_szx` (`payerName`,`orderid`,`orderAmount`,`orderTime`,`user_ip`,`game_id`,`server_id`,`user_name`,`pay_date`,`sn`,`signMsg`,`b_num`,`taocan_id`,`pay_type`) VALUES('".$row->user."','$orderId','$orderAmount','$orderTime','$user_ip','".$row->game."','".$row->server."','".$row->user."',now(),'$sn','$signMsg','".$row->pay_gold."','$tid','$bossType')";
	
	$r=mysql_query($sql);
	if (!$r) {
		$f=fopen("/www/weblog/mysql_err.log","a");
		if ($f) {
			fputs($f,date("Y-m-d H:i:s")."	".$sql."	".mysql_error()."\n");
			fclose($f);
		}
        }
} else {
	$orderTime=$queryrow->orderTime;
	$orderId=$queryrow->orderid;
	$signMsg=$queryrow->signMsg;
}
?>