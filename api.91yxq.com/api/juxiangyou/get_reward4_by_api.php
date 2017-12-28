<?php
require('../../include/config.inc.php');
require('../../include/function.php');
require('../../include/common.php');
require('../../include/configApi.php');
require('../pc_egg/user.game_api.php');

/**
 *http://api.91yxq.com/api/juxiangyou/get_reward4_by_api.php?accessCode=73291&gid=3
 */

$user_id     = htmlspecialchars(trim($_GET['accessCode']));
$game_id   = htmlspecialchars(trim($_GET['gid']));
$state = 1;

//判断参数是否为空
if ($user_id == '' || $game_id == '') {
    $state = 0;
    $content = '所有参数均不能为空!';
}

$sql = "SELECT uid, user_name FROM 91yxq_users.users WHERE uid = " . $user_id;
$res = $mysqli->query($sql)->fetch_assoc();
if (!$res) {
    $content = "用户不存在";
    $state = 0;
}
switch ($game_id) {
    case 3:
        $server_id_arr = [74, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91];break;   //热血虎卫
    case 21:
        $server_id_arr = [1, 2, 3, 4, 5, 6, 7];break;   //赤月传说2
}

$gameUserModel = new GameUser();
$max = 0;
$_nickname = '';
foreach ($server_id_arr as $val) {
    $result = $gameUserModel->main($game_id, $val, $res['user_name']);
    switch ($game_id) {
//        case 2:                           //斗破沙城
//            $status = $result['type'] === 1 ? true : false;
//            $level = $result['value'];
//            $nickname = $result['message'];
//            break;
        case 3:                           //热血虎卫
            $status = $result['code'] === 1 ? true : false;
            $level = $result['data']['level'];
            $nickname = $result['data']['name'];
            break;
        case 21:                           //赤月传说2
            $status = is_array($result) ? true : false;
            $level = $result[0]['level'];
            $nickname = $result[0]['name'];
            break;
    }
    if ($status) {
        if ($max < $level) {
            $max = $level;
            $_nickname = $nickname;
        }
    }
}

if ($max == 0) {
    $content = "获取游戏信息出错!";
    $state = 0;
}

if ($state == 0) {
    $arr['error_msg'] = $content;
} else {
    $sql = "SELECT sum(paid_amount) AS total FROM 91yxq_recharge.pay_orders WHERE `user` = '" . $res['user_name'] . "' AND succ = 1";
    $_result = $mysqli->query($sql)->fetch_assoc();

    $arr['UserID'] = $res['uid'];
    $arr['UserName'] = $res['user_name'];
    $arr['UserServer'] = '';
    $arr['ServerName'] = '';
    $arr['UserRole'] = $_nickname;
    $arr['UserLevel'] = $max;
    $arr['reCharge'] = $_result['total'] ?: 0;
    $arr['Status'] = 1;                   //查询信息是否正常（1：正常；0异常）
}
//echo $xml;
echo json_encode($arr);
