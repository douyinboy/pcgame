<?php

$magic_quotes_gpc = get_magic_quotes_gpc();

function daddslashes($string, $force = 0) {
    if(! $GLOBALS['magic_quotes_gpc'] || $force) {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = daddslashes($val, $force);
            }
        } else {
            $string = addslashes(strip_tags(trim($string)));
        }
    }
    return $string;
}

$_COOKIE = daddslashes($_COOKIE);
$_POST = daddslashes($_POST);
$_GET = daddslashes($_GET);



if (! $magic_quotes_gpc) {
    $_FILES = daddslashes($_FILES);
}

function usertab($uname, $s = true)
{
    $uname = strtolower($uname);
    $c1 = substr($uname, 0, 1);
    $c2 = substr($uname, -1);
    $n = ord($c1) + ord($c2);
    $l = strlen($uname);
    $n += $l * $l;
    if ($s) {
        return '91yxq_user_' . $n % 40;
    } else {
        return $n % 40;
    }
}

function dbinsert($table, $field, $value) //插入数据
{
    if (count($field) != count($value) || ! is_array($field) || ! is_array($value)) {
        echo "生成插入SQL错误!";
        return false;
    }
    $sql = 'INSERT INTO ' . $table . ' (';

    for ($i = 0;$i < count($field);$i++) {
        $sql = $sql . '`' . $field[$i] . '`';
        if ($i != (count($field)-1)) {
            $sql .= ", ";
        }
    }
    $sql .= ') VALUES (';

    for($i = 0;$i < count($value);$i++) {
        $sql = $sql . '\'' . $value[$i] . '\'';
        if ($i != (count($field)-1)) {
            $sql = $sql . ", ";
        }
    }
    $sql .= ');';
    global $mysqli;
    return $mysqli->query($sql);
}


function get_real_ip(){
    $ip=false;
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
        for ($i = 0; $i < count($ips); $i++) {
            if (! eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) {
                $ip = $ips[$i];
                break;
            }
        }
    }
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}




function agentReg($agent_id,$reg_name,$reg_ip,$game_id='0',$server_id='0',$from_url,$placeid='',$email='',$adid='',$turn=1,$cplaceid,$union){
    if ($reg_name)
    {
        $agent_table="91yxq_agent_reg_".date('Y');
        $sql = "INSERT INTO `$agent_table` (agent_id,placeid,adid,`union`,user_name,email,reg_ip,reg_time,referer_url,game_id,server_id,turn,ext1) VALUES ('".intval($agent_id)."','".intval($placeid)."','".$adid."','$union','".$reg_name."','".$email."','".ip2long($reg_ip)."','".time()."','".$from_url."','".$game_id."','".$server_id."','".$turn."','".$cplaceid."')";
        global $mysqli;
        $mysqli->query($sql);
    }
}

/*身份证验证函数群*/
function idcard_verify_number($idcard_base)
{
    if (strlen($idcard_base) != 17){ return false; }

    // 加权因子
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

    // 校验码对应值
    $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

    $checksum = 0;
    for ($i = 0; $i < strlen($idcard_base); $i++){
        $checksum += substr($idcard_base, $i, 1) * $factor[$i];
    }

    $mod = $checksum % 11;
    $verify_number = $verify_number_list[$mod];

    return $verify_number;

}

// 将15位身份证升级到18位
function idcard_15to18($idcard){
    if (strlen($idcard) != 15){
        return false;
    }else{
        // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
        if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false){
            $idcard = substr($idcard, 0, 6) . '18'. substr($idcard, 6, 9);
        }else{
            $idcard = substr($idcard, 0, 6) . '19'. substr($idcard, 6, 9);
        }
    }

    $idcard = $idcard . idcard_verify_number($idcard);

    return $idcard;
}

// 18位身份证校验码有效性检查
function idcard_checksum18($idcard){
    if (strlen($idcard) != 18){ return false; }
    $idcard_base = substr($idcard, 0, 17);

    if (idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))){
        return false;
    }else{
        return true;
    }
}
/*
身份证验证调用这个扩展函数即可
身份证调用这个 验证
*/
function check_idcard($idcard)
{
	if(strlen($idcard) == 15 || strlen($idcard) == 18)
	{
	   if(strlen($idcard) == 15)
	   {
			$idcard = idcard_15to18($idcard);
	   }

	   if(idcard_checksum18($idcard))
	   {
			return true;
	   }else{
			return false;
	   }
	}else{
	   return false;
	}
}

