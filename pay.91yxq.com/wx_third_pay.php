<?php
!$_GET && exit(header('location:http://pay.91yxq.com'));
$out_trade_no = $_GET['no'];
$total_fee = $_GET['money'];
$url2 = $_GET['url'];
$time = time();

?>
<!DOCTYPE html PUBliC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>网页游戏平台充值中心,91yxq充值中心,91yxq网页游戏平台</title>
    <link type="text/css" rel="stylesheet" href="http://pay.91yxq.com/wx_pay/example/css/main_pq.css" />
    <script type="text/javascript" src="http://image.91yxq.com/js/jquery-1.10.2.min.js"></script>
    <!--<script type="text/javascript" src="http://image.91yxq.com/index4/js/index4Top.js"></script>-->

</head>

<body onload="Javascript:sys_set();">

<div class="head">
    <div class="m1100">
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
                <div class="saul_p"><img alt="扫码支付" src="http://pay.91yxq.com/wx_pay/example/qrcode.php?data=<?php echo urlencode($url2);?>" /></div>
                <div class="saul_msg">
                    <span class="icon_saul"></span>
                    <span>请使用微信扫描<br />
                    二维码完成支付</span>
                </div>
            </div>
            <div class="fl wx_list">
                <ul>
                    <li><label>支付金额：</label><span class="money">￥<?php echo $total_fee;?></span></li>
                    <!--                    <li><label>商户名称：</label>南京魔苹网络科技有限公司</li>-->
                    <li><label>订单号：</label><a id="orderid" href="javascript:void(0);"><?php echo $out_trade_no;?></a></li>
                    <li><label>创建时间：</label><?php echo date('Y-m-d H:i:s', $time);?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="cl"></div>

<!--页脚-->
<!--<script type="text/javascript" src="http://image.91yxq.com/index4/js/footer.js"></script>-->
<script type="text/javascript">

    function sys_set(){
        window.setInterval(check_pay, 3000);
    }

    function check_pay(){
        var check_orderid = $('#orderid').html();
        $.ajax({
            type:"get",
            url:'http://pay.91yxq.com/api/check_wx_third_pay.php?orderid=' + check_orderid,
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