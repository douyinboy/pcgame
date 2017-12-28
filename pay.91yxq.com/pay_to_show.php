<?php
require_once( __DIR__.'/include/mysqli_config.inc.php' );
include_once( __DIR__.'/include/funcs.php' );
require_once( __DIR__.'/config/pay_way.inc.php' );

$orderid = $_GET['orderid'];

if ( $orderid ) 
{
    $query = $mysqli->query( "SELECT * FROM `pay_orders` WHERE `orderid`='{$orderid}'" );
    $queryrow = $query->fetch_object();
    //判断订单是否已经存在
    $r=$mysqli->query( "SELECT `orderid` FROM `pay_list` WHERE `orderid`='{$queryrow->orderid}'" );
    $tmp=$r->fetch_object();
    if( !$tmp && $queryrow ->succ ==1 )
	{
		$real_pay_way_arr = array(1=>0.004,3=>0.004,18=>0.007,30=>0.02,31=>0.02,32=>0.86,33=>0.0025,35=>0.035,36=>0.035,37=>0.035);
        $rs=$mysqli->query( "SELECT `agent_id`, `place_id`, `reg_time` FROM `91yxq_users`.`users` WHERE `user_name`='{$queryrow->user}'" );
        $user=$rs->fetch_object();
        if( $user->reg_time >0 ) 
		{
                 $reg_time = $user->reg_time;
        } 
		else 
		{
                 $reg_time =1448899200;//默认2015年12月1日
        }
        $year = date( "Y",$reg_time );
        $sql="SELECT * FROM `91yxq_users`.`91yxq_agent_reg_{$year}` WHERE `user_name`='{$queryrow->user}'";
        $res2=$mysqli->query($sql);
        $row2=$res2->fetch_object();
        $agent_id= $user->agent_id;
        $reg_game_id=$row2->game_id;
        $reg_server_id=$row2->server_id;
        $placeid = $user->place_id;
        $cplaceid = $row2->ext1;
        $adid    = $row2->adid;
        $from_url=$row2->referer_url;
        $reg_date=date( "Y-m-d H:i:s",$row2->reg_time );
		$cid = $row2->agent_id;
		$paid_amount = $queryrow->money * $pay_way_arr[$queryrow->pay_channel]['pay_rate'];
		if(isset($real_pay_way_arr[$queryrow->pay_channel]))
		{
			$money_float = $queryrow->money * $real_pay_way_arr[$queryrow->pay_channel];
			if( $money_float<0.01 )
			{
				$money_float = 0.01;
			}
			$money_float = round($money_float,2) * -1; 
			$pure_pay_money = bcadd($queryrow->money,$money_float,2);
		}else{
			$pure_pay_money = 0;
		}
		$sql="INSERT INTO `pay_list` (`orderid`, `user_name`, `pay_way_id`, `money`, `paid_amount`, `sync_date`, `pay_date`, `agent_id`, `placeid`, `cplaceid`, `adid`, `reg_date`, `game_id`, `reg_game_id`, `reg_server_id`, `server_id`, `from_url`, `cid`, `user_ip`,`pure_api_money`) values ('{$queryrow->orderid}','{$queryrow->user}',{$queryrow->pay_channel},{$queryrow->money},{$paid_amount},'".date("Y-m-d H:i:s",$queryrow->sync_date)."','".date("Y-m-d H:i:s",$queryrow->pay_date)."',{$agent_id},{$placeid},'{$cplaceid}','{$adid}','{$reg_date}',{$queryrow->game},{$queryrow->game},{$reg_server_id},{$queryrow->server},'{$from_url}',{$cid},'".long2ip($queryrow->user_ip)."','{$pure_pay_money}')";
		$mysqli->query($sql);
    }
    $query_s = $mysqli->query( "SELECT a.`name` as `server_name`,b.`name` as `game_name`,b.`game_byname` as `pay_game` FROM `game_server_list` as a,`game_list` as b WHERE a.`game_id`=b.`id` and b.`id`={$queryrow->game} and a.`server_id`={$queryrow->server}" );
    $queryrow_s = $query_s->fetch_object();
	
	if( $queryrow->game==0 && $queryrow->server==0 )
	{
		$queryrow_s->game_name = '91yxq';
		$queryrow_s->server_name = '平台币';
	}
	
    $pay_game = "pay_".$queryrow_s->pay_game."_log";
	
	if($queryrow->game==0 && $queryrow->server==0)
	{
		$pay_game = "pay_platform";
	}
	
    $res_g = $mysqli->query( "SELECT `stat` FROM `$pay_game` WHERE `orderid`='{$orderid}'" );
    $g_row = $res_g->fetch_object();
	
	if( $queryrow->game==0 && $queryrow->server==0 )
	{
		$plat_query = $mysqli->query( "SELECT `succ` FROM `pay_platform` WHERE `orderId`='{$orderid}'" );
		$plat_row = $plat_query->fetch_object();
		$g_row->stat = $plat_row->succ;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网页游戏平台充值中心,91yxq充值中心,91yxq网页游戏平台</title>
<meta name="keywords" content="91yxq网页游戏,91yxq充值中心,网页游戏充值,网页游戏怎么充值">
<meta name="description" content="91yxq网页游戏充值中心,在保护玩家充值安全的基础上,为玩家提供多种充值方式,让玩家体验更快捷的充值服务!" />
<link type="text/css" rel="stylesheet" href="http://image.91yxq.com/css/www/base.css" />
<link type="text/css" rel="stylesheet" href="http://image.91yxq.com/css/www/public.css" />
<link type="text/css" rel="stylesheet" href="http://image.91yxq.com/css/www/main_pq.css" />
<script type="text/javascript" src="http://image.91yxq.com/js/jquery-1.10.2.min.js"></script>
<link type="text/css" rel="stylesheet" href="./css/pay.css<?php echo "?verson=".time();?>">
</head>
<body>
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
		<script src="http://www.91yxq.com/public/www_top.js"></script>
		
    </div>
</div>

<!--主内容-->
<div class="m1200">
	<div class="m_box2 p40 mt40 clearfix" style="min-height:450px">
        <div class="tc">
            <div class="pt50 pb50">
                <i class="imgpq icon_<?php if ( $queryrow->succ==1 ) echo 'ok'; else echo 'sigh';?>"></i>
                <span style="display:inline-block; text-align:left; padding-left:20px; vertical-align:top">
                    <h4 style="font-size:20px; padding-bottom:10px"><?php if ( $queryrow->succ==1 ) echo '恭喜，您已充值成功，请到游戏里查收'; else echo '很抱歉，充值遇到了异常';?></h4>
                    <p style="font-size:14px; color:#999">如果扣款成功游戏币未收到，请联系在线客服<a href="javascript:void(0);" target="_blank" class="red ml10">充值客服</a></p>
                </span>
            </div>
        </div>
        <?php if ($orderid) { ?>
        <div style="background:#ededed">
        	<ul class="pay_info">
                <li><label>充值的方式：</label><div class="rc"><?=$pay_way_arr[$queryrow->pay_channel]['payname']?></div></li>
                <li><label>订单编号：</label><div class="rc"><?=$queryrow->orderid?></div></li>
                <li><label>充值号账号：</label><div class="rc"><span class="red"><?=$queryrow->user?></span></div></li>
                <li><label> 充值的区服：</label><div class="rc"><span class="red"><?=$queryrow_s->game_name?><?=$queryrow_s->server_name?></span></div></li>
                <li><label>充值金额：</label><div class="rc"><span class="red"><?=$queryrow->money?> 元</span></div></li>
                <li><label>充值所得：</label><div class="rc"><span class="red"><?=$queryrow->pay_gold?></span></div></li>
                <li><label>是否已到账：</label><div class="rc"><?php if ( $g_row->stat==1 ) echo '已到账请查收'; else echo '发放失败!请联系<a href="javascript:void(0);" target="_blank" class="red ml10">充值客服</a>'; ?></div></li>
            </ul>
        </div>
		<div class="tc mt20 mb20"><a href="http://www.91yxq.com/turn.php?act=gamelogin&game_id=<?=$queryrow->game?>&server_id=<?=$queryrow->server?>" class="game_btn1 mr20" target="_blank">进入游戏</a><a href="http://pay.91yxq.com/?game_id=<?=$queryrow->game?>&server_id=<?=$queryrow->server?>" class="game_btn1 mr20">继续充值</a><a href="http://www.91yxq.com" class="game_btn2 mr20" target="_blank">返回首页</a><a href="#" class="game_btn3">充值客服</a></div>
	</div>
        <?php } ?>
</div>

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
</body>
</html>