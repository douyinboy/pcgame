<?php
switch($_POST['do']){
    case "email":   //邮箱
        $re=$mysqli->query("select `email` from ".usertab($_POST['username'])." where `user_name`='".$_POST['username']."'")->fetch_assoc();
        if ($re) {
                exit('ok_@@_'.$re['email']);
        } else {
                exit('no_@@_');
        }
    break;
    case "question":   //密保问题
            $re=$mysqli->query("select `question`,`answer` from ".usertab($_POST['username'])." where `user_name`='".$_POST['username']."'")->fetch_assoc();
            if($re){
                    exit('ok_@@_'.$re['question'].'_@@_'.$re['answer']);
            } else {
                    exit( 'no_@@_');
            }
    break;
    case "passwd";  //修改密码
     $re=$mysqli->query("select uid from ".usertab($_POST['username'])." where `user_name`='".$_POST['username']."'")->fetch_assoc();
            if($re['uid']>0){
                                    $newpwd=md5($re['uid'].$_POST['newpwd']);
                                    $back = $mysqli->query("update ".usertab($_POST['username'])." set user_pwd='".$newpwd."' where user_name='".$_POST['username']."'");
                                    if(! $back){
                                            exit('no');
                                    }else{
                                            $info="uid=".$re['uid']."&newpwd=".$newpwd;
                                            $result=long_login_bbs($info,"pwd");
                                            exit( 'ok_@@_'.$newpwd);
                                    }
            } else {
                     exit('no');
            }
    break;
}
