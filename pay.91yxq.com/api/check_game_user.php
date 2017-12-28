<?php
require_once("../include/user.game_api.php");
	
$user_name = trim($_GET['user_name']);
$game_id   = @intval($_GET['game_id']);
$server_id = @intval($_GET['server_id']);

$flage='no';
$user_state = file_get_contents("http://pay.91yxq.com/api/check_user.php?act=check_user&user_name={$user_name}");
if($user_state =='no'){
	echo $user_state;
	exit;
}
if($game_id && $server_id && $user_name!=''){
	$ug = new GameUser();
	$flage = $ug->main($game_id, $server_id, $user_name);
}
echo $flage;
exit;
?>