/* 验证是否已满18周岁 */
function check_age($idcard)
{
	if(strlen($idcard) == 15 || strlen($idcard) == 18)
	{
	   if(strlen($idcard) == 15)
	   {
			$idcard = idcard_15to18($idcard);
	   }

      $y=substr($idcard,6,4);
      $ny=date("Y");
      $age=$ny-$y;

	   if($age<18)
	   {
			return false;
	   }else{
			return true;
	   }
	}else{
	   return false;
	}
}
/*身份证验证函数群END*/

class users{
	function login_($user,$pows,$my=false)
	{
                        global $mysqli;
			$rs = $mysqli->query("SELECT `login_pwd` FROM ".usertab($user)." WHERE `login_name`='".$user."' and state=1")->fetch_assoc();

			if (! $my) {
                            $pows=md5($pows);
			}

			if($rs['login_pwd']==$pows)
			{//成功
				return 'ok';
			}else{
				return 'no';
			}
	}
	//防尘迷判断
	function login_i($user,$pows,$my=false)
	{
            global $mysqli;
            $rs=$mysqli->query("SELECT `login_pwd`,`id_card`,`bbs_user_id` FROM ".usertab($user)." WHERE `login_name`='".$user."' and state=1")->fetch_assoc();

            if(!$my){
                    $pows=md5($pows);
            }

            if($rs['login_pwd']==$pows)
            {//成功
                    return 'ok'.'|'.$rs['id_card'].'|'.$rs['bbs_user_id'];
            }else{
                    return 'no';
            }
	}

	//更新游戏登录记录
	function updateGameLogin($gid,$sid,$uname,$ip='',$reg_time=1446033600)
	{
		if (!$uname) {
                    return ;
		}
		$gid += 0;
		$sid += 0;
		$t = time();
                global $mysqli;
		$year_arr = $mysqli->query("SELECT `reg_time` FROM `users` WHERE `user_name`='{$uname}' LIMIT 1")->fetch_row();
		$year = date("Y",$year_arr[0]);
		if ($year < 2015) {
                    $year = 2015;
                }
		$sql="update `91yxq_agent_reg_".$year."` set login_time='$t',login_count=login_count +1 where user_name='$uname'";
		$mysqli->query($sql);

		$usertab=usertab($uname);
		$ip=ip2long($ip);
		$sql="update `$usertab` set login_time=$t,login_ip=$ip where user_name='$uname' ";
		$mysqli->query($sql);


		if ($ip) {
			$d=date("Y-m-d");

			$tb="game_login_info_".date("Ym");

			$csql="CREATE TABLE `91yxq_login_logs`.`$tb` (
					  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
					  `user_name` varchar(50) NOT NULL,
					  `agent_id` int(11) unsigned NOT NULL,
					  `placeid` varchar(50) NOT NULL,
					  `cplaceid` varchar(50) NOT NULL,
					  `adid` varchar(50) NOT NULL,
					  `turn` tinyint(4) unsigned NOT NULL,
					  `game_id` tinyint(4) unsigned NOT NULL,
					  `server_id` smallint(6) NOT NULL,
					  `ip` int(11) unsigned NOT NULL,
					  `login_time` int(11) unsigned NOT NULL,
					  `reg_time` int(11) unsigned NOT NULL,
					  PRIMARY KEY (`id`),
					  KEY `user_name` (`user_name`),
					  KEY `agent_id` (`agent_id`),
					  KEY `game_id` (`game_id`),
					  KEY `ip` (`ip`),
					  KEY `login_time` (`login_time`),
					  KEY `reg_time` (`reg_time`)
					  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ";

			$sql="select agent_id,placeid,adid,reg_time from `91yxq_agent_reg_".$year."` where user_name='$uname' ";
			$row=$mysqli->query($sql)->fetch_object();
			//$reg_time = $row->reg_time;
			$agent_id = $row->agent_id;
			$placeid = $row->placeid;
			$adid = $row->adid;
			$sql="insert into `91yxq_login_logs`.`$tb` (user_name,agent_id,placeid,adid,game_id,server_id,ip,login_time,reg_time) values('$uname','$agent_id','$placeid','$adid','$gid','$sid','$ip','".time()."','$reg_time')";
			$res=$mysqli->query($sql);
			if (! $res && $mysqli->errno == 1146) {
				$r2=$mysqli->query($csql);
				if (!$r2) {
					return;
				}
				$mysqli->query($sql);
			}
	  }

	        $sql = "SELECT id,login_info FROM `91yxq_login_info`  WHERE user_name = '$uname'";

            $rowst=$mysqli->query($sql);
            if ($row=$rowst->fetch_assoc()) {
                $new_info =array();
                $login_info =unserialize($row['login_info']);
                $flag = 1;
                foreach($login_info  as $key=>$val){
                        if($val['gid']==$gid && $val['sid']==$sid ){
                           $val['lastlog']=time();
                           $flag = 0;
                        }
                        array_push($new_info,$val);
                }
                if($flag){
                   $row= array(
                           'gid' => $gid,
                           'sid' => $sid,
                           'lastlog' => time(),
                          );
                           array_push($new_info,$row);
                 }
                $newUpdate = serialize($new_info);
                $sql = "UPDATE `91yxq_login_info`  SET login_info='".$newUpdate."',update_time=".time()."  WHERE user_name='".$uname."'";
                $mysqli->query($sql);
            } else { // insert
                        $login_info = array();
                        $row= array(
                                 'gid' => $gid,
                                 'sid' => $sid,
                                 'lastlog' => time(),
                        );
                        array_push($login_info,$row);
                        $login_info = serialize($login_info);
                        $sql = "INSERT INTO `91yxq_login_info` (add_time,user_name,login_info) VALUES (".time().",'".$uname."','".$login_info."')";
                        $mysqli->query($sql);
                }
        $rowst->free();
	}
}

