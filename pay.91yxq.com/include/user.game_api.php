<?php

/* * ****** Create **********
 * $Author: 91yxq技术部 $ 
 * $Modtime: 2014-03-09 20:35 $ 
 * $Revision: 7 $ 
 * $Description 联营游戏角色API接口
 */

class GameUser
{

    private function get_curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);
        unset($ch);
        return $result;
    }

    private function get_info($url, $param = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_GET, 1);
// 		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_COOKIEJAR, COOKIEJAR);
        curl_setopt($ch, CURLOPT_TIMEOUT, TIMEOUT);

        ob_start();
        curl_exec($ch);
        $contents = ob_get_contents();
        ob_end_clean();
        curl_close($ch);
        return $contents;
    }

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

    /* 返回用户id */

    private function get_userid($user_name)
    {
        $userid = $this->get_curl("http://api.91yxq.com/api/get_userid.php?user_name=" . urlencode(strtolower($user_name)));
        if ($userid) {
            return $userid;
        } else {
            return false;
        }
    }

    /**
     * 返回玩家在游戏中是否创建角色
     * @param unknown_type $gameid
     * @param unknown_type $serverid
     * @param unknown_type $user_name
     */
    public function main($gameid, $serverid, $user_name, $isShowName = false)
    {
        $function = '';
        $uid = $this->get_userid($user_name);
        if (!$uid) return 'no';
        switch ($gameid) {
            case 1:
                ;
                $function = 'hys';    //火焰神
                break;
            case 2:
                ;
                $function = 'dpsc';   //斗破沙城
                break;
            case 3:
                $function = 'rxhw';   //热血虎卫
                break;
            case 4:
                $function = 'crsgz';  //成人三国志
                break;
            case 5:
                $function = 'zgzn';   //战国之势
                break;
            case 6:
                $function = 'czdtx';  //村长打天下
                break;
            case 7:
                $function = 'nslm';   //女神联盟
                break;
            case 8:
                $function = 'rxsg3';   //热血三国3
                break;
            case 9:
                $function = 'sd';      //神道
                break;
            case 10:
                $function = 'lzzj';    //龙珠战纪
                break;
            case 11:
                $function = 'xxd2';    //仙侠道2
                break;
            case 12:
                $function = 'qyz';     //青云志
                break;
            case 13:
                $function = 'fyws';    //风云无双
                break;
            case 14:
                $function = 'xsqst';   //像素骑士团
                break;
            case 15:
                $function = 'dyjd';    //第一舰队
                break;
            case 16:
                $function = 'blr';     //不良人
                break;
            case 17:
                $function = 'rxjh';    //热血江湖
                break;
            case 18:
                $function = 'wszzl';   //武神赵子龙
                break;
            case 19:
                $function = 'cgtx';    //操戈天下
                break;
            case 20:
                $function = 'sywz';    //神印王座
                break;
            case 21:
                $function = 'cycs2';   //赤月传说2
                break;
            case 22:
                $function = 'mhzn2';   //蛮荒之怒2
                break;
            case 25:
                $function = 'gcld';    //攻城掠地
                break;
        }
        $tmp = 'no';
        if ($function) {
            $tmp = $this->$function($serverid, $uid, $user_name, $isShowName);
        }
        return $tmp;
    }

    public function getRoleName($gameid, $serverid, $user_name)
    {
        return $this->main($gameid, $serverid, $user_name, true);
    }

    //魔神变
    private function hys($serverid, $uid, $user_name, $isShowName = false)
    {
        $param_arr = array(
            'account' => $uid,
            'game' => 'hys',
            'dept' => 1116,
            'time' => time(),
            'skey' => $serverid,
        );
        $param_arr['sign'] = md5($param_arr['account'] . $param_arr['game'] . $param_arr['dept'] . $param_arr['skey'] . $param_arr['time'] . 'c09aa878217512f85fe5c95a62e26758');
        $res2 = file_get_contents('http://api.hys.168pk.cn/apinormal/userinfo?' . urldecode(http_build_query($param_arr)));
        $res = json_decode($res2, true);
        $result = 'no';
        $res['code'] == 0 && $result = 'ok';
        $isShowName && $result = $res['data']['nickname'];
        return $result;
    }

    //斗破沙城
    private function dpsc($serverid, $uid, $user_name, $isShowName = false)
    {
        $param_arr = array(
            'uid' => $uid,
            'sid' => $serverid,
//            'platname' => 'test',
            'platname' => '91yxq',
        );
        $res2 = file_get_contents('http://115.159.212.216/home/aboutrole?' . urldecode(http_build_query($param_arr)));
        $res = json_decode($res2, true);
        //{'type':1, 'message':'[1区诸葛元龙]', 'value':'54'}
        $result = 'no';
        $res['type'] == 1 && $result = 'ok';
        $isShowName && $result = $res['message'];
        return $result;
    }

    //斗破沙城混服
