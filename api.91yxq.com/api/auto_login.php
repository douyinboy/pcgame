<?php
if ($act == 'auto_login') {
    $usertab = usertab($_POST['username']);
    $rs=$mysqli->query("SELECT `uid`,`user_pwd`,`email`,`integral`,`id_card`,`true_name`,`question`,`answer`,`login_ip`,`reg_time`,`login_time`,`head_pic`,`defendboss`,`state` FROM ".$usertab." WHERE `user_name`='".$_POST['username']."' and `state`>0")->fetch_assoc();
//    $pwd=md5($rs['uid'].$_POST['passwd']);
//    $rs['user_pwd']==$pwd
    if($rs){
            //防沉迷
            $id_card = trim($rs['id_card']);
                    if (check_idcard($id_card) && check_age($id_card)) {
                       $fcm=1;
                    } else {
                       $fcm=0;
                    }
            //完善资料
        if($rs['email'] && $rs['question'] && $rs['answer'] && $fcm) {
            $complete=1;
        } else {
            $complete=0;
        }
            $info="uid=".$rs['uid']."&username=".$_POST['username']."&userip=".$_POST['ip'];
            // long_login_bbs($info,"login");
            require(__DIR__ . '/get_login_ginfo.php');//登录过游戏
            echo 'ok_@@_'.$rs['uid'].'_@@_'.$_POST['username'].'_@@_'.$rs['login_ip'].'_@@_'.$rs['login_time'].'_@@_'.$rs['email'].'_@@_'.$fcm.'_@@_'.$rs['head_pic'].'_@@_'.$rs['state'].'_@@_'.$rs['defendboss'].'_@@_'.$complete.'_@@_'.$game_str.'_@@_'.$rs['reg_time'].'_@@_'.$rs['integral'];
            $mysqli->query("update ".usertab($_POST['username'])." set `login_ip`='".$_POST['login_ip']."',`login_time`=".time()."  WHERE `user_name`='".$_POST['username']."'");

            exit;
    }else{//失败
            exit('pwd error_@@_');
    }
}

?>