function long_login_bbs($info,$act){
	$time=time();
	$ch = curl_init( );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_URL, "http://bbs.91yxq.com/api/update.php" );
	curl_setopt( $ch, CURLOPT_POST, 1 );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, "act=$act&".$info."&time=".$time."&sign=".md5($time . BBS_KEY));
	curl_setopt( $ch, CURLOPT_COOKIEJAR, COOKIEJAR );
	curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );

	ob_start( );
	curl_exec( $ch );
	$contents = ob_get_contents( );
	ob_end_clean();
	curl_close( $ch );
	return $contents;
}

function long_login_5a($info,$time,$act){
    $ch = curl_init( );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_URL, "http://api.demo.com/remote_login.php" );
    curl_setopt( $ch, CURLOPT_POST, 1 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, "act=$act&".$info."&time=".$time."&sign=".md5($time."adsf"));
    curl_setopt( $ch, CURLOPT_COOKIEJAR, COOKIEJAR );
    curl_setopt( $ch, CURLOPT_TIMEOUT, TIMEOUT );

    ob_start( );
    curl_exec( $ch );
    $contents = ob_get_contents( );
    ob_end_clean();
    curl_close( $ch );
    return $contents;
}

/*验证$ip地址函数,真IP返回true,假IP返回false*/
function CheckIsIP($ip){
    return !strcmp(long2ip(sprintf('%u',ip2long($ip))),$ip) ? true : false;
}

/*获得客户端ip地址,调用方法getIP()*/
function getIP() {
    if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown")) {
        $ip = getenv("HTTP_CLIENT_IP");
    }
    else if(getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"),"unknown")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    }
    else if(getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"),"unknown")) {
        $ip = getenv("REMOTE_ADDR");
    }
    else if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'],"unknown")) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    else {
        $ip = "unknown";
    }
    return CheckIsIP($ip) ? $ip : "unknown" ;
}

/**
  * @作用：生成签名
  */
function getSign($paraMap, $secret_key, $urlencode = false)
{
    $buff = "";
    ksort($paraMap);
    foreach ($paraMap as $k => $v){
        if($urlencode){
            $v = urlencode($v);
        }
        $buff .= $k . "=" . $v . "&";
    }
    $reqPar = '';
    if (strlen($buff) > 0){
        $reqPar = substr($buff, 0, strlen($buff)-1);
    }
    $reqPar = md5($reqPar.'&secret_key='.$secret_key);
    $reqPar = strtoupper($reqPar);

    return $reqPar;
}


/**
 * @todo向文件中写入异常
 * @param array/string   $log
 */
function doLog($log,$filename){
	$day = date('Y-m-d H:i:s');
	$dir = ROOT.'/logs/'.$filename.'-'.date('Y-m-d');
	if(is_array($log)){
	  file_put_contents($dir, $day.':',FILE_APPEND);
	  file_put_contents($dir, var_export($log,TRUE),FILE_APPEND);
	}else{
	  $log = $day.":".$log."\r\n";
	  file_put_contents($dir, $log,FILE_APPEND);
	}
}
