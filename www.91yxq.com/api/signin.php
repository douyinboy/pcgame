<?php
define('SYS_ROOT',substr(__DIR__, 0, -3));
require(SYS_ROOT . 'include/common.inc.php');

$act = $_GET['act'];
$game= $_GET['game'];

$result = array();
$uname  = $_SESSION["login"]["username"];

$act_key = array('sign', 'convert', 'convertlog');
try {
	if(empty($uname)){
		$result['state']=1; //未登录
		exit(json_encode($result));
	}
	if(empty($act) || empty($game)){
		$result['state']=0; //参数错误
		$result['msg']='参数错误';
		exit(json_encode($result));
	}
	if(!in_array($act, $act_key)){
		$result['state']=0; //参数错误
		exit(json_encode($result));
	}
	
	$sourcefile = SYS_ROOT . 'source/signin/'.$game.'.php';
	if(!file_exists($sourcefile)){
		$result['state']=2; //参数错误
		exit(json_encode($result));
	}
	include($sourcefile);
	
} catch (Exception $e) {
	$result['state']=-1; //未知错误
	$result['msg']='未知错误';
	exit(json_encode($result));
}