<?php
$fhandle=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/sync_99bill.log","a");
fwrite($fhandle,date("Y-m-d H:i:s")."	".$_SERVER["HTTP_CDN_SRC_IP"]."	".$_SERVER["REQUEST_URI"]."\r\n");
fclose($fhandle);
//      核对签名是否正确 ==============  开始 =================
	function kq_ck_null($kq_va,$kq_na){if($kq_va == ""){return $kq_va="";}else{return $kq_va=$kq_na.'='.$kq_va.'&';}}
	
	$kq_check_all_para=kq_ck_null($_GET[merchantAcctId],'merchantAcctId').kq_ck_null($_GET[version],'version').kq_ck_null($_GET[language],'language').kq_ck_null($_GET[signType],'signType').kq_ck_null($_GET[payType],'payType').kq_ck_null($_GET[bankId],'bankId').kq_ck_null($_GET[orderId],'orderId').kq_ck_null($_GET[orderTime],'orderTime').kq_ck_null($_GET[orderAmount],'orderAmount').kq_ck_null($_GET[dealId],'dealId').kq_ck_null($_GET[bankDealId],'bankDealId').kq_ck_null($_GET[dealTime],'dealTime').kq_ck_null($_GET[payAmount],'payAmount').kq_ck_null($_GET[fee],'fee').kq_ck_null($_GET[ext1],'ext1').kq_ck_null($_GET[ext2],'ext2').kq_ck_null($_GET[payResult],'payResult').kq_ck_null($_GET[errCode],'errCode');
	
	$trans_body=substr($kq_check_all_para,0,strlen($kq_check_all_para)-1);
	$MAC=base64_decode($_GET[signMsg]);
	
	$cert = file_get_contents("../include/hd/99bill.cert.rsa.20140728.cer");
	$pubkeyid = openssl_get_publickey($cert); 
	$ok = openssl_verify($trans_body, $MAC, $pubkeyid);
	require_once("../include/config.inc.php");
	require_once("../include/pay_funcs.php");
	$orderid = $_GET[orderId];
	if ($ok == 1) {
		$sql="select id,b_flag from pay_99bill where orderid='$orderid'";
		$res=mysql_query($sql);
		$row=mysql_fetch_object($res);
		if ($row) {
		    mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='$orderid'");
                    $sql="update pay_99bill set b_flag=1,bankId='".trim($_GET[bankId])."',dealId='".$_GET[dealId]."',bankDealId='".$_GET[bankDealId]."',dealTime='".$_GET[dealTime]."',orderAmount='".$_GET[orderAmount]."',payAmount='".$_GET[payAmount]."',fee='".$_GET[fee]."',payResult='".$_GET[payResult]."',errCode='".$_GET[errCode]."',signMsg='".$_GET[signMsg]."',sync_date=now(),succ='1' where orderid='".$_GET[orderId]."'";
                    mysql_query($sql);
                    if (!$row->b_flag) {
                        $res = pay_gameb("pay_99bill",$row->id,$_GET[orderId]);
                    }
		 } else {
		    mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='$orderid'");
                    $sql="insert into pay_99bill(orderid,orderAmount,payAmount,fee,payResult,errCode,signMsg,sync_date) values(
					'".$_GET[orderId]."','".$_GET[orderAmount]."','".$_GET[payAmount]."','".$_GET[fee]."','".$_GET[payResult]."','".$_GET[errCode]."','".$_GET[signMsg]."',now())";			
                    mysql_query($sql);
		}	    
	    $succ =1;
		echo '<result>1</result><redirecturl>http://pay.91yxq.com/pay_to_show.php?orderid='.$orderid.'</redirecturl>';
	}else{
	    $succ = 0;
		echo '<result>0</result><redirecturl>http://pay.91yxq.com/pay_to_show.php?orderid='.$orderid.'</redirecturl>';
	}
?>