//    private function dpsc($serverid, $uid, $user_name, $isShowName = false)
//    {
//        $key = 'h7k4Fi5dsll';
//        $param_arr = array(
//            'uid' => $uid,
//            'site' => '91yxq',
//            'game' => 85,
//            'time' => time(),
//            'num' => $serverid,
//        );
//        $param_arr['sign'] = md5($param_arr['site'].'|'.$param_arr['uid'].'|85|'.$param_arr['num'].'|'.$param_arr['time'].'|'.$key);
//        $res2 = file_get_contents('http://www.dadayou.com/i-api-role?' . urldecode(http_build_query($param_arr)));
//        $res = json_decode($res2, true);
////        echo "<pre>";
////        var_dump($res);die;
//        /*
//         * array(1) {
//              [0]=>
//              array(2) {
//                ["name"]=>
//                string(18) "[1区]左丘修杰"
//                ["level"]=>
//                string(1) "4"
//              }
//            }
//         */
//        $result = 'no';
//        !empty($res) && $result = 'ok';
//        $isShowName && $result = $res[0]['name'];
//        return $result;
//    }

    //蛮荒之怒2
    private function mhzn2($serverid, $uid, $user_name, $isShowName = false)
    {
        $param_arr = array(
            'uid' => $uid,
            'sid' => $serverid,
//            'platname' => 'test',
            'platname' => '91yxq',
        );

        $res2 = file_get_contents('http://115.159.212.216:6011/mhznup/aboutrole?' . urldecode(http_build_query($param_arr)));

//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, 'http://115.159.212.216:6011/mhznup/aboutrole?' . urldecode(http_build_query($param_arr)));
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//        $res2 = curl_exec($ch);
//        $error = curl_error($ch);
//        $errno = curl_errno($ch);
////        print_r(curl_getinfo($ch));exit;
//        var_dump($res2,$error,$errno);die;
//        curl_close($ch);
//        unset($ch);

        $res = json_decode($res2, true);
        //{'type':1, 'message':'[1区诸葛元龙]', 'value':'54'}
        $result = 'no';
        $res['type'] == 1 && $result = 'ok';
        $isShowName && $result = $res['message'];
        return $result;
    }

    //热血虎卫
    private function rxhw($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = '8552C2B3C66E05AF6345';
        $param_arr = array(
            'user_name' => $user_name,
            'server_id' => $serverid,
            'time' => time(),
        );
        $param_arr['sign'] = strtolower(md5($param_arr['server_id'] . $param_arr['user_name'] . $param_arr['time'] . $key));

        $res2 = file_get_contents('http://rxhw.91yxq.com/query.php?' . urldecode(http_build_query($param_arr)));
//        {'code':1,'msg':'查询成功'，data:{'id':'玩家游戏内ID','name':'角色名','level':'等级','sex':'性别','carrer':'职业'}}
//        {'code':-1,'msg':'用户不存在'}
//        {'code':-2,'msg':'参数错误'}
//        {'code':-3,'msg':'连接服务器失败'}
//        {'code':-4,'msg':'超时'}
//        {'code':-5,'msg':'sign错误'}
//        {'code':-1,'msg':'用户不存在'}
        $res = json_decode($res2, true);
        $result = 'no';
        $res['code'] == 1 && $result = 'ok';
        $isShowName && $result = $res['data']['name'];
        return $result;
    }

    //成人三国志
    private function crsgz($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = '501wan_91yxq';
        $param_arr = array(
            'pid' => 3,
            'userid' => $uid,
            'sid' => $serverid,
            'gid' => 132,
            'time' => time(),
        );
        $param_arr['sign'] = strtolower(md5($param_arr['pid'] . $param_arr['userid'] . $param_arr['sid'] . $param_arr['gid'] . $param_arr['time'] . $key));

        $res2 = file_get_contents('http://www.501wan.com/api/unionhf/check?' . urldecode(http_build_query($param_arr)));
        $res = json_decode($res2, true);
        $result = 'no';
        $res['code'] == 0 && $result = 'ok';
        $isShowName && $result = $res['msg']['role_name'];
        return $result;
    }

    //战国之怒
    private function zgzn($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = '501wan_91yxq';
        $param_arr = array(
            'pid' => 3,
            'userid' => $uid,
            'sid' => $serverid,
            'gid' => 77,
            'time' => time(),
        );
        $param_arr['sign'] = strtolower(md5($param_arr['pid'] . $param_arr['userid'] . $param_arr['sid'] . $param_arr['gid'] . $param_arr['time'] . $key));

        $res2 = file_get_contents('http://www.501wan.com/api/unionhf/check?' . urldecode(http_build_query($param_arr)));
        $res = json_decode($res2, true);
        $result = 'no';
        $res['code'] == 0 && $result = 'ok';
        $isShowName && $result = $res['msg']['role_name'];
        return $result;
    }

    //村长打天下
    private function czdtx($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = '501wan_91yxq';
        $param_arr = array(
            'pid' => 3,
            'userid' => $uid,
            'sid' => $serverid,
            'gid' => 95,
            'time' => time(),
        );
        $param_arr['sign'] = strtolower(md5($param_arr['pid'] . $param_arr['userid'] . $param_arr['sid'] . $param_arr['gid'] . $param_arr['time'] . $key));

        $res2 = file_get_contents('http://www.501wan.com/api/unionhf/check?' . urldecode(http_build_query($param_arr)));
        $res = json_decode($res2, true);
        $result = 'no';
        $res['code'] == 0 && $result = 'ok';
        $isShowName && $result = $res['msg']['role_name'];
        return $result;
    }

    //女神联盟
    private function nslm($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = '501wan_91yxq';
        $param_arr = array(
            'pid' => 3,
            'userid' => $uid,
            'sid' => $serverid,
            'gid' => 112,
            'time' => time(),
        );
        $param_arr['sign'] = strtolower(md5($param_arr['pid'] . $param_arr['userid'] . $param_arr['sid'] . $param_arr['gid'] . $param_arr['time'] . $key));

        $res2 = file_get_contents('http://www.501wan.com/api/unionhf/check?' . urldecode(http_build_query($param_arr)));
        $res = json_decode($res2, true);
        $result = 'no';
        $res['code'] == 0 && $result = 'ok';
        $isShowName && $result = $res['msg']['role_name'];
        return $result;
    }

    //武神赵子龙
    private function wszzl($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = '501wan_91yxq';
        $param_arr = array(
            'pid' => 3,
            'userid' => $uid,
            'sid' => $serverid,
            'gid' => 103,
            'time' => time(),
        );
        $param_arr['sign'] = strtolower(md5($param_arr['pid'] . $param_arr['userid'] . $param_arr['sid'] . $param_arr['gid'] . $param_arr['time'] . $key));

        $res2 = file_get_contents('http://www.501wan.com/api/unionhf/check?' . urldecode(http_build_query($param_arr)));
        $res = json_decode($res2, true);
        $result = 'no';
        $res['code'] == 0 && $result = 'ok';
        $isShowName && $result = $res['msg']['role_name'];
        return $result;
    }

    //热血三国3
    private function rxsg3($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 55,
            'sid' => 's' . $serverid,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/QueryRole.ashx?' . urldecode(http_build_query($param_arr));
        //{"Status":"1","Data":[{"rolename":"寂寞灬の狂欢","level":6}]}
        $res2 = file_get_contents($url);
        $res = json_decode($res2, true);
        $result = 'no';
        $res['Status'] == 1 && $result = 'ok';
        $isShowName && $result = $res['Data'][0]['rolename'];

        return $result;
    }

    //神道
    private function sd($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 67,
            'sid' => 's' . $serverid,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/QueryRole.ashx?' . urldecode(http_build_query($param_arr));
        $res2 = file_get_contents($url);
        $res = json_decode($res2, true);
        $result = 'no';
        $res['Status'] == 1 && $result = 'ok';
        $isShowName && $result = $res['Data'][0]['rolename'];

        return $result;
    }

    //龙珠战纪
    private function lzzj($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 60,
            'sid' => 's' . $serverid,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/QueryRole.ashx?' . urldecode(http_build_query($param_arr));
        $res2 = file_get_contents($url);
        $res = json_decode($res2, true);
        $result = 'no';
        $res['Status'] == 1 && $result = 'ok';
        $isShowName && $result = $res['Data'][0]['rolename'];

        return $result;
    }

    //仙侠道2
    private function xxd2($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 28,
            'sid' => 's' . $serverid,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/QueryRole.ashx?' . urldecode(http_build_query($param_arr));
        $res2 = file_get_contents($url);
        $res = json_decode($res2, true);
        $result = 'no';
        $res['Status'] == 1 && $result = 'ok';
        $isShowName && $result = $res['Data'][0]['rolename'];

        return $result;
    }

    //青云志
    private function qyz($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 50,
            'sid' => 's' . $serverid,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/QueryRole.ashx?' . urldecode(http_build_query($param_arr));
        $res2 = file_get_contents($url);
        $res = json_decode($res2, true);
        $result = 'no';
        $res['Status'] == 1 && $result = 'ok';
        $isShowName && $result = $res['Data'][0]['rolename'];

        return $result;
    }

    //风云无双
    private function fyws($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 77,
            'sid' => 's' . $serverid,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/QueryRole.ashx?' . urldecode(http_build_query($param_arr));
        $res2 = file_get_contents($url);
        $res = json_decode($res2, true);
        $result = 'no';
        $res['Status'] == 1 && $result = 'ok';
        $isShowName && $result = $res['Data'][0]['rolename'];

        return $result;
    }

    //像素骑士团
    private function xsqst($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 3,
            'sid' => 's' . $serverid,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/QueryRole.ashx?' . urldecode(http_build_query($param_arr));
        $res2 = file_get_contents($url);
        $res = json_decode($res2, true);
        $result = 'no';
        $res['Status'] == 1 && $result = 'ok';
        $isShowName && $result = $res['Data'][0]['rolename'];

        return $result;
    }

    //第一舰队
    private function dyjd($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 104,
            'sid' => 's' . $serverid,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/QueryRole.ashx?' . urldecode(http_build_query($param_arr));
        $res2 = file_get_contents($url);
        $res = json_decode($res2, true);
        $result = 'no';
        $res['Status'] == 1 && $result = 'ok';
        $isShowName && $result = $res['Data'][0]['rolename'];

        return $result;
    }

    //不良人
    private function blr($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 116,
            'sid' => 's' . $serverid,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/QueryRole.ashx?' . urldecode(http_build_query($param_arr));
        $res2 = file_get_contents($url);
        $res = json_decode($res2, true);
        $result = 'no';
        $res['Status'] == 1 && $result = 'ok';
        $isShowName && $result = $res['Data'][0]['rolename'];

        return $result;
    }

    //热血江湖
    private function rxjh($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 6,
            'sid' => 's' . $serverid,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/QueryRole.ashx?' . urldecode(http_build_query($param_arr));
        $res2 = file_get_contents($url);
        $res = json_decode($res2, true);
        $result = 'no';
        $res['Status'] == 1 && $result = 'ok';
        $isShowName && $result = $res['Data'][0]['rolename'];

        return $result;
    }

    //神印王座
    private function sywz($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 124,
            'sid' => 's' . $serverid,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/QueryRole.ashx?' . urldecode(http_build_query($param_arr));
        $res2 = file_get_contents($url);
        $res = json_decode($res2, true);
        $result = 'no';
        $res['Status'] == 1 && $result = 'ok';
        $isShowName && $result = $res['Data'][0]['rolename'];

        return $result;
    }

    //攻城掠地
    private function gcld($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = 'cJ7THwvNIIdP0wIrFUdP';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $user_name,
            'gid' => 5,
            'sid' => 's' . $serverid,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/QueryRole.ashx?' . urldecode(http_build_query($param_arr));
        $res2 = file_get_contents($url);
        $res = json_decode($res2, true);
        $result = 'no';
        $res['Status'] == 1 && $result = 'ok';
        $isShowName && $result = $res['Data'][0]['rolename'];

        return $result;
    }

    //操戈天下
    private function cgtx($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = '8cb4c78e5ae12ca8186fb3a1f9a77574';
        $param_arr = array(
            'agent' => '91yxq',
            'account' => $user_name,
            'time' => time(),
            'serverId' => $serverid,
        );
        $param_arr['sign'] = strtolower(md5($param_arr['agent'] . $param_arr['account'] . $param_arr['serverId'] . $param_arr['time'] . $key));
        $url = 'http://cgtxlogin.play77.cn/api/getinfo/?' . urldecode(http_build_query($param_arr));
        $res2 = file_get_contents($url);
        $res = json_decode($res2, true);
//        array(1) {
//            [0]=>array(7) {
//                ["nickname"]=> "霜太"
//                ["grade"]=> "18"
//                ["sex"]=> "0"
//                ["profession"]=> "2"
//                ["createTime"]=> "2017-09-11 17:01:09"
//                ["roleId"]=>"262145"
//                ["fightvalue"]=>"12854"
//            }
//        }
        $result = 'no';
        is_array($res) && $result = 'ok';
        $isShowName && $result = $res[0]['nickname'];

        return $result;
    }

    //赤月传说
    private function cycs2($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = 'EttzQwk2cTEP9M4GA593bCntN8KXEdnf';
        $param_arr = array(
            'user' => $user_name,
            'agent' => '91yxq',
            'sid' => $serverid,
            'time' => time(),
        );
        $param_arr['sign'] = md5("{$param_arr['sid']}.{$param_arr['user']}.{$param_arr['agent']}.{$param_arr['time']}.{$key}");
        $url = 'http://s' . $serverid . '.cycs2.91yxq.com/api/getCharacterInfo.php?' . urldecode(http_build_query($param_arr));
        $res2 = file_get_contents($url);
        $res = json_decode($res2, true);

        $result = 'no';
        is_array($res) && $result = 'ok';
        $isShowName && $result = $res[0]['name'];

        return $result;
    }
