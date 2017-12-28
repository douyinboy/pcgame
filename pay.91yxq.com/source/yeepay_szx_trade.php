<?php
include (dirname(__DIR__) . "/include/yeepay_lib/yeepayCommon.php");
$p0_Cmd="Buy";
//$p1_MerId="10000572863";
$p3_Amt						= $row->money;
$p4_Cur						= "CNY";
$p5_Pid						= "7977";
$p6_Pcat					= "7977";
$p7_Pdesc					= "7977";
$p8_Url						= "http://pay.7977.com/api/sync_yeepay_szx.php";
$p9_SAF						= 0;
$pa_MP						= $row->user;
$pd_FrpId					= "SZX";
$pr_NeedResponse			= 0;
$sql="select id,orderid,hmac from `pay_yeepay_szx` where user_name='".$row->user."' and orderid='".$row->orderid."'";
$query=mysql_query($sql);
$queryrow=mysql_fetch_object($query);
if (!$queryrow) {
    $p2_Order=trim($row->orderid);
	$hmac = getReqHmacString($p2_Order,$p3_Amt,$p4_Cur,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$pa_MP,$pd_FrpId,$pr_NeedResponse);
	$sql="INSERT INTO `pay_yeepay_szx`(`p3_Amt`,`orderid`,`pd_FrpId`,`b_num`,`game_id`,`server_id`,`user_name`,`pay_date`,`user_ip`,`sn`,`taocan_id`) VALUES(
		'$p3_Amt','$p2_Order','$pd_FrpId','".$row->pay_gold."','".$row->game."','".$row->server."','".$row->user."',now(),'$user_ip','$sn','$taocan_id')";
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
	$p2_Order=$queryrow->orderid;
	$hmac=$queryrow->hmac;
}
?>