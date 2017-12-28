<?php
require('../include/config.inc.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/add_agent_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f&url=http://www.baidu.com&agentname=abcdefg
 */

$agentname  = htmlspecialchars($_GET['agentname']);
$url        = htmlspecialchars($_GET['url']);
$time       = htmlspecialchars($_GET['time']);
$sign       = htmlspecialchars($_GET['sign']);
$agentname  = $agentname . '_' . time();

//判断参数是否为空
if (trim($agentname) == '' || trim($url) == '' || trim($time) == '' || trim($sign) == '') {
    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
}

//验证签名
//if ($sign != getSign($_GET, $api_secret_key)) {
//    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
//}

//判断平台渠道号是否已注册
$sql = "SELECT id, agentname FROM " . ADMINTABLE . "." . GUILDINFO . " WHERE url = '" . $url . "'";
if ($aa = $mysqli->query($sql)->fetch_array()) {
    exit(json_encode(['code' => 02, 'message' => '该平台渠道号已经生成过了!']));
} else {
    //新增渠道号
    $sql = "INSERT INTO " . ADMINTABLE . "." . GUILDINFO . " (`user_name`, `user_pwd`, `agentname`, `url`, `state`, `add_date`) VALUES ('" . $agentname . "', '123456', '" . $agentname ."', '" . $url . "', 1, '" . date('Y-m-d H:i:s') . "')";
    if ($mysqli->query($sql)) {
        $sql = "SELECT id, agentname FROM " . ADMINTABLE . "." . GUILDINFO . " where url = '" . $url . "'";
        $result = $mysqli->query($sql)->fetch_array();
        exit(json_encode(['code' => 00, 'message' => '渠道号生成成功!', 'data' => $result]));
    } else {
        exit(json_encode(['code' => 03, 'message' => '渠道号生成失败!']));
    }
}
