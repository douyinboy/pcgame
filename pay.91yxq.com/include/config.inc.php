<?php
$dbuser="root";
$dbpasswd='root';
$dbhost="127.0.0.1";
$dbname="91yxq_recharge";
if (!$conn=@mysql_connect($dbhost,$dbuser,$dbpasswd))
	die("Connect to db failed");
mysql_select_db($dbname) || die("Select db failed");
mysql_query('SET NAMES utf8;');
?>
