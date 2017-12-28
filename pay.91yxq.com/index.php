<?php
require(__DIR__ . '/source/games_str.php');
require(__DIR__ . '/source/agent_rate.php');
$user_name = trim(urldecode($_GET['user_name']));
$game_id = $_REQUEST['game_id'] + 0;
$server_id = $_REQUEST['server_id'] + 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网页游戏平台充值中心,91yxq充值中心,91yxq网页游戏平台</title>
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<link type="text/css" rel="stylesheet" href="http://image.91yxq.com/css/www/base.css" />
<link type="text/css" rel="stylesheet" href="http://image.91yxq.com/css/www/public.css" />
<link type="text/css" rel="stylesheet" href="http://image.demo.com/css/www/main_pq.css" />
<script type="text/javascript" src="http://image.91yxq.com/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
document.domain = 'demo.com';
</script>
</head>
<body>
<form action="pay_to_channel.php" method="GET" autocomplete="off" target="_blank">
<div class="popup_box pay_info_box" style="display:none;" id="pay_info">
	<a href="javascript:void(0);" class="popup_close" onclick="$('.popup_box').hide();$('.popup_bg').hide();"></a>
    <div class="hd_title"><h2>充值确认信息</h2></div>
    <ul class="pay_info">
        <li><label>充值的方式：</label><div class="rc" id="confirm_payway">网上银行(汇付宝)</div></li>
        <li><label>充值的游戏：</label><div class="rc" id="confirm_gamename">XXXXXXXX</div></li>
        <li><label> 充值的区服：</label><div class="rc"><span class="red" id="confirm_servername">XXXXXXXX</span></div></li>
        <li><label>订单编号：</label><div class="rc" id="confirm_orderid">XXXXXXXX</div></li>
        <li><label>充值号账号：</label><div class="rc"><span class="red" id="confirm_username">XXX<?=$user_name?></span></div></li>
        <li><label>充值金额：</label><div class="rc"><span class="red" id="confirm_money">10元</span></div></li>
        <li><label>充值所得：</label><div class="rc"><span class="red" id="confirm_gameb">XXXX</span></div></li>
    </ul>
    <div class="tc mb20"><a href="javascript:void(0);" onclick="$('form').submit();" class="game_btn1 mr20">确认提交</a><a href="Javascript:void(0);" class="game_btn3" onclick="$('.popup_box').hide();$('.popup_bg').hide();">返回修改</a></div>
</div>
<div class="popup_bg" style="display:none;"></div>

<!---头部-->
<div class="head">
	<div id="platform_top_div" class="m1200">
        <a href="index.html" class="logo"></a>

        <!--导航-->
        <div class="nav">
            <a href="http://www.91yxq.com/index.html">首页</a>
            <a href="http://www.91yxq.com/games/index.html" >游戏大厅</a>
            <a href="http://www.91yxq.com/user.php">用户中心</a>
            <a href="http://pay.91yxq.com" class="on">充值中心</a>
            <a href="http://www.91yxq.com/news/index.html" >新闻中心</a>
            <a href="http://www.91yxq.com/help/index.html" >客服中心</a>
        </div>

        <!--游戏列表;登录注册按钮或登录后用户名js-->
		<script src="http://www.demo.com/public/www_top.js"></script>

    </div>
</div>

