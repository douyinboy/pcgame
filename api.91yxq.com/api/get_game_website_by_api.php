<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/common.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_game_website_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f&game_id=1
 */

//判断参数是否为空
if (trim($_GET['time']) == '' || trim($_GET['sign']) == '' || trim($_GET['game_id']) == '') {
    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
}

//验证签名
$sign = $_GET['sign'];
unset($_GET['sign']);
if ($sign != getSign($_GET, SECRET_KEY)) {
    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
}

//获取背景图片
//$slideData = getGameImg("GameId=".htmlspecialchars(trim($_GET['game_id'])), "nodeId = 32", 1, $mysqli);
$slideData = getRollingAd(htmlspecialchars(trim($_GET['game_id'])), $mysqli);

//获取游戏公告
$game_notice = getGameTextInfo(htmlspecialchars(trim($_GET['game_id'])), " AND NewsType > 4 AND NewsType < 8", '', $mysqli);

//系统介绍
$system_introduction = getGameTextInfo(htmlspecialchars(trim($_GET['game_id'])), " AND NewsType = 3", '', $mysqli);

//新手指南
$new_guide = getGameTextInfo(htmlspecialchars(trim($_GET['game_id'])), " AND NewsType = 1", '', $mysqli);

//高手进阶
$master_advanced = getGameTextInfo(htmlspecialchars(trim($_GET['game_id'])), " AND NewsType = 2", '', $mysqli);

//服务器列表
$server_list = getServerOfGame(htmlspecialchars(trim($_GET['game_id'])), $mysqli);

//最新的服
$best_news_server = getBestNewsServer(htmlspecialchars(trim($_GET['game_id'])), $mysqli);

//游戏截图列表
$game_Screenshot = getGameScreenshot(htmlspecialchars(trim($_GET['game_id'])), $mysqli);

exit(json_encode(['code' => 00, 'message' => '游戏官网页数据获取成功!', 'data' => ['slideData' => $slideData, 'game_notice' => $game_notice, 'system_introduction' => $system_introduction, 'new_guide' => $new_guide, 'master_advanced' => $master_advanced, 'server_list' => $server_list, 'best_news_server' => $best_news_server, 'game_Screenshot' => $game_Screenshot]]));
