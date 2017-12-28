<?php
require_once 'config.php';

$nodeID = intval($_REQUEST['nodeID']);
$title  = $_REQUEST['title'];
$photo  = $_REQUEST['photo'];
$author  = $_REQUEST['Author'];
$Thumb  = $_REQUEST['Thumb'];

if($nodeID=='' || $title =='' || $photo=='' || $author==''){
	echo '-3'; // 参数不全
	return;
}

if (! $conn=@mysql_connect($db_config['db_host'],$db_config['db_user'] ,$db_config['db_password']))
	die("-2"); //数据库链接出错

mysql_select_db($db_config['db_name']) || die("Select db failed");
mysql_query('SET NAMES utf8;');

$addTime = time();
$sql ="INSERT INTO ".$db_config['table_pre']."contribution_3(CreationDate,ModifiedDate,OwnerID,State,NodeID,ContributionDate,Title,Photo,Author,Thumb)
VALUES($addTime, $addTime, 54, 1, $nodeID, $addTime, '$title', '$photo', '$author', '$Thumb' )";//图片模型
echo mysql_query($sql)?1:0;

?>
