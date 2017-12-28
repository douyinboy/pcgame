<?php
$fhandle=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/sync_yeepay_szx.log","a");
fwrite($fhandle,date("Y-m-d H:i:s")."	".$_SERVER["HTTP_CDN_SRC_IP"]."	".$_SERVER["REQUEST_URI"]."\r\n");
fclose($fhandle);
require_once("../include/yeepay_lib/yeepayCommon.php");
require_once("../include/config.inc.php");
require_once("../include/pay_funcs.php");
$r1_Code=$_REQUEST["r1_Code"];
$r2_TrxId=$_REQUEST["r2_TrxId"];
$r3_Amt=$_REQUEST["r3_Amt"];
$r4_Cur=$_REQUEST["r4_Cur"];
$r6_Order=$_REQUEST["r6_Order"];
$r7_Uid=$_REQUEST["r7_Uid"];
$r8_MP=$_REQUEST["r8_MP"];
$r9_BType=$_REQUEST["r9_BType"]+0;

$rb_BankId=$_REQUEST["rb_BankId"];
$ro_BankOrderId=$_REQUEST["ro_BankOrderId"];
$rp_PayDate=$_REQUEST["rp_PayDate"];
$rq_CardNo=$_REQUEST["rq_CardNo"];
$rhmac=$_REQUEST["hmac"];

//解析返回参数.
$return = getCallBackValue($r0_Cmd,$r1_Code,$p1_MerId,$p2_Order,$p3_Amt,$p4_FrpId,$p5_CardNo,$p6_confirmAmount,$p7_realAmount,$p8_cardStatus,$p9_MP,$pb_BalanceAmt,$pc_BalanceAct,$hmac);
//判断返回签名是否正确（True/False）
$bRet = CheckHmac($r0_Cmd,$r1_Code,$p1_MerId,$p2_Order,$p3_Amt,$p4_FrpId,$p5_CardNo,$p6_confirmAmount,$p7_realAmount,$p8_cardStatus,$p9_MP,$pb_BalanceAmt,$pc_BalanceAct,$hmac);
//校验码正确.
if($bRet){
		if($r1_Code=="1"){
			$stat=$r1_Code+0;
			$sql="select id,b_flag from pay_yeepay_szx where orderid='$r6_Order'";
			$res=mysql_query($sql);
			$row=mysql_fetch_object($res);
			if ($row) {
				if ($stat==1) {
				    mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='$r6_Order'");
					$sql="update pay_yeepay_szx set b_flag=1,r1_Code='$r1_Code',r2_TrxId='$r2_TrxId',r3_Amt='$r3_Amt',
						  r4_Cur='$r4_Cur',orderid='$r6_Order',rb_BankId='$rb_BankId',rp_PayDate='$rp_PayDate',ro_BankOrderId='$ro_BankOrderId',
						  rq_CardNo='$rq_CardNo',rhmac='$rhmac',sync_date=now(),succ='$stat' where orderid='$r6_Order'";
					mysql_query($sql);
					if (!$row->b_flag) {
						pay_gameb("pay_yeepay_szx",$row->id,$r6_Order);
					}
				} else {
				    mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='$r6_Order'");
					$sql="insert into pay_yeepay_szx(orderid,r2_TrxId,r3_Amt,r4_Cur,r6_Order,rb_BankId,ro_BankOrderId,rp_PayDate,rq_CardNo,rhmac,sync_date) 
						values('$r1_Code','$r2_TrxId','$r3_Amt','$r4_Cur','$r6_Order','$rb_BankId','$ro_BankOrderId','$rp_PayDate','$rq_CardNo','$rhmac',now())";
					mysql_query($sql);
				}
			}
			$succ=$stat;
			if ($r9_BType==1) {
				header("Location:http://pay.91yxq.com/pay_to_show.php?orderid=".$r6_Order);exit;
			}
			else {
				echo "success";exit;
			}
		}
} else {
	echo "success";
}
?>