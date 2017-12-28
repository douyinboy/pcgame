<?php
require_once(dirname(__DIR__) . "/include/yeepay_lib/yeepayCommon.php");
$sql="select id,orderTime,orderid from `pay_yeepay` where user_name='".$row->user."' and orderid='".$row->orderid."'";
$query=mysql_query($sql);
$queryrow=mysql_fetch_object($query);
//$pd_FrpId = "";


if (!$queryrow) {
	$orderTime=date("YmdHis");
        $orderId= trim($row->orderid);
	$p2_Order					= $orderId;
	$p3_Amt						= $row->money;
	$p4_Cur						= "CNY";
	$p5_Pid						= '91yxq-Gcoin';
	$p6_Pcat					= '91yxq';
	$p7_Pdesc					= 'Game coin';
	$p8_Url						= "http://pay.91yxq.com/api/sync_yeepay.php";												
	$pa_MP						= '91yxq.com';		
	$pd_FrpId					= "";//QQCARD-NET
	$pr_NeedResponse	= "1";
	#调用签名函数生成签名串
	$hmac = getReqHmacString($p2_Order,$p3_Amt,$p4_Cur,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$pa_MP,$pd_FrpId,$pr_NeedResponse);
	$sql="INSERT INTO `pay_yeepay` (`payerName`,`orderid`,`p3_Amt`,`orderTime`,`user_ip`,`game_id`,`server_id`,`b_num`,`user_name`,`pay_date`,`sn`,`taocan_id`,`p5_Pid`,`pd_FrpId`,`p6_Pcat`,`p7_Pdesc`,`pa_MP`,`pr_NeedResponse`) VALUES('".$row->user."','$orderId','$p3_Amt','$orderTime','$user_ip','".$row->game."','".$row->server."','".$row->pay_gold."','".$row->user."',now(),'$sn','$tid','$p5_Pid','$pd_FrpId','$p6_Pcat','$p7_Pdesc','$pa_MP','$pr_NeedResponse')";
	$r=mysql_query($sql);
	if (!$r) {
		$f=fopen(dirname(dirname(__DIR__)) . "/weblog/mysql_err.log","a");
		if ($f) {
			fputs($f,date("Y-m-d H:i:s")."	".$sql."	".mysql_error()."\n");
			fclose($f);
		}
	}
}
else {
	$orderTime=$queryrow->orderTime;
	$orderId=$queryrow->orderid;
}
?>