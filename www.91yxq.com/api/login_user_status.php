<?php
header('Content-Encoding: plain');//不使用压缩。因为服务器开启了Gzip，IE6的XMLhttprequest对象不自动解压，导致返回数据错误（就是IE6下面getJSON的callback不执行）。
require(substr(__DIR__, 0, -3) . 'include/common.inc.php');
if(intval($_REQUEST['state']) ==1){
    $res = array('code' =>0, msg =>'91yxq用户');
    if($_SESSION["login"]["username"]){
            $res = array('code' =>1, 'msg' =>$_SESSION["login"]["username"]);
    }else{
        setcookie('login_game_info','',-86400 * 365,'/','demo.com');
        setcookie('login_name','',-86400 * 365,'/','demo.com');
        setcookie('userinfo','',-86400 * 365,'/','demo.com');
        setcookie('q1L_auth','',-86400 * 365,'/','demo.com');
        setcookie('q1L_loginuser','',-86400 * 365,'/','demo.com');
        setcookie('PKQ_auth','',-86400 * 365,'/','demo.com');
        setcookie('PKQ_loginuser','',-86400 * 365,'/','demo.com');
    }
    echo json_encode($res);
}
exit();