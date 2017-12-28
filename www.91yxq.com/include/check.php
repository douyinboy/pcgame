<?php
require(__DIR__ . '/common.inc.php');
exit('______' . $_SESSION['chk_code']);
$dc=new DataCheck;//构造数据验证类

if (trim($_REQUEST['action'])=="chkname")
{
	$user_name = trim($_REQUEST['user_name']); //检测注册帐号可用性
	/*帐号检测*/
	if (!$dc -> chkUserName($user_name,4,14)){
		die('<font color="red">帐号不符合要求</font>a1_ww_1au_chka1_ww_1a0');
	}

	$info="username=$user_name";
	$result=long_login($info,time(),"reg&do=chkname");
	
	if ($result == 'ok'){
		die('<font color="green">此帐号可以注册</font>a1_ww_1au_chka1_ww_1a1');
	} else {
		die('<font color="red">此帐号已被注册</font>a1_ww_1au_chka1_ww_1a0'.$result);
	}
	
	/*用户名检测END*/
	
} else if (trim($_REQUEST['action'])=="chkmail"){

	$email =trim($_REQUEST['email']);    //检测注册的邮箱可用性
	if (!$dc -> chkEmail($email) || (strlen($email)>25)) {
		die('<font color="red">邮箱格式不正确</font>a1_ww_1am_chka1_ww_1a0');
	}else{
		die('<font color="green">此邮箱可以注册</font>a1_ww_1am_chka1_ww_1a1');
	}
	/*E-Mail检测END*/
}else if (trim($_REQUEST['action'])=="chkcode"){

	$chk_code =trim($_REQUEST['chk_code']);    //检测码证码
   /*码证码检测*/
	if (trim($chk_code)!=$_SESSION['chk_code']){
		if (trim($_REQUEST['return'])=="bool"){
			die('0');
		} else {
			die('<font color="red">验证码输入不正确!</font>a1_ww_1ac_chka1_ww_1a0');
		}
	} else if (trim($chk_code)==$_SESSION['chk_code']) {
	
		if (trim($_REQUEST['return'])=="bool"){
			die('1');
		} else {
			die('<font color="green">验证码输入正确</font>a1_ww_1ac_chka1_ww_1a1');
		}
	}
	/*E-Mail检测END*/
} else if (trim($_REQUEST['action'])=="chklogin") { //检验登陆表单

	$chk_code =trim($_GET['chk_code']);   //检测码证码
	
	if (trim($chk_code)!=$_SESSION['chk_code']){
		$result .='0,'; //0代表码证码输入用误
	} else if (trim($chk_code)==$_SESSION['chk_code']){
		$result .='1,';	//1代表码证码输入正确
	}
	
	die($result);
} else if(trim($_REQUEST['action'])=="chk_indulge") {
	
	 $truename=trim($_REQUEST['truename']);
	 $idcard=trim($_REQUEST['idcard']);
	 if(!preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$truename)){
   	$result='name_error';
   } else if(!check_idcard($idcard)) {
   	$result='id_error';
   } else {
   	$result='ok';
   }
	
	die($result);
} else if(trim($_REQUEST['action'])=="chk_truename") {
	
	 $truename=trim($_REQUEST['truename']);

	 if(!preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$truename)){
   		$result='<font color="red">真实姓名只能为中文!</font>a1_ww_1atn_chka1_ww_1a0';
     }else {
		 if(strlen($truename)<6){
			 $result='<font color="red">真实姓名输入不正确!</font>a1_ww_1atn_chka1_ww_1a0';
		 }else{
   			 $result='<font color="green">真实姓名输入正确!</font>a1_ww_1atn_chka1_ww_1a1';
		 }
     }
	
	die($result);
} else if(trim($_REQUEST['action'])=="chk_idcard") {
	
	 $idcard=trim($_REQUEST['idcard']);
	 if(!check_idcard($idcard)) {
   	$result='<font color="red">身份证号码输入不正确!</font>a1_ww_1aid_chka1_ww_1a0';
   } else {
   	$result='<font color="green">身份证号码输入正确!</font>a1_ww_1aid_chka1_ww_1a1';
   }
	
	die($result);
}