<?php
require('../include/config.inc.php');
require('../include/function.php');
require('../include/configApi.php');

/**
 * @通过API添加游戏列表
 * @param url http://api.demo.com/api/get_user_info_by_api.php?time=153545615244&sign=245s4df45s4d5f4s5d4f&url=http://www.baidu1.com&username=abcdefg
 */

$username = htmlspecialchars(urldecode($_GET['username']));
$url      = htmlspecialchars($_GET['url']);
$time     = htmlspecialchars($_GET['time']);
$sign     = htmlspecialchars($_GET['sign']);

//判断参数是否为空
if (trim($username) == '' ||  trim($url) == '' || trim($time) == '' || trim($sign) == '') {
    exit(json_encode(['code' => 01, 'message' => '所有参数均不能为空!']));
}

//验证签名
$sign = $_GET['sign'];
unset($_GET['sign']);
if ($sign != getSign($_GET, SECRET_KEY)) {
    exit(json_encode(['code' => 10, 'message' => 'SIGN ERROR!']));  //签名错误
}

$bbsname_arr = explode('.', trim($url));
$bbsname = $bbsname_arr[1];
$agentname = $bbsname . '_' . mt_rand(10000, 999999);
$bbs_username = $username;

$agent_site_id = createAgentMember(10020, $agentname, $url, $mysqli);
createUser(10020, $agent_site_id, $bbs_username, $mysqli);

function createAgentMember($agent_id, $agentname, $url, $mysqli)
{
    $sql = "SELECT site_id FROM " . ADMINTABLE . "." . GUILDMEMBER . " WHERE url = '" . $url . "'";
    if ($result = $mysqli->query($sql)->fetch_assoc()) {
        return $result['site_id'];
    } else {
        //新增渠道成员
        $sql = "INSERT INTO " . ADMINTABLE . "." . GUILDMEMBER . " (`author`, `agent_id`, `aAccount`, `aPass`, `url`, `addtime`) VALUES ('" . $agentname . "'," . $agent_id . ", '" . $agentname . "', '". AGENT_ADMIN_PWD . "', '" . $url . "', '" . date('Y-m-d H:i:s') . "')";
        if ($mysqli->query($sql)) {
            return $mysqli->insert_id;
        } else {
            exit(json_encode(['code' => 02, 'message' => 'agent_site生成失败!']));
        }
    }
}

function createUser($agent_id, $agent_site_id, $bbs_username, $mysqli)
{
    $sql = "SELECT user_name FROM 91yxq_users.users WHERE bbs_username = '" . $bbs_username . "' AND place_id = " . $agent_site_id;
    if ($result = $mysqli->query($sql)->fetch_assoc()) {
        $data['username'] = $result['user_name'];
        exit(json_encode(['code' => 00, 'data' => $data]));
    } else {
        $nowtime = time();
        $sql = "INSERT INTO `users` (user_name, bbs_username, agent_id, place_id, reg_time) VALUES('". $bbs_username . time() ."', '". $bbs_username ."', ". $agent_id .", ". $agent_site_id .", $nowtime)";
        if ($result = $mysqli->query($sql)) {
            $uid = $mysqli->insert_id;
            $sql = "UPDATE users SET user_name='91yxq_" . $uid . "' WHERE uid = " . $uid;
            $mysqli->query($sql);
            $field=array('uid', 'user_name', 'login_time', 'reg_time', 'state');
            $value=array($uid, "91yxq_" . $uid, $nowtime, $nowtime, 1);
            if(dbinsert(usertab("91yxq_" . $uid), $field, $value)){
                //记录来源信息
                agentReg($agent_id, "91yxq_" . $uid, '', '', '', '', $agent_site_id, '', '', '', 1, '');
            }
            $data['username'] = "91yxq_" . $uid;
//            exit(json_encode(['code' => 00, 'username' => "91yxq_" . $uid, 'table' => usertab("91yxq_" . $uid)]));
            exit(json_encode(['code' => 00, 'data' => $data]));
        }
    }
}