<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_server_list_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f&type=news&p=1&num=20
 */

////判断参数是否为空
//if (trim($_GET['time']) == '' || trim($_GET['sign']) == '' || trim($_GET['type']) == '') {
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
    $limit = " LIMIT " . $offset . ', ' . $pageSize;
}

switch ($_GET['type']) {
    case 'yesterday':
        $condition = "OpenDate = '" . date('Y-m-d', strtotime('-1 day')) . "'";
        break;
    case 'today':
        $condition = "OpenDate = '" . date('Y-m-d') . "'";
        break;
    case 'tomorrow':
        $condition = "OpenDate = '" . date('Y-m-d', strtotime('+1 day')) . "'";
        break;
    case 'news':
        $condition = "OpenDate <= '" . date('Y-m-d') . "'";
        break;
    case 'history':
        $condition = "OpenDate <= '" . date('Y-m-d') . "'";
        break;
}

$sql = "SELECT GameId, GameName FROM  " . PUBLISH . "." . PUBLISH_5 . " WHERE 1";
$res = $mysqli->query($sql);
$_arr = [];
while ($row = $res->fetch_assoc()) {
    $_arr[] = $row;
}

$sql = "SELECT GameId, ServerId, ServerName, OpenDate, OpenTime  FROM  " . PUBLISH . "." . PUBLISH_6 . " WHERE " . $condition . " ORDER BY OpenDate DESC, OpenTime DESC" . $limit;
$res = $mysqli->query($sql);
$arr = [];
while ($row = $res->fetch_assoc()) {
    foreach ($_arr as $key => $val) {
        if ($row['GameId'] == $val['GameId']) {
            $arr[] = array_merge($row, $val);
        }
    }
}
echo '<pre>';
var_dump($arr);die;

exit(json_encode(['code' => 00, 'message' => '轮播广告获取成功!', 'data' => $arr]));