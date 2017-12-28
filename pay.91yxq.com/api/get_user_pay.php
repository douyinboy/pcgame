<?php
$power_ip = $_SERVER["REMOTE_ADDR"];
if ( $power_ip !='127.0.0.1'  && $power_ip !='201.125.143.16' ) {
    //echo 'Permission'.$power_ip;exit;//无权访问
}
require_once("../include/config.inc.php");
$user_name = htmlspecialchars(trim(urldecode($_GET['user_name'])),ENT_QUOTES);
$game_id = htmlspecialchars(trim(urldecode($_GET['game_id'])),ENT_QUOTES);
$pdate = htmlspecialchars(urldecode($_GET['pdate']));
$act = $_GET['act'];
if ( $act=="pay_times" &&  $user_name) {
     $sql ="SELECT count(id) as pc,money from `pay_list` where user_name='".$user_name."' and pay_date>='".date("Y-m-d")." 00:00:00' and pay_date<='".date("Y-m-d")." 23:59:59' group by `orderid`  having money>=30";
	 $res = @mysql_query($sql);
	 $num = @mysql_num_rows($res);
	 if ( $num>=1 ) {
	      echo $num;exit;
	 } else {
	      echo "0";exit;
	 }
}
$filter = "WHERE user_name='".$user_name."'";
if ( $game_id ) {
	$filter .= " AND game_id=$game_id"; 
}
if ( $pdate ) {
	$filter .= " AND pay_date>='$pdate 00:00:00' and pay_date<='$pdate 23:59:59'";
}
$sql = "SELECT sum(money) FROM `pay_list` $filter";
$res = mysql_query($sql);
if ($res) {  
	$row = mysql_fetch_array($res);
	$money = floor($row[0]);
	echo $money;exit;
} else {
	echo "0";exit;
}
?>