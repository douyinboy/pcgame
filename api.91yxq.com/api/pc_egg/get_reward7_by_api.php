<?php
require('../../include/config.inc.php');
require('../../include/function.php');
require('../../include/common.php');
require('../../include/configApi.php');
require('./user.game_api.php');

/**
 *http://api.demo.com/api/pc_egg/get_reward_by_api.php?merid=7778&user_name=allen&keycode=szdfgsd
 */

$user_name = htmlspecialchars(trim($_GET['user_name']));
$merid     = htmlspecialchars(trim($_GET['merid']));
$keycode   = htmlspecialchars(trim($_GET['keycode']));

$key       = '87b5b787044d2ec2';	//定义由PC蛋蛋提供的KEY 需保密；

$state = 1;

//判断参数是否为空
if ($user_name == '' || $merid == '' || $keycode == '') {
    $state = 0;
    $content = '所有参数均不能为空!';
}

//验证签名
if ($keycode != md5($merid . $key)) {
    $state = 0;
    $content = "验证码不对!";
}

$sql = "SELECT uid FROM 91yxq_users.users WHERE uid = " . $merid;
$result = $mysqli->query($sql)->fetch_assoc();
if (!$result) {
    $content = "用户不存在";
    $state = 0;
}
$game_id = 1;
$server_id_arr = [33, 34, 35, 36, 37];
$gameUserModel = new GameUser();
$max = 0;
$arr = [];
foreach ($server_id_arr as $val) {
    $result = $gameUserModel->main($game_id, $val, $user_name);
    if ($result['code'] === 0) {
        if ($max < $result['data']['level']) {
            $max = $result['data']['level'];
            $arr = $result;
        }
    }
}

if (empty($arr)) {
    $content = "获取游戏信息出错!";
    $state = 0;
}

if ($state == 0) {
//    $content = iconv("gb2312","utf-8",$content);
    $xml = '<?xml version="1.0" encoding="utf-8" ?>';
    $xml .= '<Result>';
    $xml .= '<ErrMsg>' . $content . '</ErrMsg>';
    $xml .= '<Status>-1</Status>';
    $xml .= '</Result>';
} else {
    $xml = '<?xml version="1.0" encoding="utf-8" ?>';
    $xml .= '<Result>';
    $xml .= '<GameName>' . $arr['data']['nickname'] . '</GameName>';
    $xml .= '<PlayLevel>' . $arr['data']['level'] . '</PlayLevel>';
    $xml .= '<TodayLevel>1</TodayLevel>';
    $xml .= '<Status>1</Status>';
    $xml .= '</Result>';
}
echo $xml;
