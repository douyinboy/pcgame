<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/common.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_new_activity_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f
 */

//判断参数是否为空
if (trim($_GET['time']) == '' || trim($_GET['sign']) == '') {
    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
}

//验证签名
$sign = $_GET['sign'];
unset($_GET['sign']);
if ($sign != getSign($_GET, SECRET_KEY)) {
    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
}

//最新开服
$newServer = getServerList(" AND OpenDate <= '" . date('Y-m-d') . "'", " LIMIT 0, 20", $mysqli);

//历史开服
$historyServer = getServerList(" AND OpenDate <= '" . date('Y-m-d') . "'", " LIMIT 20, 40", $mysqli);

//最新活动
$newActivity = getNewActivity($mysqli);

//echo "<pre>";
//var_dump(['slide' => $slideData, 'hot' => $hotData]);die;

exit(json_encode(['code' => 00, 'message' => '最新活动数据获取成功!', 'data' => ['newServer' => $newServer, 'historyServer' => $historyServer, 'newActivity' => $newActivity]]));
