<?php
	/*玩家平台币查询，平台币激活状态查询*/
	$user_name=strip_tags(trim($_REQUEST['user_name']));
	$time=strip_tags(trim($_REQUEST['time']));
	$time=$time+0;
	$sign=strip_tags(trim($_REQUEST['sign']));
	$result=file_get_contents("http://api.91yxq.com/remote_login.php?act=get_user_platform&time={$time}&sign={$sign}&user_name={$user_name}");
	echo $result;
?>