# For advice on how to change settings please see
# http://dev.mysql.com/doc/refman/5.7/en/server-configuration-defaults.html
# *** DO NOT EDIT THIS FILE. It‘s a template which will be copied to the
# *** default location during install, and will be replaced if you
# *** upgrade to a newer version of MySQL.

[mysqld]
sql_mode=NO_ENGINE_SUBSTITUTION,STRICT_TRANS_TABLES

# 一般配置选项
basedir = /usr/local/mysql
datadir = /usr/local/mysql/data
port = 3306
socket = /var/run/mysqld/mysqld.sock
character-set-server=utf8


back_log = 300
max_connections = 3000
max_connect_errors = 50
table_open_cache = 4096
max_allowed_packet = 32M
#binlog_cache_size = 4M

max_heap_table_size = 128M
read_rnd_buffer_size = 16M
sort_buffer_size = 16M
join_buffer_size = 16M
thread_cache_size = 16
query_cache_size = 128M
query_cache_limit = 4M
ft_min_word_len = 8

thread_stack = 512K
transaction_isolation = REPEATABLE-READ
tmp_table_size = 128M
#log-bin=mysql-bin
long_query_time = 6


server_id=1

innodb_buffer_pool_size = 1G
innodb_thread_concurrency = 16
innodb_log_buffer_size = 16M


innodb_log_file_size = 512M
innodb_log_files_in_group = 3
innodb_max_dirty_pages_pct = 90
innodb_lock_wait_timeout = 120
innodb_file_per_table = on

[mysqldump]
quick

max_allowed_packet = 32M

[mysql]
no-auto-rehash
default-character-set=utf8
safe-updates

[myisamchk]
key_buffer = 16M
sort_buffer_size = 16M
read_buffer = 8M
write_buffer = 8M

[mysqlhotcopy]
interactive-timeout

[mysqld_safe]
open-files-limit = 8192

[client]


}
?>
