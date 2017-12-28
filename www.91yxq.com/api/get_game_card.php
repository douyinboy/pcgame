<?php
//ini_set('display_errors','On');
//error_reporting(E_ALL);	
require(substr(__DIR__, 0, -3) . 'include/common.inc.php');
require(substr(__DIR__, 0, -3) . 'source/game_card.php');
//用于提取游戏新手卡
if($_REQUEST['code']!='' && $_REQUEST['code']!=$_SESSION['xsk_code']){
	echo 'codeerror';
	exit;
}
$type    = (int)$_REQUEST["type"];
$server_id = (int)$_REQUEST["server_id"];
$game_id   = (int)$_REQUEST["game_id"];
if(empty($_SESSION["login"]["username"])){
	echo 'nologin';
	exit;
}
if(empty($type) || empty($server_id) || empty($game_id) || empty($_REQUEST['callback'])){
	echo 'paramerror';
	exit;
}
$gc = new game_card($type, $server_id, $_SESSION["login"]["username"], $game_id, $db);
$gc->main();