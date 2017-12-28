<?php
require('../../include/config.inc.php');
require('../../include/function.php');
require('../../include/common.php');
require('../../include/configApi.php');
require('../pc_egg/user.game_api.php');

/**
 *http://api.91yxq.com/api/tiantianzuan/get_reward3_by_api.php?guid=61150&gid=3
 */

$guid     = htmlspecialchars(trim($_GET['guid']));
$game_id   = htmlspecialchars(trim($_GET['gid']));
$state = 1;

//判断参数是否为空
if ($guid == '' || $game_id == '') {
    $state = 0;
    $content = '所有参数均不能为空!';
}

$sql = "SELECT uid, user_name FROM 91yxq_users.users WHERE uid = " . $guid;
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
    $arr               = [];
} else {
    /*
     * 字段名	类型	说明
        Status	整形	1：代表查询成功，其他值为错误；必填
        UserID	整型	贵公司游戏平台用户ID编号（同回调链接中的uid）；必填
        UserName	字符串	贵公司游戏平台用户名（同回调链接中的username）； 必填
        UserServer	整型	用户所玩游戏的服务器编号(即区服ID)；初始化值为0
        ServerName	字符串	该服务器名称(即区服名称)；初始化值为空字符串
        UserRole	字符串	用户的最高等级角色名；初始化值为空字符串
        UserLevel	整型	该角色等级；默认值0(转身公式：N转M级=N*10000+M)
        WinCount	整形	用户在游戏中的积分数；默认值0
        Payment	整形	用户充值金额，保留字段；默认值0
     * */
    $sql = "SELECT sum(paid_amount) AS total FROM 91yxq_recharge.pay_orders WHERE `user` = '" . $res['user_name'] . "' AND succ = 1";
    $_result = $mysqli->query($sql)->fetch_assoc();
    if (!$_result['total']) {
        $_result['total'] = 0;
    }

    $arr               = [];
    $arr['Status']     = 1;                       //查询信息是否正常（1：正常；0异常）
    $arr['UserID']     = $res['uid'];             //用户ID
    $arr['UserName']   = $res['user_name'];       //用户名
    $arr['UserRole']   = $_nickname;              //用户角色
    $arr['UserLevel']  = $max;                    //用户等级
    $arr['Payment']    = $_result['total'];       //充值总额

}
echo json_encode($arr);
