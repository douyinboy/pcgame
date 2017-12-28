<?php
//��ѯ��Ϸ�б���������Ϸid�ı����������б���ѡ��ƽ̨�����б��л��¼���ͨ��ajax��̬�滻��Ϸ�����б�
define('NOW_ROOT',substr(dirname(__FILE__),0,-3));
require_once NOW_ROOT.'cms/config.php';

if (! $conn=@mysql_connect($db_config['db_host'],$db_config['db_user'] ,$db_config['db_password']))
	die("Connect to db failed");
mysql_select_db($db_config['db_name']) || die("Select db failed");
mysql_query('SET NAMES utf8;');

$PlatformId=$_REQUEST['PlatformId'];
$gtype=$_REQUEST['gtype'];

if($PlatformId<=0){ $PlatformId=1; }

$qu=mysql_query("SELECT GameName,GameId,ShortName,PlatformId FROM `91yxq_publish_5` where ServiceStatus=1 order by PlatformId,GameId");
while($re=mysql_fetch_array($qu)) {
	$game_arr[$re['PlatformId']][$re['GameId']]=$re['GameName'];
}

if($gtype=='set' and $PlatformId>0) {
	$list="<select name='data_GameId'>";
	foreach($game_arr[$PlatformId] as $k=>$v){
		$list.='<option value="'.$k.'">'.$v.'</option>';
	}
	$list.="</select>";
	echo $list;
}
// echo "<pre>";
// var_dump($game_arr);
// echo "</pre>";
?>
