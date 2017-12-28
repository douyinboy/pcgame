<?php
include(__DIR__ . "/include/config.inc.php");
include(__DIR__ . "/include/funcs.php");

/**
 * @通过API添加游戏列表
 * @param url http://pay.demo.com/recharge_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f&game=1&server=1&pay_type=18&user=allen&money=1&dfbank=icbc
 */

//判断参数是否为空
//if (trim($_GET['time']) == '' && trim($_GET['sign']) == '' && trim($_GET['game']) == '' && trim($_GET['server']) == '' && trim($_GET['pay_type']) == '' && trim($_GET['user']) == '' && trim($_GET['money']) == '' && trim($_GET['dfbank']) == '') {
//    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
//}
//
////验证签名
//$sign = $_GET['sign'];
//unset($_GET['sign']);
//if ($sign != getSign($_GET, SECRET_KEY)) {
//    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
//}

$game_list = array(0); //1:100充值比例的游戏
$game_list_own = array();//自己游戏不扣率费
$pay_channel_own = array(); //渠道卡费率特殊性
$pay_channel_list = array(1=>'1',2=>'1',3=>'1',4=>'1',5=>'1',6=>'0.95',9=>'0.84',10=>'1',11=>'1',12=>'1',13 =>'1', 14=>'0.95',15=>'0.95',18=>'1',19=>'1',23=>'1',30=>'0.98',31=>'0.98',32=>'0.84',33=>'1',34=>'0.99',35=>'0.95',36=>'0.95',37=>'0.95',38=>'0.95',39=>'0.95',40=>'0.95',41=>'0.86',42=>'0.88',43=>'0.88',44=>'0.82',46=>'0.98',100=>'1');
$user_ip = ip2long($_SERVER["HTTP_CDN_SRC_IP"]);
if (!$user_ip) {
    $user_ip = ip2long($_SERVER['REMOTE_ADDR']);
}
$phone = $_GET['phone'];
$pay_channel = $_GET['pay_type'] + 0;
$game = $_GET['game'] + 0;
$server = $_GET['server'] + 0;
//$server_name = $_GET['server_name'];
$dfbank = $_GET['dfbank'];
$user =$_GET['user'];
if(strstr($user,'@qq')){
    $user_arr=explode('-',$user);
    $user=trim($user_arr[count($user_arr)-1]);
}
if (!chkUserName($user)) { //检查提交的用户名合法性
    echo '用户名不合法!';exit;
}

$user = mysql_real_escape_string(strip_tags(trim(urldecode($user))));
$money = $_GET['money'] + 0;
if ( $money<1 || $money>99999 ) {
    echo '充值金额不得小于1元!';exit;
}

/** 最近充值游戏 start **/
$last_game = $_COOKIE['last_game'];

/** 最近充值游戏 end **/
 $orderid = 'P'.date("YmdHis").substr(microtime(),2,6);
$exchange_rate= 10;
if ( in_array($game,$game_list) ) {
    $exchange_rate= 100;
}
if (in_array($game,$game_list_own) && in_array($pay_channel,$pay_channel_own)) {
    $pay_channel_list[$pay_channel]=1;
}
if(!empty($dfbank)){
    set_cookie('dfbank',$dfbank,time()+86400*7);
    $sql = "update pay_bank set bank_count=bank_count+1 where bank_name='{$dfbank}'";
    @mysql_query($sql);
}
$pay_gold =  intval($money * $exchange_rate * $pay_channel_list[$pay_channel]);
$paid_amount = $pay_channel_list[$pay_channel] *  $money;
mysql_query('START TRANSACTION;');
try {
    if($pay_channel==100){$dfbank='';}
    $res = mysql_query("INSERT INTO `pay_orders`(`orderid`,`user`,`money`,`paid_amount`,`pay_gold`,`game`,`server`,`pay_channel`,`user_ip`,`pay_date`,`bank_type`,`phone`) VALUES('$orderid','$user',$money,$paid_amount,$pay_gold,$game,$server,$pay_channel,$user_ip,UNIX_TIMESTAMP(),'$dfbank','$phone')");
    if ($res) {
        $row = modifyPayData($orderid);
    } else {
        $orderid = 'P'.date("YmdHis").substr(microtime(),2,6);
        if($pay_channel==100){$dfbank='';}
        $res = mysql_query("INSERT INTO `pay_orders`(`orderid`,`user`,`money`,`paid_amount`,`pay_gold`,`game`,`server`,`pay_channel`,`user_ip`,`pay_date`,`bank_type`,`phone`) VALUES('$orderid','$user',$money,$paid_amount,$pay_gold,$game,$server,$pay_channel,$user_ip,UNIX_TIMESTAMP(),'$dfbank','$phone')");

        $row = modifyPayData($orderid);
    }
    mysql_query('commit;');
} catch (Exception $e) {
    mysql_query('rollback;');
}

