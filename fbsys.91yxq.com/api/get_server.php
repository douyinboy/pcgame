<?php
require_once '../cms/config.php';

if (! $conn=@mysql_connect($db_config['db_host'],$db_config['db_user'] ,$db_config['db_password']))
	die("Connect to db failed");
mysql_select_db($db_config['db_name']) || die("Select db failed");
mysql_query('SET NAMES utf8;');

$GameId=$_REQUEST['game_id'];
$ServerId=$_REQUEST['server_id'];

if(!$GameId){
	$GameId=1;
}

	$que=mysql_query("select ServerId,ServerName,MergeId from 91yxq_content_6 where ServerStatus>2 and GameId=".$GameId." and ServerId<10000 and PlatformId=1 order by ServerId");
	$i=0;
	while($re=mysql_fetch_array($que)) {
			$srvlist[$i]["ServerId"]=$re['ServerId'];
			$srvlist[$i]["ServerName"]=$re['ServerName'];
			$srvlist[$i]["ServerStatus"]="火爆";
			$srvlist[$i]["MergeId"]=$re['MergeId'];
			$i++;
	}

if(empty($srvlist)) {
	echo json_encode('0');
} else {
	echo json_encode($srvlist);
}

?>