<?php

$_POST['placeid'] == '' && $_POST['placeid'] = 0;
$nowtime = time();
$res = $mysqli->query("INSERT INTO `users`(user_name, agent_id, place_id, reg_time) VALUES('" . $_POST['username'] . "', " . intval($_POST['agent_id']) . ", " . $mysqli->escape_string(strip_tags(trim($_POST['placeid'] . ''))) . ", $nowtime)");
$uid = $mysqli->insert_id;
if ($uid <= 0) {
    echo "no";
    exit;
}

switch ($_POST['do']) {
    case "reg":
        $tableName = 'bengbeng';
        break;
    case "reg_kuailezhuan":
        $tableName = 'kuailezhuan';
        break;
    case "reg_quba":
        $tableName = 'quba';
        break;
    case "reg_juxiangyou":
        $tableName = 'juxiangyou';
        break;
    case "reg_youyiwang":
        $tableName = 'youyiwang';
        break;
    case "reg_shitoucun":
        $tableName = 'shitoucun';
        break;
    case "reg_tiantianzuan":
        $tableName = 'tiantianzuan';
        break;
    case "reg_ledouwan":
        $tableName = 'ledouwan';
        break;
    case "reg_jiquwang":
        $tableName = 'jiquwang';
        break;
    case "reg_jujuwan":
        $tableName = 'jujuwan';
        break;
    case "reg_yiruite":
        $tableName = 'yiruite';
        break;
}

$reg_bengbeng = $mysqli->query("INSERT INTO `" . $tableName . "`(uid, pcid, game_id, server_id, adid, create_time, update_time) VALUES(" . $uid . ", " . intval($_POST['pcid']) . ", " . intval($_POST['game_id']) . ", " . intval($_POST['server_id']) . ", '" . $_POST['adid'] . "', " . $nowtime . ", " . $nowtime . ")");
$pceggs_id = $mysqli->insert_id;
if ($pceggs_id <= 0) {
    echo "no";
    exit;
}

$pwd = md5($uid . $_POST['passwd']);
$value = array($uid, $_POST['username'], $pwd, $_POST['email'], $_POST['ip'], $nowtime, $nowtime, ip2long($_POST['ip']), 1, $_POST['truename'], $_POST['idcard']);
$field = array('uid', 'user_name', 'user_pwd', 'email', 'login_ip', 'login_time', 'reg_time', 'reg_ip', 'state', 'true_name', 'id_card');
if (dbinsert(usertab($_POST['username']), $field, $value)) {
    //记录来源信息
    agentReg($_POST['agent_id'], trim($_POST['username']), $_POST['ip'], $_POST['game_id'], $_POST['server_id'], $_POST['from_url'], $_POST['placeid'] . '', $_POST['email'], $_POST['adid'], $_POST['rand'], $_POST['cplaceid'], $_POST['union']);
    if ($_POST['email'] && $_POST['email'] != 'undefined') {
        // 	$info="uid=$uid&username=".$_POST['username']."&password=$pwd&email=".$_POST['email']."&userip=".$_POST['ip'];
        // $bbsuid=long_login_bbs($info,"reg");

        $mail_title = $_POST['username'] . '欢迎注册91yxq网页游戏平台';
        $mail_info = '亲爱的' . $_POST['username'] . '您好！欢迎注册91yxq游戏平台账户。<br>您的账户：' . $_POST['username'] . ' ';
        $mail_info .= file_get_contents(substr(__DIR__, 0, -3) . 'include/mailinfo.html');
        $value = array($_POST['email'], $mail_title, $mail_info, time());
        $field = array('mail', 'mail_title', 'mail_info', 'time');
        dbinsert('91yxq_sendmail', $field, $value);
    }
    echo "ok_@@_" . $uid;
} else {
    echo "no";
}
//  break;

