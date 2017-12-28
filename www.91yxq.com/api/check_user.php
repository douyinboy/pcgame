<?php
 
require(substr(__DIR__, 0, -3) . 'include/common.inc.php');


//检查玩家绑定的账号是否存在
$user_name = trim($_GET['account_name']);
$get_key = trim($_GET['ticket']);

$key = $check_user_key;

$key = md5($key.$user_name);

if($key==$get_key){
	if(!empty($user_name)){
		
		$info="username=$user_name";
		$result=long_login($info,time(),"reg&do=chkname");

		if ($result != 'ok'){
			echo 101;  //存在
		} else {
			echo 102;  //不存在
		}
	}else{
		echo 100;
	}
}else{
    echo 103;	//key错误
    exit();
}

/*用户名检测END*/