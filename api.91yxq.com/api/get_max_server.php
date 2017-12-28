<?php
require('../include/config.inc.php');
require('../include/configApi.php');

$gid = $_GET['gid'];
$sql = "SELECT ServerId FROM 91yxq_publish.91yxq_publish_6 WHERE GameId=" . $gid . " AND ServerStatus>2 Order By ServerId DESC";

$result = $mysqli->query($sql)->fetch_assoc();
echo $result['ServerId'];

