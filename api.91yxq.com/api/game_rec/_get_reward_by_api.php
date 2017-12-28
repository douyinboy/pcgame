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

$state   = 1;
$content = '';
//判断参数是否为空
if (empty($_GET['from']) || empty($_GET['stage']) || empty($_GET['gid']) || empty($_GET['guid'])) {
    exit('所有的参数都不能为空!');
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
        exit('pceggs所有参数均不能为空!');
    }

    //验证签名
    if ($keycode != md5($user_id . $key)) {
        exit('验证码不对!');
    }
}

$sql = "SELECT uid, user_name FROM 91yxq_users.users WHERE agent_id != 100 AND uid = " . $user_id;
$res = $mysqli->query($sql)->fetch_assoc();
if (!$res) {
    exit('获取游戏信息时错误');
}

$sql = "SELECT server_id FROM 91yxq_users.91yxq_agent_reg_2017 WHERE user_name = '" . $res['user_name'] . "'";
$res2 = $mysqli->query($sql)->fetch_assoc();

$sql = "SELECT login_info FROM 91yxq_users.91yxq_login_info WHERE user_name = '" . $res['user_name'] . "'";
$res1 = $mysqli->query($sql)->fetch_assoc();
$server_id_arr = unserialize($res1['login_info']);

$key = $from . '_' . $game_id . '_' . $stage;
$server_id_area = $game_rec_server_arr[$key];

if ($res2['server_id'] < $server_id_area[0] || $res2['server_id'] > $server_id_area[1]) {
    exit('您的帐号不在本次活动范围内!');
}

$mem = new Memcache();
$link = $mem->connect('127.0.0.1', 11211);
$mem_key = $key . '_' . $user_id;
$mem->delete($key . '_166430');
$json = $mem->get($mem_key);

if ($json === false) {
    $gameUserModel = new GameUser();
    $max = 0;
    $_nickname = '';
    $power = 0;

    foreach ($server_id_arr as $val) {
        if (
            $val['gid'] == $game_id
            && $val['sid'] >= $server_id_area[0]
            && $val['sid'] <= $server_id_area[1]
        ) {
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
                default:
                    $status = false;
                    $level = 0;
                    $nickname = '';
            }
            if ($status) {
                if ($max < $level) {
                    $max = $level;
                    $_nickname = $nickname;
                    $serverId = $val['sid'];
                }
                if ($from == 'pceggs' || $from == 'tiantianzuan') {
                    if ($game_id == 21 && $val['sid'] > 22) {
                        if ($max < $power) {
                            $max = $power;
                            $_nickname = $nickname;
                            $serverId = $val['sid'];
                        }
                    }
                }
                if ($game_id == 21 && $val['sid'] > 29) {
                    if ($max < $power) {
                        $max = $power;
                        $_nickname = $nickname;
                        $serverId = $val['sid'];
                    }
                }
            }
        }
    }

    if ($max == 0) {
        exit('获取游戏信息时错误!');
    }

    $json = $from($res, $_nickname, $max, $serverId, $mysqli);
    $mem->set($mem_key, $json, MEMCACHE_COMPRESSED, 3600);
}

echo $json;


