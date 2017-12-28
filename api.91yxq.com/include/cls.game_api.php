<?php
class Game
{

    /**
     * 去除字符
     * @param string $user_name
     */
    function result_user_name($user_name)
    {
        $user_name = strtolower($user_name);
        $user_name = strtr($user_name, "@", ".");
        $user_name = urlencode($user_name);
        return $user_name;
    }

    function get_real_ip()
    {
        $ip = false;
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) {
                array_unshift($ips, $ip);
                $ip = FALSE;
            }
            for ($i = 0; $i < count($ips); $i++) {
                if (!eregi("^(10|172\.16|192\.168)\.", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }

    function gethys($userid, $user_name = '', $server_id, $fcm = 1, $wd = 0)
    {//登录
        $url_arr = array(
            'uid' => $userid,
            'dept' => 1116,
            'skey' => $server_id,
            'exts' => '',
            'is_adult' => $fcm,
            'game' => 'hys',
            'time' => time()
        );
        $url_arr['type'] = $wd ? 'desk' : 'web';
        $url_arr['sign'] = md5($url_arr['uid'] . $url_arr['game'] . $url_arr['dept'] . $url_arr['skey'] . $url_arr['type'] . $url_arr['is_adult'] . $url_arr['exts'] . $url_arr['time'] . 'c09aa878217512f85fe5c95a62e26758');
        return 'http://center.168pk.cn/api/normal.html?' . urldecode(http_build_query($url_arr));
    }

    //斗破沙城
    function getdpsc($userid, $user_name = '', $server_id, $fcm = 1, $wd = 0)
    {
        $md5key = 'A93DB3E8AEFD4A4D978120877D1874BC';
        $url_arr = array(
            'uid' => $userid,
            'time' => time(),
            'sid' => $server_id,
//            'platname' => 'test',
            'platname' => '91yxq',
            'isclient' => $wd
        );
        if ($wd == 1) {
            $url_arr['from'] = 'miniloader';
        }
        $url_arr['token'] = md5($url_arr['uid'] . $url_arr['time'] . $md5key . $url_arr['sid']);
        return 'http://dpscdlnew.dadayou.com/platlogin.html?' . urldecode(http_build_query($url_arr));
    }

    //斗破沙城混服
//    function getdpsc($userid, $user_name = '', $server_id, $fcm = 1, $wd = 0)
//    {
//       $md5key = 'h7k4Fi5dsll';
//       $url_arr = array(
//           'site' => '91yxq',
//           'uid' => $userid,
//           'game' => 85,
//           'time' => time(),
//           'num' => $server_id,
//       );
//       $url_arr['sign'] = md5($url_arr['site'].'|'.$url_arr['uid'].'|85|'.$url_arr['num'].'|'.$url_arr['time'].'|'.$md5key);
//       $login_url = file_get_contents('http://www.dadayou.com/i-api-login?' . urldecode(http_build_query($url_arr)));
//
//       return $login_url;
//    }

    function getmhzn2($userid, $user_name = '', $server_id, $fcm = 1, $wd = 0)
    {
        $md5key = '56C9821691CB430CA10879C988A0A5CF';
        $url_arr = array(
            'uid' => $userid,
            'time' => time(),
            'sid' => $server_id,
//            'platname' => 'test',
            'platname' => '91yxq',
            'isclient' => $wd
        );
        if ($wd == 1) {
            $url_arr['from'] = 'miniloader';
        }
        $url_arr['token'] = md5($url_arr['uid'] . $url_arr['time'] . $md5key . $url_arr['sid']);
        return 'http://dpscdlnew.dadayou.com/mhnplatlogin.html?' . urldecode(http_build_query($url_arr));
    }

    //热血虎卫
    function getrxhw($userid, $user_name = '', $server_id, $fcm = 1, $wd = 0)
    {
        $md5key = '8552C2B3C66E05AF6345';
        $url_arr = array(
            'user_name' => $user_name,
            'server_id' => $server_id,
            'is_adult' => 0,
            'client' => $wd,
            'time' => time(),
        );
        $url_arr['sign'] = strtolower(md5($url_arr['user_name'] . $url_arr['server_id'] . $url_arr['is_adult'] . $url_arr['time'] . $md5key));
        return 'http://rxhw.91yxq.com/login.php?' . urldecode(http_build_query($url_arr));
    }

    //成人三国志
    function getcrsgz($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = '501wan_91yxq';
        $url_arr = array(
            'pid' => 3,
            'userid' => $userid,
            'sid' => $server_id,
            'gid' => 132,
            'fcm' => $fcm,
            'time' => time(),
        );
        $url_arr['sign'] = strtolower(md5($url_arr['pid'] . $url_arr['userid'] . $url_arr['sid'] . $url_arr['gid'] . $url_arr['fcm'] . $url_arr['time'] . $key));
        $url = 'http://www.501wan.com/api/unionhf/login?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //战国之怒
    function getzgzs($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = '501wan_91yxq';
        $url_arr = array(
            'pid' => 3,
            'userid' => $userid,
            'sid' => $server_id,
            'gid' => 77,
            'fcm' => $fcm,
            'time' => time(),
        );
        $url_arr['sign'] = strtolower(md5($url_arr['pid'] . $url_arr['userid'] . $url_arr['sid'] . $url_arr['gid'] . $url_arr['fcm'] . $url_arr['time'] . $key));
        $url = 'http://www.501wan.com/api/unionhf/login?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //村长打天下
    function getczdtx($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = '501wan_91yxq';
        $url_arr = array(
            'pid' => 3,
            'userid' => $userid,
            'sid' => $server_id,
            'gid' => 95,
            'fcm' => $fcm,
            'time' => time(),
        );
        $url_arr['sign'] = strtolower(md5($url_arr['pid'] . $url_arr['userid'] . $url_arr['sid'] . $url_arr['gid'] . $url_arr['fcm'] . $url_arr['time'] . $key));
        $url = 'http://www.501wan.com/api/unionhf/login?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //女神联盟
    function getnslm($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = '501wan_91yxq';
        $url_arr = array(
            'pid' => 3,
            'userid' => $userid,
            'sid' => $server_id,
            'gid' => 112,
            'fcm' => $fcm,
            'time' => time(),
        );
        $url_arr['sign'] = strtolower(md5($url_arr['pid'] . $url_arr['userid'] . $url_arr['sid'] . $url_arr['gid'] . $url_arr['fcm'] . $url_arr['time'] . $key));
        $url = 'http://www.501wan.com/api/unionhf/login?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //武神赵子龙
    function getwszzl($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = '501wan_91yxq';
        $url_arr = array(
            'pid' => 3,
            'userid' => $userid,
            'sid' => $server_id,
            'gid' => 103,
            'fcm' => $fcm,
            'time' => time(),
        );
        $url_arr['sign'] = strtolower(md5($url_arr['pid'] . $url_arr['userid'] . $url_arr['sid'] . $url_arr['gid'] . $url_arr['fcm'] . $url_arr['time'] . $key));
        $url = 'http://www.501wan.com/api/unionhf/login?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //热血三国3
    function getrxsg3($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $url_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 55,
            'sid' => 's' . $server_id,
            'fcm' => 1,
            'time' => time(),
        );
        if ($wd == 1) {
            $url_arr['isclient'] = 1;
        }
        $url_arr['sign'] = md5("pid={$url_arr['pid']}&account={$url_arr['account']}&gid={$url_arr['gid']}&sid={$url_arr['sid']}&time={$url_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/GameLoginHandler.ashx?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //神道
    function getsd($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $url_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 67,
            'sid' => 's' . $server_id,
            'fcm' => 1,
            'time' => time(),
        );
        if ($wd == 1) {
            $url_arr['isclient'] = 1;
        }
        $url_arr['sign'] = md5("pid={$url_arr['pid']}&account={$url_arr['account']}&gid={$url_arr['gid']}&sid={$url_arr['sid']}&time={$url_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/GameLoginHandler.ashx?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //龙珠战纪
    function getlzzj($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $url_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 62,
            'sid' => 's' . $server_id,
            'fcm' => 1,
            'time' => time(),
        );
        if ($wd == 1) {
            $url_arr['isclient'] = 1;
        }
        $url_arr['sign'] = md5("pid={$url_arr['pid']}&account={$url_arr['account']}&gid={$url_arr['gid']}&sid={$url_arr['sid']}&time={$url_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/GameLoginHandler.ashx?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //仙侠道2
    function getxxd2($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $url_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 28,
            'sid' => 's' . $server_id,
            'fcm' => 1,
            'time' => time(),
        );
        if ($wd == 1) {
            $url_arr['isclient'] = 1;
        }
        $url_arr['sign'] = md5("pid={$url_arr['pid']}&account={$url_arr['account']}&gid={$url_arr['gid']}&sid={$url_arr['sid']}&time={$url_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/GameLoginHandler.ashx?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //青云志
    function getqyz($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $url_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 50,
            'sid' => 's' . $server_id,
            'fcm' => 1,
            'time' => time(),
        );
        if ($wd == 1) {
            $url_arr['isclient'] = 1;
        }
        $url_arr['sign'] = md5("pid={$url_arr['pid']}&account={$url_arr['account']}&gid={$url_arr['gid']}&sid={$url_arr['sid']}&time={$url_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/GameLoginHandler.ashx?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //风云无双
    function getfyws($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $url_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 77,
            'sid' => 's' . $server_id,
            'fcm' => 1,
            'time' => time(),
        );
        if ($wd == 1) {
            $url_arr['isclient'] = 1;
        }
        $url_arr['sign'] = md5("pid={$url_arr['pid']}&account={$url_arr['account']}&gid={$url_arr['gid']}&sid={$url_arr['sid']}&time={$url_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/GameLoginHandler.ashx?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //像素骑士团
    function getxsqst($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $url_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 3,
            'sid' => 's' . $server_id,
            'fcm' => 1,
            'time' => time(),
        );
        if ($wd == 1) {
            $url_arr['isclient'] = 1;
        }
        $url_arr['sign'] = md5("pid={$url_arr['pid']}&account={$url_arr['account']}&gid={$url_arr['gid']}&sid={$url_arr['sid']}&time={$url_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/GameLoginHandler.ashx?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //第一舰队
    function getdyjd($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $url_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 104,
            'sid' => 's' . $server_id,
            'fcm' => 1,
            'time' => time(),
        );
        if ($wd == 1) {
            $url_arr['isclient'] = 1;
        }
        $url_arr['sign'] = md5("pid={$url_arr['pid']}&account={$url_arr['account']}&gid={$url_arr['gid']}&sid={$url_arr['sid']}&time={$url_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/GameLoginHandler.ashx?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //不良人
    function getblr($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $url_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 116,
            'sid' => 's' . $server_id,
            'fcm' => 1,
            'time' => time(),
        );
        if ($wd == 1) {
            $url_arr['isclient'] = 1;
        }
        $url_arr['sign'] = md5("pid={$url_arr['pid']}&account={$url_arr['account']}&gid={$url_arr['gid']}&sid={$url_arr['sid']}&time={$url_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/GameLoginHandler.ashx?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //热血江湖
    function getrxjh($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $url_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 6,
            'sid' => 's' . $server_id,
            'fcm' => 1,
            'time' => time(),
        );
        if ($wd == 1) {
            $url_arr['isclient'] = 1;
        }
        $url_arr['sign'] = md5("pid={$url_arr['pid']}&account={$url_arr['account']}&gid={$url_arr['gid']}&sid={$url_arr['sid']}&time={$url_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/GameLoginHandler.ashx?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //神印王座
    function getsywz($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $url_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 124,
            'sid' => 's' . $server_id,
            'fcm' => 1,
            'time' => time(),
        );
        if ($wd == 1) {
            $url_arr['isclient'] = 1;
        }
        $url_arr['sign'] = md5("pid={$url_arr['pid']}&account={$url_arr['account']}&gid={$url_arr['gid']}&sid={$url_arr['sid']}&time={$url_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/GameLoginHandler.ashx?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //攻城掠地
    function getgcld($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $url_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 5,
            'sid' => 's' . $server_id,
            'fcm' => 1,
            'time' => time(),
        );
        if ($wd == 1) {
            $url_arr['isclient'] = 1;
        }
        $url_arr['sign'] = md5("pid={$url_arr['pid']}&account={$url_arr['account']}&gid={$url_arr['gid']}&sid={$url_arr['sid']}&time={$url_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/GameLoginHandler.ashx?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //操戈天下
    function getcgtx($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = '8cb4c78e5ae12ca8186fb3a1f9a77574';
        $url_arr = array(
            'agent' => '91yxq',
            'account' => $user_name,
            'serverId' => $server_id,
            'time' => time(),
            'isClient' => $wd,
            'fcm' => 1,
        );

        $url_arr['sign'] = strtolower(md5($url_arr['agent'] . $url_arr['account'] . $url_arr['serverId'] . $url_arr['time'] . $url_arr['fcm'] . $key));
        $url = 'http://cgtxlogin.play77.cn/login/?' . urldecode(http_build_query($url_arr));

        return $url;
    }

    //赤月传说2
    function getcycs2($userid, $user_name = '', $server_id, $fcm = 2, $wd = 0)
    {
        $key = 'EttzQwk2cTEP9M4GA593bCntN8KXEdnf';
        $url_arr = array(
            'user' => $user_name,
            'agent' => '91yxq',
            'sid' => $server_id,
            'time' => time(),
            'isAdult' => $fcm,
            'is_client' => $wd,
//            'source' => 1,
        );

        $url_arr['sign'] = md5("user={$url_arr['user']}&agent={$url_arr['agent']}&sid={$url_arr['sid']}&key={$key}&time={$url_arr['time']}");
        $url = 'http://s' . $server_id . '.cycs2.91yxq.com/api/glogin.php?' . urldecode(http_build_query($url_arr));

        return $url;
    }


}

?>