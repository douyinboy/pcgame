<?php
session_start();
define('IN_SYS',TRUE);
require(__DIR__ . '/include/class/xsk_code.class.php');
print_r($_SESSION);
//$chk_code = new XskCheckCode(100,28,4,1);
//$chk_code -> createCheckImg();
?>