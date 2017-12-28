<?php
$_SESSION["login"]["username"] && echoTurn('', $root_url);
$agent_id = intval(trim($_REQUEST['agent_id'])); //渠道ID
$placeid = intval(trim($_REQUEST['placeid'])); //广告位ID
$cplaceid = intval(trim($_REQUEST['cplaceid'])); //子ID
$game_id = intval(trim($_REQUEST['game_id'])); //游戏ID
$from_url=$_COOKIE['from_url'];//来源URL
if(!$agent_id){ $agent_id=$placeid=100;}

if ($_COOKIE['bbs_place_id'] !== 'null') {
    $agent_id = 10020;
    $placeid = $_COOKIE['bbs_place_id'];
}

$dc=new DataCheck;//构造数据验证类
if($_POST['action']){//注册
	$u=new users;
	$u->bs=1;//为1主站注册过来 为0广告注册过来
	$login_name=trim($_POST['login_name']);
	$sex=$_POST['sex'];
	$login_pwd=$_POST['login_pwd'];
	$relogin_pwd=$_POST['relogin_pwd'];
	$email=$_POST['email'];
	$chk_code=$_POST['chk_code'];
	$truename=trim($_POST['truename']);
	$idcard=trim($_POST['idcard']);
	$reg_ip	 = GetIP();
	
	$admin = array('admin','91yxq','gm','GM','ｇｍ','ＧＭ','ＡＤＭＩＮ','ａｄｍｉｎ');
	foreach ($admin as $key=>$val){
		if(is_int(strpos($login_name, $val))){
			$message = '用户名带有非法字符!';
			echoTurn($message,$root_url); die;
		}
	}
			
	if($chk_code and $chk_code!=$_SESSION['chk_code'])
	{
		$message = '验证码输入有误,请输入正确的验证码(长度为4位, 允许字符：“0-9”)';        
		echoTurn($message,'back'); die;
	}
	 
	if (!$dc -> chkUserName($login_name,4,20))
	{
		   $message = '用户名不符合要求(长度为4~20位, 允许字符：“_, a-z, A-Z, 0-9”)';
		   echoTurn($message,'back'); die;
	}
	
	if (!$dc -> chkUserPwd($login_pwd,6,18))
	{
		   $message = '密码不符合要求(长度为6~18位, 允许字符：“_, a-z, A-Z, 0-9”)';
		   echoTurn($message,'back'); die;
	}
	
	if (trim($login_pwd) !== trim($relogin_pwd)) 
	{
		   $message = '两次输入的密码不同, 请返回重新输入!';
		   echoTurn($message,'back'); die;
	}
	
	if (!$dc -> chkEmpty($email)) 
	{
		   $message = '电子邮箱不能为空!';
		   echoTurn($message,'back'); die;
	}
	
	if (!$dc -> chkEmail($email)) 
	{
		   $message = '电子邮箱格式不正确!';
		   echoTurn($message,'back'); die;
	}

   if(!preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$truename)){
   	   echoTurn('真实姓名必须为汉字!','back');
   }
   
	if(!check_idcard($idcard)){
		echoTurn('身份证号码填写错误!','back');
   }

	$info="username=$login_name";
	$result=long_login($info,time(),"reg&do=chkname");
	if ($result != 'ok'){
	   $message = '账号\''.$login_name.'\'已经被注册, 请选择其它账号进行注册!';
	   echoTurn($message,'back');
	   exit();
	}
	if( !empty( $_SERVER['HTTP_REFERER'] ) ){
		$url_arr = parse_url( $_SERVER['HTTP_REFERER'] );
		if( $url_arr['host'] != $www_url ){
			//echo '<script language="javascript">location.href="' . $root_url . '"</script>';
			//exit();
		}
	}

	$u->reg($login_name,$login_pwd,$email,$sex,$idcard,'','',$agent_id,$game_id,$server_id,$placeid,$from_url,$adid,$truename,1,$cplaceid);
	set_cookie('login_name',$login_name,time()+86400*30);
	set_cookie('loginreg',md5($login_name),time()+86400*30);//登录标识
	$url = $root_url . 'user.php';
	if($_REQUEST['href']){
		$url = $_REQUEST['href'];
	}
	$myMsg = "注册成功";
	header("Location:".$url);   
}

$href = 'http://' . $www_url;
if($_REQUEST['href']){
	$url = parse_url($_REQUEST['href']);
	if($url['host']){
		/*
		$str = explode('.', $url['host']);
		$href = $_REQUEST['href'];
		if($str[1]!='6qwan'){
			$href='http://www.6qwan.com';
		}
		*/
		$href = 'http://'.$url['host'];
	}else{
		$href=$_REQUEST['href'];
	}	
}

$smarty->assign('href',$href);
$smarty->assign('game_id',$game_id);
?>