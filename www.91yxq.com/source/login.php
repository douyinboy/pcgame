<?php

// echo $_SERVER['HTTP_REFERER'];
// $ref=$root_url;

if( !empty($_SESSION["login"]["username"]) ){	 //已经登录  以后改用session	
	//header('Location:'.$root_url);
	echoTurn('您已经登录，如需要切换账号，请先退出登录。',$root_url);
}

if( !empty($_REQUEST['forward']) ){
	$forward = $_REQUEST['forward'];
}
elseif( !empty($_SERVER['HTTP_REFERER']) ){
	$forward = $_SERVER['HTTP_REFERER'];
}
else{
	$forward = $root_url;
}
$smarty->assign('forward',$forward);

/*
$ref=htmlspecialchars($_REQUEST['ref']);
if(!$ref){
	$ref=$_SERVER['HTTP_REFERER'];
}
*	
if ($_REQUEST['action']==1)
{		
	$user=$_POST['login_user'];
	$pows=$_POST['login_pwd'];

	if(!$user or !$pows){	
		echo 'pwd error';
		exit();
	}
	$u=new users;
	$e=$u->login_($user,$pows);

	if($ref=='bbs'){
		if($e=='ok'){
			echoTurn('','http://bbs.5399.com/');
		} else {
			echoTurn('登录失败，帐号或用户名错误！','http://www.5399.com/');
		}
		exit();
	} else {
		echo $e;
		exit();
	}
}*/

// if($ref==$root_url){
	// $ref='http://' . $www_url .$_REQUEST['href'];
	
	// $array_expression = array('<','>','<script>','select','update','delete','del','.sh','.sql');
	// foreach ($array_expression as $key => $value) {
		// if(is_int(strpos($_REQUEST['href'],$value))){
			// $ref = $root_url;
			// break;
		// }
	// }
// }
// $smarty->assign('ref',$ref);
?>