<!--主内容-->
<div class="m1200">
	<div class="m_box2 mt40 pay_box_bg clearfix">
        <div id="myTab1" class="fl pay_nav">
			<!-- <div class="li_a" id="pay_way_1" onmousedown="turnToPay(1);">网上银行(快钱)</div> -->
            <div class="li_a" id="pay_way_33" onmousedown="turnToPay(33);">网上银行(汇付宝)</div>
            <div class="li_o" id="pay_way_18" onmousedown="turnToPay(18);">支付宝(余额+快捷支付)</div>
            <div class="li_o" id="pay_way_46" onmousedown="turnToPay(46);">微信支付</div>
            <!--<div class="li_o" onmousedown="turnToPay(9);">人工充值汇款</div>-->
        </div>
        <div class="fl w880">
        	<div>
                <div class="pay_title">当前选中的是<span class="red" id="pay_name">网上银行(汇付宝)</span>充值方式</div>
                <div class="pay_fill">
                    <ul>
                        <li class="clearfix">
                            <label>充值到：</label>
                            <div class="rbox">
                                <div class="pay_tab"><a href="javascript:void(0);" class="on">充值到游戏</a></div>
                            </div>
                        </li>
                        <li class="clearfix">
							<label>充值账号：</label>
							<div class="rbox" id="sure_user"><input name="username" type="text" id="username" value="" class="input_t" style="width:258px"><a href="javascript:void(0)" class="f14 red ml10" id="define_user">【确认】</a></div>
							<div class="rbox" id="besure_user" style="display:none;font-size: 14px;line-height: 40px;"><span id="login_account"></span><a href="javascript:void(0)" class="f14 red ml10" id="change_user">【更改】</a></div>
						</li>
                        <li class="clearfix">
                            <label>选择游戏：</label>
                            <div class="rbox">
                                <div class="fl pay_drop">
                                    <a class="pay_arrow" onclick="showGameList();" href="javascript:void(0)"><span class="arrow"><i></i></span><span class="t" id="show_game_name">充值的游戏</span></a>
                                    <div class="pay_drop_box" id="game_list" style="display:none">
                                        <div class="arrow"></div>
                                        <div class="title"><h2>选择游戏</h2><div class="fr"><input name="game_keyword" type="text" id="game_keyword" value="输入游戏拼音简写" class="input_txt"></div></div>
                                        <div class="txt">
                                            <a href="javascript:void(0);">醉武侠</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="fl pay_drop">
                                    <a class="pay_arrow" href="javascript:void(0)" onclick="changeServer();"><span class="arrow"><i></i></span><span class="t" id="show_server_name">游戏服务器</span></a>
                                    <div class="pay_drop_box" id="server_list" style="display:none">
                                        <div class="arrow"></div>
                                        <div class="title"><h2>游戏服务器</h2><div class="fr"><input name="server_keyword" type="text" id="server_keyword" value="输入游戏区服ID简写" class="input_txt"></div></div>
                                        <div class="txt">
                                            <a href="javascript:void(0);">双线X服</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="clearfix">
                            <label>选择金额：</label>
                            <div class="rbox">
                                <div class="option_item clearfix" id="select_money">
                                    <dl>
                                        <dd>
                                            <i class="imgpq"></i>
                                            <font>10元</font>
                                        </dd>
                                        <dd>
                                            <i class="imgpq"></i>
                                            <font>30元</font>
                                        </dd>
                                        <dd>
                                            <i class="imgpq"></i>
                                            <font>50元</font>
                                        </dd>
                                        <dd class="option_on">
                                            <i class="imgpq"></i>
                                            <font>100元</font>
                                        </dd>
                                        <dd>
                                            <i class="imgpq"></i>
                                            <font>500元</font>
                                        </dd>
                                        <dd>
                                            <i class="imgpq"></i>
                                            <font>1000元</font>
                                        </dd>
                                        <dd>
                                            <i class="imgpq"></i>
                                            <font>5000元</font>
                                        </dd>
                                        <dd class="option_bg" id="main_other_money">
                                            <i class="imgpq"></i>
                                            <font><input class="input_txt" type="text" id="input_money" maxlength="5" title="其它">&nbsp;&nbsp;元</font>
                                        </dd>
                                    </dl>
                                </div>
                                <div class="note"><span id="gameb" class="red"></span></div>
                            </div>
                        </li>
                        <li class="clearfix" id="pay_content">
                            <label>选择银行：</label>
                            <div class="rbox">
                                <div class="option_item clearfix" id="bank_list">
									<?php $_GET['act']='99bill_bank';include __DIR__ . '/pay_index.php'?>
                                </div>
                                <a id="bank_more" href="javascript:showBank();" class="more">更多</a>
                            </div>
                        </li>
                        <li class="clearfix"><label>&nbsp;</label><input name="" onclick="check();" type="button" value="立即充值" class="game_btn2" style="width:290px"></li>
                    </ul>
                </div>
                <div class="msg mt20 mb20">
                    <h3>91yxq平台充值说明：</h3>
                    <p>1、请确认充值账号无误；<br />
                    2、请确认充值游戏无误； <br />
                    3、请确认充值游戏区服无误；<br />
                    4、请充值时务必确认好您的充值金额准确无误后再进行充值，避免输错金额导致的失误，如因未仔细确认金额造成的充值问题，我们将一律不予处理此类退款申诉。</p>
                </div>
            </div>
            <div id="myTab1_Content1" style="display:none"><div class="pay_title">支付宝<span class="red">(余额+快捷支付)</span></div></div>
        </div>
    </div>