//	case "reg_kuailezhuan":   //账号注册
//		$_POST['placeid'] =='' && $_POST['placeid'] =0;
//		$nowtime = time();
//		$res = $mysqli->query("INSERT INTO `users`(user_name, agent_id, place_id, reg_time) VALUES('".$_POST['username']."', ".intval($_POST['agent_id']).", ". $mysqli->escape_string(strip_tags(trim($_POST['placeid'] . ''))).", $nowtime)");
//		$uid = $mysqli->insert_id;
//		if($uid<=0) {
//		    echo "no";exit;
//		}
//
//        $reg_bengbeng = $mysqli->query("INSERT INTO `kuailezhuan`(uid, pcid, game_id, server_id, adid, create_time, update_time) VALUES(".$uid.", ".intval($_POST['pcid']).", ".intval($_POST['game_id']).", ".intval($_POST['server_id']).", '".$_POST['adid']."', ".$nowtime.", ".$nowtime.")");
//        $pceggs_id = $mysqli->insert_id;
//        if($pceggs_id<=0) {
//            echo "no";exit;
//        }
//
//		$pwd=md5($uid.$_POST['passwd']);
//		$value=array($uid,$_POST['username'],$pwd,$_POST['email'],$_POST['ip'],$nowtime,$nowtime,ip2long($_POST['ip']),1,$_POST['truename'],$_POST['idcard']);
//		$field=array('uid','user_name','user_pwd','email','login_ip','login_time','reg_time','reg_ip','state','true_name','id_card');
//		if(dbinsert(usertab($_POST['username']), $field, $value)){
//			//记录来源信息
//			agentReg($_POST['agent_id'],trim($_POST['username']),$_POST['ip'],$_POST['game_id'],$_POST['server_id'],$_POST['from_url'],$_POST['placeid'] . '',$_POST['email'],$_POST['adid'],$_POST['rand'],$_POST['cplaceid'],$_POST['union']);
//			if($_POST['email'] && $_POST['email']!='undefined'){
//				// 	$info="uid=$uid&username=".$_POST['username']."&password=$pwd&email=".$_POST['email']."&userip=".$_POST['ip'];
//				// $bbsuid=long_login_bbs($info,"reg");
//
//				$mail_title= $_POST['username'].'欢迎注册91yxq网页游戏平台';
//				$mail_info='亲爱的'.$_POST['username'].'您好！欢迎注册91yxq游戏平台账户。<br>您的账户：'.$_POST['username'].' ';
//				$mail_info.=file_get_contents(substr(__DIR__, 0, -3) . 'include/mailinfo.html');
//				$value=array($_POST['email'],$mail_title,$mail_info,time());
//				$field=array('mail','mail_title','mail_info','time');
//				dbinsert('91yxq_sendmail', $field, $value);
//			}
//			echo "ok_@@_".$uid;
// 		} else {
//			echo "no";
// 		}
//  break;

