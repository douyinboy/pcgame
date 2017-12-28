<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/common.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_game_information_list_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f&p=1
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

$data = [];
if (!isset($_GET['p'])) {
    //获取轮播数据
    $data['slideData'] = getGameImg("1", "nodeId = 32", SLIDE_NUM, $mysqli);

    //获取新闻资讯数据
    $data['gameInformation'] = getGameInformation(' LIMIT 10', $mysqli);

    //已开服
    $data['openServer'] = getServerList(" AND ServerStatus > 2", " LIMIT 20", $mysqli);

    //未开服
    $data['closeServer'] = getServerList(" AND ServerStatus < 3", " LIMIT 20", $mysqli);

    //游戏排行
    $data['gameRank'] = getGameList('', ' LIMIT 5', $mysqli);
}

$p = trim($_GET['p']);
$p = max($p, 1);
//获取游戏总数
$total = getGameInformationTotal($mysqli);
$max = ceil($total / GAME_INFORMATION_LIST_NUM);
$p = min($p, $max);
$offset = GAME_INFORMATION_LIST_NUM * ($p - 1);
$limit = " LIMIT " . $offset . ', ' . GAME_INFORMATION_LIST_NUM;

$data['gameInformationList'] = getGameInformation($limit, $mysqli);
$data['page_info']['count'] = $total;
$data['page_info']['number'] = GAME_INFORMATION_LIST_NUM;
$data['page_info']['page'] = $p;

//echo "<pre>";
//var_dump($data);die;

exit(json_encode(['code' => 00, 'message' => '游戏资讯列表页数据获取成功!', 'data' => $data]));
