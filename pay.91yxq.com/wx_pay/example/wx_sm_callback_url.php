<?php
require_once 'WxPay.NativePay.php';
require_once "../lib/WxPay.Data.php";
require_once("../../include/config.inc.php");
require_once("../../include/pay_funcs.php");
require_once("../../include/funcs.php");
require_once("./notify.php");

//pay.demo.com\wx_pay\example\wx_sm_callback_url.php

$xmlstring = file_get_contents("php://input");
$xmlObj = simplexml_load_string($xmlstring, 'SimpleXMLElement', LIBXML_NOCDATA);
$xmlArr = json_decode(json_encode($xmlObj), true);
$out_trade_no = $xmlArr['out_trade_no']; //订单号
$transaction_id = $xmlArr['transaction_id']; //微信流水号
$total_fee = $xmlArr['total_fee']/100; //回调回来的xml文件中金额是以分为单位的
$result_code = $xmlArr['result_code']; //状态

//日志（微信返回的数据）
doLog("微信返回:".json_encode($xmlObj)."\r\n", 'wx_return');

/**********验证wx begin*********/
//微信订单查询
$verify = new PayNotifyCallBack();
$verify_res = $verify->Queryorder($xmlArr['transaction_id']);
if(!$verify_res) {
    header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$out_trade_no);
    echo 'SUCCESS';
    exit;
}
/*********验证wx end***********/
$order_arr = mysql_fetch_array(mysql_query("SELECT money, paid_amount, pay_gold, succ FROM pay_orders WHERE orderid='{$out_trade_no}' AND succ=0"));

//验证订单状态
if(!$order_arr){
    doLog(json_encode([$out_trade_no,$order_arr]), 'order_status');
    echo 'SUCCESS';
    die;
}LU1f/P3JNzuG

//验证订单金额
if($total_fee != $order_arr['money']){
    mysql_query("UPDATE 91yxq_recharge.pay_orders SET sync_date=".time().",succ=9,paid_amount=".$total_fee." WHERE orderid='{$out_trade_no}'");
    doLog(json_encode([$out_trade_no,$total_fee,$order_arr['money']]), 'money_error');
    echo 'SUCCESS';
    die;
}

if($result_code == 'SUCCESS'){
    //处理数据库操作 例如修改订单状态 给账户充值等等
    $order_arr = mysql_fetch_array(mysql_query("select money,paid_amount,pay_gold from pay_orders where orderid='{$out_trade_no}'"));

    $sql = "select id, b_flag from pay_jct where orderid='{$out_trade_no}'";
    $res = mysql_query($sql);
    $row = mysql_fetch_object($res);
    if ($row->b_flag) {
        echo 'SUCCESS';
        header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$out_trade_no);
        exit;
    }
    if($row){
        mysql_query("UPDATE 91yxq_recharge.pay_orders SET sync_date=".time().",succ=1 WHERE orderid='{$out_trade_no}'");
        mysql_query("update 91yxq_recharge.pay_jct SET succ=1,b_flag=1,sync_date=" . time() . ",payTendOrderId='".$transaction_id."' WHERE orderid='{$out_trade_no}'");
        if (!$row->b_flag) {
            pay_gameb("pay_jct", $row->id, $out_trade_no);
        }
    }else{
        mysql_query("UPDATE 91yxq_recharge.pay_orders SET sync_date=".time().",succ=1 WHERE orderid='{$out_trade_no}'");
        mysql_query("INSERT INTO 91yxq_recharge.pay_jct (orderid,payTendOrderId,money,paid_amount,succ,pay_date,sync_date) VALUES ('{$out_trade_no}','{$transaction_id}',{$order_arr['money']},{$order_arr['paid_amount']},1,".time().",".time().")");
    }
    echo 'SUCCESS'; //返回成功给微信端 一定要带上不然微信会一直回调8次
    header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$out_trade_no);exit;
}else{ //失败
    return;
    exit;
}


?>