<?
//请你在使用前设置好，该文件可以改名存放在任何目录

$ROOT_PATH = '../../'; 		//定义cmsware系统根目录  *请使用相对路径
$Vote_plugin_name = 'vote';	//投票插件目录名称











//######################################  以下请勿做任何修改！！
define('ROOT_PATH', $ROOT_PATH.'/'); 
define('SYSTEM_REAL_PATH', realpath($ROOT_PATH));
if(!file_exists(ROOT_PATH.'/plugins/'.$Vote_plugin_name.'/include/common.php')) { echo '请修改该文件，定义好cmsware系统根目录:$ROOT_PATH，和投票插件目录名称：$Vote_plugin_name'; exit;}
@require_once(ROOT_PATH.'/plugins/'.$Vote_plugin_name.'/include/common.php') ; 
require_once(SYSTEM_REAL_PATH.'/plugins/'.$Vote_plugin_name.'/include/deal_vote.php') ; 
?>