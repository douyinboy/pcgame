<?php
if( !empty($_REQUEST['forward']) ){
    $forward = $_REQUEST['forward'];
}
elseif( !empty($_SERVER['HTTP_REFERER']) ){
    $forward = $_SERVER['HTTP_REFERER'];
}
else{
    $forward = $root_url;
}
$cookiepre = 'YRYk_2132_';
$_SESSION['login']['username'] = '';
setcookie('login_game_info','',-86400 * 365,'/','91yxq.com');
setcookie('login_name','',-86400 * 365,'/','91yxq.com');
setcookie('userinfo','',-86400 * 365,'/','91yxq.com');
setcookie($cookiepre.'auth','',-86400 * 365,'/','91yxq.com');
setcookie($cookiepre.'loginuser','',-86400 * 365,'/','91yxq.com');
session_destroy();
header("Location:".$forward);
exit;
?>