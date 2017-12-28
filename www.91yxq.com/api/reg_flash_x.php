<?php

define('SYS_ROOT',substr(__DIR__, 0, -3));
require_once(SYS_ROOT.'include/common.inc.php');
require_once(SYS_ROOT.'config/ad_gameurl.php');

$dc=new DataCheck;//构造数据验证类

$agent_id = intval(trim($_POST['agent_id'])); //渠道ID
$site_id = trim($_POST['placeid']); //广告位ID
$adid = substr(trim($_POST['adid']),0,10); //广告ID
$game_id= isset($_POST['game_id']) ? $_POST['game_id']:1;//游戏id
$rand= isset($_POST['rand']) ? $_POST['rand']:1; //广告轮数
$cplaceid=substr(trim($_POST['cplaceid']),0,50); //子id
$email=trim($_POST['email']);
$union=trim($_POST['union']);

if(!$agent_id){ $agent_id=$site_id=100;}

if($_POST['from_url']){
	$from_url=trim($_POST[from_url]);
}elseif($_GET['from_url']){
	$from_url=trim($_GET['from_url']);
}else{
	$from_url=$_COOKIE['from_url'];
}

$succ_url=$ad_gameurl[$game_id]['game_url'];

if(!$succ_url){
	$succ_url = $root_url . "turn.php?act=gamelogin&game_id=".$game_id."&server_id=".$server_id."&source=1";
} else {
	$succ_url = $succ_url . "&source=1";
}

preg_match_all('/server_id=([\d]+?)&source/i', $succ_url, $m);
$server_id=$m[1][0];

if($_REQUEST['reg_tourl'] == $root_url . 'api/reg_flash_x.php'){//注册
	$u=new users;
	
	$login_name=trim($_REQUEST['username']);
	if(empty($login_name)) {
       $login_name=trim($_REQUEST['username']);
	}
	$login_pwd=$_REQUEST['password'];
	$relogin_pwd=$_REQUEST['password'];

	//mem防注册
	include(SYS_ROOT . 'include/mem.php');
	$testIPs = array('119.145.139.237');
    if ($reg_counts>=20 && !in_array($reg_ip,$testIPs) ) {  	
		$message = '你已过多注册平台帐号，每台电脑每天最多只能注册20个帐号';       
// 	   echoTurn($message, $root_url);
// 	   exit();
	}

	if (!$dc -> chkUserName($login_name,4,20))
	{
		$message = $login_name.'用户名不符合要求（长度为4~20位，允许字符：“_，a-z，A-Z，0-9”）';
	   echoTurn($message,'back');
	   exit();
	}
	if (!$dc->chkUserName1($login_name)){
		$message = $login_name.'用户名不能含有特殊符号';
	   echoTurn($message,'back');
	   exit();
	}
	
	$admin = array('admin','9494','91yxq','gm','GM','ｇｍ','ＧＭ','ＡＤＭＩＮ','ａｄｍｉｎ');
	foreach ($admin as $key=>$val){
		if(is_int(strpos($login_name, $val))){
			$message = $login_name.'用户名含有禁止字符';
			echoTurn($message,'back');
			exit();
		}
	}
	
	if (!$dc -> chkUserPwd($login_pwd,6,18))
	{
		$message = '密码不符合要求（长度为6~18位，允许字符：“_，a-z，A-Z，0-9”）';
	   echoTurn($message,'back');
	   exit();
	}
	
	if (trim($login_pwd) !== trim($relogin_pwd)) 
	{
		$message = '两次输入的密码不同，请返回重新输入!';
	   echoTurn($message,'back');
	   exit();
	}

	$info="username=$login_name";
	$result=long_login($info,time(),"reg&do=chkname");
	
	if ($result != 'ok'){
	   $message = '账号\''.$login_name.'\'已经被注册，请选择其它账号进行注册!';
	   echoTurn($message,'back');
	   exit();
	}

	if(empty($agent_id)){
		$agent_id = $_COOKIE['agent_id'];
	}
	if(empty($game_id)){
		$game_id = $_COOKIE['game_id'];
	}
// 	if(empty($server_id)){
// 		$server_id = $_COOKIE['server_id'];
// 	}
	if(empty($site_id)){
		$site_id = $_COOKIE['site_id'];
	}
	if(empty($from_url)){
		$from_url = $_COOKIE['from_url'];
	}
	if(empty($adid)){
		$adid = $_COOKIE['adid'];
	}
	if(empty($rand)){
		$rand = $_COOKIE['rand'];
	}
	if(empty($cplaceid)){
		$cplaceid = $_COOKIE['cplaceid'];
	}
	
	$u->reg($login_name,$login_pwd,$email,$sex,'','','',$agent_id,$game_id,$server_id,$site_id,$from_url,$adid,'',$rand,$cplaceid,$union);

	//js setcookie
	set_cookie('loginreg',md5($login_name),time()+86400);
	set_cookie('login_name',$login_name,time()+86400);
    $_SESSION['source'] = 1;

	if ($succ_url) {
	   echo '<script language="javascript">location.href="'.$succ_url.'"</script>';
		exit();
	}else{
		echo '<script language="javascript">location.href="' . $root_url  . '"</script>';
		exit();
	}

}else{
		header("location:" . $root_url);
		exit();
}

exit();

?>