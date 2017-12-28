<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
$username=$_REQUEST['username'];
$type=$_REQUEST['type'];
$ip=GetIP();

// if($_REQUEST['stage']=='yes') {
	// if($type==1){
		// $code=trim($_GET['code']);
		// $log_time=trim($_GET['log_time']);
		// $sign=trim($_GET['sign']);
		// if($code==''){
			// echoTurn('验证码不能为空!请重新操作!', $root_url . '/help.php?act=getpwd_email');
			// exit();
		// }
		// if($sign!=md5($code . $get_email_key . $username)){
			// echoTurn('验证失败!请重新操作!', $root_url . '/help.php?act=getpwd_email');
			// exit();
		// }
		
		// if(time()>$log_time+3600*24*3){
			// $sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),3,0,'邮箱找回密码:链接失效')";
			// $db->query($sql);
			// echoTurn('该链接已经超过3天有效期,请重新操作!', $root_url . '/help.php?act=getpwd_email');
			// exit();
		// }
		// $log_time=date('Y-m-d H:i:s',$log_time);
		// $sql="select id from `user_logs` where username='$username' and log_time='$log_time' and log_type=3 and log_state=1 and memo='$code'";
		// $re=$db->get($sql);
		
		// if($re){
			// $newpw=getpwcode(8);
			// $info="username=".$username."&newpwd=".md5($newpw);
			// $results=long_login($info,time(),"getpwd&do=passwd");
			// $result_arr=explode('_@@_',$results);
			// if($result_arr[0]=='ok'){
				// $sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),3,1,'邮箱找回密码:成功')";
				// $db->query($sql);
				// $sql="update `user_logs` set memo='邮箱找回密码:验证成功' where id=".$re['id'];
				// $db->query($sql);
				// $result="通过邮箱找回密码成功,请牢记您的新密码: ".$newpw;
				// $smarty->assign('result',$result);
			// } else {
				// $sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),3,0,'邮箱找回密码:取回密码失败')";
				// $db->query($sql);
				// echoTurn('找回密码失败,请重新选择密码找回方式!', $root_url . '/help.php?act=getpwd_email');
			// }
		// } else {
			// $sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),3,0,'邮箱找回密码:链接无效')";
			// $db->query($sql);
			// echoTurn('该链接无效,请重新选择密码找回方式!', $root_url . '/help.php?act=getpwd_email');
			// exit();	
		// }
	// } 

// } 


	if($type==1){
		$code=trim($_GET['code']);
		$log_time=trim($_GET['log_time']);
		$sign=trim($_GET['sign']);
		if($code==''){
			echoTurn('链接无效!请重新操作!', $root_url . '/help.php?act=getpwd_email');
			exit();
		}
		if($sign!=md5($code . $get_email_key . $username)){
			echoTurn('链接无效!请重新操作!', $root_url . '/help.php?act=getpwd_email');
			exit();
		}
		
		if(time()>$log_time+3600*24*3){
			$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),3,0,'邮箱找回密码:链接失效')";
			$db->query($sql);
			echoTurn('该链接已经超过3天有效期,请重新操作!', $root_url . '/help.php?act=getpwd_email');
			exit();
		}
		$log_time=date('Y-m-d H:i:s',$log_time);
		$sql="select id from `user_logs` where username='$username' and log_time='$log_time' and log_type=3 and log_state=1 and memo='$code'";
		$re=$db->get($sql);
		
		if($re){
			$smarty->assign('username',$username);
			if(isset($_REQUEST['stage']) && $_REQUEST['stage']=='yes'){
				//$newpw=getpwcode(8);
				$newpw = trim( $_REQUEST['new_pwd'] );
				$repw = trim( $_REQUEST['re_pwd'] );
				if( $newpw != $repw  ){
					echoTurn('确认密码与新密码不一致!', 'back');
					exit;
				}
				$info="username=".$username."&newpwd=".md5($newpw);
				$results=long_login($info,time(),"getpwd&do=passwd");
				$result_arr=explode('_@@_',$results);
				if( $result == "sign error" ){
					echoTurn('api请求校验不匹配，请联系客服', $root_url . '/help/');//api_key不相同
					exit();
				}
				elseif($result_arr[0]=='ok'){
					$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),3,1,'邮箱找回密码:成功')";
					$db->query($sql);
					$sql="update `user_logs` set memo='邮箱找回密码:验证成功' where id=".$re['id'];
					$db->query($sql);
					// $result="通过邮箱找回密码成功,请牢记您的新密码: ".$newpw;
					// $smarty->assign('result',$result);
					echoTurn('新密码设置成功!赶快去登录吧。', $root_url . 'main.php?act=login&forward='.urlencode($root_url) );
					exit;
				} else {
					$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),3,0,'邮箱找回密码:取回密码失败')";
					$db->query($sql);
					echoTurn('找回密码失败,请重新操作!', $root_url . '/help.php?act=getpwd_email');
					exit;
				}
			}
		} else {
			$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),3,0,'邮箱找回密码:链接无效')";
			$db->query($sql);
			echoTurn('该链接无效,请重新操作!', $root_url . '/help.php?act=getpwd_email');
			exit();	
		}
	} 



?>
