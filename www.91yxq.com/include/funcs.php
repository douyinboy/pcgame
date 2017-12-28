<?php
//header("content=text/html; charset=utf-8");

$magic_quotes_gpc = get_magic_quotes_gpc();
$_COOKIE=daddslashes($_COOKIE);
$_POST=daddslashes($_POST);
$_GET=daddslashes($_GET);
if(!$magic_quotes_gpc) {
    $_FILES = daddslashes($_FILES);
}


function daddslashes($string, $force = 0) {
  if(!$GLOBALS['magic_quotes_gpc'] || $force) {
    if(is_array($string)) {
      foreach($string as $key => $val) {
          $string[$key] = daddslashes($val, $force);
      }
    } else {
      $string = addslashes(strip_tags(trim($string)));
    }
  }
  return $string;
}


function echoTurn($info, $url='')
{
    $url && $go = 'window.location.href="' . $url . '";';
    $url == 'back' && $go = 'history.back();';
    $info && $er = 'alert("' . $info . '");';
    header("Content-type: text/html; charset=utf-8");
    exit("<script type='text/javascript'>$er$go</script>");
}


/**
 * +--------------------------------------------------
 * |   函数名：Encode($str)
 * |   作用：转换html代码和转行等。
 * |   参数：
 * @param  $ : $str：要转换的字符串
 * |   返回值：转换后的字符串。
 * +--------------------------------------------------
 */
function Encode($str)
{
    $str = addslashes($str);
    $str = htmlspecialchars($str);
    $str = str_replace("\r\n", "<br>", $str);
    $str = str_replace("\r", "<br>", $str);
    $str = str_replace("\n", "<br>", $str);
    $str = str_replace("  ", "　", $str);
    return $str;
}
/**
 * +--------------------------------------------------
 * |   函数名：Decode($str)
 * |   作用：与Encode相反，用于修改时还原回本来的字符串
 * |   参数：
 * |
 *
 * @param  $ : $str：要转换的字符串。
 * |   返回值：转换后的字符串。
 * +--------------------------------------------------
 */
function Decode($str)
{
    $str = str_replace("<br>", "\r\n", $str);
    $str = str_replace("<br>", "\r", $str);
    $str = str_replace("<br>", "\n", $str);
    $str = str_replace("<", "&lt;", $str);
    $str = str_replace(">", "&gt;", $str);
    return $str;
}

/**
 * 解密
 * 
 * @param string $encryptedText 已加密字符串
 * @param string $key  密钥
 * @return string
 */
function decrypt($encryptedText,$key = null)
{
	$cryptText = base64_decode(str_replace(" ","+",$encryptedText));
	$ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
	$decryptText = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $cryptText, MCRYPT_MODE_ECB, $iv);
	return trim($decryptText);
}


/**
 * 加密
 *
 * @param string $plainText	未加密字符串 
 * @param string $key		 密钥
 */
function encrypt($plainText,$key = null)
{
	$ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($ivSize, MCRYPT_RAND);
	$encryptText = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $plainText, MCRYPT_MODE_ECB, $iv);
	return trim(base64_encode($encryptText));
}

function checkEmail($email)  //EMAIL地址判断
{
    if (ereg("^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+", $email)) {
        return true;
    } else {
        return false;
    }
}



function escape($str){
$sublen=strlen($str);
$reString="";
for ($i=0;$i<$sublen;$i++){
if(ord($str[$i])>=127){
$tmpString=bin2hex(iconv("GBK","ucs-2",substr($str,$i,2)));

if (!eregi("WIN",PHP_OS)){
$tmpString=substr($tmpString,2,2).substr($tmpString,0,2);
}
$reString.="%u".$tmpString;
$i++;
} else {
$reString.="%".dechex(ord($str[$i]));
}
}
return $reString;
}


/**
 * +--------------------------------------------------
 * |   函数名： getIP()
 * |   作用：  获取客户访问IP
 * |   参数：　
 * |   返回值： IP
 * +--------------------------------------------------
 */
function GetIP(){
 $ip=false;
 if(!empty($_SERVER["HTTP_CLIENT_IP"])){
  $ip = $_SERVER["HTTP_CLIENT_IP"];
 }
 if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
  if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
  for ($i = 0; $i < count($ips); $i++) {
   if (!preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/", $ips[$i])) {
    $ip = $ips[$i];
    break;
   }
  }
 }
 return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

//设置cookie
function set_cookie($name,$str,$time=0,$path='/',$domain='6qwan.com')
{
	setcookie($name,$str,$time,$path,$domain);
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
	if(strlen($idcard) == 15 || strlen($idcard) == 18){
		if(check_province(substr($idcard,0,2))){  //判断省份
		   if(strlen($idcard) == 15){
				$idcard = idcard_15to18($idcard);
		   }
		   
		   $y = substr($idcard,6,4);
		   
		   $m = substr($idcard,10,2);
		   $d = substr($idcard,12,2);
		   if(!checkdate($m,$d,$y)){  //判断日期是否正确
			   return false;
			}else{
			   
			   if(idcard_checksum18($idcard)){
					return true;
			   }else{
					return false;
			   }
		    }
		}else{
			return false;
		}
	}else{
	   return false;
	}
}
/*身份证验证函数群END*/


function getpwcode($len=8)
{
	$chars='abcdefghijklmnopqrstuvwxyzABDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; 
	
	mt_srand((double)microtime()*1000000*getmypid()); 
    
	$password='';
    
	while(strlen($password)<$len)
	{
		$password.=substr($chars,(mt_rand()%strlen($chars)),1); 
	}
    
	return $password; 
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
//省份判断
function check_province($pro_id){
	$aCity=array(11, 12, 13, 14, 15, 21, 22, 23, 31, 32, 33, 34, 35, 36, 37, 41, 42, 43, 44, 45, 46, 50, 51, 52, 53, 54, 61, 62, 63, 64, 65, 71, 81, 82, 91); 
	if(!in_array($pro_id,$aCity)){
		return false;
	}else{
		return true;
	}
}

// function path_url_params(){
	// $str = parse_url($_SERVER['HTTP_REFERER']);
	// if($_REQUEST['href']!=''){
		// $str['path'] = $_REQUEST['href'];
	// }
	// return $str['path'];
// }


function long_login($info,$time,$act){
//echo "http://passport.6qwan.com/remote_login.php?act=$act&".$info."&time=".$time."&sign=".md5($time."@_dq*3@DJl_5a_@");
        global $api_url, $api_key;
	$ch = curl_init( );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_URL, $api_url . "remote_login.php" );
	curl_setopt( $ch, CURLOPT_POST, 1 );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, "act=$act&".$info."&time=".$time."&sign=".md5($time.$api_key));
	curl_setopt( $ch, CURLOPT_COOKIEJAR, COOKIEJAR );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
    curl_setopt($ch, CURLOPT_HEADER, false);  
	curl_setopt( $ch, CURLOPT_TIMEOUT, TIMEOUT );
	$contents = curl_exec( $ch );
	curl_close( $ch );
	return $contents;
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

?>