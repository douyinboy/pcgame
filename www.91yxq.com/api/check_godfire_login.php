<?php
header('Content-Encoding: plain');//不使用压缩。因为服务器开启了Gzip，IE6的XMLhttprequest对象不自动解压，导致返回数据错误（就是IE6下面getJSON的callback不执行）。

require('../include/common.inc.php');

    $u=new users;
    $user=trim($_REQUEST['login_user']);
    $pwd=trim($_REQUEST['login_pwd']);
    $type=trim($_REQUEST['type']);
    if(!$user){
        $message = '用户名不符合要求(长度为4~20位, 允许字符：“_, a-z, A-Z, 0-9”)';
        echoTurn($message,'back'); die;
    }elseif(!$pwd){
        $message = '密码不符合要求(长度为6~18位, 允许字符：“_, a-z, A-Z, 0-9”)';
        echoTurn($message,'back'); die;
    }
    $e=$u->login_($user,$pwd);
    if($e=='ok'){
      // setCookie('save_login',1,86400*30);
      // setCookie('last_name',$user,86400*30);
      // setCookie('login_name',$user,86400*30);
        switch ($type) {
            case 'msb':
                $url = 'http://www.' . DOMAIN . '.com/godfire/select.php';
                break;
            case 'rxhw':
                $url = 'http://www.' . DOMAIN . '.com/rxhw/wd/select.php';
                break;
            case 'rxsg3':
                $url = 'http://www.' . DOMAIN . '.com/rxsg3/wd/select.php';
                break;
            case 'cgtx':
                $url = 'http://www.' . DOMAIN . '.com/cgtx/wd/select.php';
                break;
            case 'cycs2':
                $url = 'http://www.' . DOMAIN . '.com/cycs2/wd/select.php';
                break;
            case 'mhzn2':
                $url = 'http://www.' . DOMAIN . '.com/mhzn2/wd/select.php';
                break;
            default:
                $url = 'http://www.' . DOMAIN . '.com/godfire/select.php';
        }
        header("Location:".$url);
    }else{
        $_SESSION['login_error_times']++;
        if($e=='novalid'){
            $message = '您的IP已被禁止访问，请联系客服';
            echoTurn($message,'back'); die;
        }
        $message = '用户名或密码错误';
        echoTurn($message,'back'); die;
    }
?>