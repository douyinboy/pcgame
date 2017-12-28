<?php
require(__DIR__ . '/funcs.php');
/*
$mem = new Memcache;
$mem->connect("192.168.1.6", 11211);
$reg_ip = GetIP();
$reg_counts = intval($mem->get($reg_ip));
if ($reg_counts>=1) {
    $mem->replace($reg_ip,$reg_counts+1,86400);
} else {
    $mem->add($reg_ip,$reg_counts+1,86400);
}
 * */
 
//删除数据
//$mem->delete($reg_ip);
//$mem->flush();
?>