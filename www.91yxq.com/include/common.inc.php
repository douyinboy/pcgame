<?php

session_start();

define('SYS_DEBUG', FALSE);
define('DOMAIN', 'demo');
define('IN_SYS', TRUE);
define('SYS_ROOT', substr(__DIR__, 0, -7));
define('CLASS_PATH', SYS_ROOT . 'include/class/');

include(SYS_ROOT . 'include/config.inc.php');
include(SYS_ROOT . 'include/funcs.php');
include(SYS_ROOT . 'smarty/Smarty.class.php');
include(CLASS_PATH . 'mysql.class.php');
include(CLASS_PATH . 'user.class.php');
include(CLASS_PATH . 'userPceggs.class.php');
include(CLASS_PATH . 'userBengbeng.class.php');
include(CLASS_PATH . 'userKuailezhuan.class.php');
include(CLASS_PATH . 'userJuxiangyou.class.php');
include(CLASS_PATH . 'userCommon.class.php');
include(CLASS_PATH . 'userWx.class.php');
include(CLASS_PATH . 'data_check.class.php');

$db = new Mysql($dbConfig);
