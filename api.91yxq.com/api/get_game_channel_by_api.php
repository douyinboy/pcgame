<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/common.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_game_channel_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f
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

//获取轮播数据
$slideData = getGameImg("1", "nodeId = 32", SLIDE_NUM, $mysqli);

//获取新闻资讯数据
$informationData = getGameInformation(' LIMIT 10', $mysqli);

//游戏列表数据
//$gameData = getGameImg("1", "nodeId = 33", 12, $mysqli);
$gameList = getGameList('', '', $mysqli);

//已开服
$openServer = getServerList(" AND ServerStatus > 2", " LIMIT 20", $mysqli);

//未开服
$closeServer = getServerList(" AND ServerStatus < 3", " LIMIT 20", $mysqli);

//游戏排行
$gameRank = getGameList('', ' LIMIT 5', $mysqli);

//echo "<pre>";
//var_dump(['slide' => $gameList, 'hot' => $gameRank]);die;

exit(json_encode(['code' => 00, 'message' => '游戏频道数据获取成功!', 'data' => ['slide' => $slideData, 'informationData' => $informationData, 'gameList' => $gameList, 'openServer' => $openServer, 'closeServer' => $closeServer, 'gameRank' => $gameRank]]));
