<?php
session_start();
date_default_timezone_set("PRC");
$mysqli = new mysqli('127.0.0.1','root','root','91yxq_recharge');
if($mysqli->connect_error) 
{
    die("Connect to db failed");
}
$mysqli->set_charset('UTF8');
?>

