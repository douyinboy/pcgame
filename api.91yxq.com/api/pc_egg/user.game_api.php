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
        if (! $uid) return 'no';
        switch ($gameid) {
            case 1:
                $function = 'hys';    //火焰神
                break;
            case 2:
                $function = 'dpsc';   //斗破沙城
                break;
            case 3:
                $function = 'rxhw';   //热血虎卫
                break;
            case 19:
                $function = 'cgtx';   //操戈天下
                break;
            case 21:
                $function = 'cycs2';  //赤月传说2
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

        return $res;
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

        return $res;
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
        $res = json_decode($res2, true);

        return $res;
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

        return $res;
    }

    //赤月传说2
    private function cycs2($serverid, $uid, $user_name, $isShowName = false)
    {
        $key = 'EttzQwk2cTEP9M4GA593bCntN8KXEdnf';
        $param_arr = array(
            'user' => $user_name,
            'agent' => '91yxq',
            'sid' => 's' . $serverid,
            'time' => time(),
        );
        $param_arr['sign'] = md5($param_arr['sid'] . $param_arr['user'] . $param_arr['agent'] . $param_arr['time'] . $key);
        $url = 'http://s' . $serverid . '.cycs2.xxx.com/api/getCharacterInfo.php?' . urldecode(http_build_query($param_arr));
        $res2 = file_get_contents($url);
        $res = json_decode($res2, true);
//
//        $result = 'no';
//        is_array($res) && $result = 'ok';
//        $isShowName && $result = $res[0]['nickname'];

        return $res;
    }




}

?>
