<?php
	$user_name=$_POST['user_name'];
	$pay_gold=$_POST['pay_gold']+0;
	$user_table=usertab($user_name);
	$sql="UPDATE `$user_table` SET money_plat=money_plat+{$pay_gold} WHERE user_name='{$user_name}'";
	if($mysqli->query($sql)){
		echo 1;
	}else{
		echo 0;
	}
?>
