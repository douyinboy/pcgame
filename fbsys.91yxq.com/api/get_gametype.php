<?php
//获取 数据字典 - 游戏类型 列表
define('NOW_ROOT',substr(dirname(__FILE__),0,-3));
require_once NOW_ROOT.'cms/config.php';

if (! $conn=@mysql_connect($db_config['db_host'],$db_config['db_user'] ,$db_config['db_password']))
	die("Connect to db failed");
mysql_select_db($db_config['db_name']) || die("Select db failed");
mysql_query('SET NAMES utf8;');

//$PlatformId=$_REQUEST['PlatformId'];
//$gtype=$_REQUEST['gtype'];

//if($PlatformId<=0){ $PlatformId=1; }

$qu=mysql_query("SELECT DataId,DataValue FROM `91yxq_publish_4` where NodeID=24 order by DataId asc");
$gametype_list = array();
while($re=mysql_fetch_assoc($qu)) {
	$gametype_list[]=$re;
}

// if($gtype=='set' and $PlatformId>0) {
	// $list="<select name='data_GameType'>";
	// foreach($gametype_list as $k=>$v){
		// $list.='<option value="'.$v['DataValue'].'">'.$v['DataValue'].'</option>';
	// }
	// $list.="</select>";
	// echo $list;
// }

?>