<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/common.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_game_news_list_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f&game_id=1&newsType=all&p=1
 */

//判断参数是否为空
if (trim($_GET['time']) == '' || trim($_GET['sign']) == '' || trim($_GET['game_id']) == '' || trim($_GET['newsType']) == '' || trim($_GET['p']) == '') {
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

switch (trim($_GET['newsType'])) {
    case 'news':
        $condition = " AND NewsType = 5";
        break;
    case 'notice':
        $condition = " AND NewsType = 6";
        break;
    case 'activity':
        $condition = " AND NewsType = 7";
        break;
    default:
        $condition = " AND NewsType > 4 AND NewsType <= 7";
}

$p = trim($_GET['p']);
$p = max($p, 1);
//获取游戏总数
$total = getGameNewsTotal(htmlspecialchars(trim($_GET['game_id'])), $condition, $mysqli);
$max = ceil($total / GAME_NEWS_LIST_NUM);
$p = min($p, $max);
$offset = GAME_NEWS_LIST_NUM * ($p - 1);
$limit = " LIMIT " . $offset . ', ' . GAME_NEWS_LIST_NUM;

//获取游戏新闻公告
$data['gameNotice'] = getGameTextInfo(htmlspecialchars(trim($_GET['game_id'])), $condition, $limit, $mysqli);

$data['page_info']['count'] = $total;
$data['page_info']['number'] = GAME_NEWS_LIST_NUM;
$data['page_info']['page'] = $p;

if (!isset($_GET['newsType']) && !isset($_GET['p'])) {
    //获取轮播数据
    $data['slideData'] = getGameImg("1", "nodeId = 32", SLIDE_NUM, $mysqli);

    //系统介绍
    $data['system_introduction'] = getGameTextInfo(htmlspecialchars(trim($_GET['game_id'])), " AND NewsType = 3", '', $mysqli);

    //新手指南
    $data['new_guide'] = getGameTextInfo(htmlspecialchars(trim($_GET['game_id'])), " AND NewsType = 1", '', $mysqli);

    //高手进阶
    $data['master_advanced'] = getGameTextInfo(htmlspecialchars(trim($_GET['game_id'])), " AND NewsType = 2", '', $mysqli);

    //最新的服
    $data['best_news_server'] = getBestNewsServer(htmlspecialchars(trim($_GET['game_id'])), $mysqli);
}

//echo "<pre>";
//var_dump($data);die;
exit(json_encode(['code' => 00, 'message' => '游戏新闻列表页数据获取成功!', 'data' => $data]));
