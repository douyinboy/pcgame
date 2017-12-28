<?php
	MY_ACCESS != true && exit("forbiden!");
	if($_POST['stage']!='') {
		$oldpwd=htmlspecialchars(trim($_POST['oldpwd']));
		if($_SESSION['users'][29]!="" && md5($oldpwd)!=$_SESSION['users'][29]){
			echoTurn('原支付密码错误，请重新填写！','back');
			exit();
		}
		$info_arr['true_name']=htmlspecialchars(trim($_POST['truename']));
		$info_arr['id_card']=htmlspecialchars(trim($_POST['idcard']));
		if($_SESSION['users'][3]){
			if($_SESSION['users'][3]!=$info_arr['true_name']){
				echoTurn('真实姓名错误，请重新填写！','back');
				exit();
			}
		}
		if($_SESSION['users'][4]){
			if($_SESSION['users'][4]!=$info_arr['id_card']){
				echoTurn('身份证号.错误，请重新填写！','back');
				exit();
			}
		}
		
		$login_pwd=htmlspecialchars(trim($_POST['login_pwd']));
		$relogin_pwd=htmlspecialchars(trim($_POST['relogin_pwd']));
		if($login_pwd==$relogin_pwd){
			$info_arr['userPayPw']=md5($login_pwd);
		}else{
			echoTurn('密码不一致，请重新填写！','back');
			exit();
		}
		
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
	$info_arr['ptb_open']=1;
	$info=serialize($info_arr);
	$str="username=".$_SESSION['users'][18]."&info=".$info;
	$result=long_login($str,time(),"update&do=edit");
	$ip=GetIP();
	if($result=='ok'){
		$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),2,1,'')";
		$db->query($sql);
		$_SESSION['users'][3]=$info_arr['true_name'];
		$_SESSION['users'][4]=$info_arr['id_card'];
		$_SESSION['users'][29]=$info_arr['userPayPw'];
		$_SESSION['users'][31]=1;
		$_SESSION['users'][27]++;
		if( $_SESSION['users'][26]==0 ){
			$_SESSION['users'][26]=1;
			$_SESSION['users'][27]++;
		}
		echoTurn('支付密码更新成功！', $root_url . 'user.php');
	} else {
		$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),2,0,'')";
		$db->query($sql);
		echoTurn('设置支付密码失败！'.$result,'back');
	}
	}
?>