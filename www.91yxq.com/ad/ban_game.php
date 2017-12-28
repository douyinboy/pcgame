<?php
$game_id=intval( basename( dirname($_SERVER['PHP_SELF']) ) );
$url_91yxq = "http://www.demo.com";
require(substr(__DIR__, 0, -2) . 'include/mysqli_config.inc.php');
$_GET['sid']+=0;
$_GET['aid']+=0;

if($_GET['sid']>0){
	$sid = $_GET['sid'];
}else{
	$info=$mysqli->query("SELECT `ServerId` FROM `91yxq_publish`.`91yxq_publish_6` WHERE `GameId`={$game_id} AND `ServerStatus` IN (3,4) AND `ServerShow`=3 AND `PlatformId`=1 ORDER BY `OpenDate` DESC,`OpenTime` DESC LIMIT 1")->fetch_row();
	$sid = $info[0];
}

if($_GET['aid']>0){
    $aid =$_GET['aid'];
    $pid =$_GET['pid']+0;
}else{
    $pid = $aid =100;
}

/*链接被封与否判断*/
$result3=$mysqli->query("SELECT id FROM `91yxq_admin`.`ban_agent_game` where game_id={$game_id} and agent_id={$aid} and pid=0 AND server_id={$sid}");
$result3->num_rows && exit();

$result4=$mysqli->query("SELECT id FROM `91yxq_admin`.`ban_agent_game` where game_id={$game_id} and agent_id={$aid} and pid={$pid} AND server_id={$sid}");
$result4->num_rows && exit();

/*链接被封与否判断结束*/

/*ifna申请判断*/
$arr=$mysqli->query("SELECT `ifna`,`name`,`game_byname` FROM `91yxq_recharge`.`game_list` where id={$game_id}")->fetch_assoc();

if($arr['ifna'] == 1){
	$result2=$mysqli->query("SELECT aresult FROM `91yxq_admin`.`game_aplication` where game_id={$game_id} and agent_id={$aid}");
	! $result2->num_rows && exit();

	$arr2=$result2->fetch_assoc();
	! $arr2['aresult'] && exit();
}

/*ifna申请判断结束*/