//	case "reg_quba":   //账号注册
//		$_POST['placeid'] =='' && $_POST['placeid'] =0;
//		$nowtime = time();
//		$res = $mysqli->query("INSERT INTO `users`(user_name, agent_id, place_id, reg_time) VALUES('".$_POST['username']."', ".intval($_POST['agent_id']).", ". $mysqli->escape_string(strip_tags(trim($_POST['placeid'] . ''))).", $nowtime)");
//		$uid = $mysqli->insert_id;
//		if($uid<=0) {
//		    echo "no";exit;
//		}
//
//        $reg_bengbeng = $mysqli->query("INSERT INTO `quba`(uid, pcid, game_id, server_id, adid, create_time, update_time) VALUES(".$uid.", ".intval($_POST['pcid']).", ".intval($_POST['game_id']).", ".intval($_POST['server_id']).", '".$_POST['adid']."', ".$nowtime.", ".$nowtime.")");
//        $pceggs_id = $mysqli->insert_id;
//        if($pceggs_id<=0) {
//            echo "no";exit;
//        }
//
//		$pwd=md5($uid.$_POST['passwd']);
//		$value=array($uid,$_POST['username'],$pwd,$_POST['email'],$_POST['ip'],$nowtime,$nowtime,ip2long($_POST['ip']),1,$_POST['truename'],$_POST['idcard']);
//		$field=array('uid','user_name','user_pwd','email','login_ip','login_time','reg_time','reg_ip','state','true_name','id_card');
//		if(dbinsert(usertab($_POST['username']), $field, $value)){
//			//记录来源信息
//			agentReg($_POST['agent_id'],trim($_POST['username']),$_POST['ip'],$_POST['game_id'],$_POST['server_id'],$_POST['from_url'],$_POST['placeid'] . '',$_POST['email'],$_POST['adid'],$_POST['rand'],$_POST['cplaceid'],$_POST['union']);
//			if($_POST['email'] && $_POST['email']!='undefined'){
//				// 	$info="uid=$uid&username=".$_POST['username']."&password=$pwd&email=".$_POST['email']."&userip=".$_POST['ip'];
//				// $bbsuid=long_login_bbs($info,"reg");
//
//				$mail_title= $_POST['username'].'欢迎注册91yxq网页游戏平台';
//				$mail_info='亲爱的'.$_POST['username'].'您好！欢迎注册91yxq游戏平台账户。<br>您的账户：'.$_POST['username'].' ';
//				$mail_info.=file_get_contents(substr(__DIR__, 0, -3) . 'include/mailinfo.html');
//				$value=array($_POST['email'],$mail_title,$mail_info,time());
//				$field=array('mail','mail_title','mail_info','time');
//				dbinsert('91yxq_sendmail', $field, $value);
//			}
//			echo "ok_@@_".$uid;
// 		} else {
//			echo "no";
// 		}
//  break;
//	case "reg_juxiangyou":   //账号注册
//		$_POST['placeid'] =='' && $_POST['placeid'] =0;
//		$nowtime = time();
//		$res = $mysqli->query("INSERT INTO `users`(user_name, agent_id, place_id, reg_time) VALUES('".$_POST['username']."', ".intval($_POST['agent_id']).", ". $mysqli->escape_string(strip_tags(trim($_POST['placeid'] . ''))).", $nowtime)");
//		$uid = $mysqli->insert_id;
//		if($uid<=0) {
//		    echo "no";exit;
//		}
//
//        $reg_bengbeng = $mysqli->query("INSERT INTO `juxiangyou`(uid, pcid, game_id, server_id, adid, create_time, update_time) VALUES(".$uid.", ".intval($_POST['pcid']).", ".intval($_POST['game_id']).", ".intval($_POST['server_id']).", '".$_POST['adid']."', ".$nowtime.", ".$nowtime.")");
//        $pceggs_id = $mysqli->insert_id;
//        if($pceggs_id<=0) {
//            echo "no";exit;
//        }
//
//		$pwd=md5($uid.$_POST['passwd']);
//		$value=array($uid,$_POST['username'],$pwd,$_POST['email'],$_POST['ip'],$nowtime,$nowtime,ip2long($_POST['ip']),1,$_POST['truename'],$_POST['idcard']);
//		$field=array('uid','user_name','user_pwd','email','login_ip','login_time','reg_time','reg_ip','state','true_name','id_card');
//		if(dbinsert(usertab($_POST['username']), $field, $value)){
//			//记录来源信息
//			agentReg($_POST['agent_id'],trim($_POST['username']),$_POST['ip'],$_POST['game_id'],$_POST['server_id'],$_POST['from_url'],$_POST['placeid'] . '',$_POST['email'],$_POST['adid'],$_POST['rand'],$_POST['cplaceid'],$_POST['union']);
//			if($_POST['email'] && $_POST['email']!='undefined'){
//				// 	$info="uid=$uid&username=".$_POST['username']."&password=$pwd&email=".$_POST['email']."&userip=".$_POST['ip'];
//				// $bbsuid=long_login_bbs($info,"reg");
//
//				$mail_title= $_POST['username'].'欢迎注册91yxq网页游戏平台';
//				$mail_info='亲爱的'.$_POST['username'].'您好！欢迎注册91yxq游戏平台账户。<br>您的账户：'.$_POST['username'].' ';
//				$mail_info.=file_get_contents(substr(__DIR__, 0, -3) . 'include/mailinfo.html');
//				$value=array($_POST['email'],$mail_title,$mail_info,time());
//				$field=array('mail','mail_title','mail_info','time');
//				dbinsert('91yxq_sendmail', $field, $value);
//			}
//			echo "ok_@@_".$uid;
// 		} else {
//			echo "no";
// 		}
//  break;
//	case "reg_youyiwang":   //账号注册
//		$_POST['placeid'] =='' && $_POST['placeid'] =0;
//		$nowtime = time();
//		$res = $mysqli->query("INSERT INTO `users`(user_name, agent_id, place_id, reg_time) VALUES('".$_POST['username']."', ".intval($_POST['agent_id']).", ". $mysqli->escape_string(strip_tags(trim($_POST['placeid'] . ''))).", $nowtime)");
//		$uid = $mysqli->insert_id;
//		if($uid<=0) {
//		    echo "no";exit;
//		}
//
//        $reg_bengbeng = $mysqli->query("INSERT INTO `youyiwang`(uid, pcid, game_id, server_id, adid, create_time, update_time) VALUES(".$uid.", ".intval($_POST['pcid']).", ".intval($_POST['game_id']).", ".intval($_POST['server_id']).", '".$_POST['adid']."', ".$nowtime.", ".$nowtime.")");
//        $pceggs_id = $mysqli->insert_id;
//        if($pceggs_id<=0) {
//            echo "no";exit;
//        }
//
//		$pwd=md5($uid.$_POST['passwd']);
//		$value=array($uid,$_POST['username'],$pwd,$_POST['email'],$_POST['ip'],$nowtime,$nowtime,ip2long($_POST['ip']),1,$_POST['truename'],$_POST['idcard']);
//		$field=array('uid','user_name','user_pwd','email','login_ip','login_time','reg_time','reg_ip','state','true_name','id_card');
//		if(dbinsert(usertab($_POST['username']), $field, $value)){
//			//记录来源信息
//			agentReg($_POST['agent_id'],trim($_POST['username']),$_POST['ip'],$_POST['game_id'],$_POST['server_id'],$_POST['from_url'],$_POST['placeid'] . '',$_POST['email'],$_POST['adid'],$_POST['rand'],$_POST['cplaceid'],$_POST['union']);
//			if($_POST['email'] && $_POST['email']!='undefined'){
//				// 	$info="uid=$uid&username=".$_POST['username']."&password=$pwd&email=".$_POST['email']."&userip=".$_POST['ip'];
//				// $bbsuid=long_login_bbs($info,"reg");
//
//				$mail_title= $_POST['username'].'欢迎注册91yxq网页游戏平台';
//				$mail_info='亲爱的'.$_POST['username'].'您好！欢迎注册91yxq游戏平台账户。<br>您的账户：'.$_POST['username'].' ';
//				$mail_info.=file_get_contents(substr(__DIR__, 0, -3) . 'include/mailinfo.html');
//				$value=array($_POST['email'],$mail_title,$mail_info,time());
//				$field=array('mail','mail_title','mail_info','time');
//				dbinsert('91yxq_sendmail', $field, $value);
//			}
//			echo "ok_@@_".$uid;
// 		} else {
//			echo "no";
// 		}
//  break;

//
//  case "chkname":
//    $rc=$mysqli->query("select uid from `users` WHERE `user_name`='".$_POST['username']."'")->fetch_assoc();
//
//    if($rc['uid']>0){
//	    echo 'no';exit;
//	}else{
//	    echo 'ok';exit;
//	}
//  break;
//  case "getpwd":
//    $rc=$mysqli->query("select user_pwd from ".usertab($_POST['username'])." WHERE `user_name`='".$_POST['username']."'")->fetch_assoc();
//    if($rc['user_pwd']){
//	    echo 'ok_@@_'.$rc['user_pwd']; exit;
//	}else{
//	    echo 'no';exit;
//	}
//  break;
//  case "getuid":
//    $rc=$mysqli->query("select max(uid) as uid from users")->fetch_assoc();
//    if($rc['uid']){
//	    echo 'ok_@@_'.$rc['uid']; exit;
//	}else{
//	    echo 'no';exit;
//	}
//  break;
//}
?>
