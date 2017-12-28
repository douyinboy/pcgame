<?php

USER_ACCESS != true && exit("forbiden!");

if($_POST['stage']=='yes') {
	$answer=trim($_POST['answer']);
	if(!$answer){
   		echoTurn('请先设置您的密保问题和答案！',$root_url . 'user.php?act=question');
   } else if($answer!=$_SESSION['users']['12']){
   		echoTurn('密保答案回答错误！',$root_url . 'user.php?act=lock');
   } else {
		if($_POST['lock_state']==2){
			$memo="帐号锁定";
		} else {
			$memo="帐号解锁";
		}
   	$info="username=".$username."&state=".$_POST['lock_state'];
	   $result=long_login($info,time(),"update&do=state");

		$ip=GetIP();
		if($result=='no'){
			$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),5,0,'$memo')";
			$db->query($sql);
			echoTurn($memo.'失败！',$root_url . 'user.php?act=lock');
      } else if($result=='ok'){
         $sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),5,1,'$memo')";
			$db->query($sql);
			$_SESSION['users']['19']=$_POST['lock_state'];
			echoTurn($memo.'成功！',$root_url . 'user.php');
      } else {
      	echoTurn($memo.'失败！',$root_url . 'user.php?act=lock');
      }
    }
}

?>