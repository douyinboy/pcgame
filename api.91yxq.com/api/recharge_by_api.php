<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/common.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/recharge_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f&game=1&server=1&pay_type=18&user=allen&money=1&dfbank=icbc
 */

//判断参数是否为空
if (trim($_GET['time']) == '' && trim($_GET['sign']) == '' && trim($_GET['game']) == '' && trim($_GET['server']) == '' && trim($_GET['pay_type']) == '' && trim($_GET['user']) == '' && trim($_GET['money']) == '' && trim($_GET['dfbank']) == '') {
    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
}

//验证签名
$sign = $_GET['sign'];
unset($_GET['sign']);
if ($sign != getSign($_GET, SECRET_KEY)) {
    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
}

header('Location: http://pay.demo.com/recharge_by_api.php?' . urldecode(http_build_query($_GET)));
