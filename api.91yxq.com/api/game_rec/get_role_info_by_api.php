<?php
require('./game_rec_server.php');
require('../../include/config.inc.php');
require('../../include/function.php');
require('../../include/common.php');
require('../../include/configApi.php');
require('../pc_egg/user.game_api.php');

/**
 *pceggs http://api.91yxq.com/api/game_rec/get_reward_by_api.php?guid=73514&keycode=szdfgsd&gid=3&from=pceggs&stage=1
 *
 *bengbeng http://api.91yxq.com/api/game_rec/get_reward_by_api.php?guid=73350&gid=3&from=bengbeng&stage=1
 *
 *juxiangyou http://api.91yxq.com/api/game_rec/get_reward_by_api.php?guid=73291&gid=3&from=juxiangyou&stage=1
 *
 *youyiwang http://api.91yxq.com/api/game_rec/get_reward_by_api.php?guid=61173&gid=3&from=youyiwang&stage=1
 *
 *kuailezhuan http://api.91yxq.com/api/game_rec/get_reward_by_api.php?guid=73320&gid=3&from=kuailezhuan&stage=1
 *
 *tiantianzuan http://api.91yxq.com/api/game_rec/get_reward_by_api.php?guid=73326&gid=3&from=tiantianzuan&stage=1
 *
 *quba http://api.91yxq.com/api/game_rec/get_reward_by_api.php?guid=73342&gid=3&from=quba&stage=1
 *
 *shitoucun http://api.91yxq.com/api/game_rec/get_reward_by_api.php?guid=73342&gid=3&from=shitoucun&stage=1
 *
 *ledouwan http://api.91yxq.com/api/game_rec/get_reward_by_api.php?guid=73342&gid=3&from=ledouwan&stage=1
 *
 *jiquwang http://api.91yxq.com/api/game_rec/get_reward_by_api.php?guid=73342&gid=3&from=jiquwang&stage=1
 *
 *jujuwan http://api.91yxq.com/api/game_rec/get_reward_by_api.php?guid=166430&gid=21&from=jujuwan&stage=1
 */

//判断参数是否为空
if (empty($_GET['from']) || empty($_GET['stage']) || empty($_GET['gid']) || empty($_GET['guid'])) {
    exit('All the parameters can not be empty!');
}

$from = htmlspecialchars(trim($_GET['from']));
$stage = htmlspecialchars(trim($_GET['stage']));
$game_id = htmlspecialchars(trim($_GET['gid']));
$user_id     = htmlspecialchars(trim($_GET['guid']));

if ($from === 'pceggs') {
    $key       = '87b5b787044d2ec2';	//定义由PC蛋蛋提供的KEY 需保密；
    $keycode   = htmlspecialchars(trim($_GET['keycode']));

    //判断参数是否为空
    if ($keycode == '') {
        exit('pceggs keycode parameters can not be empty!');
    }

    //验证签名
    if ($keycode != md5($user_id . $key)) {
        exit('Verification code is incorrect!');
    }
}

//判断此用户是否存在
$sql = "SELECT uid, user_name FROM 91yxq_users.users WHERE agent_id != 100 AND uid = " . $user_id;
$res = $mysqli->query($sql)->fetch_assoc();
if (!$res) {
    exit('Get user information error!');
}

//获取此用户注册的区服
$sql = "SELECT server_id FROM 91yxq_users.91yxq_agent_reg_2017 WHERE user_name = '" . $res['user_name'] . "'";
$res2 = $mysqli->query($sql)->fetch_assoc();

//获取此用户登录过的游戏、区服
$sql = "SELECT login_info FROM 91yxq_users.91yxq_login_info WHERE user_name = '" . $res['user_name'] . "'";
$res1 = $mysqli->query($sql)->fetch_assoc();
$server_id_arr = unserialize($res1['login_info']);

//获取此次活动区服范围
$sql = "SELECT id FROM 91yxq_admin.agent WHERE agentname = '" . $from . "'";
$agent = $mysqli->query($sql)->fetch_assoc();

//获取此次活动区服范围
$sql = "SELECT start_server_id, end_server_id FROM 91yxq_users.channel WHERE game_id = " . $game_id . " AND agent_id = " . $agent['id'] . " AND adid = '" . $stage . "'";

$res3 = $mysqli->query($sql)->fetch_assoc();

//判断该用户是否是此次活动注册的
if ($res2['server_id'] < $res3['start_server_id'] || $res2['server_id'] > $res3['end_server_id']) {
    exit('Your account is not within this activity!');
}

//$server_id_area = $game_rec_server_arr[$key];

//if ($res2['server_id'] < $server_id_area[0] || $res2['server_id'] > $server_id_area[1]) {
//    exit('您的帐号不在本次活动范围内!');
//}

$mem = new Memcache();
$link = $mem->connect('127.0.0.1', 11211);
$mem_key = $from . '_' . $game_id . '_' . $stage . '_' . $user_id;
$mem->delete($from . '_' . $game_id . '_' . $stage . '_' . '_185430');
$json = $mem->get($mem_key);

if ($json === false) {
    $gameUserModel = new GameUser();
    $max = 0;
    $_nickname = '';
    $power = 0;
    $high_level_server = 0;

    foreach ($server_id_arr as $val) {
        if (
            $val['gid'] == $game_id
            && $val['sid'] >= $res3['start_server_id']
            && $val['sid'] <= $res3['end_server_id']
        ) {
            //获取用户游戏信息
            $result = $gameUserModel->main($game_id, $val['sid'], $res['user_name']);

            switch ($game_id) {
                case 3:                           //热血虎卫
                    $status = $result['code'] === 1 ? true : false;
                    $level = $result['data']['level'];
                    $nickname = $result['data']['name'];
                    break;
                case 19:                           //操戈天下
                    $status = is_array($result) ? true : false;
                    $level = $result[0]['grade'];
                    $nickname = $result[0]['nickname'];
                    break;
                case 21:                           //赤月传说2
                    $status = is_array($result) ? true : false;
                    $level = $result[0]['level'];
                    $power = $result[0]['power'];
                    $nickname = $result[0]['name'];
                    break;
                case 22:                           //蛮荒之怒2
                    $status = $result['type'] === 1 ? true : false;
                    $level = $result['value'];
                    $nickname = $result['message'];
                    break;
                default:
                    $status = false;
                    $level = 0;
                    $nickname = '';
            }
            if ($status) {
                //赤月传说2用战力，其他游戏用等级
                if ($game_id == 21) {
                    if ($max < $power) {
                        $max = $power;
                        $_nickname = $nickname;
                        $high_level_server = $val['sid'];
                    }
                } else {
                    if ($max < $level) {
                        $max = $level;
                        $_nickname = $nickname;
                        $high_level_server = $val['sid'];
                    }
                }
            }
        }
    }

    if ($max == 0) {
        exit('Error getting game information!');
    }

    $json = $from($res, $_nickname, $max, $high_level_server, $mysqli);
    $mem->set($mem_key, $json, MEMCACHE_COMPRESSED, 3600);
}

echo $json;


