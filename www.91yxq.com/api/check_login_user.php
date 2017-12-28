<?php
header('Content-Encoding: plain');//不使用压缩。因为服务器开启了Gzip，IE6的XMLhttprequest对象不自动解压，导致返回数据错误（就是IE6下面getJSON的callback不执行）。

require(substr(__DIR__, 0, -3) . 'include/common.inc.php');

$act = $_REQUEST['act'];
if($act == 'login'){
    if(!isset($_SESSION['login_error_times'])){
        $_SESSION['login_error_times']=0;
    }
    if($_SESSION['login_error_times']>1){
        jsonBack(array('code'=>'02','msg'=>'请输入验证码'));
    }
    if($_SESSION["login"]["username"]){
        //jsonBack(array('code'=>'10','msg'=>''));
    }
    
    $u=new users;
    $user=trim($_REQUEST['login_user']);
    $pwd=trim($_REQUEST['login_pwd']);
    if(!$user){
        jsonBack(array('code'=>'01','msg'=>'用户名为空'));
    }elseif(!$pwd){
        jsonBack(array('code'=>'01','msg'=>'密码为空'));
    }
    $e=$u->login_($user,$pwd);
    if($e=='ok'){
        jsonBack(array('code'=>'10','msg'=>'登录成功'));
    }else{
        $_SESSION['login_error_times']++;
        if($e=='novalid'){
            jsonBack(array('code'=>'01','msg'=>'您的IP已被禁止访问，请联系客服'));
        }
        jsonBack(array('code'=>'01','msg'=>'用户名或密码错误'));
    }
}elseif ($act == 'logout'){
    setcookie('login_game_info','',-86400 * 365,$cookiepath,$cookiedomain);
    setcookie('login_name','',-86400 * 365,$cookiepath,$cookiedomain);
    setcookie('userinfo','',-86400 * 365,$cookiepath,$cookiedomain);
    setcookie('q1L_auth','',-86400 * 365,$cookiepath,$cookiedomain);
    setcookie('q1L_loginuser','',-86400 * 365,$cookiepath,$cookiedomain);
    setcookie('PKQ_auth','',-86400 * 365,$cookiepath,$cookiedomain);
    setcookie('PKQ_loginuser','',-86400 * 365,$cookiepath,$cookiedomain);    
    unset($_SESSION["login"]["username"]);
    unset($_SESSION);
    session_destroy();
}else{
    jsonBack(array('code'=>'01','msg'=>'缺少参数'));
}

function jsonBack($data){
    if($_GET['callback']){
        echo $_GET['callback']."(".json_encode($data).")";
    }else{
        echo json_encode($data);
    }
    exit();
}
?>