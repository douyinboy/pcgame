<?php
define('INCROOT',substr(__DIR__,0,-5));
class userJuxiangyou{

	/*用户注册*/
	function reg($username,$pows,$mail,$sex,$id_card,$question='',$answer='',$agent_id,$game_id,$server_id='0',$placeid='',$from_url='',$adid='',$truename='',$rand='1',$cplaceid='',$pcid){
		GLOBAL $cookiepath,$cookiedomain;
		$uid=$uid?$uid:0;
		if ($from_url=='') {
			$from_url = $_COOKIE['__from_url__'];
		}
		$info='username='.$username.'&passwd='.md5($pows).'&email='.$mail.'&ip='.GetIP().'&agent_id='.$agent_id.'&game_id='.$game_id.'&from_url='.$from_url.'&placeid='.$placeid.'&adid='.$adid.'&server_id='.$server_id.'&truename='.$truename.'&idcard='.$id_card.'&rand='.$rand.'&cplaceid='.$cplaceid.'&pcid='.$pcid;//定义传递规则

		$sty_states=long_login($info, time(),'reg_bengbeng&do=reg_juxiangyou');
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
