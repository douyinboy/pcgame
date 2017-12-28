<?php
require_once 'config.php';
header("Content-Type:text/html;charset=utf-8");
//var_dump($_REQUEST);return;
$nodeID = intval($_REQUEST['nodeID']);
$title  = $_REQUEST['title'];
$content  = stripcslashes($_REQUEST['content']);
$author  = $_REQUEST['author'];

if($nodeID=='' || $title =='' || $content=='' || $author==''){
	echo '-3'; // 参数不全
	return;
}

if (! $conn=@mysql_connect($db_config['db_host'],$db_config['db_user'] ,$db_config['db_password']))
	die("-2"); //数据库链接出错

mysql_select_db($db_config['db_name']) || die("Select db failed");
mysql_query('SET NAMES utf8;');

$addTime = time();
$sql ="INSERT INTO ".$db_config['table_pre']."contribution_1(CreationDate,ModifiedDate,OwnerID,State,NodeID,ContributionDate,Title,Content,Author)
VALUES($addTime, $addTime, 57, 1, $nodeID, $addTime, '$title', '$content', '$author' )";//新闻模型

echo mysql_query($sql)?1:0;

?>
