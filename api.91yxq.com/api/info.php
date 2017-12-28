<?php

switch($_POST['do']){
	default:
	   $usertab = usertab($_POST['username']);
   	   $rs=$mysqli->query("SELECT `user_name`, `uid`,`uid` as `bbs_uid`,`email`,`integral`,`id_card`,`nick_name`,`true_name`,`sex`,`birthday`,`province`,`city`,`mobile` as `telephone`,`mobile`,`address`,`question`,`answer`,`qq`,`head_pic`,`login_ip`,`login_time`,`reg_time`,`defendboss`,`state`,userPayPw,money_plat,ptb_open FROM ".$usertab." WHERE `user_name`='".$_POST['username']."'")->fetch_assoc();
           if($rs['user_name'] ==''){
               $rs=$mysqli->query("SELECT `user_name` FROM `users` WHERE `uid`=".intval($_POST['username']))->fetch_assoc();
               if($rs['user_name']!=''){
                   $usertab = usertab($rs['user_name']);
                   $rs=$mysqli->query("SELECT user_name, `uid`,`uid` as `bbs_uid`,`email`,`integral`,`id_card`,`nick_name`,`true_name`,`sex`,`birthday`,`province`,`city`,`mobile` as `telephone`,`mobile`,`address`,`question`,`answer`,`qq`,`head_pic`,`login_ip`,`login_time`,`reg_time`,`defendboss`,`state`,userPayPw,money_plat,ptb_open FROM ".$usertab." WHERE `user_name`='".$rs['user_name']."'")->fetch_assoc();
               }
           }
        exit('ok_@@_'.$rs['email'].'_@@_'.$rs['nick_name'].'_@@_'.$rs['true_name'].'_@@_'.$rs['id_card'].
			  '_@@_'.$rs['sex'].'_@@_'.$rs['birthday'].'_@@_'.$rs['province'].'_@@_'.$rs['city'].
           '_@@_'.$rs['mobile'].'_@@_'.$rs['address'].'_@@_'.$rs['question'].'_@@_'.$rs['answer'].
			  '_@@_'.$rs['qq'].'_@@_'.$rs['head_pic'].'_@@_'.$rs['login_ip'].'_@@_'.$rs['login_time'].
			  '_@@_'.$rs['uid'].'_@@_'.$rs['user_name'].'_@@_'.$rs['state'].'_@@_'.$rs['defendboss'].
			  '_@@_'.date('Y-m-d H:i:s',$rs['reg_time']).'_@@_'.$rs['integral'].'_@@_'.$rs['userPayPw'].'_@@_'.$rs['money_plat'].'_@@_'.$rs['ptb_open']);
}

/***
1：邮箱    2：昵称   3：真实姓名  4：身份证号码
5：性别    6：生日   7：省份      8：城市
9：手机    10：地址  11：密保问题   12：密保答案
13：qq     14：头像   15：登录ip   16：登录时间
17：uid    18：账号  19：帐号状态(0:封停1:正常2:锁定3:防老板)
20：防老板标题   21：注册时间  22:用户积分
***/
