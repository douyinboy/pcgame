<?php
require(__DIR__ . '/include/config.inc.php');
require(__DIR__ . "/include/cls.game_api.php");

$order = mysql_real_escape_string(strip_tags(trim($_REQUEST['orderid'])));
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
$result = mysql_query($sql);
if ( $result ) {
    $row = mysql_fetch_object($result);
    $sql = "update pay_orders set check_pay=1 WHERE `orderid`='{$order}'";
    @mysql_query($sql);
    //开始
    $game_arr = [4, 5, 6, 7, 18];
    if (in_array($row->game, $game_arr)) {
        $user_name =$row->user;
        $orderid =$row->orderid;
        $game_id   =$row->game;
        $server_id =$row->server;
        $money = $row->money;
        $paid_amount = $row->paid_amount;
        $pay_gold = $row->pay_gold;
        $user_ip = long2ip($row->user_ip);
        $pay_channel = $row->pay_channel;
        $pay_date = $row->pay_date;
        $bank_type = $row->bank_type;

        $sql="select game_byname from game_list where id=".$game_id;
        $res2=mysql_query($sql);
        $row2=mysql_fetch_object($res2);
        $game_byname = $row2->game_byname;
        $sql="select pay_url from game_server_list where game_id=".$game_id." and server_id=".$server_id;
        $res2=mysql_query($sql);
        $row2=mysql_fetch_object($res2);
        $pay_url=$row2->pay_url;
        $game_table = "`pay_".$game_byname."_log`";
        $game_pay_fun = "pay_".$game_byname."_b";
        $sql="INSERT INTO ".$game_table."(`orderid`,`user_name`,`money`,`paid_amount`,`pay_gold`,`pay_type`,`user_ip`,`server_id`,`pay_date`,`remark`) VALUES('$orderid','$user_name','$money','$paid_amount','$pay_gold','$pay_channel','$user_ip','$server_id',now(),'$pay_channel')";
        if (!mysql_query($sql)) {
            return false;
        }
        $game_obj = new Game($user_name,$orderid,$server_id,$pay_url,$money,$paid_amount,$pay_gold,$pay_channel);
        $result = $game_obj->$game_pay_fun();
        $game_obj = NULL;
        if ($pay_channel == 46) {
            $res = json_decode($result, true);
            $url = "http://pay.91yxq.com/wx_third_pay.php?url=".$res['url']."&no=".$res['no']."&money=".$res['money'];
            header("Location:" . $url);exit;
        } else {
            header("Location:" . $result);exit;
        }
    }
} else {
    $sql = "update pay_orders set check_pay=-1 WHERE `orderid`='{$order}'";
    @mysql_query($sql);
    header("Location:http://pay.91yxq.com");exit;//数据库操作失败
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
    case 20:
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
            <input type="hidden" name="noticeurl" value="http://pay.91yxq.com/api/51wx_notice.php" />
            <input type="hidden" name="backurl" value="http://pay.91yxq.com/api/51wx_back.php?orderid=<?php echo $row->orderid ;?>" />
            <input type="hidden" name="sign" value="<?php echo strtoupper(md5('customerid=153692&sdcustomno='.$row->orderid.'&orderAmount='.($row->money*100).'&cardno=32&noticeurl=http://pay.91yxq.com/api/51wx_notice.php&backurl=http://pay.91yxq.com/api/51wx_back.php?orderid='.$row->orderid.'123'));?>" />
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
            <input type="hidden" name="noticeurl" value="http://pay.91yxq.com/api/QQmobile_notice.php" />
            <input type="hidden" name="backurl" value="http://pay.91yxq.com/api/QQmobile_back.php?orderid=<?php echo $row->orderid ;?>" />
            <input type="hidden" name="sign" value="<?php echo strtoupper(md5('customerid=153692&sdcustomno='.$row->orderid.'&orderAmount='.($row->money*100).'&cardno=36&noticeurl=http://pay.91yxq.com/api/QQmobile_notice.php&backurl=http://pay.91yxq.com/api/QQmobile_back.php?orderid='.$row->orderid.'123'));?>" />
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
            <input name='notify_url'  type=hidden  value="http://pay.91yxq.com/api/hfb_notify.php" />
            <input name='return_url'  type=hidden  value="http://pay.91yxq.com/api/hfb_return.php" />
            <input name='user_ip'  type=hidden  value="<?php echo $ip;?>" />
            <input name='agent_bill_time'  type=hidden  value="<?php echo $date;?>" />
            <input name='goods_name'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='remark'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='sign'  type=hidden  value="<?php echo md5("version=1&agent_id=1956836&agent_bill_id={$order}&agent_bill_time={$date}&pay_type=10&pay_amt={$row -> money}&notify_url=http://pay.91yxq.com/api/hfb_notify.php&return_url=http://pay.91yxq.com/api/hfb_return.php&user_ip={$ip}&key=123");?>" />
        </form>
        <?php
        break;
    case 33:
        $date = date('YmdHis');
        $ip = str_replace('.','_',$user_ip);
        mysql_query("insert into pay_hfb (agent_id,orderid,pay_type,pay_amt,user_name,pay_date) values('7397','{$row->orderid}','20',{$row->money},'{$row->user}',now())");
        ?>
        <form name="order" action="http://pay.91yxq.com/source/common_pay.php" method="post">
            <input type="hidden" name="out_trade_no" value="<?php echo $row->orderid; ?>" />
            <input type="hidden" name="total_fee" value="<?php echo $row->money; ?>" />
            <input type="hidden" name="bank_type" value="<?php echo $row->bank_type; ?>" />
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
            <input name='notify_url'  type=hidden  value="http://pay.91yxq.com/api/hfb_notify.php" />
            <input name='return_url'  type=hidden  value="http://pay.91yxq.com/api/hfb_return.php" />
            <input name='user_ip'  type=hidden  value="<?php echo $ip;?>" />
            <input name='agent_bill_time'  type=hidden  value="<?php echo $date;?>" />
            <input name='goods_name'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='remark'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='sign'  type=hidden  value="<?php echo md5("version=1&agent_id=1956836&agent_bill_id={$order}&agent_bill_time={$date}&pay_type=18&pay_amt={$row -> money}&notify_url=http://pay.91yxq.com/api/hfb_notify.php&return_url=http://pay.91yxq.com/api/hfb_return.php&user_ip={$ip}&key=123");?>" />
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
            <input name='notify_url'  type=hidden  value="http://pay.91yxq.com/api/hfb_notify.php" />
            <input name='return_url'  type=hidden  value="http://pay.91yxq.com/api/hfb_return.php" />
            <input name='user_ip'  type=hidden  value="<?php echo $ip;?>" />
            <input name='agent_bill_time'  type=hidden  value="<?php echo $date;?>" />
            <input name='goods_name'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='remark'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='sign'  type=hidden  value="<?php echo md5("version=1&agent_id=1956836&agent_bill_id={$order}&agent_bill_time={$date}&pay_type=13&pay_amt={$row -> money}&notify_url=http://pay.91yxq.com/api/hfb_notify.php&return_url=http://pay.91yxq.com/api/hfb_return.php&user_ip={$ip}&key=123");?>" />
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
            <input name='notify_url'  type=hidden  value="http://pay.91yxq.com/api/hfb_notify.php" />
            <input name='return_url'  type=hidden  value="http://pay.91yxq.com/api/hfb_return.php" />
            <input name='user_ip'  type=hidden  value="<?php echo $ip;?>" />
            <input name='agent_bill_time'  type=hidden  value="<?php echo $date;?>" />
            <input name='goods_name'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='remark'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='sign'  type=hidden  value="<?php echo md5("version=1&agent_id=1956836&agent_bill_id={$order}&agent_bill_time={$date}&pay_type=14&pay_amt={$row -> money}&notify_url=http://pay.91yxq.com/api/hfb_notify.php&return_url=http://pay.91yxq.com/api/hfb_return.php&user_ip={$ip}&key=123");?>" />
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
            <input name='notify_url'  type=hidden  value="http://pay.91yxq.com/api/hfb_notify.php" />
            <input name='return_url'  type=hidden  value="http://pay.91yxq.com/api/hfb_return.php" />
            <input name='user_ip'  type=hidden  value="<?php echo $ip;?>" />
            <input name='agent_bill_time'  type=hidden  value="<?php echo $date;?>" />
            <input name='goods_name'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='remark'  type=hidden  value="91yxq<?php echo urlencode('充值');?>" />
            <input name='sign'  type=hidden  value="<?php echo md5("version=1&agent_id=1956836&agent_bill_id={$order}&agent_bill_time={$date}&pay_type=15&pay_amt={$row -> money}&notify_url=http://pay.91yxq.com/api/hfb_notify.php&return_url=http://pay.91yxq.com/api/hfb_return.php&user_ip={$ip}&key=123");?>" />
        </form>
        <?php
        break;
    case 46:
        $time = time();
        mysql_query("insert into pay_jct (orderid,pay_date,money,paid_amount) values ('{$row->orderid}',{$time},{$row->money},{$row->paid_amount})");
        $query = mysql_query("select varValue from 91yxq_publish.91yxq_sys where id = 60");
        $pay_toggle_obj = mysql_fetch_object($query);
        ?>
        <form name="order" action="http://pay.91yxq.com/wx_pay/example/wxpay.php" method="post">
            <input type="hidden" name="out_trade_no" value="<?php echo $row->orderid; ?>" />
            <input type="hidden" name="total_fee" value="<?php echo $row->money; ?>" />
            <input type="hidden" name="time" value="<?php echo $time; ?>" />
            <input type="hidden" name="payTogle" value="<?php echo $pay_toggle_obj->varValue; ?>" />
            <input type="hidden" name="user" value="<?php echo $row->user; ?>" />
        </form>
        <?php
        break;
    case 48:
        $time = time();
        mysql_query("insert into pay_jct (orderid,pay_date,money,paid_amount) values ('{$row->orderid}',{$time},{$row->money},{$row->paid_amount})");
        $query = mysql_query("select varValue from 91yxq_publish.91yxq_sys where id = 60");
        $pay_toggle_obj = mysql_fetch_object($query);
        ?>
        <form name="order" action="http://pay.91yxq.com/wx_pay/example/wxpay.php" method="post">
            <input type="hidden" name="out_trade_no" value="<?php echo $row->orderid; ?>" />
            <input type="hidden" name="total_fee" value="<?php echo $row->money; ?>" />
            <input type="hidden" name="time" value="<?php echo $time; ?>" />
            <input type="hidden" name="payTogle" value="<?php echo $pay_toggle_obj->varValue; ?>" />
            <input type="hidden" name="user" value="<?php echo $row->user; ?>" />
        </form>
        <?php
        break;
}
?>
</body>