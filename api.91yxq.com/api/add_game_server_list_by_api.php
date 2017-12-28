<?php
require('../include/config.inc.php');
require('../include/configApi.php');

/**
 * @通过API创建游戏服务器列表
             * @param url http://api.demo.com/api/add_game_server_list_by_api.php?act=add&game_id=6&server_id=6&name=nihao&pay_url=http://www.baidu.com&create_date=2017-02-15 16:07:36&is_open=1&time=153545615244&sign=245s4df45s4d5f4s5d4f
 */

/**
array(3) {
    ["act"]=>string(3) "add"
    ["game_id"]=>string(1) "6"
    ["server_id"]=>string(1) "5"
    ["name"]=>string(16) "测试服务器3"
    ["pay_url"]=>string(19) "http://sys.demo.com"
    ["create_date"]=>string(19) "2017-02-15 16:07:36"
    ["is_open"]=>string(1) "1"
    ["time"]=>string(1) "5154154454"
    ["sign"]=>string(1) "d4s4df5sd4f5s7df8s8d9fsd"
}
 */

$act  = $_GET['act'];
$time = $_GET['time'];
$sign = $_GET['sign'];
unset($_GET['act']);
unset($_GET['time']);
unset($_GET['sign']);
$data = $_GET;

if ($sign != md5($time . $api_secret_key)) {
    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
}
switch ($act){
    case 'add':
        $sql = "SELECT * FROM " . PAYDB . "." . SERVERLIST . " WHERE server_id = " . $data['server_id'] . " AND game_id=" . $data['game_id'];
        if ($mysqli->query($sql)->fetch_object()) {
            exit(json_encode(['code' => 01, 'message' => '服务器序号已存在!']));
        }
        $sql = "SELECT * FROM " . PAYDB . "." . SERVERLIST . " WHERE name = '" . $data['name'] . "'";
        if ($mysqli->query($sql)->fetch_object()) {
            exit(json_encode(['code' => 02, 'message' => '服务器名称已存在!']));
        }
        foreach ($data as $k=>$v){
            $acc .= $k . "='" . $v . "',";
        }
        $sql = " INSERT INTO " . PAYDB . "." . SERVERLIST . " set " . substr($acc, 0, -1);
        $aa = $mysqli->query($sql);
        exit(json_encode(['code' => 00, 'message' => '服务器添加成功!']));
        break;
    case 'edit':
        if(empty($data['id'])){
            $id = $_REQUEST['id'];
            $sql="SELECT * FROM ".PAYDB.".".SERVERLIST." WHERE id=".$id;
            $data = $db ->get($sql);
        }
        unset($data['sub']);
        foreach ($data as $k=>$v){
            $acc.=$k."='".$v."',";
        }
        $sql = " UPDATE ".PAYDB.".".SERVERLIST." SET ".  substr($acc, 0,-1)." WHERE id = ".$data['id'];
        $db ->query($sql);
        echo  '<script language="javascript">alert("服务器更新成功！"); window.location.href="gameServerList.php?game_id='.$data['game_id'].'&page='.$_GET['page'].'"</script>';exit;
        break;
}