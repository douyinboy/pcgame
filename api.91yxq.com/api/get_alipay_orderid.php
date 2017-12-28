<?php
require('../include/config.inc.php');
require('../include/configApi.php');


$orderid  = htmlspecialchars($_GET['no']);

//判断参数是否为空
if (trim($orderid) == '') {
    exit('订单ID不能为空!');
}

//判断平台渠道号是否已注册
$sql = "SELECT orderid, game FROM " . PAYDB . "." . PAYORDER . " WHERE orderid = '" . $orderid . "'";

if ($result = $mysqli->query($sql)->fetch_assoc()) {
    $sql = "UPDATE " . PAYDB . "." . PAYORDER . " SET sync_date=" . time() . ",succ=1 WHERE orderid='" . $orderid . "'";
    $mysqli->query($sql);

    switch ($result['game']) {
        case 4:
            $game_name = 'crsgz';break;
        case 5:
            $game_name = 'zgzn';break;
        case 6:
            $game_name = 'czdtx';break;
        case 7:
            $game_name = 'nslm';break;
        case 18:
            $game_name = 'wszzl';break;
    }
    $table_name = 'pay_' . $game_name . '_log';
    $sql = "UPDATE " . PAYDB . "." . $table_name . " SET pay_result='成功', stat=1 WHERE orderid='" . $orderid . "'";
    $mysqli->query($sql);
} else {
    exit('该订单号不存在!');
}
