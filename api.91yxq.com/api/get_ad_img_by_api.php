<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_slide_img_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f&num=4&type=slide
 */

//判断参数是否为空
if (trim($_GET['time']) == '' || trim($_GET['sign']) == '' || trim($_GET['type']) == '') {
    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
}

//验证签名
if ($_GET['sign'] != getSign($_GET, $api_secret_key)) {
    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
}
switch ($_GET['type']) {
    case 'slide':
        $condition1 = "1";
        $condition2 = "nodeId = 32";
        break;
//    case 'recommend':
//        $condition1 = "1";
//        $condition2 = "nodeId = 00";
//        break;
    case 'hot':
        $condition1 = "1";
        $condition2 = "nodeId = 33";
        break;
    case 'search':
        $condition1 = "GameName LIKE '%" . htmlspecialchars(trim($_GET['search'])) . "%'";
        $condition2 = "nodeId = 33";
        break;
}

$limit = '';
if ($num = trim($_GET['num'])) {
    $limit = "LIMIT " . htmlspecialchars($num);
}

$sql = "SELECT GameId, GameName, GameType FROM  " . PUBLISH . "." . PUBLISH_5 . " WHERE " . $condition1;
$res = $mysqli->query($sql);
$_arr = [];
while ($row = $res->fetch_assoc()) {
    $_arr[] = $row;
}

$sql = "SELECT GameId, GameImg, URL FROM  " . PUBLISH . "." . PUBLISH_7 . " WHERE " . $condition2 . " ORDER BY SortPriority DESC " . $limit;

$res = $mysqli->query($sql);
$arr = [];
while ($row = $res->fetch_assoc()) {
    foreach ($_arr as $key => $val) {
        if ($row['GameId'] == $val['GameId']) {
            $arr[] = array_merge($row, $val);
        }
    }
}

exit(json_encode(['code' => 00, 'message' => '轮播广告获取成功!', 'data' => $arr]));