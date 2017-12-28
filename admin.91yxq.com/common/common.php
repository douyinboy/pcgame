<?php
 /**==============================
  * 公共路径文件包
  * @author Kevin
  * @email 254056198@qq.com
  * @version: 1.0 data
  * @package 游戏公会联盟后台管理系统
 =================================*/
define('ROOT', substr(dirname(__FILE__),0,-6));
define('SMARTY_DIR', ROOT . 'Smarty-3.1.7/');
define('CLASS_DIR', ROOT . 'class/');
define('ACTION_DIR', ROOT.'action/');
define('DATA_DIR', ROOT.'data/');
define('LOG_DIR', ROOT.'data/log/');
define('ATTACH_DIR', ROOT.'attachment/doc/');
include(ROOT . 'configs/config.php');//加载配置
include(ROOT . 'lang/'.LANGUAGE.'.php');//语言包
include(ROOT . 'common/functions.php');//公共函数
require_once(SMARTY_DIR . 'Smarty.class.php');//模板插件
require_once(CLASS_DIR . 'class.php');//类库

$smarty = new Smarty;   //New a smarty模板
//$smarty->force_compile = true;
$smarty->debugging = false;
$smarty->caching = false;
$smarty->cache_lifetime = 1;

$db = new Mysql($unionDb);  //New a db