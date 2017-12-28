<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
if( isset($_POST['stage']) && $_POST['stage']=='getqa' ){
	$username= trim( $_REQUEST['username'] );
	if( empty( $username ) ){
		echoTurn('帐号不能为空！', $root_url . 'help.php?act=getpwd_qa');
		exit();
	}
	$ip=GetIP();
	$info="username=".$username;
	$result=long_login($info,time(),"getpwd&do=question");
	$result_arr=explode('_@@_', $result);
	if( $result == "sign error" ){
		echoTurn('api请求校验不匹配，请检查相关配置', $root_url . 'help.php?act=getpwd_qa');
		exit();
	}
	elseif($result_arr[0]=='ok'){
		$question = $result_arr[1];
		if( empty( $question ) ){
			echoTurn('此帐号尚未设置密保问题，请选择其它密码找回方式或联系我们客服！', $root_url . 'help.php?act=getpwd_qa');
			exit();
		}
		$smarty->assign('username',$username);
		$smarty->assign('question',$question);
	}
	else{
		echoTurn('此帐号不存在，请重新确认账号！', $root_url . 'help.php?act=getpwd_qa');
        exit();
	}
}
elseif(isset($_POST['stage']) && $_POST['stage']=='setpw') {
		$ip=GetIP();
		$username=trim($_POST['username']);
		$answer=trim($_POST['answer']);
		if(!$username || !$answer){
			echoTurn('帐号和密保答案不能为空！', $root_url . 'help.php?act=getpwd_email');
			exit();
		}
		$info="username=".$username;
		$result=long_login($info,time(),"getpwd&do=question");
		$result_arr=explode('_@@_', $result);
		
		if( $result == "sign error" ){
			echoTurn('api请求校验不匹配，请联系客服', $root_url . '/help/');//api_key不相同
			exit();
		}
		elseif($result_arr[0]=='ok'){
			
			if($answer==$result_arr[2]){
			
				$newpw = trim( $_REQUEST['new_pwd'] );
				$repw = trim( $_REQUEST['re_pwd'] );
				if( $newpw != $repw  ){
					echoTurn('确认密码与新密码不一致!', 'back');
					exit;
				}
				$info="username=".$username."&newpwd=".md5($newpw);
				$results=long_login($info,time(),"getpwd&do=passwd");
				$result_arr=explode('_@@_',$results);
				if($result_arr[0]=='ok'){
					$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),3,1,'密保问题找回密码:成功')";
					$db->query($sql);
					echoTurn('新密码设置成功!赶快去登录吧。', $root_url . 'main.php?act=login&forward='.urlencode($root_url) );
					exit;
				} else {
					$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),3,0,'密保问题找回密码:取回密码失败')";
					$db->query($sql);
					echoTurn('找回密码失败,请重新操作!', $root_url . '/help.php?act=getpwd_qa');
					exit;
				}
				
				
			} else {
				
				$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),3,0,'密保问题找回密码:填写密保答案不正确')";
				$db->query($sql);
				echoTurn('填写的填写密保答案不正确,请返回重新填写', $root_url . '/help.php?act=getpwd_qa');
				exit;
			}
		} else {
				$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),3,0,'邮箱找回密码:注册邮箱为空')";
				$db->query($sql);
				echoTurn('该帐号不存在,请重新确认您的账户或联系我们客服!', $root_url . 'help.php?act=getpwd_qa');
				exit;
		}
}
unset($_POST)
?>
