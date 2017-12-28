<?php
require(substr(__DIR__, 0, -3) . 'include/config.inc.php');
$mem = new Memcache;
$mem->connect($memcacheIP, $memcachePort);
$act = $_GET['act'];
$s_ip = $_SERVER['REMOTE_ADDR'];
$user_ip  = $_GET['user_ip'];
$timeout  = $_GET['timeout'];
//$mem->set('119.145.139.237','119.145.139.237',3600);
$ip = ip2long('119.145.139.237');
echo  $result = $mem->get($ip);
//$mem->flush();
$mem->close();
?>
