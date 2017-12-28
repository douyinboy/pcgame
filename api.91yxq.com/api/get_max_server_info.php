<?php
require('../include/config.inc.php');
require('../include/configApi.php');

$gid = $_GET['gid'];
$sql = "SELECT ServerId FROM 91yxq_publish.91yxq_publish_6 WHERE GameId=" . $gid . " AND ServerStatus>2 Order By ServerId DESC";

$result1 = $mysqli->query($sql)->fetch_assoc();

$sql = "SELECT channel_is_open FROM 91yxq_recharge.game_server_list WHERE game_id=" . $gid . " AND server_id=" . $result1['ServerId'];

$result2 = $mysqli->query($sql)->fetch_assoc();

echo json_encode([$result1['ServerId'], $result2['channel_is_open']]);

