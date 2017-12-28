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
$inputCharset=1;
$bgUrl="http://pay.91yxq.com/api/sync_99bill_szx.php";
$version="v2.0";
$language="1";
$signType="1";
$merchantAcctId="1002315094002"; //商户ID
$payerName=$row->user;
$payerContactType="1";
$payerContact="";
$fullAmountFlag="0";
$productName="91yxq游戏充值";
$productNum="1";
$productId="";
$productDesc="";
$payType="44";
$redoFlag="1";
$pid="";
$key="GRRWBI3IJSJUSXEF";//密钥
$orderAmount=$row->money*100;
$orderId=trim($row->orderid);
$sql="select id,orderTime,orderid,signMsg from pay_99bill_szx  where user_name='".$row->user."' and orderid='$orderId'";
$query=mysql_query($sql);
$queryrow=mysql_fetch_object($query);
if (!$queryrow) {
	$orderTime=date("YmdHis");
	$sql="INSERT INTO `pay_99bill_szx`(`payerName`,`orderid`,`orderAmount`,`orderTime`,`user_ip`,`game_id`,`server_id`,`b_num`,`user_name`,`pay_date`,`sn`,`taocan_id`) VALUES('".$row->user."','".$orderId."','$orderAmount','$orderTime','$user_ip','".$row->game."','".$row->server."','".$row->pay_gold."','".$row->user."',now(),'$sn','$tid')";
	$r=mysql_query($sql);
	if (!$r) {
		$f=fopen("/www/weblog/mysql_err.log","a");
		if ($f) {
			fputs($f,date("Y-m-d H:i:s")."	".$sql."	".mysql_error()."\n");
			fclose($f);
		}
	}
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
	$signMsgVal=appendParam($signMsgVal,"key",$key);
	$signMsg= strtoupper(md5($signMsgVal));//安全校验域
}
else {
	$orderTime=$queryrow->orderTime;
	$orderId=$queryrow->orderid;
	$signMsg=$queryrow->signMsg;
}
?>