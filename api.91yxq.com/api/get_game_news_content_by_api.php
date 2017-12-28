<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/common.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_game_news_content_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f&game_id=3&IndexID=222
 */

//判断参数是否为空
if (trim($_GET['time']) == '' || trim($_GET['sign']) == '' || trim($_GET['game_id']) == '' || trim($_GET['newsType']) == '') {
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

//最新的服
$best_news_server = getBestNewsServer(htmlspecialchars(trim($_GET['game_id'])), $mysqli);

//系统介绍
$system_introduction = getGameTextInfo(htmlspecialchars(trim($_GET['game_id'])), " AND NewsType = 3", '', $mysqli);

//新手指南
$new_guide = getGameTextInfo(htmlspecialchars(trim($_GET['game_id'])), " AND NewsType = 1", '', $mysqli);

//高手进阶
$master_advanced = getGameTextInfo(htmlspecialchars(trim($_GET['game_id'])), " AND NewsType = 2", '', $mysqli);

//文章内容
$news_content = getNewsContent(htmlspecialchars(trim($_GET['IndexID'])), $mysqli);

//上一篇
$last_news = getLastGameInfo(htmlspecialchars(trim($_GET['game_id'])), htmlspecialchars(trim($_GET['IndexID'])), $mysqli);

//下一篇
$next_news = getNextGameInfo(htmlspecialchars(trim($_GET['game_id'])), htmlspecialchars(trim($_GET['IndexID'])), $mysqli);

//echo '<pre>';
//var_dump(['news_content' => $news_content, 'system_introduction' => $system_introduction, 'new_guide' => $new_guide, 'master_advanced' => $master_advanced, 'last_news' => $last_news, 'next_news' => $next_news]);
exit(json_encode(['code' => 00, 'message' => '游戏新闻内容页数据获取成功!', 'data' => ['slideData' => $slideData, 'best_news_server' => $best_news_server, 'news_content' => $news_content, 'system_introduction' => $system_introduction, 'new_guide' => $new_guide, 'master_advanced' => $master_advanced, 'last_news' => $last_news, 'next_news' => $next_news]]));
