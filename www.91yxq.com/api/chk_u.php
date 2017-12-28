<?php
require(substr(__DIR__, 0, -3) . 'include/common.inc.php');

$user_name=trim($_REQUEST['username']);

if(empty($user_name)){ echo 'data=3'; exit(); }

$dc=new DataCheck;//构造数据验证类

	/*帐号检测*/
	if (!$dc -> chkUserName($user_name,3,14)){
		echo 'data=3'; exit();
	}

	$info="username=$user_name";
	$result=long_login($info,time(),"reg&do=chkname");
	
	if ($result != 'ok'){
		echo 'data=1'; exit();
	} else {
		echo 'data=2'; exit();
	}