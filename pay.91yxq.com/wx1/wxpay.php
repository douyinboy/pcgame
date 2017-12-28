<?php
require_once "../wx/lib/WxPay.Api.php";

! $_POST && exit(header('location:http://pay.91yxq.com'));
$total_fee = $_POST['total_fee'];
$time = $_POST['time'];
$body = $_POST['body'];
$id = $_POST['id'];
$nonce_str = $_POST['nonce_str'];
$out_trade_no = $_POST['out_trade_no'];
//$post_arr = http_build_query($_POST);
//$ch = curl_init('http://pay.paytend.com/api/wxpay/pc_pay.htm');
//curl_setopt($ch, CURLOPT_POST, true);
//curl_setopt($ch, CURLOPT_POSTFIELDS, $post_arr);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_HEADER, false);
//curl_setopt($ch, CURLOPT_TIMEOUT, 8);
//$result = json_decode(curl_exec($ch), true);    //这个是读到的值
//curl_close($ch);
//unset($ch);
//$result['return_code'] !== 'SUCCESS' && exit(header('location:http://pay.91yxq.com'));
//define('IMG', 'wximages/');
//$img = IMG . $result['out_trade_no'] . '.png';
//if (! file_exists(IMG . $result['out_trade_no'] . '.png')) {
//	require('phpqrcode.php');
//	QRcode::png($result['code_url'], IMG . $result['out_trade_no'] . '.png', "L", 4);
//}

$input = new WxPayUnifiedOrder();
$input->SetBody($body);
$input->SetAttach($body);
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee($out_trade_no);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("");
$input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
$input->SetTrade_type("NATIVE");
$input->SetProduct_id($id);
$result = $notify->GetPayUrl($input);
$url2 = $result["code_url"];
?>
<!DOCTYPE html PUBliC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网页游戏平台充值中心,91yxq充值中心,91yxq网页游戏平台</title>
<link type="text/css" rel="stylesheet" href="css/main_pq.css" />
<script type="text/javascript" src="http://image.91yxq.com/index4/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="http://image.91yxq.com/index4/js/index4Top.js"></script>

</head>

<body onload="Javascript:sys_set();">

<div class="head">
	<div class="m1100">
        <a href="index.html" class="fl logo">7gwan</a>
        <!--导航-->
        <div class="fr nav">
            <a href="http://www.91yxq.com/index.html">首页</a>
            <a href="http://www.91yxq.com/games/index.html">游戏大厅</a>
            <a href="http://www.91yxq.com/my.php">用户中心</a>
            <a href="http://pay.91yxq.com/">充值中心</a>
            <a href="http://www.91yxq.com/news/index.html">新闻中心</a>
            <a href="http://www.91yxq.com/kfzx/index.html">客服中心</a>
        </div>
	</div>
</div>

<!--主内容-->
<div class="m1100">
    <div class="location">您当前的位置：<a href="http://www.91yxq.com/index.html">首页</a><sapn class="arrow"> &gt; </sapn><a href="http://pay.91yxq.com/">充值中心</a><sapn class="arrow"> &gt; </sapn><span class="orange">微信支付</span></div>
    <div class="m_box p20">
		<style>

        </style>
        <div class="saul_pay_box clearfix">
            <div class="fl">
                <div class="saul_p"><img src="<?php echo $img;?>" /></div>
                <div class="saul_msg">
                    <span class="icon_saul"></span>
                    <span>请使用微信扫描<br />
                    二维码完成支付</span>
                </div>
            </div>

            <div class="fl wx_list">
                <ul>
                    <li><label>支付金额：</label><span class="money">￥<?php echo $money;?></span></li>
                    <li><label>商户名称：</label>广东奇趣网络科技有限公司 91yxq</li>
                    <li><label>订单号：</label><a id="orderid" href="javascript:void(0);"><?php echo $result['out_trade_no'];?></a></li>
                    <li><label>创建时间：</label><?php echo date('Y-m-d H:i:s', $time);?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="cl"></div>
<!--页脚-->
<script type="text/javascript" src="http://image.91yxq.com/index4/js/footer.js"></script>
<script type="text/javascript">
function sys_set(){
	window.setInterval(check_pay, 3000);
	window.setTimeout(out_turn, 60000);
}
function out_turn(){
	var turn_orderid = $('#orderid').html();
	window.location.href = 'http://pay.91yxq.com/pay_to_show.php?orderid=' + turn_orderid;
}
function check_pay(){
	var check_orderid = $('#orderid').html();
	$.ajax({
        type:"get",
        url:'http://pay.91yxq.com/api/check_wx_pay.php?orderid=' + check_orderid,
        dataType:'text',
        success:function(data){
            switch(data){
                case 'ok':
                    window.location.href = 'http://pay.91yxq.com/pay_to_show.php?orderid=' + check_orderid;
                    break;
                default :
                    break;
            }
        },
        error:function()
        {
            return false;
        }
    });

}
</script>
</body>
</html>