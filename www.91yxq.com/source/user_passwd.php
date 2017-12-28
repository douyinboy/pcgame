<?php

USER_ACCESS != true && exit("forbiden!");
if($_POST['stage']=='yes') {
   $sql="select count(*) as num from `user_logs` where username='$username' and date_format(log_time,'%Y-%m-%d')='".date('Y-m-d')."' and log_type=2";
   $re=$db->get($sql);
	
   $_SESSION['my_passwd_num']=2-$re['num'];
   if($re['num']>3){
       echoTurn('一天只能修改3次密码！',$root_url . 'user.php');
       exit();
   }
   if($_SESSION['my_passwd_num']<0){
   	   $_SESSION['my_passwd_num']=0;
   }
   $sc=date('Y-m-d').$username.'num';
   setcookie($sc, $_SESSION['my_passwd_num']);
   $dc=new DataCheck;//构造数据验证类
   if(empty($_POST['oldpwd']) || empty($_POST['login_pwd']) || empty($_POST['relogin_pwd'])) {
          echoTurn('填写内容不能为空！',$root_url . 'user.php?act=passwd');
   } else if($_POST['login_pwd']!=$_POST['relogin_pwd']){
          echoTurn('两次输入密码不一致！',$root_url . 'user.php?act=passwd');
   } else if(!$dc -> chkUserPwd($_POST['login_pwd'],6,18)){
          echoTurn('密码不符合要求（长度为6~18位，允许字符：“_，a-z，A-Z，0-9”）',$root_url . 'user.php?act=passwd');
   }else {
       $info="username=".$username."&passwd=".md5($_POST['oldpwd'])."&newpw=".md5($_POST['login_pwd']);
       $result=long_login($info,time(),"update&do=passwd");

        $ip=GetIP();
        if($result=='no'){
            $sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),2,0,'旧密码输入错误')";
            $db->query($sql);
            echoTurn('旧密码输入错误！',$root_url . 'user.php?act=passwd');
      } else if($result=='ok'){
            $db->query("insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),2,1,'密码修改成功！')");
            echoTurn('密码修改成功！',$root_url . 'user.php');
      } else {
              echoTurn('密码修改失败！',$root_url . 'user.php?act=passwd');
      }
    }
}
if(is_null($_SESSION['my_passwd_num'])){
    $sc=date('Y-m-d').$username.'num';
	$_SESSION['my_passwd_num']=$_COOKIE[$sc];
	if(is_null($_SESSION['my_passwd_num'])){
		$_SESSION['my_passwd_num']=3;
	}
}

if($_SESSION['my_passwd_num']<0){
	$_SESSION['my_passwd_num']=0;
}

$smarty->assign('num',$_SESSION['my_passwd_num']);
?>