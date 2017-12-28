<?php
$fhandle=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/91pay_return.log","a");
fwrite($fhandle,date("Y-m-d H:i:s")."	".$_SERVER["HTTP_CDN_SRC_IP"]."	".$_SERVER["REQUEST_URI"]."\r\n");
fclose($fhandle);

require_once("../include/config.inc.php");
require_once("../include/pay_funcs.php");
$_REQUEST['v_oid'] = mysql_real_escape_string(strip_tags(trim($_REQUEST['v_oid'])));
$_REQUEST['v_pstatus'] = $_REQUEST['v_pstatus'] + 0;
if($_REQUEST['v_pstatus']==30){
	header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$_REQUEST['v_oid']);exit;
}else if ($_REQUEST['v_pstatus']==20){
	$_REQUEST['v_amount'] = $_REQUEST['v_amount'] + 0;
	$_REQUEST['v_moneytype'] = mysql_real_escape_string(strip_tags(trim($_REQUEST['v_moneytype'])));
	if($_REQUEST['v_md5str']!=md5("{$_REQUEST['v_oid']}20{$_REQUEST['v_amount']}{$_REQUEST['v_moneytype']}IGXLy8EzgqB0RGW8")){
		//header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$_REQUEST['v_oid']);exit;
		exit($_REQUEST['v_oid'].'___'.$_REQUEST['v_pstatus'].'___'.$_REQUEST['v_amount'].'___'.$_REQUEST['v_moneytype'].'___'.$_REQUEST['v_md5str']);
	}
	$sql="select succ from pay_orders where orderid='{$_REQUEST['v_oid']}'";
	$res=mysql_query($sql);
	$row=mysql_fetch_object($res);
	
	if ($row->succ) {
		$sql_wx="select id,b_flag from pay_91pay where orderid='{$_REQUEST['v_oid']}'";
		$res_wx=mysql_query($sql_wx);
		$row_wx=mysql_fetch_object($res_wx);
		if ( $row_wx->b_flag) {
		 //header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$_REQUEST['v_oid']);exit;
		 exit($_REQUEST['v_oid'].'@___'.$_REQUEST['v_pstatus'].'___'.$_REQUEST['v_amount'].'___'.$_REQUEST['v_moneytype'].'___'.$_REQUEST['v_md5str']);
		}else if(!$row_wx->b_flag){
			$sql_u="update pay_91pay set b_flag=1,sync_date=now(),succ=1 where orderid='{$_REQUEST['v_oid']}'";
			mysql_query($sql_u);
			pay_gameb("pay_91pay",$row_wx->id,$_REQUEST['v_oid']);
		}
	}
}
	

//header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$_REQUEST['v_oid']);exit;
exit($_REQUEST['v_oid'].'#___'.$_REQUEST['v_pstatus'].'___'.$_REQUEST['v_amount'].'___'.$_REQUEST['v_moneytype'].'___'.$_REQUEST['v_md5str']);

?>