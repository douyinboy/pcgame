<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_game_list_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f&p=2&num=2&type=1
 */

////判断参数是否为空
//if (trim($_GET['time']) == '' || trim($_GET['sign']) == '') {
//    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
//}
//
////验证签名
//if ($_GET['sign'] != getSign($_GET, $api_secret_key)) {
//    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
//}

$limit = '';
if (!empty($_GET['p']) || $_GET['p'] === 0) {
    $p = trim($_GET['p']);
    $p = max($p, 1);
    $pageSize = trim($_GET['num']);
    $offset = $pageSize * ($p - 1);
    $limit = "LIMIT " . $offset . ', ' . $pageSize;
}

$condition = '';
if (!empty($_GET['type'])) {
    $condition = " AND GameTypeId = '" . htmlspecialchars(trim($_GET['type'])) . "'";
}

$sql = "SELECT GameId, GameName FROM  " . PUBLISH . "." . PUBLISH_5 . " WHERE 1 " . $condition . $limit;
$res = $mysqli->query($sql);
$arr = [];
while ($row = $res->fetch_assoc()) {
    $arr[] = $row;
}
echo '<pre>';
var_dump($arr);die;

exit(json_encode(['code' => 00, 'message' => '轮播广告获取成功!', 'data' => $arr]));