</div>
<!--订单信息保留处-->
<input type="hidden" name="orderid" id="orderid" value="" />
<input type="hidden" name="pay_way_id" id="pay_way_id" value="33" />
  <input type="hidden" id="game_id" name="game_id" value="0" />
  <input type="hidden" id="server_id" name="server_id" value="0" />
  <input type="hidden" name="game_byname" id="game_byname" value="" />
  <input type="hidden" name="pay_rate" id="pay_rate" value="1" />
  <input type="hidden" name="pay_amount" id="pay_amount" value="100" />
  <input type="hidden" name="bank_name" id="bank_name" value="1001" />
<!--订单信息保留处-->
<!--页脚-->
<div class="foot clearfix">
	<div class="m1200">
        <div class="fl foot_copy">
            <p>游戏网络有限公司版权所有 ©2015-2016&nbsp;&nbsp;粤ICP备00088888号-1</p>
            <p><a href="about.html">关于我们</a><span class="line">|</span><a href="contact.html">商务合作</a><span class="line">|</span><a href="contact.html">联系我们</a><span class="line">|</span><a href="javascript:void(0);">家长监护</a></p>
            <p>抵制不良游戏，拒绝盗版游戏。注意自我保护，谨防受骗上当。适度游戏益脑，沉迷游戏伤身。合理安排时间，享受健康生活。</p>
        </div>
        <div class="fr foot_prove">
            <a href="javascript:void(0);" class="prove_ic1"></a>
            <a href="javascript:void(0);" class="prove_ic2"></a>
            <a href="javascript:void(0);" class="prove_ic3"></a>
            <a href="javascript:void(0);" class="prove_ic4"></a>
        </div>
    </div>
</div>
<div class="popup_box pay_info_box" id="pay_tips" style="display:none;">
	<a href="javascript:void(0);" class="popup_close" onclick="$('#pay_tips').hide();$('.popup_bg').hide();"></a>
    <div class="hd_title"><h2>充值提示</h2></div>
    <div class="pt50 pb50 tc">
        <div style="font-size:24px; color:#dc5562;">请您在新打开的页面上完成付款充值！</div>
        <div style="font-size:16px; color:#999; line-height:30px; padding:20px 0">付款完成请不要关闭或刷新页面<br />
        完成付款后请根据您的情况点击下面按钮</div>
        <a href="javascript:void(0);" style="font-size:16px; color:#dc5562" onclick="$('#pay_tips').hide();$('.popup_bg').hide();">返回继续充值</a>
    </div>
    <div class="tc mb20"><a href="javascript:void(0);" class="game_btn2 mr20" onclick="$('#pay_tips').hide();$('.popup_bg').hide();">返回充值首页</a><a href="#" class="game_btn1">联系充值客服</a></div>
</div>
</form>
<script type="text/javascript" src="./js/pay.js?version=<?php echo time();?>"></script>
<script type="text/javascript">
var gl = <?=$gl?>;
var agent_rate = <?=$agent_rate?>;
var game_id = <?='"'.$game_id.'"'?>;
var server_id = <?='"'.$server_id.'"'?>;
var bj = <?='"'.$bj.'"'?>;
if(game_id>0){
	for(i in gl){
		if(game_id==gl[i]['gid']){
			var game_byname=i;
			showServerList(game_byname,server_id);
			break;
		}
	}
}

var errorWay=0;
var errorToWay=0;
if(errorToWay>0){
	changePayway(errorToWay);
}
selectMoney();
</script>
</body>
</html>
