<?php

function chkLength_x($string,$len_1,$len_2 = 100)
{
    $string  = trim($string);
    $str_len = strlen($string);
    if ($str_len < $len_1) return false;
    if ($str_len > $len_2) return false;
    return true;
}
function chkUserName_x($string,$len_1,$len_2)
{
    if (! chkLength_x($string,$len_1,$len_2)) return false;
    if (strtolower(substr($string, -3, 3)) == '@qq') return false;
    $temp =iconv('gbk', 'utf-8', $string);
    //if (!preg_match("/^[\x{4e00}-\x{9fa5}|A-Z|a-z|0-9|\_]+$/u",$temp)) return false;
    if (!preg_match("/^[A-Z|a-z|0-9|\_@]+$/u",$string)) return false;
    return true;
}

require(__DIR__ . '/include/config.inc.php');
require(__DIR__ . '/include/function.php');

$user_name=urldecode(trim($_GET['username']));
if (!chkUserName_x($user_name,4,14))
{
        echo 'data=3';exit;
}

$sql = 'SELECT `id` FROM '.usertab($user_name).' WHERE `user_name`=\''.$user_name.'\'';
$res = mysql_query($sql);
$row = mysql_fetch_object($res);
if ($row ->id >0) {
    echo 'data=1';exit;
} else {
        echo 'data=2';exit;
}
?>
