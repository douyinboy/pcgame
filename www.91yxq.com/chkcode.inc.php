<?php
session_start();
define('IN_SYS',TRUE);
require(__DIR__ . '/include/class/chk_code.class.php');
$chk_code = new CheckCode(100,30,4,1);
$chk_code->createCheckImg();