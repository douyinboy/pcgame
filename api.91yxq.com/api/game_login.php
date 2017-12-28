<?php
$usertab = usertab($_POST['username']);
$rs = $mysqli->query("SELECT `uid`,`vm_uid`,`user_pwd`,`email`,`integral`,`id_card`,`true_name`,`login_ip`,`reg_time`,`login_time` FROM ".$usertab." WHERE `user_name`='".$_POST['username']."' and `state`>0")->fetch_assoc();
if($rs['user_pwd'] == $_POST['passwd']){
    //防沉迷
    $id_card = trim($rs['id_card']);
    if ($id_card == '') {
        $fcm = 2;
    } else {
        if (check_idcard($id_card) && check_age($id_card)) {
           $fcm = 1;
        } else {
           $fcm = 0;
        }
    }
    //用户id
    if ($rs['vm_uid']>0) {
        $uid=$rs['vm_uid'];
    } else {
        $uid=$rs['uid'];
    }
    echo 'ok_@@_'.$uid.'_@@_'.$_POST['username'].'_@@_'.$rs['login_ip'].'_@@_'.$rs['login_time'].'_@@_'.$rs['email'].'_@@_'.$fcm.'_@@_'.$rs['reg_time'];
    $u_obj = new users();
    $u_obj->updateGameLogin($_POST['game_id'],$_POST['server_id'],$_POST['username'],$_POST['login_ip'],'');//玩家登录日志
    $mysqli->query("UPDATE ".usertab($_POST['username'])." SET `login_ip`='".$_POST['login_ip']."',`login_time`=".time()."  WHERE `user_name`='".$_POST['username']."'");
    exit;
}else{//失败
    exit('pwd error_@@_');
}
