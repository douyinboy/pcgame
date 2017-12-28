<?php
 /**==============================
  * 公共配置文件
  * @author Kevin
  * @email 254056198@qq.com
  * @version 1.0 data
  * @package 游戏公会总后台管理系统
 =================================*/
//数据库配置
//联盟库
$unionDb = array('host' =>'127.0.0.1','port' =>3306, 'username' =>'root', 'password' =>'root', 'dbname' =>'91yxq_admin', 'charset' =>'UTF8');
//$unionDb = array('host' =>'192.168.0.20','port' =>3306, 'username' =>'91yxq', 'password' =>'7X(xyELU2FSy!QyZ', 'dbname' =>'91yxq_admin', 'charset' =>'UTF8');
//后台入口方法
$publicModule = array('public',);
date_default_timezone_set("Asia/Shanghai");
/*************************************其他定义***********************************************/
//定义语言包
define('LANGUAGE', 'zh_cn');
//网站入口
define('URL_INDEX','http://admin.demo.com/index.php');
//define('URL_INDEX','http://admin.91yxq.com/index.php');
//综合管理文件入口
define('MANAGE_URL', 'http://admin.demo.com/');
//define('MANAGE_URL', 'http://admin.91yxq.com/');
//平台首页
define('INDEX_URL', 'http://www.demo.com');
//define('INDEX_URL', 'http://www.91yxq.com');
//充值统一KEY 
define('KEY_HDPAY', '7S%3d09?15#EGJ(106JGc*+<342c@9dH');
//充值统一URL【综合管理】
define('PAY_URL', 'http://pay.91yxq.com/api/sync_myhaodong.php');
//查询角色名统一URL【综合管理】
define('GETUSERROLE_URL', 'http://pay.91yxq.com/api/sync_myhaodong.php');
//登录玩家游戏
define("LOGIN_URL", 'http://api.demo.com/remote_login.php');
//define("LOGIN_URL", 'http://api.91yxq.com/remote_login.php');
//发放元宝接口
define("PAYGLOD_URL", 'http://pay.91yxq.com/api/sync_sendgoldapi.php');
//审核内充 ，首充，vip充值密码
define("PASSWORD_PAY", "dls_3#gz.mx$12");
/****************************************数据库定义*************************************************************/
//数据表定义
define('TABLE_PRE', '91yxq_');
define('ADMINTABLE', TABLE_PRE . 'admin'); //默认选择库
define('ADMINGROUP', TABLE_PRE . 'admin_group'); //后台管理组权限表
define('ADMINUSERS', TABLE_PRE . 'admin_users'); //后台管理人员表
define('GUILDINFO', 'agent'); //公会信息表
define('GUILDMEMBER', 'agent_site'); //公会成员列表

define('BOUNDUSER', ' bound_user_toguild'); //绑定注册到公会记录表
define('BOUNDRECORD', 'agent_del_spreadurl'); //绑定记录表
define('BANAGENTGAME','ban_agent_game');//广告封解
define('GUILDDEL', 'agent_delete'); //公会删除日记表
define('SYEXCEL',rtrim($_SERVER['DOCUMENT_ROOT'],'/').'/Excel/'); //excel表 临时存放位置

//充值库数据表定义
define('PAYDB', TABLE_PRE.'recharge'); //充值库
define('PAY_TABLE_PRE', 'pay_');
define('PAYLIST', PAY_TABLE_PRE . 'list');//成功充值表
define('PAYORDER', PAY_TABLE_PRE . 'orders'); //充值订单表
define('GAMELIST', 'game_list');//游戏列表
define('SERVERLIST', 'game_server_list');//服务器列表
define('PAYFIRST', 'admin_pay_first');//首充记录表
define('PAYINNER', 'admin_pay_inner');//内充记录表
define('PAYJIE', 'admin_pay_jie');//公会结算记录表
define('PAYVIP', 'admin_pay_vip');//充vip记录表

define('MONTHGAMEDATA', 'month_game_data');//游戏月数据
define('MONTHGUILDDATA', 'month_guild_data');//公会月数据
define('INNERGUILD', 'apply_inner_guild');//公会申请内充表
define('GUILDWEEK','guild_game_week_statistics');//公会游戏周统计数据表
define('GUILDDIVIDE','guild_divide_adjust');//公会分成调整表
define('PLATFORM', 'pay_platform');//充值到平台币记录表
define('PLATFORMLOG', 'pay_platform_log');//平台币支付记录表

//用户库数据表定义
define('USERDB', TABLE_PRE.'users');
define('USERS', 'users');
define('REGINDEX', TABLE_PRE.'agent_reg_');
define('REGCHILDTAB', TABLE_PRE.'user_'); //用户注册子表
define('CHANNEL', 'channel'); //用户注册子表

//其他库数据表定义
define('YYDB', TABLE_PRE.'extension');
define('COMPANY', 'game_company');//研发公司
define('REGTOTAL', 'reg_total');//公会【公会成员】各游戏区服注册统计表
define('LOGINTOTAL', 'login_total');//公会【公会成员】各游戏区服登录ip
define('NOUSERC', 'user_analyse');//新老用户登录、消费记录表
define('DAYUSERC', 'sync_user_statistics');//每日用户统计表
define('KFAPPLYYB', ' kf_yb_apply');//申请发放元宝
define('OPERATELOG', 'xieenet_operate_log');  //操作日志记录表
/******************/
define('WWWPLAT', TABLE_PRE.'plat');
define('UQUSETION', 'help_question');  //玩家问题记录表 
define('USERLOGS', 'user_logs');  //玩家操作记录表
//登陆游戏日志库
define('GAMELOGIN',TABLE_PRE.'login_logs');
define('GLOLOG','game_login_info_');//玩家登陆游戏日志表


