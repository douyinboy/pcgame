<?php
require(substr(__DIR__,0,-3).'include/mysqli_config.inc.php');

$orderid = $mysqli->escape_string(strip_tags(trim($_REQUEST['orderid'])));

$check = $mysqli->query("SELECT succ FROM pay_orders WHERE orderid='$orderid'")->fetch_row();
$check[0] && exit('ok');
exit();