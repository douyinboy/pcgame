<?php

USER_ACCESS != true && exit("forbiden!");
if($_POST['stage']=='yes') {
	$info_arr['nick_name']=htmlspecialchars(trim($_POST['nickname']));
	$info_arr['sex']=$_POST['sex'];
	$info_arr['birthday']=$_POST['birthday'];
	$info_arr['qq']=htmlspecialchars(trim($_POST['qq']));

	$telephone=$_POST['telephone'] + 0;
	$info_arr['mobile']=$telephone;
	if($_SESSION['users'][9] != $telephone){
		$dc=new DataCheck;
		if(!$dc->chkMobile($telephone)){
			$error.='手机格式不正确！ ';
			$info_arr['mobile']='';
		}
	}
	
	$email=trim($_POST['email']);
	if(!$_SESSION['users'][25] && $email){
		$dc=new DataCheck;
		if(!$dc->chkEmail($email)){
			$error.='邮箱格式不正确！ ';
		} else {
			$info_arr['email']=$email;
		}
	}
	
// 	print_r($info_arr);exit;
	
	$info=serialize($info_arr);
	$str="username=".$username."&info=".$info;
	$result=long_login($str,time(),"update&do=edit");
	$ip=GetIP();
	if($result=='ok'){	
		$memo='';
		//校对资料完善度
		if($_SESSION['users'][2] != $info_arr['nick_name']){
			$_SESSION['users'][2]=$info_arr['nick_name'];
			if(!$_SESSION['users'][2]){
				$_SESSION['users'][28]++;
			}
			$memo.=('昵称: '.$info_arr['nick_name']);
		}
		if($_SESSION['users'][5] != $info_arr['sex']){
			$_SESSION['users'][5]=$info_arr['sex'];
			if(!$_SESSION['users'][5]){
				$_SESSION['users'][28]++;
			}
			$memo.=('性别 '.$info_arr['sex']);
		}
		if($_SESSION['users'][6] != $info_arr['birthday']){
			$_SESSION['users'][6]=$info_arr['birthday'];
			if(!$_SESSION['users'][6]){
				$_SESSION['users'][28]++;
			}
			$memo.=('生日 '.$info_arr['birthday']);
		}
		if($_SESSION['users'][9] != $info_arr['mobile']){
			$_SESSION['users'][9]=$info_arr['mobile'];
			if(!$_SESSION['users'][9]){
				$_SESSION['users'][27]++;
				$_SESSION['users'][28]++;
			}
			$memo.=('手机 '.$info_arr['mobile']);
		}
		if($_SESSION['users'][13] != $info_arr['qq']){
			$_SESSION['users'][13]=$info_arr['qq'];
			if(!$_SESSION['users'][13]){
				$_SESSION['users'][28]++;
			}
			$memo.=('qq '.$info_arr['qq']);
		}
		if(!$_SESSION['users'][25] && $info_arr['email']){
			$_SESSION['users'][1]=$info_arr['email'];
			$_SESSION['users'][27]++;
			$_SESSION['users'][28]++;
			$memo.=('email '.$info_arr['email']);
		}
		if($memo!=''){
			$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),1,1,'$memo')";
			$db->query($sql);
		}
		if(!$error){
			echoTurn('完善资料成功！',$root_url . 'user.php?act=info');
		}
	} else {
		//$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),1,0,'')";
		//$db->query($sql);
		if(!$error){
			echoTurn('完善资料成功！',$root_url . 'user.php?act=info');
		}
	}
	$smarty->assign('error',$error);
}
?>