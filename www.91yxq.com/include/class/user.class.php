<?php
define('INCROOT',substr(__DIR__,0,-5));
class users{

	 function logintrue(){
		if($_COOKIE['loginreg'])
		{
			return true;
		}else{
			return false;
		}
	 }
	 
	 
	/**
	 * +--------------------------------------------------
	 * |   函数名： login($user,$pows,$validate)
	 * |   作用：   用户登录
	 * |   参数：　
	 * |    $user               用户名
	 * |    $pows              用户密码
	 * |    $validate          验证码
	 * |   返回值：1 2 3 分别代表  验证码错误 密码错误 用户名错误
	 * +--------------------------------------------------
	 */
	 
	function login($user,$pows,$validate){
		if($_SESSION['chk_code']!=$validate)
		{
			return 'code error';//验证码错误
		}
		
		return $this-> login_($user,$pows);
	}

///////////////////////一下是不需要外面掉用的/////////////////////////////////////////
	
	/**
	 * +--------------------------------------------------
	 * |   函数名： login_($user,$pows)
	 * |   作用：   个人用户登录
	 * |   参数：　
	 * |    $user               用户名
	 * |    $pows              用户密码
	 * |    $my              my为真接收过来的pows为md5加密过的密码，否则pows为明码密码
	 * |   返回值：true
	 * +--------------------------------------------------
	 */
	function login_($user,$pows,$my=false,$game=false){
		GLOBAL $cookiepath,$cookiedomain;
        $powsold = $pows;
		$IP = ip2long(GetIP());
		$mem = new Memcache;
		$mem->connect('127.0.0.1', 11211);
		if($mem->get($IP)>0){ $mem->close();return 'novalid'; exit; }
		$mem->close();

		if(!$user or !$pows) {
			return 'value error';
		} else {
			if(!$my){
				$pows=md5($pows);
			}
			$info="username=$user&passwd=$pows&login_ip=".GetIP();
			$results=long_login($info, time(),'login');
		}
		
		$result_arr=explode('_@@_',$results);

		if($result_arr[0]=='ip error'){//ip错误
			return 'ip error';
			exit;	
		}elseif($result_arr[0]=='pwd error'){//密码错误
			return 'pwd error';
			exit;
		}elseif($result_arr[0]=='ok'){//如果验证通过

			//数组0－>返回状态
			//数组1－>用户id	
			//数组2－>用户名
			//数组3－>上次登录ip
			//数组4－>上次登录时间
			//数组5－>用户的email信息
			//数组6－>防沉迷标识
		   //数组7－>用户头像
		   //数组8－>帐号状态
		   //数组9－>防老板标题
		   //数组10－>完善资料标识
		   //数组11－>登录过游戏
		   //数组12－>注册时间
		   //数组13－>积分

			if(intval($_POST['denglu'])==1){//记住登录
				$cookietime = time()+3600*24*30; //保存时间一个月
			}else{
				$cookietime = time()+3600*12;
			}
			//设置上次登录游戏的ip地址
			set_cookie('login_ip',"'".$result_arr[3]."'",$cookietime,$cookiepath,$cookiedomain);
			//设置上次登录时间
			set_cookie('login_time',date("Y-m-d H:i:s",$result_arr[4]),$cookietime,$cookiepath,$cookiedomain);
			set_cookie('login_name',$user,$cookietime,$cookiepath,$cookiedomain);
			//设置上次登录用户的密码
			set_cookie('last_name',$user,$cookietime,$cookiepath,$cookiedomain);
			//set_cookie('last_pass', $powsold, $cookietime,$cookiepath,$cookiedomain);
			//设置最近登录过游戏
// 			$game_str=escape(iconv('UTF-8', 'GBK', $result_arr[11]));
 			set_cookie('login_game_info',$result_arr[11],$cookietime,$cookiepath,$cookiedomain);
			//设置防老板
			if($result_arr[8]==3){
				set_cookie('flb',$result_arr[9],$cookietime,$cookiepath,$cookiedomain);
			}
			//用户id|帐号状态|完善资料标识|防沉迷标识|用户头像
			set_cookie('userinfo',$result_arr[1].'|'.$result_arr[8].'|'.$result_arr[10].'|'.$result_arr[6].'|'.$result_arr[7], $cookietime,$cookiepath,$cookiedomain); 

			$cookiepre = 'YRYk_2132_';			         // cookie 前缀
			$md5dcbbsid = md5($result_arr[1].$pows)."\t".$result_arr[1];

			set_cookie($cookiepre.'cookietime', $cookietime, $cookietime,$cookiepath,$cookiedomain);
			set_cookie($cookiepre.'auth', $this->authcode($md5dcbbsid, 'ENCODE'), $cookietime,$cookiepath,$cookiedomain);
                        set_cookie($cookiepre.'sid', '',  -86400 * 365);//清空论坛sid，loginuser，activationauth，以避免重新激活
			set_cookie($cookiepre.'loginuser', $user, time()+3600 * 12,$cookiepath,$cookiedomain);
			set_cookie($cookiepre.'activationauth', '', -86400 * 365,$cookiepath,$cookiedomain);
			
			//BBS记录END
		
			$_SESSION["login"]["reg_time"]=$result_arr[12];
			$_SESSION["login"]["fcm"]=$result_arr[6];
                        $_SESSION["login"]["username"]=$user;
                        $_SESSION["login"]["uid"]=$result_arr[1];
			$_SESSION["login"]["user_state"]=$result_arr[8];
			$_SESSION["login"]["integral"]=$result_arr[13];

			return "ok";
		}

	}

