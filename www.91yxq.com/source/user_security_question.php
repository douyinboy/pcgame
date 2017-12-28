<?php

USER_ACCESS != true && exit("forbiden!");

if($_POST['stage']=='yes'){
    $sql="select count(*) as num from `user_logs` where username='$username' and date_format(log_time,'%Y-%m-%d')='".date('Y-m-d')."' and log_type=6";
    $re=$db->get($sql);
	if($re['num']){
        echoTurn('一天只能修改1次密保！',$root_url . 'user.php');
        exit();
    }
	
	if( $_SESSION['users'][23] && trim($_POST['old_answer']) != $_SESSION['users'][12] ){
		echoTurn('原密保答案不正确！','back');
		exit();
	}
	
	$info_arr['question']=htmlspecialchars(trim($_POST['question']));
	$info_arr['answer']=htmlspecialchars(trim($_POST['answer']));
	if(empty($info_arr['question']) || empty($info_arr['answer'])){
		echoTurn('填写项不能为空！','back');
		exit();
	}
	$info=serialize($info_arr);
	$str="username=".$username."&info=".$info;
	$result=long_login($str,time(),"update&do=edit");
	$ip=GetIP();
	if($result=='ok'){
		$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),6,1,'密保')";
		$db->query($sql);
		$_SESSION['users'][11]=$info_arr['question'];
		$_SESSION['users'][12]=$info_arr['answer'];
		$_SESSION['users'][23]=1;
		$_SESSION['users'][27]++;
		echoTurn('密保资料修改成功！',$root_url . 'user.php');
	} else {
		$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),6,0,'密保')";
		$db->query($sql);
		echoTurn('密保资料修改失败！'.$result,'back');
	}
}
?>
