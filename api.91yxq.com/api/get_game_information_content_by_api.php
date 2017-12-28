<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/common.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.91yxq.com/api/get_game_information_content_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f&indexId=1&PublishDate=15455
 */

//判断参数是否为空
if (trim($_GET['time']) == '' || trim($_GET['sign']) == '' || trim($_GET['indexId']) == '' || trim($_GET['PublishDate']) == '') {
    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
}

//验证签名
$sign = $_GET['sign'];
unset($_GET['sign']);
if ($sign != getSign($_GET, SECRET_KEY)) {
    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
}

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

//游戏资讯内容
$data['gameInformationContent'] = getGameInformationContent(htmlspecialchars(trim($_GET['indexId'])), $mysqli);

//上一篇
$data['last_information'] = getLastInformation(htmlspecialchars(trim($_GET['PublishDate'])), $mysqli);

//下一篇
$data['next_information'] = getNextInformation(htmlspecialchars(trim($_GET['PublishDate'])), $mysqli);

//echo "<pre>";
//var_dump($data);die;

exit(json_encode(['code' => 00, 'message' => '游戏资讯详情页数据获取成功!', 'data' => $data]));