	/*用户注册*/
	function reg($username,$pows,$mail,$sex,$id_card,$question='',$answer='',$agent_id,$game_id,$server_id='0',$placeid='',$from_url='',$adid='',$truename='',$rand='1',$cplaceid='',$union=''){
		GLOBAL $cookiepath,$cookiedomain;
		$uid=$uid?$uid:0;
		if ($from_url=='') {
			$from_url = $_COOKIE['__from_url__'];
		}
		$info='username='.$username.'&passwd='.md5($pows).'&email='.$mail.'&ip='.GetIP().'&agent_id='.$agent_id.'&game_id='.$game_id.'&from_url='.$from_url.'&placeid='.$placeid.'&adid='.$adid.'&server_id='.$server_id.'&truename='.$truename.'&idcard='.$id_card.'&rand='.$rand.'&cplaceid='.$cplaceid.'&union='.$union;//定义传递规则

		$sty_states=long_login($info, time(),'reg&do=reg');
		$results=explode('_@@_',$sty_states);
		if($results[0]!='ok'){
			echo "<script>alert('注册失败！');location.href='{$root_url}';</script>";
			exit();
		}
		
		if (trim($_COOKIE['first_ip'])=='') {
	        set_cookie('first_ip',GetIP(), time()+86400 * 365,$cookiepath,$cookiedomain);
		}
		if (trim($_COOKIE['first_time'])=='' || $_COOKIE['first_time']==0) {
	        set_cookie('first_time',time(), time()+86400 * 365,$cookiepath,$cookiedomain);
	    }
	//同步登录
        set_cookie('login_name',$username, time()+86400 * 365,$cookiepath,$cookiedomain);
		if ($id_card && check_age($id_card)) {
			$_SESSION["login"]["fcm"]=1;
		} else if ( $id_card ) {
			$_SESSION["login"]["fcm"]=0;
		} else {
			$_SESSION["login"]["fcm"]=2;
		}
		
		$cookiepre = 'YRYk_2132_';		
		$cookietime = time()+86400;
		$md5dcbbsid = md5($results[1].md5($pows))."\t".$results[1];
		
		//用户id|帐号状态|完善资料标识|防沉迷标识|用户头像
		set_cookie('userinfo',$results[1].'|1|0|'.$_SESSION["login"]["fcm"].'|', $cookietime,$cookiepath,$cookiedomain);

		set_cookie($cookiepre.'cookietime', $cookietime, $cookietime,$cookiepath,$cookiedomain);
		set_cookie($cookiepre.'auth', $this->authcode($md5dcbbsid, 'ENCODE'), $cookietime,$cookiepath,$cookiedomain);
		set_cookie($cookiepre.'sid', '',  -86400 * 365,$cookiepath,$cookiedomain);//清空论坛sid，loginuser，activationauth，以避免重新激活
		set_cookie($cookiepre.'loginuser', $username, time()+86400 * 365,$cookiepath,$cookiedomain);
		set_cookie($cookiepre.'activationauth', '', -86400 * 365,$cookiepath,$cookiedomain);
		
		$_SESSION["login"]["reg_time"]=time();
		$_SESSION["login"]["username"]=$username;
		$_SESSION["login"]["uid"]=$results[1];
		$_SESSION["login"]["integral"]=0;//积分
		return "ok";
	}
	
	function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
		global $discuz_auth_key;
		$ckey_length = 4;
		$key = md5($key ? $key:$discuz_auth_key);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);

		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);

		$result = '';
		$box = range(0, 255);

		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}

		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}

		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}

		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}

	}
}
?>
