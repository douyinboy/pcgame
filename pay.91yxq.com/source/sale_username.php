<?php
include("../include/config.inc.php");

$username = $_GET['username'];
$_query = mysql_query("SELECT agent_id FROM 91yxq_users.users WHERE user_name='" . $username . "'");
$result = mysql_fetch_object($_query);

$code = 0;
if (in_array($result->agent_id, [100, 10020, 10021])) {
    $code = 1;
}

echo $code;die;



