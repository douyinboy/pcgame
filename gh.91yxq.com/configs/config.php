<?php
 /**==============================
  * 公共配置文件
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 公会会长后台管理系统
 =================================*/
//数据库配置
//联盟库
$unionDb = array('host' =>'127.0.0.1','port' =>3306, 'username' =>'root', 'password' =>'root', 'dbname' =>'91yxq_admin', 'charset' =>'UTF8');

//定义语言包
define('LANGUAGE', 'zh_cn');
//网站入口
define('URL_INDEX', 'http://gh.demo.com/index.php');
//广告入口地址,agent_id=&place_id=&game_id=&server_id=
define('ADENTR', 'http://www.demo.com/ad/');
date_default_timezone_set("Asia/Shanghai");

//充值统一KEY 
define('KEY_HDPAY', '7S%3d09?15#EGJ(106JGc*+<342c@9dH');
//发放元宝接口
define("PAYGLOD_URL", 'http://pay.demo.com/api.php');

//公共模块、无需登录状态验证模块
$publicModule = array('public',);
//联盟库数据表定义
define('TABLE_PRE', '91yxq_');//数据表前缀
define('ADMINUSERS', TABLE_PRE . 'admin_users'); //后台管理人员表
define('GUILDINFO', 'agent'); //公会信息表
define('GUILDMEMBER', 'agent_site'); //公会成员列表
define('GUILDLOGINLOG', 'agent_login_log');



//充值库数据表定义
define('PAYDB', TABLE_PRE.'recharge');
define('PAY_TABLE_PRE', 'pay_');//数据表前缀
define('PAYLIST', PAY_TABLE_PRE . 'list');//成功充值表
define('PAYORDER', PAY_TABLE_PRE . 'orders'); //充值订单表
define('GAMELIST', 'game_list');//游戏列表
define('SERVERLIST', 'game_server_list');//服务器列表
define('PAYFIRST', 'admin_pay_first');//首充记录表
define('PAYINNER', 'admin_pay_inner');//内充记录表
define('PAYJIE', 'admin_pay_jie');//公会结算记录表
define('GUILDINNER', 'apply_inner_guild'); //公会申请内充
define('GUILDWEEK','guild_game_week_statistics');//公会游戏周统计数据表
define('PLATFORM', 'pay_platform');//充值到平台币记录表
define('PLATFORMLOG', 'pay_platform_log');//平台币支付记录表

//用户库数据表定义
define('USERDB', TABLE_PRE.'users');
define('USERS', 'users');
define('REGINDEX', TABLE_PRE.'agent_reg_'); //用户注册表
//运营中心库数据表定义
define('YYDB', TABLE_PRE.'extension');