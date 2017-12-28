<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
if(isset($_POST['stage']) && $_POST['stage']=='yes') {
		$ip=GetIP();
		$username=trim($_POST['username']);
		$email=trim($_POST['email']);
		if(!$username || !$email){
                    echoTurn('帐号和邮箱不能为空！', $root_url . 'help.php?act=getpwd_email');
                    exit();
		}
		$info="username=".$username;
		$result=long_login($info,time(),"getpwd&do=email");
		$result_arr=explode('_@@_', $result);
		$result1='';
		if( $result == "sign error" ){
			echoTurn('api请求校验不匹配，请联系客服', $root_url . '/help/');//api_key不相同
			exit();
		}
		elseif($result_arr[0]=='ok'){
			
			if($email==$result_arr[1]){
				$code=getpwcode(16);
				$log_time=date('Y-m-d H:i:s');
				$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip','$log_time',3,1,'$code')";
				$db->query($sql);
				$url=$root_url . "help.php?act=getpwd_result&type=1&username=".urlencode($username)."&code=".$code."&log_time=".strtotime($log_time)."&sign=".md5($code.$get_email_key.$username);
				$content='<div style="width: 488px; padding: 30px 30px 0px; line-height: 26px; font-size: 12px; float: left; clear: left;">亲爱的<span class="STYLE1">：'.$username.' </span><br><b>请点击下面按钮完成取回' . $english_title . '帐号的密码(链接有效期为3天)</b><br><div style="width: 136px; height: 32px; line-height: 32px; color: rgb(255, 255, 255); font-weight: bold; font-size: 14px; margin: 10px 0px; border: 0px none; cursor: pointer; text-align: center;"><a target="_blank" href="'.$url.'" style="text-decoration:none;"><div style="width:136px; height:32px; line-height:32px; text-align:center; font-size:14px; color:#FFF; font-weight:bold; background:url(' . $image_url . 'help/getpwd.gif); cursor:pointer">取回密码</div></a></div><div style="line-height: 20px;">提示：如果您点击验证按钮无效,请复制下面链接,粘贴到浏览器地址栏中,手动验证：<br><a target="_blank" href="'.$url.'">'.$url.'</a></div><div style="border-top: 1px dotted rgb(163, 163, 163); margin-top: 10px; padding: 5px 0px; color: rgb(119, 119, 119); line-height: 18px;">
	此封信为系统自动发出,系统概不接收您的回信,请勿回复邮件<br>' . $chinese_title . '(' . $english_title . ')是中国最火爆的网页游戏娱乐平台之一,实时公布最新网页游戏排行榜与游戏资料,' . $english_title . '平台千万游戏玩家等你一起玩!<a href="' . $root_url . '" target="_blank">' . $www_url . '</a><br>如果您有任何问题,可以随时<a href="' .$qq_url . '" target="_blank" style="text-decoration: underline;">咨询我们的客服人员</a></div></div>';
				$mailsubject = '=?UTF-8?B?'.base64_encode('找回' . $english_title . '帐号密码').'?=';
				//exit( __DIR__.'=='.dirname(__DIR__)."==".dirname(__DIR__) . "/include/class/email.class.php" );
				include(dirname(__DIR__) . "/include/class/email.class.php");
				
				//if(strstr($email,'qq.com')){
					$content=iconv('UTF-8','GB2312',$content);
				//}
				$re = $smtp->sendmail($email, 'kf@' . $english_title . '.com', $mailsubject, $content, 'HTML'); //成功返回true,失败返回false
				if($re)
				$result1='找回密码的链接已经发送到您的注册邮箱,请登录邮箱进行操作!';
				else
				$result1='邮件发送失败，请重新发送!';
			} else {
				
				$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),3,0,'邮箱找回密码:填写邮箱与注册邮箱不符')";
				$db->query($sql);
				$result1='填写的邮箱与该用户的注册邮箱不符,请返回重新填写';
			}
		} else {
				$sql="insert into `user_logs` (username,log_ip,log_time,log_type,log_state,memo) values('$username','$ip',now(),3,0,'邮箱找回密码:注册邮箱为空')";
				$db->query($sql);
				$result1='该帐号的注册邮箱信息为空,请选择其它密码找回方式或联系我们客服!';
		}
		if($result1){
			echoTurn($result1, $root_url . 'help.php?act=getpwd_email');
		}
}
unset($_POST)
?>
