<?php

USER_ACCESS != true && exit("forbiden!");

if($_POST['stage']=='yes'){
	if($_SESSION['users'][26]==1){
		echoTurn('您已通过防沉迷认证，不能重复提交！',$root_url . 'user.php?act=indulge'); exit;
	}
	
	$info_arr['true_name']=htmlspecialchars(trim($_POST['truename']));
	$info_arr['id_card']=htmlspecialchars(trim($_POST['idcard']));
	if(empty($info_arr['true_name']) || empty($info_arr['id_card'])){
		echoTurn('填写项不能为空！','back');
		exit();
	}
	
	if(!preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$info_arr['true_name']) || strlen($info_arr['true_name'])<6 ){
		echoTurn('真实姓名填写不正确！','back');
		exit();
	}
	
	if(!check_idcard($info_arr['id_card'])){
		echoTurn('身份证号码填写不正确！','back');
		exit();
	}
	
	$info=serialize($info_arr);
	$str="username=".$username."&info=".$info;
	$result=long_login($str,time(),"update&do=edit");
	$ip=GetIP();
	if($result=='ok'){
		$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values ('$username','$ip',now(),4,1,'')";
		$db->query($sql);
		$_SESSION['users'][3]=$info_arr['true_name'];
		$_SESSION['users'][4]=$info_arr['id_card'];
		$_SESSION['users'][26]=1;
		$_SESSION['users'][27]++;
		echoTurn('防沉迷验证成功！',$root_url . 'user.php');
	} else {
		$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values ('$username','$ip',now(),4,0,'')";
		$db->query($sql);
		echoTurn('防沉迷验证失败！'.$result,'back');
	}
}

?>