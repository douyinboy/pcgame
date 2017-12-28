<?php
require_once("../include/user.game_api.php");	
$user_name = trim($_GET['user_name']);
$game_id   = @intval($_GET['game_id']);
$server_id = @intval($_GET['server_id']);

$flage='';
if($game_id && $server_id && $user_name!=''){
	$ug = new GameUser();
	$flage = $ug->getRoleName($game_id, $server_id, $user_name);
}
echo $flage;
exit;
?>