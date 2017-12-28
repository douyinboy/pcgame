<?php 
session_start();
function LocationSvrUrl($user,$game_id,$server_id,$smarty,$wd){
	global $root_url;
//	$wd = 0;
//	$_REQUEST['wd'] ==1 && $wd=1;
//    if ($from == 'weiduan') {
//        $wd = 1;
//    }
    $time = time();
    $login_ip = GetIP();
    $info = "user_name=".$_SESSION["login"]["username"]."&userid=".$_SESSION["login"]["uid"]."&game_id=".$game_id."&server_id=".$server_id."&wd=".$wd."&login_ip=".$login_ip."&fcm=".$_SESSION['login']['fcm']."&reg_time=".$_SESSION['login']['reg_time'];  //.$_SESSION['login']['fcm'];
    $game_url=long_login($info,$time,'getgameurl');
    if (!$game_url) {
        $game_url = $root_url;
    }
	require(SYS_ROOT . "config/gameSvrData.php");
	$gameData = json_decode($gameData,true);
	$SvrData = json_decode($SvrData,true);
	if( $SvrData[$game_id][$server_id]['svrStateID']>2 || $_SESSION["login"]["username"] =='91yxq'){  //开服
        if($_REQUEST['wd'] == 1 || $_REQUEST['wd'] == 2){
			//exit( $game_url );
			header("Location:".$game_url);
		}else{
			$frmTemplate = 'gamelogin/index.html';
			$smarty->assign('top',file_exists(SYS_ROOT . 'gameTop/'.$game_id.'.html')+0);
			$smarty->assign('wd',file_exists(SYS_ROOT . $gameData[$game_id]['nameEn'].'/dlq/index.html')+0);
			$smarty->assign('server_name',$SvrData[$game_id][$server_id]['svrName']);
			$smarty->assign('game_id',$game_id);
			$smarty->assign('game_name',$gameData[$game_id]['nameCn']);
			$smarty->assign('game_short_name',$gameData[$game_id]['nameEn']);
			$smarty->assign('server_id',$server_id);
			$smarty->assign('game_url',$game_url);
			$smarty->assign('root_url',$root_url);
			$smarty->assign('user',$user);
			$smarty->display($frmTemplate);
		}
		exit;
	}else{
		$flage = '尚未开启';
		if($SvrData[$game_id][$server_id]['svrStateID']==1){
			$flage='尚未维护完毕';
		}else{
			$flage='待开';
		}
		$msg = '当前服务器'.$flage.'，详细情况敬请关注官方公告';
		$gotoUrl = strlen($SvrData[$game_id][$server_id]['svrGameUrl']) > 10 ? $SvrData[$game_id][$server_id]['svrGameUrl'] : $gameData[$game_id]['gameWeb']; 
		$gotoUrl == '' && $gotoUrl = $root_url;
                if($_REQUEST['wd'] ==1){
                    if($game_id==1){
                        $gotoUrl = $root_url . "wj/dlq/index.html";
                    }
                }
                echoTurn($msg,$gotoUrl);
	}
}

$game_id=(int)$_REQUEST['game_id'];
$server_id=(int)$_REQUEST['server_id'];
$wd = 0;
if (isset($_REQUEST['wd'])) {
    $wd = $_REQUEST['wd'];
}
if(!$game_id){
   echoTurn('所选的游戏暂未开服,请留意官网公告!',$root_url);  //以后跳到对应官网的地址；
}
if($_SESSION["login"]["username"]){	 //已经登录  以后改用session	
	$user=$_SESSION["login"]["username"];
	LocationSvrUrl($user,$game_id,$server_id,$smarty,$wd);
	exit();
} else {
	
	if( isset($_REQUEST['wd']) && $_REQUEST['wd'] ==1 ){
		header("Location:".$root_url.'/public/popup_login.html?forward='.urlencode($root_url . 'main.php?act=gamelogin&game_id='.$game_id.'&server_id='.$server_id.'&wd=1'));
	}
	else{
		header("Location:".$root_url.'main.php?act=login&forward='.urlencode($root_url . 'main.php?act=gamelogin&game_id='.$game_id.'&server_id='.$server_id));
	}

	exit;
}

$backurl = $root_url . 'main.php?act=gamelogin&game_id='.$game_id.'&server_id='.$server_id;
if($_REQUEST['other_act']==1){
    $user=strip_tags(trim($_POST['login_user']));
    $pows=trim($_POST['login_pwd']);
    if(!$user || !$pows){	
            $msg = '帐号和密码都不能为空，请您核对！';
            echoTurn($msg,$backurl);
    }
    $u = new users;
    $e=$u->login_($user,$pows);

    if($e=='ok'){
            LocationSvrUrl($user,$game_id,$server_id,$smarty,$wd);
    } else {
            $msg = '抱歉！你填写的帐号或密码不正确';
            echoTurn($msg,$backurl);
    }
    exit();	
}else{
    setcookie('loginreg','',-86400 * 365,'/',$cookieurl);//登录标识；
    setcookie('login_name','',-86400 * 365,'/',$cookieurl);//清除玩家账号；
    $frmTemplate = 'gamelogin/'.$game_id.'/login.html';
    if(!file_exists(SYS_ROOT . 'template/'.$frmTemplate)){
        $frmTemplate = 'login.html';
    }
    $smarty->assign('ref',$backurl);
}

if($_REQUEST['wd'] ==1){
    if($game_id==1){
        header("Location:{$root_url}wj/dlq/index.html");
    }
}


$smarty->assign('login_user',$user);
$smarty->assign('game_id',$game_id);
$smarty->assign('server_id',$server_id);
$smarty->display($frmTemplate);
die();

?>