function modifyPayData($order)
{
    $paymethod = $_POST['paymethod']; //银行卡=bankPay,余额=directPay
    if ( $paymethod=='bankPay' ) {
        $defaultbank = $_POST["defaultbank"]; //银行代码
    } else {
        $defaultbank = "";
    }
    $user_ip = $_SERVER["HTTP_CDN_SRC_IP"];
    if (!$user_ip) {
        $user_ip = $_SERVER['REMOTE_ADDR'];
    }
    $sql = "SELECT * FROM `pay_orders` WHERE `orderid`='{$order}'";
    $row = mysql_query($sql);
    if ( $row ) {
        $row = mysql_fetch_object($row);
        $sql = "update pay_orders set check_pay=1 WHERE `orderid`='{$order}'";
        @mysql_query($sql);
        return $row;
    } else {
        $sql = "update pay_orders set check_pay=-1 WHERE `orderid`='{$order}'";
        @mysql_query($sql);
        exit(json_encode(['code' => 02, 'message' => '订单生成失败!']));
    }
}

?>

<body onLoad="document.forms.order.submit();">
<div style='font-size:12px;'>系统正在跳转中,请稍后....</div>
<?php
switch($row->pay_channel){
    case 18:
        header("Content-type: text/html; charset=utf-8");
        require(__DIR__ . '/source/alipay_trade.php');
        echo $html_text;
        break;
    case 30:
        mysql_query("insert into pay_51wx (customerid,sd51no,orderid,ordermoney,realmoney,pay_date,user_name) values('153692','','{$row->orderid}',{$row->money},".($row->money * 0.98).",now(),'{$row->user}')");
        ?>
        <form name="order" action="http://www.zhifuka.net/gateway/weixin/weixinpay.asp" method="post">
            <input type="hidden" name="customerid" value="153692" />
            <input type="hidden" name="sdcustomno" value="<?php echo $row->orderid ; ?>" />
            <input type="hidden" name="orderAmount" value="<?php echo $row->money*100 ; ?>" />
            <input type="hidden" name="cardno" value="32" />
            <input type="hidden" name="noticeurl" value="http://pay.demo.com/api/51wx_notice.php" />
            <input type="hidden" name="backurl" value="http://pay.demo.com/api/51wx_back.php?orderid=<?php echo $row->orderid ;?>" />
            <input type="hidden" name="sign" value="<?php echo strtoupper(md5('customerid=153692&sdcustomno='.$row->orderid.'&orderAmount='.($row->money*100).'&cardno=32&noticeurl=http://pay.demo.com/api/51wx_notice.php&backurl=http://pay.demo.com/api/51wx_back.php?orderid='.$row->orderid.'123'));?>" />
            <input type="hidden" name="mark" value="91yxq" />
        </form>
        <?php
        break;
    case 6:
        require(__DIR__ . '/source/99bill_szx_trade.php');
        ?>
        <form name="order" action="http://www.99bill.com/szxgateway/recvMerchantInfoAction.htm" method="post">
            <input type="hidden" name="inputCharset" value="<?php echo $inputCharset ; ?>" />
            <input type="hidden" name="bgUrl" value="<?php echo $bgUrl ; ?>" />
            <input type="hidden" name="pageUrl" value="<?php echo $pageUrl ; ?>" />
            <input type="hidden" name="version" value="<?php echo $version ; ?>" />
            <input type="hidden" name="language" value="<?php echo $language ; ?>" />
            <input type="hidden" name="signType" value="<?php echo $signType ; ?>" />
            <input type="hidden" name="merchantAcctId" value="<?php echo $merchantAcctId ; ?>" />
            <input type="hidden" name="payerName" value="<?php echo urlencode($payerName) ; ?>" />
            <input type="hidden" name="payerContactType" value="<?php echo $payerContactType ; ?>" />
            <input type="hidden" name="payerContact" value="<?php echo $payerContact ; ?>" />
            <input type="hidden" name="orderId" value="<?php echo $orderId ; ?>" />
            <input type="hidden" name="orderAmount" value="<?php echo $orderAmount ; ?>" />
            <input type="hidden" name="payType" value="<?php echo $payType ; ?>" />
            <input type="hidden" name="fullAmountFlag" value="<?php echo $fullAmountFlag ; ?>" />
            <input type="hidden" name="orderTime" value="<?php echo $orderTime ; ?>" />
            <input type="hidden" name="productName" value="<?php echo urlencode($productName) ; ?>" />
            <input type="hidden" name="productNum" value="<?php echo $productNum ; ?>" />
            <input type="hidden" name="productId" value="<?php echo $productId ; ?>" />
            <input type="hidden" name="productDesc" value="<?php echo urlencode($productDesc) ; ?>" />
            <input type="hidden" name="ext1" value="<?php echo urlencode($ext1) ; ?>" />
            <input type="hidden" name="ext2" value="<?php  echo urlencode($ext2) ; ?>" />
            <input type="hidden" name="signMsg" value="<?php echo $signMsg ; ?>" />
        </form>
        <?php
        break;
    case 9:
        require(__DIR__ . '/source/99bill_telecom_unicom_trade.php');
        ?>
        <form name="order" action="https://www.99bill.com/szxgateway/recvMerchantInfoAction.htm" method="post">
            <input type="hidden" name="inputCharset" value="<?php echo $inputCharset ; ?>" />
            <input type="hidden" name="bgUrl" value="<?php echo $bgUrl ; ?>" />
            <input type="hidden" name="pageUrl" value="<?php echo $pageUrl ; ?>" />
            <input type="hidden" name="version" value="<?php echo $version ; ?>" />
            <input type="hidden" name="language" value="<?php echo $language ; ?>" />
            <input type="hidden" name="signType" value="<?php echo $signType ; ?>" />
            <input type="hidden" name="merchantAcctId" value="<?php echo $merchantAcctId ; ?>" />
            <input type="hidden" name="payerName" value="<?php echo urlencode($payerName) ; ?>" />
            <input type="hidden" name="payerContactType" value="<?php echo $payerContactType ; ?>" />
            <input type="hidden" name="payerContact" value="<?php echo $payerContact ; ?>" />
            <input type="hidden" name="orderId" value="<?php echo $orderId ; ?>" />
            <input type="hidden" name="orderAmount" value="<?php echo $orderAmount ; ?>" />
            <input type="hidden" name="payType" value="<?php echo $payType ; ?>" />
            <input type="hidden" name="fullAmountFlag" value="<?php echo $fullAmountFlag ; ?>" />
            <input type="hidden" name="orderTime" value="<?php echo $orderTime ; ?>" />
            <input type="hidden" name="productName" value="<?php echo urlencode($productName) ; ?>" />
            <input type="hidden" name="productNum" value="<?php echo $productNum ; ?>" />
            <input type="hidden" name="productId" value="<?php echo $productId ; ?>" />
            <input type="hidden" name="productDesc" value="<?php echo urlencode($productDesc) ; ?>" />
            <input type="hidden" name="ext1" value="<?php echo urlencode($ext1) ; ?>" />
            <input type="hidden" name="ext2" value="<?php  echo urlencode($ext2) ; ?>" />
            <input type="hidden" name="bossType" value="<?php  echo $bossType ; ?>">
            <input type="hidden" name="signMsg" value="<?php echo $signMsg ; ?>" />
        </form>
        <?php
        break;
    case 15:
        require(__DIR__ . '/source/99bill_telecom_unicom_trade.php');
        ?>
        <form name="order" action="https://www.99bill.com/szxgateway/recvMerchantInfoAction.htm" method="post">
            <input type="hidden" name="inputCharset" value="<?php echo $inputCharset ; ?>" />
            <input type="hidden" name="bgUrl" value="<?php echo $bgUrl ; ?>" />
            <input type="hidden" name="pageUrl" value="<?php echo $pageUrl ; ?>" />
            <input type="hidden" name="version" value="<?php echo $version ; ?>" />
            <input type="hidden" name="language" value="<?php echo $language ; ?>" />
            <input type="hidden" name="signType" value="<?php echo $signType ; ?>" />
            <input type="hidden" name="merchantAcctId" value="<?php echo $merchantAcctId ; ?>" />
            <input type="hidden" name="payerName" value="<?php echo urlencode($payerName) ; ?>" />
            <input type="hidden" name="payerContactType" value="<?php echo $payerContactType ; ?>" />
            <input type="hidden" name="payerContact" value="<?php echo $payerContact ; ?>" />
            <input type="hidden" name="orderId" value="<?php echo $orderId ; ?>" />
            <input type="hidden" name="orderAmount" value="<?php echo $orderAmount ; ?>" />
            <input type="hidden" name="payType" value="<?php echo $payType ; ?>" />
            <input type="hidden" name="fullAmountFlag" value="<?php echo $fullAmountFlag ; ?>" />
            <input type="hidden" name="orderTime" value="<?php echo $orderTime ; ?>" />
            <input type="hidden" name="productName" value="<?php echo urlencode($productName) ; ?>" />
            <input type="hidden" name="productNum" value="<?php echo $productNum ; ?>" />
            <input type="hidden" name="productId" value="<?php echo $productId ; ?>" />
            <input type="hidden" name="productDesc" value="<?php echo urlencode($productDesc) ; ?>" />
            <input type="hidden" name="ext1" value="<?php echo urlencode($ext1) ; ?>" />
            <input type="hidden" name="ext2" value="<?php  echo urlencode($ext2) ; ?>" />
            <input type="hidden" name="bossType" value="<?php  echo $bossType ; ?>">
            <input type="hidden" name="signMsg" value="<?php echo $signMsg ; ?>" />
        </form>
        <?php
        break;
    case 3:
        require(__DIR__ . '/source/99bill_trade.php');
        ?>
        <form name="order" action="<?php echo $kq_target; ?>"  method="post">
            <input type="hidden" name="inputCharset" value="<?php echo $kq_inputCharset; ?>">
            <input type="hidden" name="pageUrl" value="<?php echo $kq_pageUrl; ?>">
            <input type="hidden" name="bgUrl" value="<?php echo $kq_bgUrl; ?>">
            <input type="hidden" name="version" value="<?php echo $kq_version; ?>">
            <input type="hidden" name="language" value="<?php echo $kq_language; ?>">
            <input type="hidden" name="signType" value="<?php echo $kq_signType; ?>">
            <input type="hidden" name="merchantAcctId" value="<?php echo $kq_merchantAcctId; ?>">
            <input type="hidden" name="payerName" value="<?php echo $kq_payerName; ?>">
            <input type="hidden" name="payerContactType" value="<?php echo $kq_payerContactType; ?>">
            <input type="hidden" name="payerContact" value="<?php echo $kq_payerContact; ?>">
            <input type="hidden" name="orderId" value="<?php echo $kq_orderId; ?>">
            <input type="hidden" name="orderAmount" value="<?php echo $kq_orderAmount; ?>">
            <input type="hidden" name="orderTime" value="<?php echo $kq_orderTime; ?>">
            <input type="hidden" name="productName" value="<?php echo $kq_productName; ?>">
            <input type="hidden" name="productNum" value="<?php echo $kq_productNum; ?>">
            <input type="hidden" name="productId" value="<?php echo $kq_productId; ?>">
            <input type="hidden" name="productDesc" value="<?php echo $kq_productDesc; ?>">
            <input type="hidden" name="ext1" value="<?php echo $kq_ext1; ?>">
            <input type="hidden" name="ext2" value="<?php echo $kq_ext2; ?>">
            <input type="hidden" name="payType" value="<?php echo $kq_payType; ?>">
            <input type="hidden" name="bankId" value="<?php echo $kq_bankId; ?>">
            <input type="hidden" name="redoFlag" value="<?php echo $kq_redoFlag; ?>">
            <input type="hidden" name="pid" value="<?php echo $kq_pid; ?>">
            <input type="hidden" name="signMsg" value="<?php echo $kq_sign_msg; ?>">
        </form>
        <?php
        break;
    case 31:
        mysql_query("insert into pay_QQmobile (customerid,sd51no,orderid,ordermoney,realmoney,pay_date,user_name) values('153692','','{$row->orderid}',{$row->money},".($row->money * 0.98).",now(),'{$row->user}')");
        ?>
        <form name="order" action="http://www.zhifuka.net/gateway/QQpay/QQpay.asp" method="post">
            <input type="hidden" name="customerid" value="153692" />
            <input type="hidden" name="sdcustomno" value="<?php echo $row->orderid ; ?>" />
            <input type="hidden" name="orderAmount" value="<?php echo $row->money*100 ; ?>" />
            <input type="hidden" name="cardno" value="36" />
            <input type="hidden" name="noticeurl" value="http://pay.demo.com/api/QQmobile_notice.php" />
            <input type="hidden" name="backurl" value="http://pay.demo.com/api/QQmobile_back.php?orderid=<?php echo $row->orderid ;?>" />
            <input type="hidden" name="sign" value="<?php echo strtoupper(md5('customerid=153692&sdcustomno='.$row->orderid.'&orderAmount='.($row->money*100).'&cardno=36&noticeurl=http://pay.demo.com/api/QQmobile_notice.php&backurl=http://pay.demo.com/api/QQmobile_back.php?orderid='.$row->orderid.'123'));?>" />
            <input type="hidden" name="mark" value="91yxq" />
        </form>
        <?php
        break;
    case 14:
        require(__DIR__ . '/source/99bill_telecom_unicom_trade.php');
        ?>
        <form name="order" action="https://www.99bill.com/szxgateway/recvMerchantInfoAction.htm" method="post">
            <input type="hidden" name="inputCharset" value="<?php echo $inputCharset ; ?>" />
            <input type="hidden" name="bgUrl" value="<?php echo $bgUrl ; ?>" />
            <input type="hidden" name="pageUrl" value="<?php echo $pageUrl ; ?>" />
            <input type="hidden" name="version" value="<?php echo $version ; ?>" />
            <input type="hidden" name="language" value="<?php echo $language ; ?>" />
            <input type="hidden" name="signType" value="<?php echo $signType ; ?>" />
            <input type="hidden" name="merchantAcctId" value="<?php echo $merchantAcctId ; ?>" />
            <input type="hidden" name="payerName" value="<?php echo urlencode($payerName) ; ?>" />
            <input type="hidden" name="payerContactType" value="<?php echo $payerContactType ; ?>" />
            <input type="hidden" name="payerContact" value="<?php echo $payerContact ; ?>" />
            <input type="hidden" name="orderId" value="<?php echo $orderId ; ?>" />
            <input type="hidden" name="orderAmount" value="<?php echo $orderAmount ; ?>" />
            <input type="hidden" name="payType" value="<?php echo $payType ; ?>" />
            <input type="hidden" name="fullAmountFlag" value="<?php echo $fullAmountFlag ; ?>" />
            <input type="hidden" name="orderTime" value="<?php echo $orderTime ; ?>" />
            <input type="hidden" name="productName" value="<?php echo urlencode($productName) ; ?>" />
            <input type="hidden" name="productNum" value="<?php echo $productNum ; ?>" />
            <input type="hidden" name="productId" value="<?php echo $productId ; ?>" />
            <input type="hidden" name="productDesc" value="<?php echo urlencode($productDesc) ; ?>" />
            <input type="hidden" name="ext1" value="<?php echo urlencode($ext1) ; ?>" />
            <input type="hidden" name="ext2" value="<?php  echo urlencode($ext2) ; ?>" />
            <input type="hidden" name="bossType" value="<?php  echo $bossType ; ?>">
            <input type="hidden" name="signMsg" value="<?php echo $signMsg ; ?>" />
        </form>
        <?php
        break;
    case 32:
        $date = date('YmdHis');
        $ip = str_replace('.','_',$user_ip);
        mysql_query("insert into pay_hfb (agent_id,orderid,pay_type,pay_amt,user_name,pay_date) values('1956836','{$row->orderid}','10',{$row->money},'{$row->user}',now())");
        ?>
        <form name="order" action="https://pay.heepay.com/Payment/Index.aspx" method="post">
            <input name='version'  type=hidden  value="1" />
            <input name='pay_type'  type=hidden  value="10" />
            <input name='agent_id'  type=hidden  value="1956836" />
            <input name='agent_bill_id'  type=hidden  value="<?php echo $order;?>" />
            <input name='pay_amt'  type=hidden  value="<?php echo $row -> money;?>" />
            <input name='notify_url'  type=hidden  value="http://pay.demo.com/api/hfb_notify.php" />
            <input name='return_url'  type=hidden  value="http://pay.demo.com/api/hfb_return.php" />
            <input name='user_ip'  type=hidden  value="<?php echo $ip;?>" />
            <input name='agent_bill_time'  type=hidden  value="<?php echo $date;?>" />
            <input name='goods_name'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='remark'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='sign'  type=hidden  value="<?php echo md5("version=1&agent_id=1956836&agent_bill_id={$order}&agent_bill_time={$date}&pay_type=10&pay_amt={$row -> money}&notify_url=http://pay.demo.com/api/hfb_notify.php&return_url=http://pay.demo.com/api/hfb_return.php&user_ip={$ip}&key=123");?>" />
        </form>
        <?php
        break;
    case 33:
        $date = date('YmdHis');
        $ip = str_replace('.','_',$user_ip);
        mysql_query("insert into pay_hfb (agent_id,orderid,pay_type,pay_amt,user_name,pay_date) values('1956836','{$row->orderid}','20',{$row->money},'{$row->user}',now())");
        ?>
        <form name="order" action="https://pay.heepay.com/Payment/Index.aspx" method="post">
            <input name='version'  type=hidden  value="1" />
            <input name='pay_type'  type=hidden  value="20" />
            <input name='pay_code'  type=hidden  value="0" />
            <input name='agent_id'  type=hidden  value="1956836" />
            <input name='agent_bill_id'  type=hidden  value="<?php echo $order;?>" />
            <input name='pay_amt'  type=hidden  value="<?php echo $row -> money;?>" />
            <input name='notify_url'  type=hidden  value="http://pay.demo.com/api/hfb_notify.php" />
            <input name='return_url'  type=hidden  value="http://pay.demo.com/api/hfb_return.php" />
            <input name='user_ip'  type=hidden  value="<?php echo $ip;?>" />
            <input name='agent_bill_time'  type=hidden  value="<?php echo $date;?>" />
            <input name='goods_name'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='remark'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='sign'  type=hidden  value="<?php echo md5("version=1&agent_id=1956836&agent_bill_id={$order}&agent_bill_time={$date}&pay_type=20&pay_amt={$row -> money}&notify_url=http://pay.demo.com/api/hfb_notify.php&return_url=http://pay.demo.com/api/hfb_return.php&user_ip={$ip}&key=123");?>" />
        </form>
        <?php
        break;
    case 34:
        $date = date('YmdHis');
        $ip = str_replace('.','_',$user_ip);
        mysql_query("insert into pay_hfb (agent_id,orderid,pay_type,pay_amt,user_name,pay_date) values('1956836','{$row->orderid}','18',{$row->money},'{$row->user}',now())");
        ?>
        <form name="order" action="https://pay.heepay.com/Payment/Index.aspx" method="post">
            <input name='version'  type=hidden  value="1" />
            <input name='pay_type'  type=hidden  value="18" />
            <input name='agent_id'  type=hidden  value="1956836" />
            <input name='agent_bill_id'  type=hidden  value="<?php echo $order;?>" />
            <input name='pay_amt'  type=hidden  value="<?php echo $row -> money;?>" />
            <input name='notify_url'  type=hidden  value="http://pay.demo.com/api/hfb_notify.php" />
            <input name='return_url'  type=hidden  value="http://pay.demo.com/api/hfb_return.php" />
            <input name='user_ip'  type=hidden  value="<?php echo $ip;?>" />
            <input name='agent_bill_time'  type=hidden  value="<?php echo $date;?>" />
            <input name='goods_name'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='remark'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='sign'  type=hidden  value="<?php echo md5("version=1&agent_id=1956836&agent_bill_id={$order}&agent_bill_time={$date}&pay_type=18&pay_amt={$row -> money}&notify_url=http://pay.demo.com/api/hfb_notify.php&return_url=http://pay.demo.com/api/hfb_return.php&user_ip={$ip}&key=123");?>" />
        </form>
        <?php
        break;
    case 35:
        $date = date('YmdHis');
        $ip = str_replace('.','_',$user_ip);
        mysql_query("insert into pay_hfb (agent_id,orderid,pay_type,pay_amt,user_name,pay_date) values('1956836','{$row->orderid}','13',{$row->money},'{$row->user}',now())");
        ?>
        <form name="order" action="https://pay.heepay.com/Payment/Index.aspx" method="post">
            <input name='version'  type=hidden  value="1" />
            <input name='pay_type'  type=hidden  value="13" />
            <input name='agent_id'  type=hidden  value="1956836" />
            <input name='agent_bill_id'  type=hidden  value="<?php echo $order;?>" />
            <input name='pay_amt'  type=hidden  value="<?php echo $row -> money;?>" />
            <input name='notify_url'  type=hidden  value="http://pay.demo.com/api/hfb_notify.php" />
            <input name='return_url'  type=hidden  value="http://pay.demo.com/api/hfb_return.php" />
            <input name='user_ip'  type=hidden  value="<?php echo $ip;?>" />
            <input name='agent_bill_time'  type=hidden  value="<?php echo $date;?>" />
            <input name='goods_name'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='remark'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='sign'  type=hidden  value="<?php echo md5("version=1&agent_id=1956836&agent_bill_id={$order}&agent_bill_time={$date}&pay_type=13&pay_amt={$row -> money}&notify_url=http://pay.demo.com/api/hfb_notify.php&return_url=http://pay.demo.com/api/hfb_return.php&user_ip={$ip}&key=123");?>" />
        </form>
        <?php
        break;
    case 36:
        $date = date('YmdHis');
        $ip = str_replace('.','_',$user_ip);
        mysql_query("insert into pay_hfb (agent_id,orderid,pay_type,pay_amt,user_name,pay_date) values('1956836','{$row->orderid}','14',{$row->money},'{$row->user}',now())");
        ?>
        <form name="order" action="https://pay.heepay.com/Payment/Index.aspx" method="post">
            <input name='version'  type=hidden  value="1" />
            <input name='pay_type'  type=hidden  value="14" />
            <input name='agent_id'  type=hidden  value="1956836" />
            <input name='agent_bill_id'  type=hidden  value="<?php echo $order;?>" />
            <input name='pay_amt'  type=hidden  value="<?php echo $row -> money;?>" />
            <input name='notify_url'  type=hidden  value="http://pay.demo.com/api/hfb_notify.php" />
            <input name='return_url'  type=hidden  value="http://pay.demo.com/api/hfb_return.php" />
            <input name='user_ip'  type=hidden  value="<?php echo $ip;?>" />
            <input name='agent_bill_time'  type=hidden  value="<?php echo $date;?>" />
            <input name='goods_name'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='remark'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='sign'  type=hidden  value="<?php echo md5("version=1&agent_id=1956836&agent_bill_id={$order}&agent_bill_time={$date}&pay_type=14&pay_amt={$row -> money}&notify_url=http://pay.demo.com/api/hfb_notify.php&return_url=http://pay.demo.com/api/hfb_return.php&user_ip={$ip}&key=123");?>" />
        </form>
        <?php
        break;
    case 37:
        $date = date('YmdHis');
        $ip = str_replace('.','_',$user_ip);
        mysql_query("insert into pay_hfb (agent_id,orderid,pay_type,pay_amt,user_name,pay_date) values('1956836','{$row->orderid}','15',{$row->money},'{$row->user}',now())");
        ?>
        <form name="order" action="https://pay.heepay.com/Payment/Index.aspx" method="post">
            <input name='version'  type=hidden  value="1" />
            <input name='pay_type'  type=hidden  value="15" />
            <input name='agent_id'  type=hidden  value="1956836" />
            <input name='agent_bill_id'  type=hidden  value="<?php echo $order;?>" />
            <input name='pay_amt'  type=hidden  value="<?php echo $row -> money;?>" />
            <input name='notify_url'  type=hidden  value="http://pay.demo.com/api/hfb_notify.php" />
            <input name='return_url'  type=hidden  value="http://pay.demo.com/api/hfb_return.php" />
            <input name='user_ip'  type=hidden  value="<?php echo $ip;?>" />
            <input name='agent_bill_time'  type=hidden  value="<?php echo $date;?>" />
            <input name='goods_name'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='remark'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='sign'  type=hidden  value="<?php echo md5("version=1&agent_id=1956836&agent_bill_id={$order}&agent_bill_time={$date}&pay_type=15&pay_amt={$row -> money}&notify_url=http://pay.demo.com/api/hfb_notify.php&return_url=http://pay.demo.com/api/hfb_return.php&user_ip={$ip}&key=123");?>" />
        </form>
        <?php
        break;
    case 46:
        $time = time();
        mysql_query("insert into pay_jct (orderid,pay_date,money,paid_amount) values ('{$row->orderid}',{$time},{$row->money},{$row->paid_amount})");
        ?>
        <form name="order" action="http://pay.demo.com/wx/wxpay.php" method="post">
            <input name='merchantId'  type=hidden  value="188001000236391" />
            <input name='out_trade_no'  type=hidden  value="<?php echo $row->orderid ; ?>" />
            <input type="hidden" name="total_fee" value="<?php echo bcmul($row->money, 100); ?>" />
            <input type="hidden" name="sub_mch_notify_url" value="http://pay.demo.com/api/jct_notify.php" />
            <input type="hidden" name="body" value="91yxq游戏充值-91yxq" />
            <input type="hidden" name="nonce_str" value="GEMU-91yxq" />
            <input type="hidden" name="money" value="<?php echo $row->money;?>" />
            <input type="hidden" name="time" value="<?php echo $time;?>" />
            <input type="hidden" name="sign" value="<?php echo strtoupper(md5("body=91yxq游戏充值-91yxq&merchantId=188001000236391&nonce_str=GEMU-91yxq&out_trade_no={$row->orderid}&sub_mch_notify_url=http://pay.demo.com/api/jct_notify.php&total_fee=" . bcmul($row->money, 100) . "&key=123"));?>" />
        </form>
        <?php
        break;
}
?>
</body>
