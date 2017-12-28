<?php
	/*使用平台币支付处理页面*/
	$fhandle=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/platformB_pay.log","a");//此为平台币支付备份文件
	fwrite($fhandle,date("Y-m-d H:i:s")."	".$_SERVER["HTTP_CDN_SRC_IP"]."	".$_SERVER["REQUEST_URI"]."\r\n");
	fclose($fhandle);
	require_once(dirname(__DIR__) . "/include/config.inc.php");
	require_once(dirname(__DIR__) . "/include/pay_funcs.php");
	require_once(dirname(__DIR__) . "/include/funcs.php");
	$order = mysql_real_escape_string(strip_tags(trim($_REQUEST['order'])));
	$pwForPt = mysql_real_escape_string(strip_tags(trim($_REQUEST['pwForPt'])));	//支付密码
	$loginuser = $_COOKIE["login_name"];   //登陆账号
	
	$ip = $_SERVER["HTTP_CDN_SRC_IP"];
	if (!$ip) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	$time=time();
	$sign=md5($time.'@_dq*3@DJl_5a_@');
	$sql_m = "SELECT paid_amount,user,pay_gold,game,server FROM pay_orders WHERE orderid='{$order}'";
	$result_m = mysql_query($sql_m);
	$row_m=mysql_fetch_array($result_m);
	$platformB=$row_m['paid_amount']*100;
	
	/*判断订单是否已存在*/
	$sql_pd_i="select id,b_flag from pay_platform_log  where orderid='{$order}'";
	$arr_i=mysql_fetch_object(mysql_query($sql_pd_i));
	if(!$arr_i){
		$sql_q="insert into pay_platform_log (orderid,payname,user_name,money_platform,paid_amount,pay_gold,pay_date,user_ip,game_id,server_id) values ('{$order}','{$loginuser}','{$row_m['user']}',{$platformB},{$row_m['paid_amount']},{$row_m['pay_gold']},now(),'{$ip}',{$row_m['game']},{$row_m['server']})";
		mysql_query($sql_q);
	}else{
		header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$order);exit;
	}
	$url = "http://api.91yxq.com/remote_login.php?act=payFromPlatformB&time={$time}&sign={$sign}&user={$loginuser}&pwForPt={$pwForPt}&paid_amount={$row_m['paid_amount']}";
	$content=file_get_contents($url);
	if($content!="ok"){
		header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$order);exit;
	}else if($content=="ok"){
		//扣除平台币成功记录
		$f=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/platformB_pay_jilu.log","a");//此为平台币支付记录备份文件
		fwrite($f,date("Y-m-d H:i:s")."	".$loginuser."    ".$row_m['user']."     ".$platformB."    ".$_SERVER["HTTP_CDN_SRC_IP"]."	".$_SERVER["REQUEST_URI"]."\r\n");
		fclose($f);
		mysql_query("UPDATE `pay_orders` SET sync_date=".time().",succ=1 WHERE orderid='{$order}'");
		mysql_query("update pay_platform_log set synv_date=now(),succ=1,b_flag=1 where orderid='{$order}'");
		$sql_cx="select id,b_flag from pay_platform_log  where orderid='{$order}'";
		$arr_cx=mysql_fetch_object(mysql_query($sql_cx));
		if($arr_cx->b_flag!=2){
			pay_gameb("pay_platform_log",$arr_cx->id,$order);
		}
		header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$order);exit;
	}
	header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$order);exit;
?>