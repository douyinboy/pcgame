<?php
$loginname=$_SESSION["login"]["username"];

$where = '';
if (!empty($_GET['orderid'])) {
    $where .= "orderid='" . $_GET['orderid'] . "' AND ";
}
if (!empty($_GET['startTime'])) {
    $where .= "sync_date>" . strtotime($_GET['startTime']) . ' AND ';
}
if (!empty($_GET['endTime'])) {
    $where .= "sync_date<" . strtotime($_GET['endTime']) . ' AND ';
}

$pay_channel = [
    11 => '人工充值',
    18 => '支付宝(91yxq)',
    20 => '支付宝(畅付云)',
    33 => '网银(畅付云)',
    46 => '微信(91yxq)',
    48 => '微信(畅付云)',
];

$sql = "select count(orderid) total from 91yxq_recharge.pay_orders where " . $where . " `user` = '" . $loginname . "' and succ = 1";
$arr = $db->find($sql);

//当前页数
$p = empty($_GET['p']) ? 1 : $_GET['p'];
//总行数
$total = $arr[0]['total'];
//每页显示行数
$num = 1;
//总页数
$pageTotal = ceil($total/$num);
$offset = ($p - 1) * $num;

$sql = "select `user`, orderid, money, game, server, pay_channel, pay_gold, sync_date from 91yxq_recharge.pay_orders where " . $where . " `user` = '" . $loginname . "' and succ = 1 order by sync_date desc limit " . $offset . "," . $num;
$arr = $db->find($sql);

foreach ($arr as $key=>$val) {
    $sql = "select name from 91yxq_recharge.game_list where id = " . $val['game'];
    $game_name = $db->get($sql);
    $arr[$key]['num'] = $key + 1;
    $arr[$key]['game'] = $game_name['name'];
    $arr[$key]['server'] = '双线' . $val['server'] . '服';
    $arr[$key]['pay_channel'] = $pay_channel[$val['pay_channel']];
    $arr[$key]['sync_date'] = date('Y-m-d H:i:s', $val['sync_date']);
}
//
//echo "<pre>";
//var_dump($_SERVER);

$url = $_SERVER['REQUEST_URI'];

$smarty->assign('startTime',$_GET['startTime']);
$smarty->assign('endTime',$_GET['endTime']);
$smarty->assign('orderid',$_GET['orderid']);
$smarty->assign('pageTotal',$pageTotal);
$smarty->assign('url',$url);
$smarty->assign('p',$p);
$smarty->assign('list',$arr);
