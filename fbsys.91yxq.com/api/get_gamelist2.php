<?php
//获取游戏名称二维数组 array['平台id']['游戏id'] = '游戏名称'，供非游戏列表模型的内容替换游戏id为游戏名称
define('NOW_ROOT',substr(dirname(__FILE__),0,-3));
require_once NOW_ROOT.'cms/config.php';

if (! $conn=@mysql_connect($db_config['db_host'],$db_config['db_user'] ,$db_config['db_password']))
	die("Connect to db failed");
mysql_select_db($db_config['db_name']) || die("Select db failed");
mysql_query('SET NAMES utf8;');
$qu=mysql_query("SELECT GameName,GameId,ShortName,PlatformId FROM `91yxq_publish_5` where ServiceStatus=1 order by PlatformId,GameId");
while($re=mysql_fetch_array($qu)) {
	$game_arr[$re['PlatformId']][$re['GameId']]=$re['GameName'];
}

?>
