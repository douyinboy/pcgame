<?php
//
//$uname = strtolower($_GET['user_name']);
//$c1 = substr($uname, 0, 1);
//$c2 = substr($uname, -1);
//$n = ord($c1) + ord($c2);
//$l = strlen($uname);
//$n += $l * $l;
//if ($s) {
//    echo '91yxq_user_' . $n % 40;
//} else {
//    echo $n % 40;
//}die;

switch($_POST['do']){
	case "reg":   //账号注册
                $_POST['placeid'] =='' && $_POST['placeid'] =0;
                $nowtime = time();
		$res = $mysqli->query("INSERT INTO `users`(user_name, agent_id, place_id, reg_time) VALUES('".$_POST['username']."', ".intval($_POST['agent_id']).", ". $mysqli->escape_string(strip_tags(trim($_POST['placeid'] . ''))).", $nowtime)");
		$uid = $mysqli->insert_id;
		if($uid<=0) {
		    echo "no";exit;
		}
		$pwd=md5($uid.$_POST['passwd']);
		$value=array($uid,$_POST['username'],$pwd,$_POST['email'],$_POST['ip'],$nowtime,$nowtime,ip2long($_POST['ip']),1,$_POST['truename'],$_POST['idcard']);
		$field=array('uid','user_name','user_pwd','email','login_ip','login_time','reg_time','reg_ip','state','true_name','id_card');
		if(dbinsert(usertab($_POST['username']), $field, $value)){
			//记录来源信息
			agentReg($_POST['agent_id'],trim($_POST['username']),$_POST['ip'],$_POST['game_id'],$_POST['server_id'],$_POST['from_url'],$_POST['placeid'] . '',$_POST['email'],$_POST['adid'],$_POST['rand'],$_POST['cplaceid'],$_POST['union']);
			if($_POST['email'] && $_POST['email']!='undefined'){
				// 	$info="uid=$uid&username=".$_POST['username']."&password=$pwd&email=".$_POST['email']."&userip=".$_POST['ip'];
				// $bbsuid=long_login_bbs($info,"reg");
				
				$mail_title= $_POST['username'].'欢迎注册91yxq网页游戏平台';
				$mail_info='亲爱的'.$_POST['username'].'您好！欢迎注册91yxq游戏平台账户。<br>您的账户：'.$_POST['username'].' ';
				$mail_info.=file_get_contents(substr(__DIR__, 0, -3) . 'include/mailinfo.html');  
				$value=array($_POST['email'],$mail_title,$mail_info,time());
				$field=array('mail','mail_title','mail_info','time');
				dbinsert('91yxq_sendmail', $field, $value);
			}
			echo "ok_@@_".$uid;
 		} else {
			echo "no";
 		}
  break;
  case "chkname":
    $rc=$mysqli->query("select uid from `users` WHERE `user_name`='".$_POST['username']."'")->fetch_assoc();
    
    if($rc['uid']>0){
	    echo 'no';exit;
	}else{
	    echo 'ok';exit;
	}
  break;
  case "getpwd":
    $rc=$mysqli->query("select user_pwd from ".usertab($_POST['username'])." WHERE `user_name`='".$_POST['username']."'")->fetch_assoc();
    if($rc['user_pwd']){
	    echo 'ok_@@_'.$rc['user_pwd']; exit;
	}else{
	    echo 'no';exit;
	}
  break;
  case "getuid":
    $rc=$mysqli->query("select max(uid) as uid from users")->fetch_assoc();
    if($rc['uid']){
	    echo 'ok_@@_'.$rc['uid']; exit;
	}else{
	    echo 'no';exit;
	}
  break;
}
?>
