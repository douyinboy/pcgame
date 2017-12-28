<?php
define('ROOT', __DIR__ . '/');
require(ROOT . 'include/config.inc.php');
require(ROOT . 'include/function.php');
require(ROOT . 'include/ipconfig.php');
$getip = get_real_ip();
if (!in_array($getip,$ipj)) {
	//echo "ip error";
	//exit();
}
$_POST = $_REQUEST;
$time=trim(intval($_POST['time']));
$act=trim($_POST['act']);
$sign=trim($_POST['sign']);
if(md5($time.$api_key)!=$sign){
	exit("sign error");
}
switch($act){
	case "login":  //帐号登录
		require("api/login.php");
	break;
	case "auto_login":  //帐号登录
		require("api/auto_login.php");
	break;
	case "reg":   //帐号注册
		require("api/reg.php");
	break;
	case "reg_pceggs":   //蛋蛋帐号注册
		require("api/reg_pceggs.php");
	break;
	case "reg_bengbeng":   //蹦蹦帐号注册
		require("api/reg_bengbeng.php");
	break;
	case "wx_reg":   //微信扫码登录
		require("api/wx_reg.php");
	break;
	case "info":   //帐号注册
		require("api/info.php");
	break;
	case "getgameurl":  //获取游戏地址
	    require("api/get_game_url.php");
	break;
	case "update":   //资料更新
		require("api/update.php");
	break;
	case "getpwd":   //找回密码
		require("api/getpwd.php");
	break;
	case "update_user_platform":   //更新用户平台币值
		require("api/update_user_platform.php");
	break;
	case "check_user_platform":   //查询用户平台币状态
		require("api/check_user_platform.php");
	break;
	case "payFromPlatformB":      //用平台币支付
		require("api/payFromPlatformB.php");
		break;
	case "get_user_platform":        //获取用户平台币值
		require("api/get_user_platform.php");
		break;
}
?>