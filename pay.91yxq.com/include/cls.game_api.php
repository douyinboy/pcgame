<?php
/******** Create **********
 * $Author: 91yxq技术部 $
 * $Modtime: 2013-03-09 20:35 $
 * $Revision: 7 $
 * $Description 联营游戏充值API接口
 */

class Game {
    /*
    * 游戏充值规定函数
    *
    * @params mixed $order 在平台方的订单号ID，字符串或者整数
    * @params mixed $user 如果是整数类型，则认为是 userid；否则认为是 username
    * @return string
    */
    private $user_name;              //属性,玩家帐号
    private $userid;                //属性,玩家帐号
    private $orderid ;             //属性,订单号
    private $server_id ;          //属性,服ID
    private $pay_url ;           //属性,充值接口地址
    private $money;             //属性,充值面额
    private $paid_amount;      //属性,扣费率后的金额
    private $pay_gold;        //属性,游戏币
    private $pay_channel;    //属性,充值渠道ID

    public function __construct ($user_name,$orderid,$server_id,$pay_url,$money,$paid_amount,$pay_gold,$pay_channel) { //构造函数
        $this->user_name   = $user_name;
        $this->userid     = $this->get_userid($user_name);
        $this->orderid     = $orderid;
        $this->server_id   = $server_id;
        $this->pay_url     = $pay_url;
        $this->money       = $money;
        $this->paid_amount = $paid_amount;
        $this->pay_gold    = $pay_gold;
        $this->pay_channel = $pay_channel;
    }

