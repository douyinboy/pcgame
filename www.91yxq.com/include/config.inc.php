<?php
date_default_timezone_set("PRC");
$dbConfig = array(
	'host'  =>'127.0.0.1',
	'port' =>3306,
	'username' =>'root',
	'password' =>'root',
	'dbname' =>'91yxq_plat',
	'charset' =>'UTF8'
);

$memcacheIP='127.0.0.1';
$memcachePort='11211';

$tbprefix = '91yxq_';

$cookiepre = '91yxqn_';                   // cookie 前缀
$cookiedomain = '.demo.com'; 		// cookie 作用域 .demo.com
$cookieurl = 'demo.com';
$cookiepath = '/';			// cookie 作用路径

ini_set('session.use_cookies', 1);//使用 COOKIE 保存 SESSION ID 的方式    
ini_set('session.cookie_path', $cookiepath);    
ini_set('session.cookie_domain', $cookiedomain);
session_start();


$adminemail = 'admin@demo.com';		// 系统管理员 Email

$chinese_title = '91yxq游戏平台';
$company_title = '南京魔苹网络科技有限公司';
$icp = '苏ICP备14015522号-1';
$english_title = '91yxq';

$root_dir = dirname( dirname(__FILE__) );//设置子网站所在目录 dirname( __DIR__ )
$root_url = 'http://www.demo.com/';
$pay_url = 'http://pay.demo.com/';
$js_url = 'http://www.demo.com/jsLib/';
$image_url = 'http://image.demo.com/';
$api_url = 'http://api.demo.com/';
$www_url = 'www.demo.com';

$qq_url = 'http://wpa.qq.com/msgrd?v=3&uin=22222222&site=qq&menu=yes';

$api_key = 'adsf';

$check_user_key = '5a::HGeeeFF98FeSXxeFP';

$discuz_auth_key = '5ca026f74e91e5059be0496f007666cc';

$get_email_key = '~@5399@getpwd@by@email@~';

$entrance = basename($_SERVER['PHP_SELF'],'.php');
