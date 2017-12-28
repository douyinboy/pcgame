<?php
require(substr(__DIR__, 0, -3) . "include/config.inc.php");
$user_name = urldecode($_GET['user_name']);
$row = $mysqli->query("SELECT `uid` FROM `users` WHERE `user_name`='$user_name'")->fetch_row();
echo $row[0] + 0;
exit;
?>
