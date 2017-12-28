<?php
define('SYS_ROOT',substr(__DIR__, 0, -3));
define('CLASS_PATH', SYS_ROOT . 'include/class/');
include(SYS_ROOT . 'include/config.inc.php');
include(SYS_ROOT . 'include/funcs.php');
include(SYS_ROOT . 'smarty/Smarty.class.php');
include(CLASS_PATH . 'mysql.class.php');
include(CLASS_PATH . 'userWx.class.php');
include(CLASS_PATH . 'data_check.class.php');

$agent_id = 10010; //渠道ID
$placeid = 10045; //广告位ID
$game_id = 1; //游戏ID
$server_id = 10; //服务器ID
$pcid = $_GET['pcid'];
$adid = 'adid';
$login_pwd = '111111';
$u = new userWx();

if($_GET['state'] != $_SESSION["wx_state"]){
    exit("请求状态码错误!");
}
$AppID = 'wxce63b3d6f7b382fc';
$AppSecret = 'f26fcf6b68f7388f512f78728c8c2162';
$url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$AppID.'&secret='.$AppSecret.'&code='.$_GET['code'].'&grant_type=authorization_code';
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_URL, $url);
$json = curl_exec($ch);
curl_close($ch);
$arr = json_decode($json,1);
$openid = $arr['openid'];

//验证openid是否存在
$info = "openid=$openid";
$result = long_login($info, time(), "wx_reg&do=checkopenid");
if (!empty($result)) {
    $e = $u->login_($result, $login_pwd);
    if ($e != 'ok') {
        echo "<script>alert('登录2失败！');</script>";
        exit();
    } else {
        $game_url = 'http://www.91yxq.com/main.php?act=gamelogin&game_id=' . $game_id . '&server_id=' . $server_id;
        header("Location:".$game_url);
        exit;
    }
}

$url='https://api.weixin.qq.com/sns/userinfo?access_token='.$arr['access_token'].'&openid='.$arr['openid'].'&lang=zh_CN';
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_URL, $url);
$json =  curl_exec($ch);
curl_close($ch);
$arr = json_decode($json,1);
$username = $arr['nickname'] . '_' . substr(md5(uniqid(rand(), TRUE)), 0, 6);

$e = $u->wxReg($username,$login_pwd,$openid,'','','','','',$agent_id,$game_id,$server_id,$placeid,'',urlencode($adid),'',1,'',$pcid);
if ($e != 'ok') {
    echo "<script>alert('注册1失败！');</script>";
    exit();
}
set_cookie('login_name',$username,time()+86400*30);
set_cookie('loginreg',md5($username),time()+86400*30);//登录标识

$game_url = 'http://www.91yxq.com/main.php?act=gamelogin&game_id=' . $game_id . '&server_id=' . $server_id;
header("Location:".$game_url);
exit;

?>