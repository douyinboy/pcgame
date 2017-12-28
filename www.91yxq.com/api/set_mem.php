<?php
//require_once("../include/config.inc.php");
//echo '1';
/*
$mem = new Memcache;
$mem->connect($memcacheIP, $memcachePort);
$act = $_GET['act'];
$s_ip = $_SERVER['REMOTE_ADDR'];
$user_ip  = $_GET['user_ip'];
$timeout  = $_GET['timeout'];
if ( $s_ip!='192.168.1.9' ) {
     echo '0';exit;
}
if ( $act =='ban' ) {
     $mem->set($user_ip,$user_ip,$timeout);
	 echo '1';
} else if ( $act =='unban' ) {
	 $mem->delete($user_ip);
	 echo '1';
} else if ( $act =='search' ) {
     $result = $mem->get($user_ip);
	 if ( $result>0 ) {
	      echo '1';
	 } else {
	      echo '0';
	 }
}
$mem->close();
 * 
 */
?>
