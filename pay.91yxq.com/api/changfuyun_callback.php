<?php
ini_set('date.timezone','Asia/Shanghai');
require_once("../include/alipay_lib/alipay.config.php");
//require_once("../include/alipay_lib/alipay_notify.class.php");
require_once("../include/config.inc.php");
require_once("../include/pay_funcs.php");
require_once("../include/funcs.php");

//计算得出通知验证结果
//$alipayNotify = new AlipayNotify($aliapy_config);
//$verify_result = $alipayNotify->verifyReturn();
//if($verify_result) {//验证成功

//获取畅付云的通知返回参数，可参考技术文档中服务器异步通知参数列表
$returncode = $_GET['returncode'];	    //返回代码   1表示扫码成功
$userid	  = $_GET['userid'];	    	//商户号
$out_trade_no = $_GET['orderid'];	    //获取订单号
$total_fee	  =  $_GET['money'];		//获取总价格
$sign  =  $_GET["sign"];
$sign2  =  $_GET["sign2"];
$ext =  $_GET['ext'];

if(!isset($sign2) && empty($sign2))
{
    echo 'sign2 param error';exit;
}

$localsign = md5(strtolower("returncode={$returncode}&userid={$userid}&orderid={$out_trade_no}&keyvalue={$alipay_params['key']}"));
$localsign2 = md5(strtolower("money={$total_fee}&returncode={$returncode}&userid={$userid}&orderid={$out_trade_no}&keyvalue={$alipay_params['key']}"));

if ($sign != $localsign)
{
    echo 'sign error';
    exit;            //加密错误
}
//注意这个带金额的加密 判断 一定要加上，否则非常危险 ！！
if ($sign2 != $localsign2)
{
    echo 'sign2 error';
    exit;            //加密错误
}

if($returncode == 1) {
    //returncode=1&orderid=P20170928140935148551&paymoney=1.0000&sign=f659a494085dc5f6fcd190136354355e
    $_sign = md5("userid={$userid}&orderid={$out_trade_no}&keyvalue={$alipay_params['key']}");
    $url = "http://pay.changfpay.com/payquery.aspx?userid={$userid}&orderid={$out_trade_no}&sign={$_sign}";
    $result = file_get_contents($url);
    parse_str($result, $arr);
    if ($arr['returncode'] != 1) {
        echo '订单支付失败!';
        exit;
    }
    doLog(json_encode([$_GET, $url, $result]), 'changfpay');

    //判断实际充值金额与订单金额是否一致
    if($total_fee != $arr['paymoney']){
        echo '订单金额不一致!';
        exit;
    }

    switch ($ext) {
        case 18:
            $tableName = 'pay_alipay';
            $update_sql = "update pay_alipay set total_fee = '$total_fee', b_flag=1, trade_status = 'TRADE_SUCCESS', sync_date = now(), succ = 1 where orderid = '$out_trade_no'";
            $insert_sql = "INSERT INTO pay_alipay(orderid, total_fee, trade_status, sync_date, succ) values('$out_trade_no', '$total_fee', 'TRADE_SUCCESS', now(), '1')";
            break;
        case 46:
            $tableName = 'pay_jct';
            $update_sql = "update pay_jct SET money = '$total_fee', paid_amount = '$total_fee', succ = 1, b_flag = 1, sync_date = " . time() . " where orderid = '$out_trade_no'";
            $insert_sql = "INSERT INTO pay_jct (orderid,money,paid_amount,succ,pay_date,sync_date) VALUES ('{$out_trade_no}',{$total_fee},{$total_fee},1,".time().",".time().")";
            break;
        case 33:
            $tableName = 'pay_hfb';
            $update_sql = "update pay_hfb SET result = 1, b_flag = 1, sync_date = now(), succ = 1 where orderid = '$out_trade_no'";
            $insert_sql = "INSERT INTO pay_hfb (result, agent_id, orderid, pay_type,pay_amt, pay_date) VALUES (1, 7397, '$out_trade_no', 20, $total_fee,now())";
            break;
    }

    $sql="select id, b_flag from " . $tableName . " where orderid = '$out_trade_no'";
    $res=mysql_query($sql);
    $row=mysql_fetch_object($res);

    if ($row->b_flag) {
        header("location:http://pay.91yxq.com/pay_to_show.php?orderid=".$out_trade_no);exit;
    }

    //更新订单表
    mysql_query("UPDATE `pay_orders` SET sync_date = ".time().", succ = 1 WHERE orderid = '$out_trade_no'");
    if ($row) {
        //更新对应的支付类型表
        mysql_query($update_sql);

        //发游戏币
        if (!$row->b_flag) {
            pay_gameb($tableName, $row->id, $out_trade_no);
        }
    } else {
        //插入对应的支付类型表
        mysql_query($insert_sql);
    }
}

echo "ok";
?>
