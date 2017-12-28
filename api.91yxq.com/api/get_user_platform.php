<?php
	/*查询用户平台币激活状态*/
	$user_name=$mysqli->escape_string(strip_tags(trim($_REQUEST['user_name'])));
	$user_table = usertab($user_name);
	$row=$mysqli->query("SELECT `money_plat` FROM $user_table WHERE `user_name`='$user_name'")->fetch_assoc();
	exit($row['money_plat']);
