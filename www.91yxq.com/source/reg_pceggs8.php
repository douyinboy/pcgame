<?php
$agent_id = intval(trim($_POST['agent_id'])); //渠道ID
$placeid = intval(trim($_POST['placeid'])); //广告位ID
$pcid = intval(trim($_POST['pcid'])); //广告位ID
$cplaceid = intval(trim($_REQUEST['cplaceid'])); //子ID
$game_id = intval(trim($_REQUEST['game_id'])); //游戏ID
$server_id = intval(trim($_REQUEST['server_id'])); //服务器ID
$from_url=$_COOKIE['from_url'];//来源URL
if(!$agent_id){ $agent_id=$placeid=100;}
$dc=new DataCheck;//构造数据验证类

if($_POST['action']){//注册
    $u=new userPceggs();
    $u->bs = 1;//为1主站注册过来 为0广告注册过来
    $login_name = trim($_POST['login_name']);
    $login_pwd = $_POST['login_pwd'];
    $relogin_pwd = $_POST['repeat_pwd'];
    $reg_ip	= GetIP();
    $admin = array('admin','91yxq','gm','GM','ｇｍ','ＧＭ','ＡＤＭＩＮ','ａｄｍｉｎ');
    foreach ($admin as $key=>$val){
        if(is_int(strpos($login_name, $val))){
            $message = '用户名带有非法字符!';
            echoTurn($message,$root_url); die;
        }
    }

    if (!preg_match('/^[\w]{4,20}$/u', $login_name))
    {
        $message = '用户名不符合要求(长度为4~20位, 允许字符：“_, a-z, A-Z, 0-9”)';
        echoTurn($message,'back'); die;
    }

    if (!$dc -> chkUserPwd($login_pwd,6,18))
    {
        $message = '密码不符合要求(长度为6~18位, 允许字符：“_, a-z, A-Z, 0-9”)';
        echoTurn($message,'back'); die;
    }

    if (trim($login_pwd) !== trim($relogin_pwd))
    {
        $message = '两次输入的密码不同, 请返回重新输入!';
        echoTurn($message,'back'); die;
    }

    $info="username=$login_name";
    //验证用户名是否存在
    $result=long_login($info,time(),"reg&do=chkname");
    if ($result != 'ok'){
        $message = '账号\''.$login_name.'\'已经被注册, 请选择其它账号进行注册!';
        echoTurn($message,'back');
        exit();
    }

    $adid    = 'uMgisiul0lw%3d';
    $key     = '87b5b787044d2ec2';

    $result = $u->reg($login_name,$login_pwd,'','','','','',$agent_id,$game_id,$server_id,$placeid,$from_url,urlencode($adid),'',1,'',$pcid);
    if ($result == 'ok') {
        $url = "http://api.91yxq.com/api/get_userid.php?user_name=" . urlencode(strtolower($login_name));
        $result = get_curl($url);
        $merid   = $result;
        $mername = $login_name;
        $keycode = md5($pcid . $merid . $mername . $key);

        $url = 'http://adtaste.pceggs.com/ADComate/WebService/AdBack.aspx?pcid='.$pcid.'&adid='.$adid.'&merid='.$merid.'&mername='.$mername.'&keycode='.$keycode;
        $res = get_curl($url);
        if ($res != 1) {
            exit('PC蛋蛋验证失败！');
        } else {
            echo 1;
        }
    }

    set_cookie('login_name',$login_name,time()+86400*30);
    set_cookie('loginreg',md5($login_name),time()+86400*30);//登录标识

    $game_url = 'http://www.' . DOMAIN . '.com/main.php?act=gamelogin&game_id=' . $game_id . '&server_id=' . $server_id;
    header("Location:".$game_url);
    exit;

}

function get_curl($url)
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

?>