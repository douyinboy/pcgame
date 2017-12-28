<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/common.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_game_all_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f&gameType=1&p=1
 */

//判断参数是否为空
if (trim($_GET['time']) == '' || trim($_GET['sign']) == '') {
    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
}

//验证签名
$sign = $_GET['sign'];
unset($_GET['sign']);
if (isset($_GET['callback'])) {
    unset($_GET['callback']);
    unset($_GET['_']);
}
if ($sign != getSign($_GET, SECRET_KEY)) {
    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
}

if (!isset($_GET['gameType']) && !isset($_GET['p'])) {
    //已开服
    $data['openServer'] = getServerList(" AND ServerStatus > 2", " LIMIT 20", $mysqli);

    //未开服
    $data['closeServer'] = getServerList(" AND ServerStatus < 3", " LIMIT 20", $mysqli);

    //游戏类型
    $data['gameType'] = getGameType($mysqli);
}

//游戏列表
$condition = '';
if (!empty($_GET['gameType']) && trim($_GET['gameType']) !== '0') {
    $condition = " AND GameTypeId = " . htmlspecialchars(trim($_GET['gameType']));
}

//$limit = 'LIMIT 0, ' . GAME_LIST_NUM;
//if (isset($_GET['p'])) {
$p = trim($_GET['p']);
$p = max($p, 1);
//获取游戏总数
$total = getGameTotal($condition, $mysqli);
$max = ceil($total / GAME_LIST_NUM);
$p = min($p, $max);
$offset = GAME_LIST_NUM * ($p - 1);
$limit = "LIMIT " . $offset . ', ' . GAME_LIST_NUM;
//}

$data['gameList'] = getGameList($condition, $limit, $mysqli);

$data['page_info']['count'] = $total;
$data['page_info']['number'] = GAME_LIST_NUM;
$data['page_info']['page'] = $p;

//echo "<pre>";
//var_dump($data);die;
exit(json_encode(['code' => 00, 'message' => '游戏大全页数据获取成功!', 'data' => $data]));

