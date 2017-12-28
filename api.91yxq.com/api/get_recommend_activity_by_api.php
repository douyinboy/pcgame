<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_recommend_activity_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f
 */

////判断参数是否为空
//if (trim($_GET['time']) == '' || trim($_GET['sign']) == '' || trim($_GET['gid']) == '' || trim($_GET['newsType']) == '') {
//    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
//}
//
////验证签名
//if ($_GET['sign'] != getSign($_GET, $api_secret_key)) {
//    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
//}

$sql = "SELECT IndexID, GameId, Photo FROM  " . PUBLISH . "." . PUBLISH_1 . " WHERE NodeID = 12 AND Photo != '' ORDER BY PublishDate DESC LIMIT 8";
$res = $mysqli->query($sql);
$arr = [];
while ($row = $res->fetch_assoc()) {
    $arr[] = $row;
}

echo '<pre>';
var_dump($arr);die;

exit(json_encode(['code' => 00, 'message' => '轮播广告获取成功!', 'data' => $arr]));