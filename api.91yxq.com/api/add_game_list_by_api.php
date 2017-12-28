<?php
require('../include/config.inc.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/add_game_list_by_api.php?act=add&game_byname=demo1&time=153545615244&sign=245s4df45s4d5f4s5d4f
 */

/**
 * array(3) {
    ["act"]=>string(8) "add"
    ["name"]=>tring(7) "测试1"
    ["game_byname"]=>string(5) "demo1"
    ["b_name"]=>string(6) "元宝"
    ["exchange_rate"]=>string(3) "100"
    ["rank"]=>string(1) "2"
    ["back_result"]=>string(1) "1"
    ["result_code"]=>string(1) "1"
    ["pay_url"]=>string(19) "http://sys.demo.com"
    ["fuildfc"]=>string(2) "60"
    ["is_open"]=>string(1) "1"
    ["owner"]=>string(2) "35"
    ["time"]=>654515454234
    ["sign"]=>35454fd5g5df5g2rd4g6retger

}
    name=测试1,game_byname=demo1,b_name=元宝,exchange_rate=100,rank=2,back_result=1,result_code='a:1:{i:1;N;}',pay_url='http://sys.demo.com',fuildfc='60',is_open='1',owner='35',
 */

$act = $_GET['act'];
$time = $_GET['time'];
$sign = $_GET['sign'];
unset($_GET['act']);
unset($_GET['time']);
unset($_GET['sign']);
$data = $_GET;

if ($sign != md5($time . $api_secret_key)) {
    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
}

switch($act){
    case 'add':
        $sql = "SELECT id, name FROM " . PAYDB . "." . GAMELIST . " where game_byname = '" . $data['game_byname'] . "' order by id desc";
        if ($mysqli->query($sql)->fetch_object()) {
            exit(json_encode(['code' => 01, 'message' => '游戏简称已存在!']));
        }

        $arr_tmp = preg_split('/\r\n/', trim($data['result_code']));
        $result_code = [];
        foreach ($arr_tmp as $v) {
            $av = explode(":", $v);
            $result_code[$av[0]] = $av[1];
        }
        unset($v);
        $data['result_code'] = serialize($result_code);
        foreach ($data as $k => $v){
            $acc .= $k . "='" . $v . "',";
        }
        $acc =  substr($acc, 0,-1);
        $sql = "INSERT INTO " . PAYDB . "." . GAMELIST . " SET " . $acc;
        $db->query($sql);
        $db->query("CREATE TABLE IF NOT EXISTS " . PAYDB . " .`pay_" . $data['game_byname'] . "_log` (
            `id` int(10) NOT NULL AUTO_INCREMENT,
            `orderid` varchar(30) NOT NULL,
            `user_name` varchar(40) NOT NULL,
            `money` smallint(5) NOT NULL,
            `paid_amount` decimal(7,2) NOT NULL,
            `pay_type` tinyint(3) NOT NULL,
            `pay_gold` mediumint(8) NOT NULL,
            `sign` varchar(32) NOT NULL,
            `pay_date` datetime NOT NULL,
            `user_ip` varchar(19) NOT NULL,
            `back_result` tinyint(1) NOT NULL,
            `pay_result` varchar(30) NOT NULL,
            `server_id` smallint(5) NOT NULL,
            `remark` varchar(30) NOT NULL,
            `stat` tinyint(1) NOT NULL,
            `pay_url` varchar(255) NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `orderid` (`orderid`),
            KEY `user_name` (`user_name`),
            KEY `pay_date` (`pay_date`),
            KEY `stat` (`stat`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

        exit(json_encode(['code' => 00, 'message' => '游戏添加成功!']));
        break;
    case 'update':
        $arr_tmp = preg_split('/\r\n/', trim($data['result_code']));
        $result_code = array();
        foreach ($arr_tmp as $v) {
            $av = explode(":", $v);
            $result_code[$av[0]] = $av[1];
        }
        unset($v);
        $data['result_code'] = serialize($result_code);
        foreach ($data as $k => $v){
            $acc .= $k . "='" . $v . "',";
        }
        $acc =  substr($acc, 0,-1);
        $sql = 'UPDATE ' . PAYDB . '.' . GAMELIST . ' SET ' . $acc . ' WHERE id = ' . $id;
        $db->query($sql);
        $sql = "SELECT id,name FROM " . PAYDB . "." . GAMELIST . " where 1 order by id desc ";
        $garr = $db->find($sql);
        foreach($garr as $gr){
            $game_arr[$gr['id']] = $gr['name'];
        }
        $gl_str=serialize($game_arr);
        echo  '<script language="javascript">alert("游戏修改成功！"); window.location.href="gameList.php";</script>';
        die;
        break;
}

//$sql="select * from  ".YYDB.".".COMPANY." order by name desc";
//$res=$db->find($sql);
//foreach($res as $val){
//    $company_list[$val['id']]=$val['name'];
//}