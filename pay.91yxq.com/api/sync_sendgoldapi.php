<?php
/*
*综合业务平台接口发放元宝接口
*/
$fhandle=fopen(dirname(dirname(__DIR__)) . "/home/91yxq/logs/sync_snedgoldapi.log","a");
fwrite($fhandle,date("Y-m-d H:i:s")."	".$_SERVER["REMOTE_ADDR"]."	".$_SERVER["REQUEST_URI"]."\r\n");
fclose($fhandle);
include("../include/dbconn_4.php");
include_once("../include/config.inc.php");
require_once("../include/cls.game_api.php");
$user_name = $_POST['user_name'];
$game_id = $_POST['game_id'];
$server_id = $_POST['server_id'];
$orderid = $_POST['orderid'];
$time = $_POST['time'];
$b_num = $_POST['b_num'];
$money = $_POST['money'];
$pay_ip = $_POST['pay_ip'];
$flag = $_POST['flag'];
$power_ip = $_SERVER["REMOTE_ADDR"];
$Key_HD = '5apasywuE(73)s$%&KBJzCc:5qLM0928h';
if ( $power_ip !='127.0.0.1' && $power_ip !='218.15.113.216' && $power_ip !='112.90.226.88') {
     //echo '2';exit;//此IP无权访问
}
$flag2 = md5($time.$Key_HD.$user_name.$game_id.$server_id.$pay_ip);
if ( $flag2!=$flag ) {
     echo '3';exit;//数字签名失败
}
if ( $game_id=='' || $server_id=='' ) {
     echo '4';exit;//所填的游戏ID或者服ID不能为空
}
$sql = "SELECT a.name as game_name,a.game_byname,a.back_result,b.pay_url,b.name as server_name FROM `game_list` as a,`game_server_list` as b WHERE a.id=b.game_id and a.id=".$game_id." and b.server_id=".$server_id." limit 1";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);
$game_table =  "`pay_".$row->game_byname."_log`";
$game_pay_fun = "pay_".$row->game_byname."_b";
$pay_url = trim($row->pay_url);

$sql = "SELECT stat FROM {$game_table} WHERE orderid='{$orderid}'";
$stat_arr = mysql_fetch_row(mysql_query($sql));
if(!$stat_arr){
	$sql="INSERT INTO ".$game_table."(`orderid`,`user_name`,`money`,`paid_amount`,`pay_gold`,`pay_type`,`user_ip`,`server_id`,`remark`)
    VALUES('$orderid','$user_name','".$money."','".$money."','".$b_num."','16','$pay_ip','$server_id','16')";
	mysql_query($sql);
}else if($stat_arr[0]==1){
		echo '1';exit;
}
$game_obj = new Game($user_name,$orderid,$server_id,$pay_url,$money,$money,$b_num,16); //创建付费对象
$result= $game_obj ->$game_pay_fun();
$game_obj = NULL;
if ($result) {
		echo '1';exit;
} else {
		echo '0';exit;
}
?>