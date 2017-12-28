<?php
header('Content-Encoding: plain');//不使用压缩。因为服务器开启了Gzip，IE6的XMLhttprequest对象不自动解压，导致返回数据错误（就是IE6下面getJSON的callback不执行）。
/*返回值说明：
	00:帐号或密码不正确；
	01:帐号为空；
	02：密码为空；
	03:主要参数错误；
	
	10：登录成功；
	
	20：退出成功；
*/
require(substr(__DIR__, 0, -3) . 'include/common.inc.php');

$act = $_REQUEST['act'] ? $_REQUEST['act']:die('03');

$u=new users;

if($act == 'login'){
	$user=$_REQUEST['login_user'];
	$pows=$_REQUEST['login_pwd'];
	if(!$user){
		die('01');
	}elseif(!$pows){
		die('01');
	}
	$e=$u->login_($user,$pows); 
	
	$resCode = '00';
	if($e=='ok'){
		$resCode = '10';
	}
	
	$json = json_encode($resCode);
	echo $_GET['callback']."(".$json.")";		
	die();//$resCode	
}elseif ($act == 'logout'){
	$backurl=$_SERVER['HTTP_REFERER'];
	if(!$backurl){
		$backurl='http://www.6qwan.com';
	}
	$_SESSION['login']['username'] = '';		
	setcookie('login_game_info','',-86400 * 365,'/','6qwan.com');
	setcookie('login_name','',-86400 * 365,'/','6qwan.com');
	setcookie('userinfo','',-86400 * 365,'/','6qwan.com');
	setcookie('q1L_auth','',-86400 * 365,'/','6qwan.com');
	setcookie('q1L_loginuser','',-86400 * 365,'/','6qwan.com');
	session_destroy();
	header("Location:$backurl");
}else{
	die('03');	
}

?>