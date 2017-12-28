<?php
$fhandle=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/sync_yeepay.log","a");
fwrite($fhandle,date("Y-m-d H:i:s")."	".$_SERVER["HTTP_CDN_SRC_IP"]."	".$_SERVER["REQUEST_URI"]."\r\n");
fclose($fhandle);
require_once("../include/config.inc.php");
require_once("../include/pay_funcs.php");
require_once ("../include/yeepay_lib/yeepayCommon.php");
$p1_MerId = $_REQUEST['p1_MerId'];
$return = getCallBackValue($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
$bRet = CheckHmac($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);

if($bRet){
	if($r1_Code=="1"){  
	    $sql="select count(*) as c from `pay_yeepay` where orderid='$r6_Order'";//
		$res=mysql_query($sql);
        $row=mysql_fetch_object($res);
		if ($row->c>0){  	
			if($r9_BType=="1"){ //在线支付页面返回
			    mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='$r6_Order'");
				$sql="select id,count(*) as c from `pay_yeepay` where orderid='$r6_Order' and succ=1";
				$res=mysql_query($sql);
				$row=mysql_fetch_object($res);
				if ($row->c>0) {
					echo "<script>location.href='http://pay.91yxq.com/pay_to_show.php?orderid=$r6_Order';</script>";exit;
				} else {
					$succ =1; 
					$sql="update `pay_yeepay` set p1_MerId='$p1_MerId',pd_FrpId='$r2_TrxId',sync_date=now(),succ='$succ' where orderid='$r6_Order'";
					mysql_query($sql);
					$sql="select id,b_flag from `pay_yeepay` where orderid='$r6_Order' and succ=1";
				    $res=mysql_query($sql);
				    $row=mysql_fetch_object($res);
					if (!$row->b_flag) {
						pay_gameb("pay_yeepay",$row->id,$r6_Order);
					}
				}
				echo "<script>location.href='http://pay.91yxq.com/pay_to_show.php?orderid=$r6_Order';</script>";exit;
			}elseif($r9_BType=="2"){ //服务器点对点返回
			    mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='$r6_Order'");
				$sql="select id,count(*) as c from `pay_yeepay` where orderid='$r6_Order' and succ=1";
				$res=mysql_query($sql);
				$row=mysql_fetch_object($res);
				if ($row->c>0) {
					echo "<script>location.href='http://pay.91yxq.com/pay_to_show.php?orderid=$r6_Order';</script>";exit;
				} else {
					$succ =1; 
					$sql="update `pay_yeepay` set p1_MerId='$p1_MerId',pd_FrpId='$r2_TrxId',sync_date=now(),succ='$succ' where orderid='$r6_Order'";
					mysql_query($sql);
					$sql="select id,b_flag from `pay_yeepay` where orderid='$r6_Order' and succ=1";
				    $res=mysql_query($sql);
				    $row=mysql_fetch_object($res);
					if (!$row->b_flag) {
						pay_gameb("pay_yeepay",$row->id,$r6_Order);
					}
				}
				echo "<script>location.href='http://pay.91yxq.com/pay_to_show.php?orderid=$r6_Order';</script>";exit;
			}
		} else {
		    if ($r9_BType=="1" || $r9_BType=="2") {
			    $orderTime=date("YmdHis");
				$ip =$_SERVER["HTTP_CDN_SRC_IP"];
				mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='$r6_Order'");
			    $sql="insert into `pay_yeepay` (payerName,orderid,p3_Amt,orderTime,user_ip,game_id,server_id,b_num,user_name,pay_date,sn,taocan_id,p5_Pid,pd_FrpId,p6_Pcat,p7_Pdesc,pa_MP,pr_NeedResponse) values('$user_name','$r6_Order','$r3_Amt','$orderTime','$ip','$game_id','$server_id','$b_num','$user_name',now(),'$sn','$tid','$r5_Pid','$r2_TrxId','$r6_Pcat','$r7_Pdesc','$r8_MP','$pr_NeedResponse')";
				$res=mysql_query($sql);
				echo "<script>location.href='http://pay.91yxq.com/pay_to_show.php?orderid=$r6_Order';</script>";exit;
			} else {
			    echo "<script>location.href='http://pay.91yxq.com/pay_to_show.php?orderid=$r6_Order';</script>";exit;
			}
		}
	}
}else{
    echo "<script>location.href='http://pay.91yxq.com/pay_to_show.php?orderid=$r6_Order';</script>";exit;
}
?>