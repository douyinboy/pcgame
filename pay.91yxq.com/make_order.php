<?php
include(__DIR__ . "/include/config.inc.php");
include(__DIR__ . "/include/funcs.php");
$game_list = array(1, 2, 3, 21, 22); //1:100充值比例的游戏
$game_list_own = array();//自己游戏不扣率费
$pay_channel_own = array(); //渠道卡费率特殊性
$pay_channel_list = array(1 => '1', 2 => '1', 3 => '1', 4 => '1', 5 => '1', 6 => '0.95', 9 => '0.84', 10 => '1', 11 => '1', 12 => '1', 13 => '1', 14 => '0.95', 15 => '0.95', 18 => '1', 20 => '1', 23 => '1', 30 => '0.98', 31 => '0.98', 32 => '0.84', 33 => '1', 34 => '0.99', 35 => '0.95', 36 => '0.95', 37 => '0.95', 38 => '0.95', 39 => '0.95', 40 => '0.95', 41 => '0.86', 42 => '0.88', 43 => '0.88', 44 => '0.82', 46 => '1', 48 => '1', 100 => '1');
$user_ip = ip2long($_SERVER["HTTP_CDN_SRC_IP"]);
if (!$user_ip) {
    $user_ip = ip2long($_SERVER['REMOTE_ADDR']);
}
$phone = $_GET['phone'];
$pay_channel = $_GET['pay_type'] + 0;
$game = $_GET['game'] + 0;
$server = $_GET['server'] + 0;
$server_name = $_GET['server_name'];
$dfbank = $_GET['dfbank'];
$user = $_GET['user'];
if (strstr($user, '@qq')) {
    $user_arr = explode('-', $user);
    $user = trim($user_arr[count($user_arr) - 1]);
}
if (!chkUserName($user)) { //检查提交的用户名合法性
    echo 'money_too_more';
    exit;
}

//支付方式（渠道）
$query = mysql_query("select varValue from 91yxq_publish.91yxq_sys where id = 60");
$pay_toggle_obj = mysql_fetch_object($query);
if ($pay_toggle_obj->varValue == 1) {
    if ($pay_channel == 18) {
        $pay_channel = 20;
    }
    if ($pay_channel == 46) {
        $pay_channel = 48;
    }
}

$user = mysql_real_escape_string(strip_tags(trim(urldecode($user))));
$money = $_GET['money'] + 0;
if ($money < 10 || $money > 99999) {
    echo '每次充值金额不得小于10元';
    exit;
}

/** 最近充值游戏 start **/
$last_game = $_COOKIE['last_game'];
/** 最近充值游戏 end **/

$orderid = 'P' . date("YmdHis") . substr(microtime(), 2, 6);
$exchange_rate = 10;
if (in_array($game, $game_list)) {
    $exchange_rate = 100;
}

//查询充值用户信息
$sql = "SELECT * FROM 91yxq_users.users WHERE user_name='" . $user . "'";
$_res = mysql_query($sql);
$_row = mysql_fetch_object($_res);
//返利游戏集合
$game_rabate = [2, 3, 19, 21];
if (in_array($game, $game_rabate) && $_row->agent_id == 100) {
    $exchange_rate *= 2;
}

//mocuz和站长链接来的用户任何游戏充值双倍
if (in_array($_row->agent_id, [10020, 10021])) {
    $exchange_rate *= 2;
}

//if ($_row->uid == 5686) {
//    $money = 1;
//}

if (in_array($game, $game_list_own) && in_array($pay_channel, $pay_channel_own)) {
    $pay_channel_list[$pay_channel] = 1;
}
if (!empty($dfbank)) {
    set_cookie('dfbank', $dfbank, time() + 86400 * 7);
    $sql = "update pay_bank set bank_count=bank_count+1 where bank_name='{$dfbank}'";
    @mysql_query($sql);
}
$pay_gold = intval($money * $exchange_rate * $pay_channel_list[$pay_channel]);
$paid_amount = $pay_channel_list[$pay_channel] * $money;
mysql_query('START TRANSACTION;');
try {
    if ($pay_channel == 100) {
        $dfbank = '';
    }
    $res = mysql_query("INSERT INTO `pay_orders`(`orderid`,`user`,`money`,`paid_amount`,`pay_gold`,`game`,`server`,`pay_channel`,`user_ip`,`pay_date`,`bank_type`,`phone`) VALUES('$orderid','$user',$money,$paid_amount,$pay_gold,$game,$server,$pay_channel,$user_ip,UNIX_TIMESTAMP(),'$dfbank','$phone')");
    if ($res) {
        echo $orderid;
    } else {
        $orderid = 'P' . date("YmdHis") . substr(microtime(), 2, 6);
        if ($pay_channel == 100) {
            $dfbank = '';
        }
        $res = mysql_query("INSERT INTO `pay_orders`(`orderid`,`user`,`money`,`paid_amount`,`pay_gold`,`game`,`server`,`pay_channel`,`user_ip`,`pay_date`,`bank_type`,`phone`) VALUES('$orderid','$user',$money,$paid_amount,$pay_gold,$game,$server,$pay_channel,$user_ip,UNIX_TIMESTAMP(),'$dfbank','$phone')");
        echo $orderid;
    }
    mysql_query('commit;');
} catch (Exception $e) {
    mysql_query('rollback;');
}
exit;



/*   echo "4444444";
if($last_game){
    $last_game_arr=json_decode($last_game);
}
echo "555555555";
var_dump($last_game_arr);
$last_game_arr[$game][$server]=$server_name;
echo "6666666";
var_dump($last_game_arr);
if(count($last_game_arr)>3){
    array_pop($last_game_arr);
}
var_dump($last_game_arr);
$last_game=json_encode($last_game_arr);
set_cookie('last_game',$last_game,time()+86400*7);
 * */
?>