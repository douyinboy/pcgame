<?php
function usertab($uname,$s=true) {
	$uname=strtolower($uname);
	$c1=substr($uname,0,1);
	$c2=substr($uname,-1);
	$n=ord($c1)+ord($c2);
	$l=strlen($uname);
	$n+=$l*$l;
	if($s){
		return '91yxq_user_'.$n%40;
	}else{
		return $n%40;
	}
}

function GetIP(){
   $ip = $_SERVER["HTTP_CDN_SRC_IP"];
   if (!$ip) {
      $ip = $_SERVER['REMOTE_ADDR'];
   }
   return $ip;
}

function chkUserName($user_str) {
	if(preg_match("/[ ',:;*?~`!#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$user_str)){
	   return false;
	} else {
	   return true;
	} 
} 

function set_cookie($name,$str,$time=0,$path='/',$domain='pay.91yxq.com'){
	setcookie($name,$str,$time,$path,$domain);
}

function doLog($log, $filename){
    $path = dirname(dirname(__FILE__)) . '/logs/';
    $day = date('Y-m-d H:i:s');
    $dir = $path . $filename.'-'.date('Y-m-d');

    if(is_array($log)){
        file_put_contents($dir, $day.':',FILE_APPEND);
        file_put_contents($dir, var_export($log,TRUE),FILE_APPEND);
    }else{
        $log = $day.":".$log."\r\n";
        file_put_contents($dir, $log,FILE_APPEND);
    }
}

?>