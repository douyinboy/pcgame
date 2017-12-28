<?php
$user_name = trim($_GET['user_name']);
$game_id   = @intval($_GET['game_id']);
$server_id = @intval($_GET['server_id']);

if($game_id && $server_id && $user_name!=''){
    $flage = file_get_contents("http://pay.777wan.com/api/get_user_rolename.php?game_id={$game_id}&server_id={$server_id}&user_name={$user_name}");
}
if($flage ==''){
    $flage = '未获取到';
}
echo $flage;
exit;
?>