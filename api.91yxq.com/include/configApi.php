<?php
//定义api_secret_key
define('SECRET_KEY', 'df21@sef78sae%4dd$kk');
//轮播图展示个数
define('SLIDE_NUM', 4);
//热门游戏展示个数
define('HOT_NUM', 12);
//游戏列表展示个数
define('GAME_LIST_NUM', 12);
//新闻列表展示个数
define('GAME_NEWS_LIST_NUM', 12);
//游戏资讯列表展示个数
define('GAME_INFORMATION_LIST_NUM', 20);
//自动添加工会和推广员的密码
define('AGENT_ADMIN_PWD', 'kj5sdf445sd87f!@#');

//平台首页
define('INDEX_URL', 'http://www.demo.com');
//define('INDEX_URL', 'http://www.91yxq.com');

//登录玩家游戏
define("LOGIN_URL", 'http://api.demo.com/remote_login.php');
//define("LOGIN_URL", 'http://api.91yxq.com/remote_login.php');

//数据表定义
define('TABLE_PRE', '91yxq_');

define('ADMINTABLE', TABLE_PRE . 'admin'); //默认选择库
//define('ADMINGROUP', TABLE_PRE . 'admin_group'); //后台管理组权限表
//define('ADMINUSERS', TABLE_PRE . 'admin_users'); //后台管理人员表
define('GUILDINFO', 'agent'); //公会信息表
define('GUILDMEMBER', 'agent_site'); //公会成员列表

//其他库数据表定义
define('YYDB', TABLE_PRE.'extension');
define('OPERATELOG', 'xieenet_operate_log');  //操作日志记录表
define('COMPANY', 'game_company');//研发公司

//充值库数据表定义
define('PAYDB', TABLE_PRE.'recharge'); //充值库
define('PAY_TABLE_PRE', 'pay_');
//define('PAYLIST', PAY_TABLE_PRE . 'list');//成功充值表
define('PAYORDER', PAY_TABLE_PRE . 'orders'); //充值订单表
define('GAMELIST', 'game_list');//游戏列表
define('SERVERLIST', 'game_server_list');//服务器列表
//define('PAYFIRST', 'admin_pay_first');//首充记录表
//define('PAYINNER', 'admin_pay_inner');//内充记录表
//define('PAYJIE', 'admin_pay_jie');//公会结算记录表
//define('PAYVIP', 'admin_pay_vip');//充vip记录表

//广告位数据表定义
define('MANAGE', TABLE_PRE.'manage');
define('AD', TABLE_PRE.'ad');

//发布库数据表定义
define('PUBLISH', TABLE_PRE.'publish'); //发布库
define('PUBLISH_1', TABLE_PRE.'publish_1');
define('PUBLISH_4', TABLE_PRE.'publish_4');
define('PUBLISH_5', TABLE_PRE.'publish_5');
define('PUBLISH_6', TABLE_PRE.'publish_6');
define('PUBLISH_7', TABLE_PRE.'publish_7');
define('CONTENT_1', TABLE_PRE.'content_1');
define('CONTENT_5', TABLE_PRE.'content_5');
define('CONTENT_6', TABLE_PRE.'content_6');
define('CONTENT_INDEX', TABLE_PRE.'content_index');

















