<?php
$fhandle=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/51wx_back.log","a");
fwrite($fhandle,date("Y-m-d H:i:s")."	".$_SERVER["HTTP_CDN_SRC_IP"]."	".$_SERVER["REQUEST_URI"]."\r\n");
fclose($fhandle);

require_once("../include/config.inc.php");
require_once("../include/pay_funcs.php");

	$sql="select succ from pay_orders where orderid='{$_REQUEST['orderid']}'";
	$res=mysql_query($sql);
	$row=mysql_fetch_object($res);
	
	if ($row->succ) {
		$sql_wx="select id,b_flag from pay_51wx where orderid='{$_REQUEST['orderid']}'";
		$res_wx=mysql_query($sql_wx);
		$row_wx=mysql_fetch_object($res_wx);
		if ( $row_wx->b_flag) {
		 header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$_REQUEST['orderid']);exit;
		}else if(!$row_wx->b_flag){
			$sql_u="update pay_51wx set b_flag=1,sync_date=now(),succ=1 where orderid='{$_REQUEST['orderid']}'";
			mysql_query($sql_u);
			pay_gameb("pay_51wx",$row_wx->id,$_REQUEST['orderid']);
		}
	}

header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$_REQUEST['orderid']);exit;

?>