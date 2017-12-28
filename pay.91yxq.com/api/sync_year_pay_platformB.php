<?php
//年活动之签到获取首充值比例平台币
//年会活动过后次脚本将被设置为91yxq平台内充平台币脚本
		date_default_timezone_set("Asia/Shanghai");
		
		$user_name = trim($_REQUEST['user_name']);
		$pay_gold = trim($_REQUEST['platformB']);
		$sign_from = trim($_REQUEST['sign']);
		if($sign_from!=md5($user_name.$pay_gold.'7qu@91yxqV5')){
			echo 'sign error';
			exit;
		}
		
		$fhandle2=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/year_pay_to_platform.log","a");
		fwrite($fhandle2,date("Y-m-d H:i:s")."	".$_SERVER["REMOTE_ADDR"]."	".$user_name." ".$pay_gold."\r\n");
		fclose($fhandle2);
		
		mysql_connect('192.168.0.20','91yxq','7X(xyELU2FSy!QyZ');
		mysql_select_db('91yxq_plat');
		mysql_query('SET NAMES UTF8');
		
		if(time()<1424188800 || time()>1424793599){//活动期间检测账户是否超过3次充值平台币
		$user_platformB_count = mysql_fetch_row(mysql_query("SELECT COUNT(id) FROM year_user_pay_platformB WHERE user_name='{$user_name}'"));
		if($user_platformB_count[0]>=3){
			echo 'more times';
			exit;
		}
		}
		$time_now=time();
		mysql_query("INSERT INTO year_user_pay_platformB (user_name,platformB,pay_time,state) VALUES ('{$user_name}',{$pay_gold},".$time_now.",0)");
		
		
		$sign=md5($time_now.'@_dq*3@DJl_5a_@');
		$update_url = 'http://api.91yxq.com/remote_login.php';
		$post_fields="time={$time_now}&sign={$sign}&act=update_user_platform&user_name={$user_name}&pay_gold={$pay_gold}";
		$ch = curl_init($update_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
		$update_result=curl_exec($ch);
		curl_close($ch);
		if($update_result==1){
			$pay_state=mysql_query("UPDATE year_user_pay_platformB SET state=1,get_time=".time()." WHERE user_name='{$user_name}' AND pay_time={$time_now}");
			if($pay_state){
				echo 'pay OK';
				exit;
			}else{
				echo 'pay NO';
				exit;
			}
		}else{
			echo 'pay NO';
			exit;
		}
		
?>