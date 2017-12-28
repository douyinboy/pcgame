<?php
	/*玩家平台币查询，平台币激活状态查询*/
	$user_name=$mysqli->escape_string(strip_tags(trim($_REQUEST['user_name'])));
	$pwForPt=$mysqli->escape_string(strip_tags(trim($_REQUEST['pwForPt'])));
	$user_table = usertab($user_name);
	$money += 0;
	$platformB = $money * 100;
	$sql="SELECT `userPayPw`,`money_plat`,`ptb_open` FROM `$user_table` WHERE `user_name`='$user_name'";
	$row=$mysqli->query($sql)->fetch_assoc();
	if ($row['ptb_open'] != 1) {
		exit('not open');
	} elseif ($row['money_plat'] < $platformB) {
		exit('not sufficient funds');
	} elseif ($pwForPt && $row['userPayPw'] != $pwForPt) {
		exit('password error');
	} else {
		exit('ok');
	}
?>
