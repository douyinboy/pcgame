<?php
	/*玩家平台币查询，平台币激活状态查询*/
	$user_name=strip_tags(trim($_REQUEST['user_name']));
	$pwForPt=strip_tags(trim($_REQUEST['pwForPt']));
	$money=strip_tags(trim($_REQUEST['money']));
	$money=$money+0;
	$time=strip_tags(trim($_REQUEST['time']));
	$time=$time+0;
	$sign=strip_tags(trim($_REQUEST['sign']));
	$result=file_get_contents("http://api.91yxq.com/remote_login.php?act=check_user_platform&time={$time}&sign={$sign}&user_name={$user_name}&pwForPt={$pwForPt}&money={$money}");
	echo $result;
?>