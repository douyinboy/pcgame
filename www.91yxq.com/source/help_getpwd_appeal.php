<?php

$ip=GetIP();
if($_POST['stage']=='yes'){
	$server_id = (int)$_POST['server_id'];
	$game_id = (int)$_POST['game_id'];
		$sql="select count(id) as n from `help_getpw` where ip='$ip' and sub_time>='".date('Y-m-d')." 00:00:00'";
		$res=$db->get($sql);
		if($res['n']>2){
			$result='同一个ip一天只能提交密码申述请求3次！';
		} else {
			$re=$db->query("insert into `help_getpw` (passport,game_id,server_id,pwd,reg_mail,per_mail,truename,birthday,city,idcard,tel,reg_time,sub_time,ip) value('".htmlspecialchars($_POST['passport'])."','".(int)($_POST['game_id'])."','".(int)($_POST['server_id'])."','".htmlspecialchars($_POST['pwd'])."','".htmlspecialchars($_POST['email'])."','".htmlspecialchars($_POST['pemail'])."','".htmlspecialchars($_POST['truename'])."','".htmlspecialchars($_POST['birthday'])."','".htmlspecialchars($_POST['city'])."','".htmlspecialchars($_POST['idcard'])."','".htmlspecialchars($_POST['tel'])."','".htmlspecialchars($_POST['regtime'])."',now(),'".$ip."')");
			if($re){
				$result='您的密码申诉请求已经提交！请耐心等待申诉结果';
			} else {
				$result='密码申诉请求提交失败';
			}
		}
}
$smarty->assign('result',$result);
unset($_POST);
?>