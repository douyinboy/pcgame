<?php
//require('../include/config.inc.php');
//require('../include/function.php');
//require('../include/ipconfig.php');
//require('../include/configApi.php');
require('../include/common.inc.php');

/**
 * @通过API进入游戏
 * @param url http://www.91yxq.com/api/enter_game_by_api.php?game_id=1&server_id=1&user_name=sxj66784&time=1487574573&sign=df21kk
 */

$game_id      = htmlspecialchars($_GET['game_id']);
$server_id    = htmlspecialchars($_GET['server_id']);
$user_name    = htmlspecialchars($_GET['user_name']);
$time         = htmlspecialchars($_GET['time']);
$sign         = htmlspecialchars($_GET['sign']);

//if (trim($game_id) == '' || trim($server_id) == '' || trim($user_name) == '' || trim($time) == '' || trim($sign) == '') {
//    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));  //所有参数不能为空
//}
//
////验证签名
//$sign = $_GET['sign'];
//unset($_GET['sign']);
//if ($sign != getSign($_GET, SECRET_KEY)) {
//    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
//}

$u=new userPceggs;
$e=$u->login_($user_name, '111111');

if ($e == 'ok') {
    $game_url = 'http://www.91yxq.com/main.php?act=gamelogin&game_id=' . $game_id . '&server_id=' . $server_id;
    header("Location:".$game_url);
    exit;
}

?>