    private function get_curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);
        unset($ch);
        return $result;
    }

    private function post_curl ($post_url,$post_arr) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $post_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_arr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        //curl_setopt($ch, CURLOPT_VERBOSE, true);
        $result = curl_exec($ch);    //这个是读到的值
        curl_close($ch);
        unset($ch);
        return $result;
    }

    private function GetIP(){
        $ip = $_SERVER["HTTP_CDN_SRC_IP"];
        if (!$ip) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function get_userid($user_name){
        $userid = $this->get_curl("http://api.91yxq.com/api/get_userid.php?user_name=".urlencode(strtolower($user_name)));
        if ( $userid ) {
            return $userid;
        } else {
            return false;
        }
    }

    private function pay_log_result($filename,$content) {
        $f=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/pay_".$filename.".log","a");
        if ($f) {
            fputs($f,date("Y-m-d H:i:s").$content."\n");
            fclose($f);
        }
    }

    /**
     * 去除字符
     * @param string $user_name
     */
    function result_user_name($user_name){
        $user_name = strtolower($user_name);
        $user_name = strtr($user_name,"@",".");
        $user_name = urlencode($user_name);
        return $user_name;
    }

    function pay_hys_b(){
        $param_arr = array(
            'account' => $this->userid,
            'orderid' => $this->orderid,
            'rmb' => intval($this->paid_amount),
            'num' => $this ->pay_gold,
            'dept' => 1116,
            'game' => 'hys',
            'time' => time(),
            'skey' => $this ->server_id,
            'cparam' => '',
        );
        $param_arr['sign'] = md5($param_arr['account'] . $param_arr['game'] . $param_arr['dept'] . $param_arr['skey'] . $param_arr['orderid'] . $param_arr['rmb'] . $param_arr['num'] . $param_arr['time'] . $param_arr['cparam'] . 'ef899dda4ba246956178965e61b0f7ad');
        $url = 'http://centerpay.168pk.cn/normal/pay?' . urldecode(http_build_query($param_arr));
        $result = file_get_contents($url);
        $result_data = json_decode($result, true);
        if ($result_data['code'] == -18) {
            return true;
        }
        if ($result_data['code'] == 0) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_hys_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //斗破沙城
    function pay_dpsc_b(){
        $md5key = '3BC7355B5CCC4399B15BD1CB862072CD';
        $param_arr = array(
            'uid' => $this->userid,
            'time' => time(),
            'point' => intval($this->paid_amount),
            'order' => $this->orderid,
            'sid' => $this ->server_id,
//            'platname' => 'test'
            'platname' => '91yxq'
        );
        $param_arr['token'] = md5($param_arr['uid'] . $param_arr['time'] . $param_arr['point'] . $param_arr['order'] . $md5key . $param_arr['sid']);
        $url = 'http://115.159.212.216/home/pay?' . urldecode(http_build_query($param_arr));
        $result = file_get_contents($url);
        if ($result == -7) {
            return true;
        }
        if ($result == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_dpsc_log set sign='{$param_arr['token']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //斗破沙城混服
//    function pay_dpsc_b(){
//        $md5key = 'qfrt3WyQ8uf';
//        $param_arr = array(
//            'uid' => $this->userid,
//            'time' => time(),
//            'money' => intval($this->paid_amount),
//            'orderId' => $this->orderid,
//            'game' => 85,
//            'num' => $this ->server_id,
//            'site' => '91yxq'
//        );
//        $param_arr['sign'] = md5($param_arr['site'].'|'.$param_arr['uid'].'|85|'.$param_arr['num'].'|'.$param_arr['money'].'|'.$param_arr['time'].'|'.$param_arr['orderId'].'|'.$md5key);
//        $url = 'http://www.dadayou.com/i-api-pay?' . urldecode(http_build_query($param_arr));
//        $result = file_get_contents($url);
//
//        if ($result == 1) {
//            $back_result = 1;
//            $pay_result="成功";
//            $stat=1;
//        } else {
//            $pay_result="失败";
//            $stat=0;
//        }
//        $sql="update pay_dpsc_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
//        mysql_query($sql);
//        if ($back_result == 1) {
//            return true;
//        } else {
//            return false;
//        }
//    }

    function pay_mhzn2_b(){
        $md5key = '395952CAE09946E5B12B65C60DA5F289';
        $param_arr = array(
            'uid' => $this->userid,
            'time' => time(),
            'point' => intval($this->paid_amount),
            'order' => $this->orderid,
            'sid' => $this ->server_id,
//            'platname' => 'test'
            'platname' => '91yxq'
        );
        $param_arr['token'] = md5($param_arr['uid'] . $param_arr['time'] . $param_arr['point'] . $param_arr['order'] . $md5key . $param_arr['sid']);
        $url = 'http://115.159.212.216:6011/mhznup/pay?' . urldecode(http_build_query($param_arr));
        $result = file_get_contents($url);
        if ($result == -7) {
            return true;
        }
        if ($result == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_mhzn2_log set sign='{$param_arr['token']}',pay_date=now(),pay_result='$result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //热血虎卫
    function pay_rxhw_b(){
        $key = '8552C2B3C66E05AF6345';
        $param_arr = array(
            'user_name' => $this->user_name,
            'server_id' => $this->server_id,
            'coin' => $this->pay_gold,
            'money' => intval($this->paid_amount),
            'order_id' => $this->orderid,
            'time' => time(),
        );
        $param_arr['sign'] = strtolower(md5($param_arr['order_id'] . $param_arr['user_name'] . $param_arr['server_id'] . $param_arr['coin'] . $param_arr['money'] . $param_arr['time'] . $key));
        $url = 'http://rxhw.91yxq.com/pay.php?' . urldecode(http_build_query($param_arr));
        $_result = file_get_contents($url);
        $result = json_decode($_result, true);
        if ($result['code'] == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $pay_result = $result['code'];
        $sql="update pay_rxhw_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    function pay_crsgz_b(){
        $key = '501wan_91yxq';
        $recharge_type = 1;
        if ($this->pay_channel == 46) {
            $recharge_type = 3;
        }
        $param_arr = array(
            'paytype' => $recharge_type,
            'pid'     => 3,
            'userid'  => $this->userid,
            'sid'     => $this->server_id,
            'gid'     => 132,
            'orderid' => $this->orderid,
            'time'    => time(),
            'money'   => intval($this->paid_amount),
        );
        $param_arr['sign'] = strtolower(md5($param_arr['pid'] . $param_arr['userid'] . $param_arr['sid'] . $param_arr['gid'] . $param_arr['orderid'] . $param_arr['time'] . $param_arr['money'] . $key));
        $url = 'http://www.501wan.com/api/unionhf/makeorder?' . urldecode(http_build_query($param_arr));
        if ($this->pay_channel == 46) {
            $_result = file_get_contents($url);
            $result = json_decode($_result, true);
            if ($result['status'] == 200) {
                return $_result;
            } else {
                exit('获取微信URL出错!');
            }
        } else {
            return $url;
        }
    }

    function pay_zgzn_b(){
        $key = '501wan_91yxq';
        $recharge_type = 1;
        if ($this->pay_channel == 46) {
            $recharge_type = 3;
        }
        $param_arr = array(
            'paytype' => $recharge_type,
            'pid'     => 3,
            'userid'  => $this->userid,
            'sid'     => $this->server_id,
            'gid'     => 77,
            'orderid' => $this->orderid,
            'time'    => time(),
            'money'   => intval($this->paid_amount),
        );
        $param_arr['sign'] = strtolower(md5($param_arr['pid'] . $param_arr['userid'] . $param_arr['sid'] . $param_arr['gid'] . $param_arr['orderid'] . $param_arr['time'] . $param_arr['money'] . $key));
        $url = 'http://www.501wan.com/api/unionhf/makeorder?' . urldecode(http_build_query($param_arr));
        if ($this->pay_channel == 46) {
            $_result = file_get_contents($url);
            $result = json_decode($_result, true);
            if ($result['status'] == 200) {
                return $_result;
            } else {
                exit('获取微信URL出错!');
            }
        } else {
            return $url;
        }
    }

    function pay_czdtx_b(){
        $key = '501wan_91yxq';
        $recharge_type = 1;
        if ($this->pay_channel == 46) {
            $recharge_type = 3;
        }
        $param_arr = array(
            'paytype' => $recharge_type,
            'pid'     => 3,
            'userid'  => $this->userid,
            'sid'     => $this->server_id,
            'gid'     => 95,
            'orderid' => $this->orderid,
            'time'    => time(),
            'money'   => intval($this->paid_amount),
        );
        $param_arr['sign'] = strtolower(md5($param_arr['pid'] . $param_arr['userid'] . $param_arr['sid'] . $param_arr['gid'] . $param_arr['orderid'] . $param_arr['time'] . $param_arr['money'] . $key));
        $url = 'http://www.501wan.com/api/unionhf/makeorder?' . urldecode(http_build_query($param_arr));
        if ($this->pay_channel == 46) {
            $_result = file_get_contents($url);
            $result = json_decode($_result, true);
            if ($result['status'] == 200) {
                return $_result;
            } else {
                exit('获取微信URL出错!');
            }
        } else {
            return $url;
        }
    }

    function pay_nslm_b(){
        $key = '501wan_91yxq';
        $recharge_type = 1;
        if ($this->pay_channel == 46) {
            $recharge_type = 3;
        }
        $param_arr = array(
            'paytype' => $recharge_type,
            'pid'     => 3,
            'userid'  => $this->userid,
            'sid'     => $this->server_id,
            'gid'     => 112,
            'orderid' => $this->orderid,
            'time'    => time(),
            'money'   => intval($this->paid_amount),
        );
        $param_arr['sign'] = strtolower(md5($param_arr['pid'] . $param_arr['userid'] . $param_arr['sid'] . $param_arr['gid'] . $param_arr['orderid'] . $param_arr['time'] . $param_arr['money'] . $key));
        $url = 'http://www.501wan.com/api/unionhf/makeorder?' . urldecode(http_build_query($param_arr));
        if ($this->pay_channel == 46) {
            $_result = file_get_contents($url);
            $result = json_decode($_result, true);
            if ($result['status'] == 200) {
                return $_result;
            } else {
                exit('获取微信URL出错!');
            }
        } else {
            return $url;
        }
    }

    function pay_wszzl_b(){
        $key = '501wan_91yxq';
        $recharge_type = 1;
        if ($this->pay_channel == 46) {
            $recharge_type = 3;
        }
        $param_arr = array(
            'paytype' => $recharge_type,
            'pid'     => 3,
            'userid'  => $this->userid,
            'sid'     => $this->server_id,
            'gid'     => 103,
            'orderid' => $this->orderid,
            'time'    => time(),
            'money'   => intval($this->paid_amount),
        );
        $param_arr['sign'] = strtolower(md5($param_arr['pid'] . $param_arr['userid'] . $param_arr['sid'] . $param_arr['gid'] . $param_arr['orderid'] . $param_arr['time'] . $param_arr['money'] . $key));
        $url = 'http://www.501wan.com/api/unionhf/makeorder?' . urldecode(http_build_query($param_arr));
        if ($this->pay_channel == 46) {
            $_result = file_get_contents($url);
            $result = json_decode($_result, true);
            if ($result['status'] == 200) {
                return $_result;
            } else {
                exit('获取微信URL出错!');
            }
        } else {
            return $url;
        }
    }

    //热血三国3
    function pay_rxsg3_b(){
        $key = 'pZGdj8k0a0qLmY7y1lce';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $this->user_name,
            'gid' => 55,
            'sid' => 's' . $this->server_id,
            'tradeno' => $this->orderid,
            'money' => intval($this->paid_amount),
            'point' => $this->pay_gold,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&tradeno={$param_arr['tradeno']}&money={$param_arr['money']}&point={$param_arr['point']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/PayHandler.ashx?' . urldecode(http_build_query($param_arr));
        $result = file_get_contents($url);
        if ($result == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_rxsg3_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //神道
    function pay_sd_b(){
        $key = 'pZGdj8k0a0qLmY7y1lce';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $this->user_name,
            'gid' => 67,
            'sid' => 's' . $this->server_id,
            'tradeno' => $this->orderid,
            'money' => intval($this->paid_amount),
            'point' => $this->pay_gold,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&tradeno={$param_arr['tradeno']}&money={$param_arr['money']}&point={$param_arr['point']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/PayHandler.ashx?' . urldecode(http_build_query($param_arr));
        $result = file_get_contents($url);
        if ($result == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_sd_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //龙珠战纪
    function pay_lzzj_b(){
        $key = 'pZGdj8k0a0qLmY7y1lce';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $this->user_name,
            'gid' => 60,
            'sid' => 's' . $this->server_id,
            'tradeno' => $this->orderid,
            'money' => intval($this->paid_amount),
            'point' => $this->pay_gold,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&tradeno={$param_arr['tradeno']}&money={$param_arr['money']}&point={$param_arr['point']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/PayHandler.ashx?' . urldecode(http_build_query($param_arr));
        $result = file_get_contents($url);
        if ($result == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_lzzj_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //仙侠道2
    function pay_xxd2_b(){
        $key = 'pZGdj8k0a0qLmY7y1lce';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $this->user_name,
            'gid' => 28,
            'sid' => 's' . $this->server_id,
            'tradeno' => $this->orderid,
            'money' => intval($this->paid_amount),
            'point' => $this->pay_gold,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&tradeno={$param_arr['tradeno']}&money={$param_arr['money']}&point={$param_arr['point']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/PayHandler.ashx?' . urldecode(http_build_query($param_arr));
        $result = file_get_contents($url);
        if ($result == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_xxd2_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //青云志
    function pay_qyz_b(){
        $key = 'pZGdj8k0a0qLmY7y1lce';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $this->user_name,
            'gid' => 50,
            'sid' => 's' . $this->server_id,
            'tradeno' => $this->orderid,
            'money' => intval($this->paid_amount),
            'point' => $this->pay_gold,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&tradeno={$param_arr['tradeno']}&money={$param_arr['money']}&point={$param_arr['point']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/PayHandler.ashx?' . urldecode(http_build_query($param_arr));
        $result = file_get_contents($url);
        if ($result == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_qyz_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //风云无双
    function pay_fyws_b(){
        $key = 'pZGdj8k0a0qLmY7y1lce';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $this->user_name,
            'gid' => 77,
            'sid' => 's' . $this->server_id,
            'tradeno' => $this->orderid,
            'money' => intval($this->paid_amount),
            'point' => $this->pay_gold,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&tradeno={$param_arr['tradeno']}&money={$param_arr['money']}&point={$param_arr['point']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/PayHandler.ashx?' . urldecode(http_build_query($param_arr));
        $result = file_get_contents($url);
        if ($result == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_fyws_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //像素骑士团
    function pay_xsqst_b(){
        $key = 'pZGdj8k0a0qLmY7y1lce';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $this->user_name,
            'gid' => 3,
            'sid' => 's' . $this->server_id,
            'tradeno' => $this->orderid,
            'money' => intval($this->paid_amount),
            'point' => $this->pay_gold,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&tradeno={$param_arr['tradeno']}&money={$param_arr['money']}&point={$param_arr['point']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/PayHandler.ashx?' . urldecode(http_build_query($param_arr));
        $result = file_get_contents($url);
        if ($result == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_xsqst_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //第一舰队
    function pay_dyjd_b(){
        $key = 'pZGdj8k0a0qLmY7y1lce';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $this->user_name,
            'gid' => 104,
            'sid' => 's' . $this->server_id,
            'tradeno' => $this->orderid,
            'money' => intval($this->paid_amount),
            'point' => $this->pay_gold,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&tradeno={$param_arr['tradeno']}&money={$param_arr['money']}&point={$param_arr['point']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/PayHandler.ashx?' . urldecode(http_build_query($param_arr));
        $result = file_get_contents($url);
        if ($result == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_dyjd_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //不良人
    function pay_blr_b(){
        $key = 'pZGdj8k0a0qLmY7y1lce';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $this->user_name,
            'gid' => 116,
            'sid' => 's' . $this->server_id,
            'tradeno' => $this->orderid,
            'money' => intval($this->paid_amount),
            'point' => $this->pay_gold,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&tradeno={$param_arr['tradeno']}&money={$param_arr['money']}&point={$param_arr['point']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/PayHandler.ashx?' . urldecode(http_build_query($param_arr));
        $result = file_get_contents($url);
        if ($result == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_blr_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //热血江湖
    function pay_rxjh_b(){
        $key = 'pZGdj8k0a0qLmY7y1lce';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $this->user_name,
            'gid' => 6,
            'sid' => 's' . $this->server_id,
            'tradeno' => $this->orderid,
            'money' => intval($this->paid_amount),
            'point' => $this->pay_gold,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&tradeno={$param_arr['tradeno']}&money={$param_arr['money']}&point={$param_arr['point']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/PayHandler.ashx?' . urldecode(http_build_query($param_arr));
        $result = file_get_contents($url);
        if ($result == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_rxjh_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //神印王座
    function pay_sywz_b(){
        $key = 'pZGdj8k0a0qLmY7y1lce';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $this->user_name,
            'gid' => 124,
            'sid' => 's' . $this->server_id,
            'tradeno' => $this->orderid,
            'money' => intval($this->paid_amount),
            'point' => $this->pay_gold,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&tradeno={$param_arr['tradeno']}&money={$param_arr['money']}&point={$param_arr['point']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/PayHandler.ashx?' . urldecode(http_build_query($param_arr));
        $result = file_get_contents($url);
        if ($result == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_sywz_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //攻城掠地
    function pay_gcld_b(){
        $key = 'pZGdj8k0a0qLmY7y1lce';
        $param_arr = array(
            'pid' => '91yxq',
            'account' => $this->user_name,
            'gid' => 5,
            'sid' => 's' . $this->server_id,
            'tradeno' => $this->orderid,
            'money' => intval($this->paid_amount),
            'point' => $this->pay_gold,
            'time' => time(),
        );
        $param_arr['sign'] = md5("pid={$param_arr['pid']}&account={$param_arr['account']}&gid={$param_arr['gid']}&sid={$param_arr['sid']}&tradeno={$param_arr['tradeno']}&money={$param_arr['money']}&point={$param_arr['point']}&time={$param_arr['time']}&key={$key}");
        $url = 'http://api.ccjoy.cc/PayHandler.ashx?' . urldecode(http_build_query($param_arr));
        $result = file_get_contents($url);
        if ($result == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_sywz_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //操戈天下
    function pay_cgtx_b(){
        $key = '8cb4c78e5ae12ca8186fb3a1f9a77574';
        $param_arr = array(
            'uid' => urlencode($this->user_name),
            'platform' => '91yxq',
            'gkey' => 'cgtx',
            'skey' => $this->server_id,
            'money' => intval($this->paid_amount),
            'oid' => $this->orderid,
            'time' => time(),
        );
        $param_arr['sign'] = md5($param_arr['platform'] . $param_arr['gkey'] . $param_arr['skey'] . $param_arr['money'] . $param_arr['oid'] . $param_arr['uid'] . $param_arr['time'] . '#' . $key);
        $url = 'http://www.4jyx.com/JointOperation/getCoinsByAdvanceCharge.html?' . urldecode(http_build_query($param_arr));

        $result = file_get_contents($url);
        $result_data = json_decode($result, true);
        if ($result_data['errno'] == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $sql="update pay_cgtx_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$pay_result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

    //赤月传说2
    function pay_cycs2_b(){
        $key = 'EttzQwk2cTEP9M4GA593bCntN8KXEdnf';
        $param_arr = array(
            'game' => 'cycs2',
            'agent' => '91yxq',
            //'referer' => $user_name,
            'user' => urlencode($this->user_name),
            'order' => $this->orderid,
            'money' => intval($this->paid_amount),
            'coin' => $this->pay_gold,
            'server' => $this->server_id,
            'time' => time(),
        );
        $param_arr['sign'] = strtoupper(md5($param_arr['game'] . $param_arr['agent'] . $param_arr['server'] . $param_arr['user'] . $param_arr['order'] . $param_arr['money'] . $param_arr['coin'] . $param_arr['time'] . $key));
        $url = 'http://union.9377.com/pay.php';
        $result = $this->post_curl($url, $param_arr);
//        $result_data = json_decode($result, true);
        if ($result == 1) {
            $back_result = 1;
            $pay_result="成功";
            $stat=1;
        } else {
            $pay_result="失败";
            $stat=0;
        }
        $url .= '?' . urldecode(http_build_query($param_arr));
        $sql="update pay_cycs2_log set sign='{$param_arr['sign']}',pay_date=now(),pay_result='$result',back_result='$back_result',stat='$stat',pay_url='{$url}' where orderid='{$this ->orderid}'";
        mysql_query($sql);
        if ($back_result == 1) {
            return true;
        } else {
            return false;
        }
    }

//    function doLog($log,$filename){
//        $day = date('Y-m-d H:i:s');
//        $dir = '/logs/'.$filename.'-'.date('Y-m-d');
//        if(is_array($log)){
//            file_put_contents($dir, $day.':',FILE_APPEND);
//            file_put_contents($dir, var_export($log,TRUE),FILE_APPEND);
//        }else{
//            $log = $day.":".$log."\r\n";
//            file_put_contents($dir, $log,FILE_APPEND);
//        }
//    }


}
?>
