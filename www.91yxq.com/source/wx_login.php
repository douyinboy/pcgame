<?php
//-------配置
$AppID = 'wxce63b3d6f7b382fc';
$AppSecret = 'f26fcf6b68f7388f512f78728c8c2162';
$callback  =  'http://www.91yxq.com/api/wx_login.php?pcid=1111'; //回调地址
//微信登录
session_start();
//-------生成唯一随机串防CSRF攻击
$state  = md5(uniqid(rand(), TRUE));
$_SESSION["wx_state"] = $state; //存到SESSION
$callback = urlencode($callback);
$wxurl = "https://open.weixin.qq.com/connect/qrconnect?appid=".$AppID."&redirect_uri=".$callback."&response_type=code&scope=snsapi_login&state=".$state."#wechat_redirect";
header("Location: $wxurl");

//$ch = curl_init( );
//curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
//curl_setopt( $ch, CURLOPT_URL, $wxurl );
//curl_setopt( $ch, CURLOPT_POST, 1 );
//curl_setopt( $ch, CURLOPT_POSTFIELDS, "act=$act&".$info."&time=".$time."&sign=".md5($time.$api_key));
//curl_setopt( $ch, CURLOPT_COOKIEJAR, COOKIEJAR );
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_HEADER, false);
//curl_setopt( $ch, CURLOPT_TIMEOUT, TIMEOUT );
//$contents = curl_exec( $ch );
//curl_close( $ch );
//return $contents;







?>