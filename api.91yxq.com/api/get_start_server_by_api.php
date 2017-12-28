<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/common.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_start_server_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f
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

//昨日开服
$yesterdayServer = getServerList(" AND OpenDate = '" . date('Y-m-d', strtotime('-1 day')) . "'", "", $mysqli);

//今日开服
$todayServer = getServerList(" AND OpenDate = '" . date('Y-m-d') . "'", "", $mysqli);

//明日开服
//$tomorrowServer = getServerList(" AND OpenDate = '" . date('Y-m-d', strtotime('+1 day')) . "'", "", $mysqli);

//服务器列表
$serverList = getAllServerList($mysqli);

exit(json_encode(['code' => 00, 'message' => '开服表页数据获取成功!', 'data' => ['yesterdayServer' => $yesterdayServer, 'todayServer' => $todayServer, 'serverList' => $serverList]]));
