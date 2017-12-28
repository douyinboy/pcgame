<?php
//充值卡中转站 

$qiqu_pay_channel = $_POST['qiqu_pay_channel'] + 0;
$qiqu_time = $_POST['qiqu_time'] + 0;
$qiqu_sign = strip_tags(trim($_POST['qiqu_sign']));
$qiqu_orderid = strip_tags(trim($_POST['qiqu_orderid']));
if($qiqu_sign != md5($qiqu_pay_channel.$qiqu_time.'qiqu#1year@V5'.$qiqu_orderid)){
	exit('error');
}

require_once("../include/config.inc.php");
$pay_channel_list = array(1=>'1',2=>'1',3=>'1',4=>'1',5=>'1',6=>'0.95',9=>'0.84',10=>'1',11=>'1',12=>'1',13 =>'1', 14=>'0.95',15=>'0.95',18=>'1',19=>'1',23=>'1',30=>'0.98',31=>'0.98',32=>'0.84',33=>'1',34=>'0.99',35=>'0.95',36=>'0.95',37=>'0.95',38=>'0.95',39=>'0.95',40=>'0.95',41=>'0.86',42=>'0.88',43=>'0.88',44=>'0.82',100=>'1');
	
switch($qiqu_pay_channel){
	case 38:
	case 39:
	case 40:
		$post = array();
		$post['version_id'] = trim($_POST['version_id']);
		$post['merchant_id'] = trim($_POST['merchant_id']) + 0;
		$post['order_id'] = trim($_POST['order_id']);
		$post['amount'] = trim($_POST['amount']) + 0;
		$post['currency'] = trim($_POST['currency']);
		$post['pm_id'] = trim($_POST['pm_id']);
		$post['pc_id'] = trim($_POST['pc_id']);
		$post['cardnum1'] = trim($_POST['cardnum1']);
		$post['cardnum2'] = trim($_POST['cardnum2']);
		$post['retmode'] = trim($_POST['retmode']) + 0;
		$post['notify_url'] = trim($_POST['notify_url']);
		$post['order_date'] = trim($_POST['order_date']);
		$post['verifystring'] = trim($_POST['verifystring']);
		$return = file_get_contents('http://interchange1.19ego.cn/pgworder/orderdirect.do?'.http_build_query($post));
		if(!$return){
			$return = file_get_contents('http://change.19ego.cn/pgworder/orderdirect.do?'.http_build_query($post));
		}
		if(!$return){
			exit('订单错误！');
		}
		$return_arr = explode('|',$return);
		if($return_arr[11]=='P'){
			mysql_query("UPDATE pay_19pay SET receive_state=1 WHERE orderid='{$post['order_id']}'");
		}
	break;
	case 41:
	case 42:
	case 43:
	case 44:
		$post = array();
		$post['customerid'] = trim($_POST['customerid']) + 0;
		$post['sdcustomno'] = trim($_POST['sdcustomno']);
		$post['ordermoney'] = trim($_POST['ordermoney']);
		$post['cardno'] = trim($_POST['cardno']);
		$post['faceno'] = trim($_POST['faceno']);
		$post['cardnum'] = trim($_POST['cardnum']);
		$post['cardpass'] = trim($_POST['cardpass']);
		$post['noticeurl'] = trim($_POST['noticeurl']);
		$post['remarks'] = trim($_POST['remarks']);
		$post['sign'] = trim($_POST['sign']);
		$post['mark'] = trim($_POST['mark']);
		$xmlparser = xml_parser_create();
		$return_xml = file_get_contents('http://www.zhifuka.net/gateway/zfgateway.asp?'.http_build_query($post));
		xml_parse_into_struct($xmlparser,$return_xml,$values);
		xml_parser_free($xmlparser);
		$state = $values[2]['attributes']['VALUE'];
		if($state==1){
			mysql_query("UPDATE pay_xqt SET receive_state=1 WHERE orderid='{$post['order_id']}'");
		}
	break;
}
header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$qiqu_orderid);exit;
?>