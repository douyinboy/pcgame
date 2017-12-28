<?php
require('../../include/config.inc.php');
require('./user.game_api.php');
require('../../include/function.php');
require('../../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/pc_egg/reg_by_api.php?pcid=12298131&agent_id=10073&place_id=10062
 */

$pcid     = htmlspecialchars(trim($_GET['pcid']));
$agent_id = htmlspecialchars(trim($_GET['agent_id']));
$place_id = htmlspecialchars(trim($_GET['place_id']));

//判断参数是否为空
if ($pcid == '' || $agent_id == '' || $place_id == '') {
    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
}

//验证签名
//$sign = $_GET['sign'];
//unset($_GET['sign']);
//if ($sign != getSign($_GET, SECRET_KEY)) {
//    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
//}

$bbs_username = 'pceggs_' . $pcid;
$adid    = 'ryln8H14VKc%3d';
$key     = '87b5b787044d2ec2';

$sql = "SELECT uid, user_name FROM 91yxq_users.users WHERE bbs_username = '" . $bbs_username . "' AND adid = '" . $adid . "'";
if ($result = $mysqli->query($sql)->fetch_assoc()) {
    $merid   = $result['uid'];
    $mername = $result['user_name'];
    $keycode = md5($pcid . $merid . $mername . $key);

    $gameUser = new GameUser();
    $url = 'http://adtaste.pceggs.com/ADComate/WebService/AdBack.aspx?pcid='.$pcid.'&adid='.$adid.'&merid='.$merid.'&mername='.$mername.'&keycode='.$keycode;
    $res = $gameUser->get_curl($url);
    if ($res != 1) {
        exit('PC蛋蛋验证失败！');
    }
} else {
    $nowtime = time();
    $sql = "INSERT INTO `users` (user_name, adid, bbs_username, agent_id, place_id, reg_time) VALUES('". $bbs_username . time() ."', '". $adid ."', '". $bbs_username ."', ". $agent_id .", ". $place_id .", $nowtime)";
    if ($result = $mysqli->query($sql)) {
        $uid = $mysqli->insert_id;
        $sql = "UPDATE users SET user_name='91yxq_" . $uid . "' WHERE uid = " . $uid;
        $mysqli->query($sql);
        $field=array('uid', 'user_name', 'login_time', 'reg_time', 'state');
        $value=array($uid, "91yxq_" . $uid, $nowtime, $nowtime, 1);
        if(dbinsert(usertab("91yxq_" . $uid), $field, $value)){
            //记录来源信息
            agentReg($agent_id, "91yxq_" . $uid, '', '', '', '', $place_id, '', $adid, '', 1, '');
        }

        $merid   = $uid;
        $mername = '91yxq_' . $uid;
        $keycode = md5($pcid . $uid . $mername . $key);

        $gameUser = new GameUser();
        $url = 'http://adtaste.pceggs.com/ADComate/WebService/AdBack.aspx?pcid='.$pcid.'&adid='.$adid.'&merid='.$merid.'&mername='.$mername.'&keycode='.$keycode;
        $res = $gameUser->get_curl($url);
        if ($res != 1) {
            exit('PC蛋蛋验证失败！');
        }
    }
}
